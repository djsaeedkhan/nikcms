<?= $this->Html->css(['/Formbuilder/css/style.css'])?>

<h3><?= __d('Formbuilder', 'مدیریت فرم ساز');?></h3>
<?= $this->Form->create($result,['id'=>'forms','onsubmit'=>'return checker()']);
$form_data = isset($result['formbuilder_items'][0]['form_data'])?$result['formbuilder_items'][0]['form_data']:'';
echo $this->form->control('formbuilder_items.0.form_html',['type'=>'hidden','class'=>'form_html']);
echo $this->form->control('formbuilder_items.0.form_data',['type'=>'hidden','class'=>'form_data form-control']);
?>

<div class="float-left">
    <?= $this->Form->button(__d('Formbuilder', 'ثبت اطلاعات'),['class'=>'btn btn-success','style'=>'margin-right:14px;']);?>
    <a class="btn btn-info export_html d-none">Export HTML</a>
    <!-- <a style="cursor: pointer;" class="btn btn-info ex2">Serialize</a> -->
</div>

<ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link active show" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
        <?= $this->Form->control('title',[
            'label' => false,
            'placeholder' => __d('Formbuilder', 'عنوان فرم جدید'),
            'type'=>'text',
            'class'=>'']);?>
        </a>
    </li>
    <!-- <li class="nav-item">
        <a class="nav-link active show" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true" style="padding: 11px;">
            ایجاد فرم جدید</a>
    </li> -->
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false" style="padding: 11px;">
            <?= __d('Formbuilder', 'تنظیمات فرم ساز')?>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#style" role="tab" aria-controls="style" aria-selected="false" style="padding: 11px;">
            <?= __d('Formbuilder', 'استایل اضافه')?>
        </a>
    </li>
</ul>

<div class="tab-content">
    <div class="tab-pane col-sm-12" id="style" role="tabpanel">
        <div class="card"><div class="card-body">
        <?= $this->Form->control('formbuilder_items.0.css',[
            'type'=>'textarea','class'=>'ltr form-control','rows'=>20])?>
        </div></div>    
    </div>
    
    <div class="tab-pane" id="profile" role="tabpanel">
        <div class="row">
            <div class="col-sm-6"><div class="card"><div class="card-body">
                <?php 
                $this->Form->control('password',[
                    'type'=>'text',
                    'class'=>'ltr form-control mb-1']);

                echo $this->Form->control('action',[
                    'label'=>__d('Formbuilder', 'نحوه ذخیره اطلاعات'),
                    'default'=>isset($result['action'])?$result['action']:'db',
                    'type'=>'select',
                    'empty' =>'-- '.__d('Formbuilder', 'انتخاب کنید').' --',
                    'options'=>[ 
                        'db' =>__d('Formbuilder', 'ذخیره در دیتابیس'), 
                        'email'=>__d('Formbuilder', 'ارسال بصورت ایمیل'), 
                        'all'=>__d('Formbuilder', 'هردو - ذخیره و ایمیل') 
                    ],
                    'class'=>'form-control mb-1']);

                echo $this->Form->control('alert',[
                    'label'=>__d('Formbuilder', 'نحوه اطلاع رسانی'),
                    'type'=>'select',
                    'empty' =>'-- '.__d('Formbuilder', 'انتخاب کنید').' --',
                    'options'=>[
                        1 =>__d('Formbuilder', 'ارسال ایمیل اطلاع رسانی'),
                        0 =>__d('Formbuilder', 'عدم ارسال ایمیل اطلاع رسانی')
                    ],
                    'class'=>'form-control mb-1']);

                echo $this->Form->control('enable',[
                    'label'=>__d('Formbuilder', 'وضعیت'),
                    'type'=>'select',
                    'empty' =>'-- '.__d('Formbuilder', 'انتخاب کنید').' --',
                    'class'=>'form-control mb-1',
                    'options'=>[ 
                        1 =>__d('Formbuilder', 'فعال'), 
                        0 =>__d('Formbuilder', 'غیرفعال')
                    ]]);

                echo $this->Form->control('emails',[
                    'label'=>__d('Formbuilder', 'آدرس ایمیل'),
                    'type'=>'email',
                    'class'=>'ltr form-control mb-1']);
                ?>
                </div></div>
                <div class="card"><div class="card-body">
                <?php
                echo $this->Form->control('formbuilder_items.0.logo',[
                    'type'=>'text',
                    'label'=>__d('Formbuilder', 'تصویر لوگو بالای صفحه'),
                    'class'=>'ltr form-control mb-1'
                ]);

                echo $this->Form->control('formbuilder_items.0.footer',[
                    'type'=>'text',
                    'label'=>__d('Formbuilder', 'متن فوتر'),
                    'class'=>'form-control mb-1']);

                echo $this->Form->control('formbuilder_items.0.submit',[
                    'type'=>'text',
                    'default' =>__d('Formbuilder', 'ثبت فرم'),
                    'label'=>__d('Formbuilder', 'متن کلید ثبت'),
                    'class'=>'form-control mb-1']);
                ?>
                </div></div>
            </div>

            <div class="col-sm-6">
                <div class="card"><div class="card-body">
                <?php 
                echo $this->Form->control('formbuilder_items.0.uinfo',[
                    'type'=>'textarea',
                    'label'=>__d('Formbuilder', 'توضیحات فرم'),
                    'class'=>'form-control mb-1']);

                echo $this->Form->control('formbuilder_items.0.smstext',[
                    'type'=>'textarea',
                    'label'=>__d('Formbuilder', 'متن پیامک'),
                    'class'=>'form-control mb-1']);
                ?>
                </div></div>
            </div>
        </div>
    </div>

    <div class="tab-pane active show" id="home" role="tabpanel">
       
        <div class="form_builder" style="direction:ltr;width:100%">
            <div class="row">
                <div class="col-md-5">
                <div class="alert alert-info text-right"><?=__d('Formbuilder', 'پیش نمایش ها')?></div>
                    <div class="col-md-12 p-0">
                        <div class="form-group plain_html d-none">
                            <?= $this->Form->control('formbuilder_items.0.data',[
                                'type'=>'textarea',
                                'class'=>'form_exported form-control',
                                'rows'=>50])?>
                        </div>
                        <?= $this->Form->end() ?>
                        <div class="preview" style="direction:rtl"></div>
                    </div>
                </div>

                <div class="col-md-5 bal_builder">
                    <div class="alert alert-info text-right"><?=__d('Formbuilder', 'تنظیمات ابزارها')?></div>
                    <div style="position: relative;height: calc( 100% - calc(3.49rem + 3.32rem));overflow-y: auto;">
                        <!-- <div class="form_builder_area"></div> -->
                        <div class="form_builder_area ui-sortable"><?php
                        if($result->id):
                            echo $result['formbuilder_items'][0]['form_html'];
                        else:?><div class="li_68043 form_builder_field" style="width: 437.656px; height: 201.953px;"><div class="all_div"><div class="row li_row"><div class="col-md-12"><button type="button" class="btn btn-primary btn-sm remove_bal_field pull-right" data-field="68043">X</button></div></div></div><hr><div class="row li_row form_output" data-type="text" data-field="68043"><div class="col-md-12"><div class="form-group"><input type="text" name="label_68043" class="form-control rtl form_input_label" value="<?=__d('Formbuilder', 'عنوان فیلد')?>" data-field="68043"></div></div><div class="col-md-12"><div class="form-group"><input type="text" name="placeholder_68043" data-field="68043" class="rtl form-control form_input_placeholder" placeholder="Placeholder"></div></div><div class="col-md-12"><div class="form-group"><input type="text" name="text_68043" required="" class="form-control form_input_name" placeholder="Name"></div></div><div class="col-md-12"><div class="form-check"><label class="form-check-label"><input data-field="68043" type="checkbox" name="check_68043" class="form-check-input form_input_req"><?=__d('Formbuilder', 'اجباری')?></label></div></div></div></div><?php endif?>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-2 rtl">
                <div class="alert alert-info text-right"><?=__d('Formbuilder', 'لیست ابزارها')?></div>
                    <nav class="nav-sidebar p-0">
                        <ul class="nav">
                            <li class="form_bal_textfield">
                                <a href="javascript:;">
                                    <i data-feather='plus-circle' class="pull-right"></i>
                                    <?=__d('Formbuilder', 'فیلد متنی')?> <small>Text Field</small> 
                                </a>
                            </li>
                            <li class="form_bal_textarea">
                                <a href="javascript:;">
                                    <i data-feather='plus-circle' class="pull-right"></i>
                                    <?=__d('Formbuilder', 'ناحیه ی متن')?> <small>Text Area</small> 
                                </a>
                            </li>
                            <li class="form_bal_select">
                                <a href="javascript:;">
                                    <i data-feather='plus-circle' class="pull-right"></i>                            
                                    <?=__d('Formbuilder', 'انتخاب لیستی')?> <small>Select</small> 
                                </a>
                            </li>
                            <li class="form_bal_radio">
                                <a href="javascript:;">
                                    <i data-feather='plus-circle' class="pull-right"></i>
                                    <?=__d('Formbuilder', 'انتخاب تکی')?> <small>Radio Button</small> 
                                </a>
                            </li>
                            <li class="form_bal_checkbox">
                                <a href="javascript:;">
                                    <i data-feather='plus-circle' class="pull-right"></i>
                                    <?=__d('Formbuilder', 'چک باکس')?> <small>Checkbox</small>
                                </a>
                            </li>
                            <li class="form_bal_email">
                                <a href="javascript:;">
                                    <i data-feather='plus-circle' class="pull-right"></i>
                                    <?=__d('Formbuilder', 'ایمیل')?> <small>Email</small>
                                </a>
                            </li>
                            <li class="form_bal_number">
                                <a href="javascript:;">
                                    <i data-feather='plus-circle' class="pull-right"></i>
                                    <?=__d('Formbuilder', 'شماره')?> <small>Number</small>
                                </a>
                            </li>
                            <li class="form_bal_password">
                                <a href="javascript:;">
                                    <i data-feather='plus-circle' class="pull-right"></i>
                                    <?=__d('Formbuilder', 'رمز')?> <small>Password</small>
                                </a>
                            </li>
                            <li class="form_bal_file">
                                <a href="javascript:;">
                                    <i data-feather='plus-circle' class="pull-right"></i>
                                    <?=__d('Formbuilder', 'فایل')?> <small>UploadFile</small>
                                </a>
                            </li>
                            <li class="form_bal_date">
                                <a href="javascript:;">
                                    <i data-feather='plus-circle' class="pull-right"></i>
                                    <?=__d('Formbuilder', 'تاریخ')?> <small>Date</small>
                                </a>
                            </li>
                            <li class="form_bal_button">
                                <a href="javascript:;">
                                    <i data-feather='plus-circle' class="pull-right"></i>
                                    <?=__d('Formbuilder', 'کلید')?> <small>Button</small>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
<style nonce="<?=get_nonce?>">
.form_builder_field{
    height:inherit !important;
    width: 99% !important;
}
.form_builder_area hr{
    margin: 5px 0 !important;
} 
.li_row .form-group{
    margin-bottom:5px;
}
.li_row .form-control{
    padding:6px;
}
.remove_bal_field{
    padding: 0 5px;
}
.form-group .rtl{
    direction: rtl;
}
.all_div .remove_bal_field {
    padding-top: 3px;
    padding-bottom: 2px;
    border-radius: 50px;
    font-family: monospace;
}
.nav-tabs .nav-link.active {
    position: relative;
    color: #FFF;
    background: #7d72ea;
}
.form_builder_area input[type='checkbox']{
    right: 0;
    margin: 0;
    top: 3px;
}
</style>
<script nonce="<?=get_nonce?>">
function checker(){
    /* $('.preview').val() = ''; */
    $('.form_html').val($('.form_builder_area').html());
    $('.form_data').val($('.form_builder_area :input').serialize());
    /* values = jQuery(".form_builder_area :input").serializeArray();
    values = values.concat(
        jQuery('.form_builder_area input[type=checkbox]').map(
                function() {
                    console.log(this);
                    return {"name": this.name, "value": false}
                }).get()
    );
    console.log(values); */

    //return false;
}
$('#forms').submit(function() {
    $(".export_html").click();
    if($('.form_exported').val() == ''){
        alert("<?=__d('Formbuilder', 'فرم شما خالی است. از لیست ابزارها، انتخاب کنید و اضافه کنید')?>");
        return false;
    }
    $('.preview').val() = '';
    return true;
});
function getPreview(plain_html = '') {
        var el = $('.form_builder_area .form_output');
        var html = '';
        el.each(function () {
            var data_type = $(this).attr('data-type');
            //var field = $(this).attr('data-field');
            var label = $(this).find('.form_input_label').val();
            var name = $(this).find('.form_input_name').val();
            if (data_type === 'text') {
                var placeholder = $(this).find('.form_input_placeholder').val();
                var checkbox = $(this).find('.form-check-input');
                var required = '';
                if (checkbox.is(':checked')) {
                    required = 'required';
                    required ='';
                }
                
                html += '<div class="form-group"><label class="control-label">' + label + '</label><input data-title="' + label + '" data-name="' + name + '" type="text" name="' + name + '" placeholder="' + placeholder + '" class="form-control" ' + required + '/></div>';
            }
            if (data_type === 'file') {
                var placeholder = $(this).find('.form_input_placeholder').val();
                var checkbox = $(this).find('.form-check-input');
                var required = '';
                if (checkbox.is(':checked')) {
                    required = 'required';
                    required ='';
                }
                html += '<div class="form-group"><label class="control-label">' + label + '</label><input data-title="' + label + '" data-name="' + name + '" type="file" name="' + name + '" placeholder="' + placeholder + '" class="form-control" ' + required + '/><span class="upload_notify"></span></div>';
            }
            if (data_type === 'number') {
                var placeholder = $(this).find('.form_input_placeholder').val();
                var checkbox = $(this).find('.form-check-input');
                var required = '';
                if (checkbox.is(':checked')) {
                    required = 'required';
                    required ='';
                }
                html += '<div class="form-group"><label class="control-label">' + label + '</label><input data-title="' + label + '" data-name="' + name + '" type="number" name="' + name + '" placeholder="' + placeholder + '" class="form-control" ' + required + '/></div>';
            }
            if (data_type === 'email') {
                var placeholder = $(this).find('.form_input_placeholder').val();
                var checkbox = $(this).find('.form-check-input');
                var required = '';
                if (checkbox.is(':checked')) {
                    required = 'required';
                    required ='';
                }
                html += '<div class="form-group"><label class="control-label">' + label + '</label><input data-title="' + label + '" data-name="' + name + '" type="email" name="' + name + '" placeholder="' + placeholder + '" class="form-control" ' + required + '/></div>';
            }
            if (data_type === 'password') {
                var placeholder = $(this).find('.form_input_placeholder').val();
                var checkbox = $(this).find('.form-check-input');
                var required = '';
                if (checkbox.is(':checked')) {
                    required = 'required';
                    required ='';
                }
                html += '<div class="form-group"><label class="control-label">' + label + '</label><input data-title="' + label + '" data-name="' + name + '" type="password" name="' + name + '" placeholder="' + placeholder + '" class="form-control" ' + required + '/></div>';
            }
            if (data_type === 'textarea') {
                var placeholder = $(this).find('.form_input_placeholder').val();
                var checkbox = $(this).find('.form-check-input');
                var required = '';
                if (checkbox.is(':checked')) {
                    required = 'required';
                    required ='';
                }
                html += '<div class="form-group"><label class="control-label">' + label + '</label><textarea data-title="' + label + '" data-name="' + name + '" rows="5" name="' + name + '" placeholder="' + placeholder + '" class="form-control" ' + required + '/></textarea></div>';
            }
            if (data_type === 'date') {
                var checkbox = $(this).find('.form-check-input');
                var required = '';
                if (checkbox.is(':checked')) {
                    required = 'required';
                    required ='';
                }
                html += '<div class="form-group"><label class="control-label">' + label + '</label><input data-title="' + label + '" data-name="' + name + '" type="date" name="' + name + '" class="form-control" ' + required + '/></div>';
            }
            if (data_type === 'button') {
                var btn_class = $(this).find('.form_input_button_class').val();
                var btn_value = $(this).find('.form_input_button_value').val();
                html += '<button name="' + name + '" type="submit" class="' + btn_class + '">' + btn_value + '</button>';
            }
            if (data_type === 'select') {
                var option_html = '';
                $(this).find('select option').each(function () {
                    var option = $(this).html();
                    var value = $(this).val();
                    option_html += '<option value="' + value + '">' + option + '</option>';
                });
                html += '<div class="form-group"><label class="control-label">' + label + '</label><select data-title="' + label + '" data-name="' + name + '" class="form-control" name="' + name + '">' + option_html + '</select></div>';
            }
            if (data_type === 'radio') {
                var option_html = '';
                $(this).find('.mt-radio').each(function () {
                    var option = $(this).find('p').html();
                    var value = $(this).find('input[type=radio]').val();
                    option_html += '<div class="form-check"><label class="form-check-label"><input data-title="' + label + '" data-name="' + name + '" type="radio" class="form-check-input" name="' + name + '" value="' + value + '">' + option + '</label></div>';
                });
                html += '<div class="form-group"><label class="control-label">' + label + '</label>' + option_html + '</div>';
            }
            if (data_type === 'checkbox') {
                var option_html = '';
                $(this).find('.mt-checkbox').each(function () {
                    var option = $(this).find('p').html();
                    var value = $(this).find('input[type=checkbox]').val();
                    option_html += '<div class="form-check"><label class="form-check-label"><input data-title="' + label + '" data-name="' + name + '" type="checkbox" class="form-check-input" name="' + name + '[]" value="' + value + '">' + option + '</label></div>';
                });
                html += '<div class="form-group"><label class="control-label">' + label + '</label>' + option_html + '</div>';
            }
        });
        if (html.length) {
            $('.export_html').show();
        } else {
            $('.export_html').hide();
        }
        if (plain_html === 'html') {
            $('.preview').hide();
            $('.plain_html').show().find('textarea').val(html);
        } else {
            $('.plain_html').hide();
            $('.preview').html(html).show();
    }
}
</script>
<?php
if($form_data != null){
    $fdata = explode('&',$form_data);
    if(is_array($fdata)){
        echo '<script nonce="'.get_nonce.'">
        $(function() {';
        foreach($fdata as $fd){
            $fd = explode('=',$fd);
            if(isset($fd[0]) and isset($fd[0])):echo "\n"; 
                if($fd[1] == "on"){?>
                    $("input[name='<?=$fd[0]?>']").prop('checked', true);
                <?php }else{?>
                    $("input[name='<?=$fd[0]?>']").val("<?=$fd[1]?>");<?php 
                }
            endif;
        }
        echo '
        });
        $(document).ready(function () {
            getPreview();
        });
        </script>';
    }
}
?>
<?= $this->Html->script([
    '/Formbuilder/js/popper.min.js',
    '/Formbuilder/js/jquery-ui.min.js',
    '/Formbuilder/js/form_builder.js?d='.date("d"),
],['nonce'=>get_nonce])?>