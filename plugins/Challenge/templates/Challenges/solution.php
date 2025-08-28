<?php
use Challenge\Predata;
$this->Func->getSiteSetting();
$predata = new Predata();

$show = false;
if($this->request->getSession()->read('Auth.User')):
    if(
        !isset($users['challengeuserprofile']) or 
        (isset($users['challengeuserprofile']) and !isset($users['challengeuserprofile']['id'])) 
        ):
        echo '<div class="text-center">';
        echo '<div class="alert alert-warning">
            پروفایل کاربری شما هنوز تکمیل نشده است.<br>
            لطفا ابتدا پروفایلتان را تکمیل کرده و سپس اقدام نمایید</div>';	
        echo $this->html->link(
            '<button class="btn btn-primary btn-sm m-0">تکمیل پروفایل کاربری</button>',
            '/challenge/profile/edit',['escape'=>false]);
        echo '</div>';
        
    elseif( $challenge['chtype'] == 2 and $users['challengeuserprofile']['single'] != 2):
        echo '<div class="alert alert-warning text-center">
            این '.__d('Template', 'همیاری').' فقط برای کاربران حقوقی تعریف شده است<br>
            دسترسی شما برای مشارکت در این '.__d('Template', 'همیاری').' محدود شده است
        </div>';

    elseif(isset($forms['id']) or $formlist_count > 0):
        if(isset($this->request->getParam('?')['edit'])){
            echo '
            <div class="alert alert-danger">
                توجه :<br>
                - فقط متون وارد شده قابل ویرایش  هستند
                    برای تغییر گزینه های انتخابی لطفا مجددا مشارکت کنید. (مشارکت را حذف کرده و مجدد در '.__d('Template', 'همیاری').' شرکت کنید) <br><br><br>
                - در صورت اپلود فایل ضمیمه جدید، فایل اپلود شده قبلی حذف خواهد گردید.<br>
                - در صورت ثبت ویرایش '.__d('Template', 'همیاری').' اطلاعات قبلی ثبت شده حذف خواهند شد
            </div>';	

            $show = true;
        }
        else
        {
            echo '<div class="alert alert-info text-center">شما قبلا در این '.__d('Template', 'همیاری').' شرکت کرده اید
            . برای مشاهده یا ویرایش از لینک زیر استفاده کنید</div>';
            echo '<div class="text-center"><br>';
            echo $this->html->link('<button class="btn btn-primary btn-sm m-0 ml-1">'.__d('Template', 'لیست مشارکت های من').'</button>',
                '/challenge/profile/challenge',['escape'=>false,'target'=>'_parent']).'&nbsp;&nbsp;';
            echo $this->html->link('<button class="btn btn-primary btn-sm m-0">پروفایل کاربری</button>',
                '/challenge/profile/',['escape'=>false,'target'=>'_parent']);
                echo '</div>';
        }
    else:
        $show = true;
    endif;
else:
    echo '<div class="alert alert-warning text-center"> 
        برای مشارکت در '.
        __d('Template', 'همیاری').
        ' می‌بایست ابتدا در سایت، 
        <a href="#" style="font-weight: bold;" data-bs-toggle="modal" class="registerModals" data-bs-target="#registerModal">
          ثبت نام
        </a>
         کرده و یا 
        <a href="#" style="font-weight: bold;" data-bs-toggle="modal" data-bs-target="#loginModal">
          وارد سایت
        </a>
          شوید.<br>';
    /* echo $this->html->link('ورود',['plugin'=>false, 'controller'=>'Users','action'=>'login'],['data-lightbox'=>'inline']);
    echo ' / ';
    echo $this->html->link('ثبت نام',['plugin'=>false, 'controller'=>'Users','action'=>'register']); */
    echo '</div>';
endif;

if($show == true):
    echo $this->Form->create($userform,['id'=>'userprofiles','target'=>'_parent','type'=>'file']);?>
    <div class="mlist"></div>
    <?php
    if(isset($editform)){
        echo "<script nonce='".get_nonce."'>alert('کاربر گرامی فقط متون وارد شده قابل ویرایش  هستند. برای تغییر گزینه های انتخابی لطفا مجددا مشارکت کنید. (مشارکت را حذف کرده و مجدد در '.__d('Template', 'همیاری').' شرکت کنید)');</script>";
        echo $predata->createjsform($challenge_id,$editform);
    }
    else
        echo $predata->createjsform($challenge_id);

    if(isset(setting['chcomm_text']) and setting['chcomm_text']!= ''):
        echo $this->Form->control('rules',[
            'type'=>'textarea',
            'default'=> isset(setting['chcomm_text'])?setting['chcomm_text']:'' ,
            'disabled',
            'label'=>'قوانین و مقررات',
            'class'=>'form-control text-justify',
            'style'=>'font-size:14px;'
            ]);
        echo $this->Form->button(__('تایید قوانین و ثبت اطلاعات'),['class'=>'btn btn-primary btn-sm m-0 mt-4']);
    else:
        echo $this->Form->button(__('ثبت اطلاعات'),['class'=>'btn btn-primary btn-sm m-0 mt-4']);
    endif;

    echo $this->Form->end();
endif;
?>
<script type="text/javascript" nonce="<?=get_nonce?>">
$(function() {
    $('input[type=file]').change(function() {
        var fileExtension = ['zip'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            alert("فقط فایل های با پسوند zip و حجم کمتر از  20مگابایت آپلود خواهند گردید");
            $(this).val('');
            return false;
        }
        if( this.files[0].size > 5242880 || this.files[0].size > 5242880) {
            errorMessage = 'Files must be less than 5MB.';
        }
    });
})
</script>

<style>
#userprofiles .input {margin-top:15px;}
#userprofiles label{margin:0;letter-spacing: 0;font-size:15px;font-weight: normal;text-align: justify;}
.button{letter-spacing: 0;font-weight: normal;}
.mlist b{font-weight: bold !important;}
.clh1{font-size: 25px;}
.mlist label{width:100%;}
.mlist p{text-align: justify;}
.mlist textarea{height: 150px;}
.mlist h3{
    font-size: 18px;
    text-align: justify;
    letter-spacing: -0.5px;
}
.mlist h1{
    font-size:22px;
    text-align: justify;
}
</style>