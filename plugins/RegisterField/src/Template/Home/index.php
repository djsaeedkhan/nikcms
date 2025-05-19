<?php
echo $this->Form->create(null,['url'=>['plugin'=>'Admin','controller'=>'Options', 'action'=>'SaveSetting']]);
if(count($result)):
    $hsite = unserialize($result['plugin_registerfield']);
    $this->request->withData('plugin_registerfield',$hsite);
    @$this->request->data['plugin_registerfield'] = $hsite;
endif;
?>

<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    <?= __('افزونه فیلدهای ثبت نام');?>
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0"></ol>
                </div>
            </div>
        </div>
    </div>
</div>

    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active show" data-toggle="tab" href="#home" role="tab" aria-controls="home" 
                aria-selected="true">نمونه ثبت نام 1</a>
        </li>
        <!-- <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#home1" role="tab" aria-controls="sendsms" 
                aria-selected="true">نمونه ثبت نام 2</a>
        </li> -->
    </ul>

    <div class="tab-content">
        <div class="tab-pane active show" id="home" role="tabpanel">
            <div class="card"><div class="card-body"><div class="row">
                <div class="col-sm-6">
                    <?= $this->Form->control('plugin_registerfield.1.title' , [
                        'label'=> 'عنوان', 
                        'class'=> 'form-control mb-1']);?>
                </div>    
                <div class="col-sm-4">
                    <?= $this->Form->control('plugin_registerfield.1.query' , [
                        'label'=> 'کلید فراخوانی',
                        'id'=>'query1',
                        'class'=> 'ltr form-control mb-1']);?>
                </div>
                <div class="col-sm-2">
                    <?= $this->Form->control('plugin_registerfield.1.enable' , [
                        'type' => 'select',
                        'empty' =>' --انتخاب کنید--',
                        'options' => [
                            1 => 'فعال',
                            0 => 'غیرفعال' ],
                        'label'=> 'وضعیت نمایش', 
                        'class'=> 'form-control mb-1']);?>
                </div>
                <div class="col-sm-12">
                    <?= $this->Form->control('plugin_registerfield.1.sms' , [
                        'type' => 'text',
                        'label'=> 'متن پیامک  تایید ثبت نام', 
                        'class'=> 'form-control']);?>

                    <div class="alert alert-secondary mb-1">
                        - در صورتی که این فیلد خالی باشد، ارسال پیامک انجام نخواهد شد<br>
                        - در صورتی که نام کاربری شماره موبایل باشد این پیامک ارسال خواهد شد.
                    </div>
                </div>

                <div class="col-sm-12">
                    <label for="plugin-registerfield-1-query">لینک دسترسی</label>
                    <input type="text" id="urls" class="ltr form-control alert alert-dark">
                </div>

                <script nonce="<?=get_nonce?>">
                    $('#urls').val('<?=\Cake\Routing\Router::url(['plugin'=>false,'controller'=>'Users','action'=>'register','?'=>['type'=>'']],'true')?>'+$('#query1').val() );
                    $(document).ready(function () {
                        $('#query1').keyup(function () {
                            $('#urls').val('<?=\Cake\Routing\Router::url(['plugin'=>false,'controller'=>'Users','action'=>'register','?'=>['type'=>'']],'true')?>'+$('#query1').val() );
                            });
                    });
                </script>
            </div></div>
            </div></div>
                <?php
                $arr = [
                    'field_title'=>'عنوان فیلد',
                    'field_name'=>'نامک فیلد (Name)',
                    'field_type'=>'نوع فیلد (Type)',
                    'field_value'=>'مقدار پیشفرض جداسازی با ;',
                ];
                for($i=1;$i<10;$i++):
                    echo '<div class="card mb-1"><div class="card-body"><div class="row">';
                    foreach($arr as $a => $t){
                        echo '<div class="col-sm-3">';
                        if($a == 'field_type' ){
                            echo $this->Form->control("plugin_registerfield.1.{$i}.".$a , [
                                'type'>'select',
                                'options'=>[
                                    'text' =>'باکس متنی',
                                    'textarea' =>'ناحیه ی متن',
                                    'select' =>'لیست تک انتخابی',
                                ],
                                'label'=> $t, 
                                'class'=> 'form-control mb-1']);
                        }
                        else{
                            echo $this->Form->control("plugin_registerfield.1.{$i}.".$a , [
                                'label'=> $t, 
                                'type' => in_array($a ,['field_value'])?'textarea':'text',
                                'class'=> (in_array($a ,['field_title','field_value'])?'rtl':'ltr').' form-control mb-1']);
                        }
                        echo '</div>';
                    }
                    echo '</div></div></div>';
                endfor;?>
    </div>
</div>
<?php
echo $this->Form->button('ثبت اطلاعات',['class'=>'btn btn-success col-xs-3']);
echo $this->Form->end();
?>
<br>