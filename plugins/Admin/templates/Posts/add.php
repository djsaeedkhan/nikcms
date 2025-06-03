<?php
use Admin\View\Helper\ModuleHelper;
use Cake\ORM\TableRegistry;
$path = $this->request->getAttribute("webroot") . $upload_path;
?>
<!-- <script src='//static.codepen.io/assets/common/stopExecutionOnTimeout-41c52890748cd7143004e05d3c5f786c66b19939c4500ce446314d1748483e13.js'></script>-->
<script nonce="<?=get_nonce?>">
var myListItems = {<?php 
    foreach(ModuleHelper::post_elementor() as $k=>$nav){
        echo "'{$k}'".':'."`{$nav}`,";
    }?>};

tinymce.PluginManager.add('mhelementor', function (editor) {
    var menuItems = [];
    tinymce.each(myListItems, function (key, value) {
        menuItems.push({text: value,onclick: function () {editor.insertContent(key);}});
    });
    editor.addButton('mhelementor', {
        type: 'menubutton',
        text: '<?=__d('Admin', 'المنتور')?>',
        tooltip: '<?= __d('Admin', 'برای افزودن المان به ادیتور کلیک کنید')?>',
        menu: menuItems
        //icon: 'code',
    });
    editor.addMenuItem('mhelementorDropDownMenu', {
        icon: 'code',
        text: '<?= __d('Admin', 'المان های پیشفرض')?>',
        menu: menuItems,
        context: 'insert',//prependToContext: true
    });
});
</script>

<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                <?= (isset($post['id'])?
                    $this->Func->get_label($post_types,'single_edit'):$this->Func->get_label($post_types,'single_add'))?>
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                        <?= (isset($post['id'])?$this->Auths->link(
                            $this->Func->get_label($post_types,'index_add')
                            ,['action'=>'Add','?'=>['post_type'=>$post_types]],['class'=>'btn btn-primary btn-sm']):'');?>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <?php if(isset($post->id)):?>
    <div class="content-header-left col-md-3 col-12" style="text-align:left">
        <?= $this->Form->control('PostMetas.template',[
            'onchange'=>"window.location.href='?langview='+this.value",
            'label'=>__d('Admin', 'درحال نمایش زبان'),
            'empty'=>'-- '.__d('Admin', 'پیش فرض').' --',
            'class'=>'form-control form-control-sm',
            'type'=>'select',
            'default'=>isset($change_lang_to)?$change_lang_to:$this->Func->Optionget('lang_name'),
            'options'=>$this->Func->language_list()  
        ]);?>
    </div>
    <?php endif?>

    <style>
        .content-header-left > div{display: inline-flex;}
        .content-header-left select{width: inherit;}
        .content-header-left label{padding-top: 4px;padding-left: 10px;}
        #delete_thumimg{color: #5E50EE;cursor: pointer;margin-top:10px;}
    </style>

</div>

<?= $this->Form->create($post,['id' => 'myform','class'=>'post_page']) ?>
<script nonce="<?=get_nonce?>">
$("#myform").submit(function(){
    let isValidDate = Date.parse($('#pdpGregorian').val());
    if (!$('#pdpGregorian').val() && isNaN(isValidDate)) {
        alert("<?= __d('Admin', 'تاریخ وارد شده صحیح نمی باشد')?>");
        $('#pdpGregorian').focus();
        return false;
    }
    return true;
});
</script>

<?php
if(isset($post_meta_list['show_in_slider']) and $post_meta_list['show_in_slider'] == 1):?>
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">تنظیمات مربوط به اسلایدر</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="width:100%;">
                <?php
                echo $this->Form->control('PostMetas.slider_title',[
                    'default'=>(isset($post_meta_list['slider_title'])?$post_meta_list['slider_title']:''),
                    'class'=>'form-control mb-2','label'=>'بازنویسی عنوان اسلایدر (اختیاری)',]);

                echo $this->Form->control('PostMetas.slider_desc',[
                    'class'=>'form-control mb-2',
                    'type'=>'textarea',
                    'default'=>(isset($post_meta_list['slider_desc'])?$post_meta_list['slider_desc']:''),
                    'label'=>'بازنویسی توضیحات (اختیاری)',]);

                echo $this->Form->control('PostMetas.slider_image',[
                    'class'=>'form-control mb-2 ltr',
                    'placeholder'=>'https://',
                    'default'=>(isset($post_meta_list['slider_image'])?$post_meta_list['slider_image']:''),
                    'label'=>'بازنویسی لینک تصویر (اختیاری)',]);
                
                echo $this->Form->control('PostMetas.slider_label',[
                    'class'=>'form-control mb-2',
                    'placeholder'=>'',
                    'default'=>(isset($post_meta_list['slider_label'])?$post_meta_list['slider_label']:''),
                    'label'=>'لیبل نمایش (اختیاری)',]);
                    
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">ثبت</button>
            </div>
        </div>
    </div>
</div>
<!-- Vertical modal end-->
<?php endif?>

<div class="row">
    <div class="col-sm-8">
        <div class="card cart1"><div class="card-body">
        <?= $this->Form->control('title',[ 
            //'templates' => ['inputContainer' => ''],
            'type'=>'text',
            'required',
            'label'=>__d('Admin', 'عنوان'),
            'class'=>'form-control mb-1']);?>

        <?= $this->Form->control('slug',[
            //'templates' => ['inputContainer' =>'{{content}}'],
            'type'=>'text',
            'class'=>'form-control form-control-sm ltr',
            'label'=>__d('Admin', 'نامک') ]);?>
        </div></div>

        <!-- --------------------------------------------------------- -->
        <?php 
        if($this->Func->plugin_available('Elementor')){
            if(isset($post_meta_list)){
                echo $this->cell('Elementor.Home',[$post_meta_list]);
            }
            else
                echo '<div class="alert alert-secondary">'.
                __d('Admin', 'لطفا ابتدا پست را منتشر کرده تا از المنتور بتوانید استفاده کنید').'</div>';
        }
        ?>
        <!-- --------------------------------------------------------- -->
        <?php if($this->Func->get_ptaccess($post_types,'editor')):?>
            <div class="card cart1"><div class="card-body">
                <?= $this->Html->link(
                    __d('Admin', 'افزودن پرونده چندرسانه ای'),
                    false,[
                    'id'=>'upload','class'=>'btn btn-primary btn-sm pull-left',
                    'data-toggle'=>'modal','data-target'=>'#exampleModal','data-action'=>'select_gallery']);?>
                <div style="margin-top:10px;"></div>
                <div class="clearfix"></div>
                
                <?=  $this->Form->control('content', [
                    'type' => 'textarea',
                    'class' => 'edittextarea form-control',
                    'label' => __d('Admin', 'محتوا'),
                    'rows'=>15,
                    'id'=>'edittextarea',
                    'style'=>'margin-top: 12px;',
                    'class'=>'form-control',
                    'div'=>'form-group']);?>
            </div></div>

            <script nonce="<?=get_nonce?>">
            tinymce.init({
                invalid_elements: "script",
                valid_elements: '*[*]',

                forced_root_block : "", 
                convert_urls: false,
                force_br_newlines : true,
                force_p_newlines : false,
                selector: "#edittextarea",  // change this value according to your HTML
                //rtl_ui:true,
                directionality: "<?=$this->Func->language_list($current_lang,'arr_dir')?>",
                plugins:[
                    "advlist autolink lists link image charmap print preview anchor textcolor",
                    "searchreplace visualblocks code fullscreen mhelementor", //
                    "insertdatetime media table contextmenu paste directionality",
                ],
                toolbar: "ltr rtl | mhelementor | fontselect fontsizeselect | insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify| bullist numlist outdent indent | link image media forecolor backcolor ",
                //textcolor_cols: "2",
                textcolor_maps: [
                    "000000", "Black",
                    "993300", "Burnt orange",
                    "333300", "Dark olive",
                    "003300", "Dark green",
                    "003366", "Dark azure",
                    "000080", "Navy Blue",
                    "333399", "Indigo",
                    "333333", "Very dark gray",
                    "800000", "Maroon",
                    "FF6600", "Orange",
                    "808000", "Olive",
                    "008000", "Green",
                    "008080", "Teal",
                    "0000FF", "Blue",
                    "666699", "Grayish blue",
                    "808080", "Gray",
                    "FF0000", "Red",
                    "FF9900", "Amber",
                    "99CC00", "Yellow green",
                    "339966", "Sea green",
                    "33CCCC", "Turquoise",
                    "3366FF", "Royal blue",
                    "800080", "Purple",
                    "999999", "Medium gray",
                    "FF00FF", "Magenta",
                    "FFCC00", "Gold",
                    "FFFF00", "Yellow",
                    "00FF00", "Lime",
                    "00FFFF", "Aqua",
                    "00CCFF", "Sky blue",
                    "993366", "Red violet",
                    "FFFFFF", "White",
                    "FF99CC", "Pink",
                    "FFCC99", "Peach",
                    "FFFF99", "Light yellow",
                    "CCFFCC", "Pale green",
                    "CCFFFF", "Pale cyan",
                    "99CCFF", "Light sky blue",
                    "CC99FF", "Plum"
                ],
                font_formats: "Tahoma=tahoma,arial,helvetica,sans-serif;Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Open Sans=Open Sans,helvetica,sans-serif;Symbol=symbol;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats",
                fontsize_formats: "8px 10px 11px 12px 14px 18px 24px 36px",
                setup: function (ed) {
                    ed.on('init', function (ed) {
                        ed.target.editorCommands.execCommand("fontName", false, "tahoma");
                    });
                }
            });
            </script>
        <?php endif;?>
        <!-- --------------------------------------------------------- -->
        <?php if($this->Func->get_ptaccess($post_types,'excerpt')):?>
        <div class="card cart1"><div class="card-body">
        <?=  $this->Form->control('summary',[
            'type'=>'textarea',
            'label'=>__d('Admin', 'توضیحات کوتاه'),
            'class'=>'form-control']);?>
        </div></div>
        <?php endif;?>
        <!-- --------------------------------------------------------- -->
        <?php
        //Load cell
        if(count(@$navmenu = $this->Func->admin_postwidget($post_types))):
            foreach($navmenu as $nav){
                foreach($nav as $knav=>$vnav)
                    echo $this->cell($vnav,[$knav,isset($post_meta_list)?$post_meta_list:[]]);
            }
        endif;
        ?>
    </div>
    <div class="col-sm-4">
        <!-- --------------------------------------------------------- -->
        <style>
            .cart2 .select select, .cart2 .text input {
                width: fit-content;
                display: inline;
                margin-right: 2px;
                min-width: 115px;
                width: 115px;
                padding: 5px 10px 8px !important;
                height: auto !important;
            }
            .cart2 .select label,
            .cart2 .text label{
                min-width: 55px !important;
                width: 60px !important;
            }
        </style>
        <!-- --------------------------------------------------------- -->
        <div class="card cart1 cart2"><div class="card-body pl-1 pb-0">
            
            <?= $this->Form->button(
                $post->id?__d('Admin', 'بروز رسانی'):__d('Admin', 'انتشار'),[
                'class'=>'btn btn-success pull-left'])?>
            
            <?=  $this->Form->control('published',[
                'type'=>'select',
                'empty'=>false,
                'required',
                'label'=>__d('Admin', 'وضعیت'),
                'options' =>$this->Func->predata('post_publish_list'),
                'class'=>'form-control mb-1']);?>

            <?=  $this->Form->control('post_status',[
                'options' => $this->Func->predata('post_show_list'),
                'type'=>'select',
                'id'=>'post_status',
                'empty'=>false,
                'required',
                'label'=>__d('Admin', 'نمایانی'),
                'class'=>'form-control mb-1']);?>

            <div class="<?=$post['post_status'] == 3?'':'d-none';?>">
                <div class="alert alert-secondary aw1">
                    <div class="row">
                        <div class="col-sm-5 pr-0">
                            <?= $this->Form->control('PostMetas.adpost_password',[
                                'label'=>__d('Admin', 'پسورد') .': ',
                                'id'=>'adpost_password',
                                'class'=>'form-control ltr form-control-sm',
                                'default'=>(isset($post_meta_list['adpost_password'])?$post_meta_list['adpost_password']:''),
                                ]);?>
                        </div>
                        <div class="col-sm-7">
                            <?= $this->Form->control('PostMetas.adpost_passtype',[
                                'type'=>'select',
                                'label'=>__d('Admin', 'نحوه نمایش').': ',
                                'id'=>'adpost_passtype',
                                'options'=>[
                                    1 =>__d('Admin', 'عدم نمایش متن نوشته'),
                                    2 =>__d('Admin', 'عدم نمایش کل صفحه'),
                                ],
                                'class'=>'form-control form-control-sm pr-0',
                                'default'=>(isset($post_meta_list['adpost_passtype'])?$post_meta_list['adpost_passtype']:''),
                                ]);?>
                        </div>
                    </div>
                    <script nonce="<?=get_nonce?>">
                        $('#post_status').on('change', function() {
                        if(this.value == 3){
                            $('#adpost_password').parent().parent().parent().parent().parent().removeClass('d-none');
                        }
                        else{
                            $('#adpost_password').parent().parent().parent().parent().parent().addClass('d-none');
                            $('#adpost_password').val("") ;
                        }
                        });
                    </script>
                </div>
            </div>

            <?php
            $time = null;
            if(isset($post->created)){
                if($this->Func->Optionget('admin_calender') != 1 ){
                    $time = date('Y/m/d',strtotime($post->created->format('Y-m-d')));
                    $post->created = $this->Func->mil_to_shm($time,'/') .' '. date('H:i:s',strtotime($post->created->format('H:i:s')));
                }
                else
                    $post->created = date('Y/m/d H:i:s',strtotime($post->created->format('Y-m-d H:i:s')));
            }else{
                //$post->created = date('Y/m/d H:i:s',strtotime($post->created->format('Y-m-d H:i:s')));
                if($this->Func->Optionget('admin_calender') != 1 ){
                    $post->created = $this->Func->mil_to_shm(date('Y/m/d'),'/') .' '. date('H:i:s',strtotime(date('H:i:s')));
                }
                else
                    $post->created = date('Y/m/d H:i:s');
            }

            echo $this->Form->control('created',[
                'type'=>'text',
                'label'=>__d('Admin', 'تاریخ ثبت'),
                'id'=>'pdpGregorian',
                'style'=>'font-family:tahoma;width: 170px;',
                'class'=>'form-control invoice-edit-input due-date-picker date-picker ltr mb-1' ]);
            ?>

            <?php if($this->Func->Optionget('admin_calender') ==1):?>
                <!-- https://flatpickr.js.org/examples/ -->
                <?= $this->Html->css([
                    inter_mode == true?'/admin/css/flatpickr.min.css':'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css']);?>

                <?= $this->Html->script([
                    inter_mode == true?'/admin/js/flatpickr.js':'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css'],['nonce'=>get_nonce]);?>
                <script nonce="<?=get_nonce?>">
                    $("#pdpGregorian").flatpickr({enableTime: true,dateFormat: "Y/m/d H:i:s",});
                    $("#pdpGregorian2").flatpickr({enableTime: true,dateFormat: "Y/m/d H:i:s",});
                    </script>
            <?php else:?>
                <script nonce="<?=get_nonce?>">
                    //https://behzadi.github.io/persianDatepicker/
                    $("#pdpGregorian").persianDatepicker({ 
                        //formatDate: "YYYY/0M/0D hh:mm:ss",
                        formatDate: "YYYY/0M/0D 0h:0m:0s",
                        fontSize: 13, // by px
                        selectableMonths: [01, 02, 03, 04, 05, 06, 07, 08, 09, 10, 11, 12],
                        persianNumbers: !0,
                        isRTL: !1,  //  isRTL:!0 => because of persian words direction
                        //onSelect: function () {alert('asd')},
                        showGregorianDate: <?=$this->Func->Optionget('admin_calender') == 1?'true':'false'?> });

                    $("#pdpGregorian2").persianDatepicker({ 
                        //formatDate: "YYYY/0M/0D hh:mm:ss",
                        formatDate: "YYYY-0M-0D",
                        fontSize: 13, // by px
                        selectableMonths: [01, 02, 03, 04, 05, 06, 07, 08, 09, 10, 11, 12],
                        persianNumbers: !0,
                        isRTL: !1,  //  isRTL:!0 => because of persian words direction
                        //onSelect: function () {alert('asd')},
                        showGregorianDate: true });
                </script>
            <?php endif?>

                    <style>
                    /* .move > .select{display: inline;} */
                    .move #move_status {
                        width: 100% !important;
                        min-width: 100% !important;
                        height: 39px !important;
                    }
                </style>
            <?php if(isset($post->id)):?>
            <div class="d-flex justify-content-between1 mb-1 move">
                <label class="move-title pr-1" for="move" style="padding-top: 10px;">
                    <?= __d('Admin', 'جابجایی')?>
                </label>
                <div class="d-block" style="width:100%;">
                    <div id="accordionWrapa1" role="tablist" aria-multiselectable="true">
                        <div id="heading1"  data-toggle="collapse" role="button" data-target="#accordion1" 
                            aria-expanded="false" aria-controls="accordion1" style="margin-top: 10px;">
                            <i data-feather="plus-circle"></i>
                        </div>
                        <div id="accordion1" role="tabpanel" data-parent="#accordionWrapa1" aria-labelledby="heading1" class="collapse">
                            <div class="row">
                                <div class="col-md-4 pr-0">
                                    <?= $this->Form->control('move_status',[
                                        'empty'=>'-',
                                        'options' =>[
                                            'before'=>__d('Admin', 'قبل از'),
                                            'after'=>__d('Admin', 'بعداز'),
                                            'move'=>__d('Admin', 'جابجایی'),
                                            'same'=>__d('Admin', 'هم تاریخ')],
                                        'type'=>'select','id'=>'move_status','label'=>false,
                                        'class'=>'form-control']);?>
                                </div>
                                <div class="col-md-8">
                                    <?=  $this->Form->control('move_id',[
                                        'options' => 
                                            TableRegistry::getTableLocator()->get('Admin.Posts')
                                            ->find('list',['keyField'=>'id','valueField'=>'title'])
                                            ->where(['post_type'=>$post_types,'Posts.id !='=>$post['id']])
                                            ->order(['created'=>'desc'])->toarray()
                                        /*$this->Query->post($post_types,[
                                            'field'=>['id','title'],'limit'=>0, 
                                            'order'=>'created',
                                            'find_type'=>'list']) */,
                                        'type'=>'select',
                                        'id'=>'move_id','empty'=>'-',
                                        'label'=>false,'style'=>'width:100%',
                                        'class'=>'form-control select2']);?>
                                </div>
                            </div>
                            <div class="alert alert-secondary small mt-1 text-center"style="padding: 7px;">
                                <b><?=__d('Admin', 'توجه')?>:</b>
                                <?=__d('Admin', 'جابجایی به روش تغییر تاریخ ثبت پست بصورت اتوماتیک انجام می شود')?>.
                            </div>  

                        </div>
                    </div>
                    <script nonce="<?=get_nonce?>">
                        $("#heading1").click(function(){
                            $(this).addClass('d-none');
                        });
                    </script>
                </div>
                
            </div>
            <?php endif?>

            <div class="d-flex justify-content-between1 mb-1">
                <label class="pin-title pr-1" for="pin">
                    <?= __d('Admin', 'سنجاق')?> (Pin)
                </label>
                <div class="custom-control custom-switch">
                    <input type="checkbox" name="PostMetas[pin]" value="1" class="custom-control-input" 
                    <?=(isset($post_meta_list['pin']) and $post_meta_list['pin'] == 1)?'checked':''?> id="pin" />
                    <label class="custom-control-label" for="pin"></label>
                    <!-- <i data-feather="flag"></i> -->
                </div>
            </div>

            <div class="d-flex justify-content-between1 mb-1">
                <label class="show_in_slider-title pr-1" for="show_in_slider">
                    <?= __d('Admin', 'نمایش در اسلایدر');?>
                </label>
                <div class="custom-control custom-switch">
                    <input type="checkbox" name="PostMetas[show_in_slider]" value="1" class="switch-control custom-control-input" <?=(isset($post_meta_list['show_in_slider']) and $post_meta_list['show_in_slider'] == 1)?'checked':''?> id="show_in_slider" />
                    <label class="custom-control-label" for="show_in_slider"></label>
                    <!-- <i data-feather="flag"></i> -->
                    <a style="cursor:pointer" class="<?=(isset($post_meta_list['show_in_slider']) and $post_meta_list['show_in_slider'] == 1)?'':'d-none'?> show_in_slider_modal"  data-toggle="modal" data-target="#exampleModalCenter">تنظیمات</a>
                </div>

                <script>
                    $('#show_in_slider').change(function(){
                        if($(this).prop('checked') == true){
                            $('#show_in_slider').prop( "checked", true );
                            $('.show_in_slider_modal').removeClass('d-none');
                        }
                        else{
                            $('.show_in_slider_modal').addClass('d-none');
                            $('#show_in_slider').prop( "checked", false );
                        }
                    });
                </script>
            </div>
            
            <?php if($post['id']):?>
            <div class="d-flex">
                <!-- <?php /* $this->Auths->postlink('<i data-feather="trash"></i> حذف نوشته',
                    ['action'=>'Delete',$post['id'] ],
                    ['escape'=>false,'class'=>'p-2','confirm'=>'Are U sure to delete post?','style'=>'color:#F00;']); */?> -->


                <?= $this->Form->postlink('<i data-feather="trash"></i> '.__d('Admin', 'حذف نوشته'),
                    ['action'=>'Delete',$post['id'] ],
                    ['escape'=>false,'class'=>'d-none',]);?>

                <?= $this->Form->postlink('<i data-feather="trash"></i> '.__d('Admin', 'حذف نوشته'),
                    ['action'=>'Delete',$post['id'] ],
                    ['escape'=>false,'class'=>'p-2','confirm'=>'Are U sure to delete post?','style'=>'color:#F00;']);?>

                <div class="p-2 pull-left">
                    <?php
                        echo '<span title="'.__d('Admin', 'نمایش مطلب').'">'.
                        $this->Query->permalink(
                            __d('Admin', 'نمایش مطلب'),
                            $post
                            ).'</span>';
                        echo ' | &nbsp;';
                        echo $this->html->link('<i data-feather="link"></i>',
                                '/p/'.$post['id'],
                                ['escape'=>false,'class'=>'ml-0 float-left ',
                                'target'=>'_blank',
                                'title'=>__d('Admin', 'لینک کوتاه مطلب') ]);  
                    ?>
                </div>
            </div>
            <?php endif?>
        </div></div>
        <!-- --------------------------------------------------------- -->
        <!-- --------------------------------------------------------- -->
        <?php if($this->Func->get_ptaccess($post_types,'category')):?>
        <div class="card cart1"><div class="card-body" >
        <label for="categories-ids" style="font-weight: bold;">
            <?= __d('Admin', 'دسته بندی')?>
            <?= $this->Auths->link(
                '[ '.__d('Admin', 'مدیریت').' ]',
                ['controller'=>'Categories','action'=>'index','?'=>['post_type'=>$post_types]],
                ['target'=>'_blank']);?>
        </label>
        <?=  $this->Form->control('categories._ids', [
            'class'=>'form-control checkbox',
            'label'=>false,
            'escape'=>false,
            'templates' => [
                'inputContainer' => '<div class="checkbox" style="height:200px;overflow:auto">{{content}}</div>',
                'input' => '<input type="{{type}}" name="{{name}}"{{attrs}}/>',
                'nestingLabel' => '{{hidden}}<label{{attrs}}>{{text}}</label> {{input}}',
                'checkboxWrapper' => '<div class="radio" {{text}}>{{label}}</div>'
            ],
            'multiple'=>'checkbox', 
            'div'=>'form-group']);?>
        </div>
        
        </div>
        <?php endif;?>
        <!-- --------------------------------------------------------- -->
        <!-- --------------------------------------------------------- -->
        <?php if($post_types == 'page'):?>
        <div class="card cart1"><div class="card-body" >
        <?= $this->Form->control('PostMetas.template',[
            'label'=>__d('Admin', 'Template'),
            'empty'=>'-- '.__d('Admin', 'پیش فرض').' --',
            'class'=>'form-control',
            'type'=>'select',
            'default'=>(isset($post_meta_list['template'])?$post_meta_list['template']:''),
            'options'=>$this->Func->PageListGet()]);
            ?>
        </div></div>
        <?php endif;?>
        <!-- --------------------------------------------------------- -->
        <!-- --------------------------------------------------------- -->
        <?php if($this->Func->get_ptaccess($post_types,'tag')):?>
        <div class="card cart1"><div class="card-body">
            <?php
            echo $this->Html->css(array(
                //'/admin/css/tagify.css',
                //'https://yaireo.github.io/tagify/dist/tagify.css'
                ));?>
            <?php $taglist='';if($post->tags)foreach($post->tags as $tag)$taglist.= str_replace('"','',$tag['title']).',';?>
            <?= $this->Form->control('data.tagss', array(
                'name'=>'taglist',
                'type'=>'text',
                'id'=>'taglist',
                'placeholder'=>__d('Admin', 'بنویسید و اینتر بزنید'),
                'label'=>[
                    'text'=>__d('Admin', 'برچسب'),
                    'style'=>'font-weight: bold'
                ],
                'dir'=>$this->Func->language_list($current_lang,'arr_dir'),
                'default'=>$taglist,
                ));?><small><?= __d('Admin', 'برچسب‌ها را با ویرگول لاتین (,) جدا کنید')?></small><br>

            <?php
            $result = TableRegistry::getTableLocator()->get('Admin.Tags')
                ->find('list',['keyField'=>'id','valueField'=>'title'])
                ->where(['post_type'=> $post_types,'title !='=>''])
                ->limit(100)
                ->toarray();
            $vals = array_count_values($result );
            ?>
            <script nonce="<?=get_nonce?>">
                ///var myInput = $('[name=taglist]').tagify();
                var input = document.querySelector('[name=taglist]'),
                tagify = new Tagify(input, {
                whitelist: [<?php foreach($vals as $kv =>$val) echo '"'.str_replace('"','',$kv).'" , ';?>],
                maxTags: 25,
                dropdown: {
                    maxItems: 20,           // <- mixumum allowed rendered suggestions
                    classname: "tags-look", // <- custom classname for this dropdown, so it could be targeted
                    enabled: 0,             // <- show suggestions on focus
                    closeOnSelect: false    // <- do not hide the suggestions dropdown once an item has been selected
                }
                });
            </script>
        </div></div>
        <?php endif;?>
        <!-- ---------------------------------------------------------- -->
        <!-- ---------------------------------------------------------- -->
        <!-- <div class="card cart1"><div class="card-body" >
        
        </div></div> -->
        <!-- ---------------------------------------------------------- -->
        <!-- ---------------------------------------------------------- -->
        <?php if($this->Func->get_ptaccess($post_types,'author')):?>
            <div class="card cart1"><div class="card-body">
            <?=  $this->Form->control('user_id', [
                'options' => $users,
                'default'=> isset($post['user_id'])?$post['user_id']: $user_ids ,
                'label'=>[
                    'text'=>__d('Admin', 'نویسنده'),
                    'style'=>'font-weight:bold'
                ],
                'class'=>'form-control']);?>
            </div></div>
        <?php endif?>
        <!-- --------------------------------------------------------- -->
        <?php if($this->Func->get_ptaccess($post_types,'thumbnail')):?>
            <div class="card cart1"><div class="card-body text-center">
            <br>
            <?php
            if(isset($post_meta_list['thumbnail'])){
                $temp = $this->Func->PostGet($post_meta_list['thumbnail']);
                if(isset($temp['post_metas']['thumbnail'])){
                    echo $this->Html->link('[انتخاب تصویر شاخص]<br>',false,[
                        'id'=>'upload2','data-toggle'=>'modal','data-target'=>'#exampleModal','data-action'=>'select_thumbnail','escape'=>false]);
                    echo '<img id="post_image_cover" src="'.$path.$temp['post_metas']['thumbnail'].'" class="img-responsive img-thumbnail">';
                    echo '<br><div id="delete_thumimg">['.__d('Admin', 'حذف تصویر'). ']</div>';
                }
                else{
                    echo $this->Html->link(
                        '['. __d('Admin', 'انتخاب تصویر شاخص') .']<br>',false,[
                        'id'=>'upload2','data-toggle'=>'modal','data-target'=>'#exampleModal','data-action'=>'select_thumbnail','escape'=>false]);
                    echo '<img id="post_image_cover" src="" class="img-responsive">';
                    echo '<br><div id="delete_thumimg"></div>';
                }
            }
            else{
                echo $this->Html->link(
                    '['. __d('Admin', 'انتخاب تصویر شاخص') .']<br>',
                    false,[
                    'id'=>'upload2','data-toggle'=>'modal','data-target'=>'#exampleModal','data-action'=>'select_thumbnail','escape'=>false]);
                echo '<img id="post_image_cover" src="" class="img-responsive">';
                echo '<br><div id="delete_thumimg"></div>';
            }
            ?>
            <?= $this->Form->control('PostMetas.thumbnail',[
                'type'=>'hidden',
                'id'=>'post_metas__thumbnail',
                'default'=>(isset($post_meta_list['thumbnail'])?$post_meta_list['thumbnail']:'')]);?>

            <?= $this->Form->control('PostMetas.setting',[
                'type'=>'hidden',
                'default'=>(isset($post_meta_list['setting'])?$post_meta_list['setting']:'')]);?>
            </div></div>
        <?php endif;?>
        <!-- --------------------------------------------------------- -->
        <!-- --------------------------------------------------------- -->
    </div>
</div>
<?= $this->Form->end() ?>
<!-- -------------------------------------- -->
<!-- -------------------------------------- -->

<script nonce="<?=get_nonce?>">
    document.getElementById('delete_thumimg').addEventListener('click', function(e) {
        $("#post_image_cover").attr("src", null);
        $("#post_metas__thumbnail").val('');
        $("#delete_thumimg").html("");
        e.preventDefault();
    }, false);

    <?php for($i=1;$i<15;$i++):?>
    tinymce.init({
        forced_root_block : "", 
        convert_urls: false,
        force_br_newlines : true,
        force_p_newlines : false,
        selector: "#edittextarea<?=$i?>",
        directionality: "<?=$this->Func->language_list($current_lang,'arr_dir')?>",//rtl
        plugins:[
            "advlist autolink lists link image charmap print preview anchor textcolor",
                "searchreplace visualblocks code fullscreen mhelementor", //
                "insertdatetime media table contextmenu paste directionality", ],
        toolbar: "ltr rtl | mhelementor | fontselect fontsizeselect | insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify| bullist numlist outdent indent | link image media forecolor backcolor ",
        font_formats: "Tahoma=tahoma,arial,helvetica,sans-serif;Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Open Sans=Open Sans,helvetica,sans-serif;Symbol=symbol;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats",
        fontsize_formats: "8px 10px 11px 12px 14px 18px 24px 36px",
        setup: function (ed) {
            ed.on('init', function (ed) {
                ed.target.editorCommands.execCommand("fontName", false, "tahoma");
            });
        }
    })
    <?php endfor?>
</script>

<?php $this->start('modal');?>
    <?= $this->cell('Admin.Favorite::upload',[]);?>
<?php $this->end(); ?>