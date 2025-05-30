<?php
use Cake\Routing\Router;
use Cake\ORM\TableRegistry;
if($this->Func->OptionGet('role'.$this->request->getAttribute('identity')->get('role_id')) === "0"){
    echo $this->Func->Redirect(Router::url('/'));
}
$dir = 'rtl';// = $this->Func->language_list($current_lang,'arr_dir');?>
<!DOCTYPE html>
<html class="loading" lang1="en" data-text direction1="<?= $dir=='rtl'?'rtl':'ltr'?>">
<!-- BEGIN: Head-->
<head><?php /*<meta http-equiv='Content-Security-Policy' content="script-src 'strict-dynamic' 'nonce-<?=get_nonce?>'"> */?>
    <?= $this->Func->CSP();?>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="author" content="mehregan-system">
    <link rel="shortcut icon" type="image/x-icon" href="<?= $this->Query->info('site_favicon');?>">
    <title>
        <?= $this->Func->OptionGet('name');?> <?= $this->fetch('title')!=''?' - '.$this->fetch('title'):'';?>
    </title>
    <?= $this->Html->css([
        '/admin/app-assets/vendors/css/vendors'.($dir =='rtl'?'-rtl':'').'.min.css',
        '/admin/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css',
        '/admin/app-assets/vendors/css/extensions/toastr.min.css',
        '/admin/app-assets/vendors/css/forms/select/select2.min.css',
        '/admin/app-assets/vendors/css/file-uploaders/dropzone.min.css',
        '/admin/app-assets/css'.($dir =='rtl'?'-rtl':'').'/plugins/forms/form-file-uploader.css',
        '/admin/app-assets/vendors/css/extensions/dragula.min.css',
        '/admin/app-assets/css'.($dir =='rtl'?'-rtl':'').'/plugins/forms/pickers/form-flat-pickr.css',
        '/admin/app-assets/css'.($dir =='rtl'?'-rtl':'').'/bootstrap.css',
        '/admin/app-assets/css'.($dir =='rtl'?'-rtl':'').'/bootstrap-extended.css',
        '/admin/app-assets/css'.($dir =='rtl'?'-rtl':'').'/colors.css',
        '/admin/app-assets/css'.($dir =='rtl'?'-rtl':'').'/components.css',
        '/admin/app-assets/css'.($dir =='rtl'?'-rtl':'').'/themes/dark-layout.css',
        '/admin/app-assets/css'.($dir =='rtl'?'-rtl':'').'/themes/bordered-layout.css',
        '/admin/app-assets/css'.($dir =='rtl'?'-rtl':'').'/themes/semi-dark-layout.css',
        '/admin/app-assets/css'.($dir =='rtl'?'-rtl':'').'/core/menu/menu-types/horizontal-menu.css',
        '/admin/app-assets/css'.($dir =='rtl'?'-rtl':'').'/pages/dashboard-ecommerce.css',
        '/admin/app-assets/css'.($dir =='rtl'?'-rtl':'').'/plugins/extensions/ext-component-toastr.css',
        '/admin/app-assets/css'.($dir =='rtl'?'-rtl':'').'/plugins/extensions/ext-component-drag-drop.css',
        $dir =='rtl'?'/admin/app-assets/css-rtl/custom-rtl.css':'',
        '/admin/assets/css/style'.($dir =='rtl'?'-rtl':'').'.css',
        '/admin/css/css/style.css?'.date('his'),
        '/admin/css/persianDatepicker-default.css',
        '/admin/css/tagify2021.css',
        '/admin/css/tagify.css',
    ],['nonce'=>get_nonce])?>
    <style>
        <?= ($this->Func->OptionGet('admin_extrastyle'))?>
    </style>
    <?= $this->Html->script([
        '/admin/app-assets/vendors/js/vendors.min.js?2',
        //'/admin/app-assets/vendors/js/extensions/dropzone.min.js',
        '/admin/app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js',
        '/admin/js/persianDatepicker.js',
        '/admin/js/jQuery.tagify.min.js',
        '/admin/js/jquery-tagsinput.js',
        '/admin/js/dragsort.js',
        inter_mode == true?[
            '/admin/js/tinymce/tinymce.min.js',
            '/admin/js/tinymce/plugins/code/plugin.min.js',
            '/admin/js/tinymce/plugins/advlist/plugin.min.js',
            '/admin/js/tinymce/plugins/autolink/plugin.min.js',
            '/admin/js/tinymce/plugins/lists/plugin.min.js',
            '/admin/js/tinymce/plugins/image/plugin.min.js',
            '/admin/js/tinymce/plugins/charmap/plugin.min.js',
            '/admin/js/tinymce/plugins/print/plugin.min.js',
            '/admin/js/tinymce/plugins/preview/plugin.min.js',
            '/admin/js/tinymce/plugins/directionality/plugin.min.js',
            '/admin/js/tinymce/plugins/paste/plugin.min.js',
            '/admin/js/tinymce/plugins/contextmenu/plugin.min.js',
            '/admin/js/tinymce/plugins/table/plugin.min.js',
            '/admin/js/tinymce/plugins/media/plugin.min.js',
            '/admin/js/tinymce/plugins/insertdatetime/plugin.min.js',
            '/admin/js/tinymce/plugins/visualblocks/plugin.min.js',
            '/admin/js/tinymce/plugins/searchreplace/plugin.min.js',
            '/admin/js/tinymce/plugins/link/plugin.min.js',
            '/admin/js/tinymce/plugins/anchor/plugin.min.js',
            '/admin/js/tinymce/plugins/fullscreen/plugin.min.js',
            '/admin/js/tinymce/plugins/textcolor/plugin.min.js',
            '/admin/js/tinymce/themes/modern/theme.min.js'
            ]:
            'https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.9.11/tinymce.min.js',
        
    ],['nonce'=>get_nonce])?>
    <script nonce="<?=get_nonce?>">
        if (feather) {feather.replace({width: 14,height: 14});}
        $(window).on('load', function() {if (feather) {feather.replace({width: 14,height: 14});}})
    </script>
    <script nonce="<?=get_nonce?>">
    $( document ).ready(function() {
        function submitCspForm(e){
            let conditionValue = e.getAttribute('data-csp-confirm');
            let form = document.getElementsByName(e.getAttribute('data-csp-form'))[0];
            if (conditionValue === null || confirm(conditionValue) == true) {
                form.submit()
            }
        }
        [...document.getElementsByClassName('csp-postLink')].forEach(e => e.addEventListener('click', () => submitCspForm(e)))
    });
    </script>
</head>
<?= $this->fetch('modal');?>

<body class="vertical-layout vertical-menu-modern  navbar-floating1 navbar-sticky footer-static" data-open="click" data-menu="vertical-menu-modern" data-col="">

    <!-- BEGIN: Header-->
    <nav class="header-navbar navbar navbar-expand-lg align-items-center <?= $this->request->getQuery('nonav')?'d-none':'floating-nav1'?> navbar-light navbar-shadow fixed-top">
        <div class="navbar-container d-flex content">
            <div class="bookmark-wrapper d-flex align-items-center">
                <ul class="nav navbar-nav d-xl-none">
                    <li class="nav-item" style="margin-right: 5px;">
                        <a class="nav-link menu-toggle" href="javascript:void(0);">
                            <i class="ficon" data-feather="menu"></i>
                        </a>
                    </li>
                </ul>
                <ul class="nav navbar-nav bookmark-icons">
                    <li class="nav-item d-none d-lg-block"><a class="nav-link" href="#" data-toggle="tooltip" data-placement="top" title="<?=__d('Admin', 'ایمیل')?>"><i class="ficon" data-feather="mail"></i></a></li>
                    <li class="nav-item d-none d-lg-block"><a class="nav-link" href="#" data-toggle="tooltip" data-placement="top" title="<?= __d('Admin', 'چت')?>"><i class="ficon" data-feather="message-square"></i></a></li>
                    <li class="nav-item d-none d-lg-block"><a class="nav-link" href="#" data-toggle="tooltip" data-placement="top" title="<?= __d('Admin', 'تقویم')?>"><i class="ficon" data-feather="calendar"></i></a></li>
                    <li class="nav-item d-none d-lg-block"><a class="nav-link" href="#" data-toggle="tooltip" data-placement="top" title="<?= __d('Admin', 'لیست اقدام')?>"><i class="ficon" data-feather="check-square"></i></a></li>
                </ul>
            </div>
            <ul class="nav navbar-nav align-items-center ml-auto">
                
                <li class="nav-item btn-showsite">
                    <?php 
                    if($this->Func->OptionGet('admin_hdr_showsitetitle')!= '-'){
                        echo $this->Html->link(
                            ( ($p = $this->Func->OptionGet('admin_hdr_showsitetitle')) != ''?$p:
                                __d('Admin', 'نمایش سایت') )
                            ,
                            ( ($p = $this->Func->OptionGet('admin_hdr_showsitelink')) != ''?$p:'/')
                            ,['class'=>'btn btn-sm btn-flat-primary waves-effect','target'=>'_blank','escape'=>false]);
                    }?>
                </li>
                
                <?php 
                if($this->Func->OptionGet('admin_hdr_showsitetitle2')!= ''){
                    echo '<li class="nav-item btn-showsite2">';
                    echo $this->Html->link(
                        $this->Func->OptionGet('admin_hdr_showsitetitle2'),
                        $this->Func->OptionGet('admin_hdr_showsitelink2'),
                        ['class'=>'btn btn-sm btn-flat-primary waves-effect','target'=>'_blank','escape'=>false]);
                    echo '</li>';
                }?>
            
                <li class="nav-item dropdown dropdown-language d-none d-lg-block nav-lang">
                    <a class="nav-link dropdown-toggle" id="dropdown-flag" href="javascript:void(0);" 
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="<?= $this->Func->language_list($current_lang);?>">
                        <i class="flag-icon flag-icon-<?php
                        switch ($current_lang) {
                            case 'fa':echo 'ir'; break;
                            case 'en':echo 'us'; break;
                            case 'ar':echo 'sa'; break;
                            default:echo $current_lang;break;
                        }?>"></i>
                        <!-- <span class="selected-language">
                            <?php // $this->Func->language_list($current_lang);?>
                        </span> -->
                    </a>
                </li>
                <li class="nav-item nav-moon"><a class="nav-link nav-link-style"><i class="ficon" data-feather="moon"></i></a></li>

                <?php if( $this->request->getAttribute('identity')->get('role_id') == 1):?>
                    <li class="nav-item dropdown dropdown-notification mr-25">
                        <?php
                        $temp = null;
                        $count = 0;
                        $alarm = [];
                        $list = TableRegistry::getTableLocator()->get('Admin.Options')->find('list',['keyField'=>'name','valueField'=>'value'])
                            ->where(['name LIKE'=> 'alert_%'])->toarray();
                        if($list and is_array($list)){
                            foreach($list as $lst){
                                $temp = unserialize($lst);
                                if(is_array($temp)){
                                    foreach($temp as $v){
                                        $count += $v['count'];
                                        $alarm[] = $v;
                                    }
                                }
                            }
                        }
                        ?>
                        <a class="nav-link" href="javascript:void(0);" data-toggle="dropdown">
                            <i class="ficon" data-feather="bell"></i>
                            <span class="badge badge-pill badge-danger badge-up"><?=$count?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                            <li class="dropdown-menu-header">
                                <div class="dropdown-header d-flex">
                                    <h4 class="notification-title mb-0 mr-auto"><?= __d('Admin', 'اطلاع رسانی')?></h4>
                                    <div class="badge badge-pill badge-light-primary"><?=$count?> <?= __d('Admin', 'جدید')?></div>
                                </div>
                            </li>
                            <li class="scrollable-container media-list">
                                <?php foreach($alarm as $alrm):?>
                                    <a class="d-flex" href="<?=Router::url($alrm['link'].'?read=true')?>">
                                        <div class="media d-flex align-items-start">
                                            <div class="media-left">
                                                <div class="avatar bg-light-danger">
                                                    <div class="avatar-content" 
                                                        title="<?=(isset($alrm['plugin']) and $alrm['plugin']!='')?$alrm['plugin']:''?>" 
                                                        style="text-transform: uppercase;">
                                                        <?=(isset($alrm['plugin']) and $alrm['plugin']!='')?
                                                            substr($alrm['plugin'],0,2):''?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <p class="media-heading">
                                                    <!-- <span class="font-weight-bolder">boldtext</span> -->
                                                    <?= $alrm['title']?>
                                                </p>
                                                <small class="notification-text">
                                                    <?=(isset($alrm['descr']) and $alrm['descr'] !='')?
                                                    $alrm['descr']:
                                                    __d('Admin', 'برای نمایش پیام کلیک کنید')?>
                                                </small>
                                            </div>
                                        </div>
                                    </a>
                                <?php endforeach; echo count($alarm) == 0?
                                    '<div style="padding: 10px;text-align:center">'.__d('Admin', 'پیامی برای نمایش وجود ندارد') .'</div>':
                                    ''?>
                            </li>
                            <li class="dropdown-menu-footer"><!-- <a class="btn btn-primary btn-block" href="javascript:void(0)">دیدن تمام پیغام ها</a> --></li>
                        </ul>
                    </li>
                <?php endif?>
                <li class="nav-item dropdown dropdown-user">
                    <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="user-nav d-sm-flex d-none">
                            <span class="user-name font-weight-bolder"><?= $this->request->getAttribute('identity')->get('family');?></span>
                            <span class="user-status"><?= $this->request->getAttribute('identity')->get('username');?></span>
                        </div>
                        <span class="avatar">
                            <?= $this->html->image('/admin/img/avatars/6.jpg',[
                                'class'=>'round','width'=>'40','height'=>'40'])?>
                            <span class="avatar-status-online"></span>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-user">

                        <div class="dropdown-item d-sm-none d-block">
                            <span class="user-name font-weight-bolder"><?= $this->request->getAttribute('identity')->get('family');?></span>
                            <span class="user-status"><?= $this->request->getAttribute('identity')->get('username');?></span>
                        
                        </div>
                        <div class="dropdown-divider d-sm-none d-block"></div>

                        

                        <?= $this->Html->link('<i class="mr-50" data-feather="user"></i> پروفایل',
                            '/admin/users/profile',
                            ['escape'=>false,'class'=>'dropdown-item']);?>
                        <!-- <a class="dropdown-item" href="#"><i class="mr-50" data-feather="mail"></i> صندوق ورودی</a> -->
                        <!-- <a class="dropdown-item" href="#"><i class="mr-50" data-feather="check-square"></i> وظایف</a>
                        <a class="dropdown-item" href="#"><i class="mr-50" data-feather="message-square"></i> چت</a> -->
                        <!-- <a class="dropdown-item" href="#"><i class="mr-50" data-feather="settings"></i> تنظیمات</a> -->
                        <div class="dropdown-divider"></div>
                        <?= $this->Html->link('<i class="mr-50" data-feather="power"></i> خروج',
                            '/users/logout',
                            ['escape'=>false,'class'=>'dropdown-item',
                            'confirm'=>__d('Admin', 'برای خروج از پنل کاربری مطمئن هستید؟')]);?>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <!-- END: Header-->

    <!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow menu-dark1" data-scroll-to-active="true">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto"><a class="navbar-brand" href1="<?= Router::url('/admin/')?>"><span class="brand-logo">
                    <?php if($this->Func->OptionGet('dashboard_logo') != ''):
                        echo $this->html->image($this->Func->OptionGet('dashboard_logo'),['style'=>'max-width: 50px;max-height: 30px;']);
                    else:?>
                        <svg viewbox="0 0 139 95" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="24">
                            <defs>
                                <lineargradient id="linearGradient-1" x1="100%" y1="10.5120544%" x2="50%" y2="89.4879456%">
                                    <stop stop-color="#000000" offset="0%"></stop>
                                    <stop stop-color="#FFFFFF" offset="100%"></stop>
                                </lineargradient>
                                <lineargradient id="linearGradient-2" x1="64.0437835%" y1="46.3276743%" x2="37.373316%" y2="100%">
                                    <stop stop-color="#EEEEEE" stop-opacity="0" offset="0%"></stop>
                                    <stop stop-color="#FFFFFF" offset="100%"></stop>
                                </lineargradient>
                            </defs>
                            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="Artboard" transform="translate(-400.000000, -178.000000)">
                                    <g id="Group" transform="translate(400.000000, 178.000000)">
                                        <path class="text-primary" id="Path" d="M-5.68434189e-14,2.84217094e-14 L39.1816085,2.84217094e-14 L69.3453773,32.2519224 L101.428699,2.84217094e-14 L138.784583,2.84217094e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L6.71554594,44.4188507 C2.46876683,39.9813776 0.345377275,35.1089553 0.345377275,29.8015838 C0.345377275,24.4942122 0.230251516,14.560351 -5.68434189e-14,2.84217094e-14 Z" style="fill:currentColor"></path>
                                        <path id="Path1" d="M69.3453773,32.2519224 L101.428699,1.42108547e-14 L138.784583,1.42108547e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L32.8435758,70.5039241 L69.3453773,32.2519224 Z" fill="url(#linearGradient-1)" opacity="0.2"></path>
                                        <polygon id="Path-2" fill="#000000" opacity="0.049999997" points="69.3922914 32.4202615 32.8435758 70.5039241 54.0490008 16.1851325"></polygon>
                                        <polygon id="Path-21" fill="#000000" opacity="0.099999994" points="69.3922914 32.4202615 32.8435758 70.5039241 58.3683556 20.7402338"></polygon>
                                        <polygon id="Path-3" fill="url(#linearGradient-2)" opacity="0.099999994" points="101.428699 0 83.0667527 94.1480575 130.378721 47.0740288"></polygon>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    <?php endif?>
                    </span>
                    <h2 class="brand-text" 
                        style="<?=strlen($this->Func->OptionGet('name'))<40?'font-size: 1.40rem;':'font-size: 15px;'?>">
                        <?= $this->Func->OptionGet('name');?>
                    </h2>
                </a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <?= $this->element('Admin.side_menu');?>
        </div>
    </div>
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <div class="app-content content" style="<?= $this->request->getQuery('nonav')?'padding-top: 20px !important;':''?>">
        <div class="content-wrapper">
            <div class="content-body">
                <?= $this->Flash->render() ?>
                <?= $this->fetch('content');?>
            </div>
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-light">
        <p class="clearfix mb-0 d-none">
            <span class="float-md-right d-none d-md-block">
                طراحی و پیاده سازی: 
                <a href="https://mehregan-system.com/" target="_blank" title="گروه برنامه نویسی مهرگان سیستم سیلک">
                مهرگان سیستم سیلک</a>
            </span>
        </p>
    </footer>
    <button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
    <!-- END: Footer-->

    <!-- BEGIN: Page Vendor JS--><?= $this->Html->script([
        '/admin/app-assets/vendors/js/ui/jquery.sticky.js',
        '/admin/app-assets/vendors/js/extensions/toastr.min.js',
        '/admin/app-assets/vendors/js/forms/cleave/cleave.min.js',
        '/admin/app-assets/vendors/js/forms/select/select2.full.min.js',
        '/admin/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js',
        '/admin/app-assets/js/scripts/forms/form-repeater.js',
        '/admin/app-assets/vendors/js/extensions/dragula.min.js',
        '/admin/app-assets/js/core/app-menu.js',
        '/admin/app-assets/js/core/app.js?1',
        '/admin/app-assets/js/scripts/forms/form-select2.js',
        '/admin/app-assets/js/scripts/extensions/ext-component-drag-drop.js',
        //'/admin/app-assets/js/scripts/components/components-popovers.js',
        inter_mode == true?'/admin/js/jquery.dataTables.min.js':'https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js',
        inter_mode == true?'/admin/js/dataTables.buttons.min.js':'https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js',
        inter_mode == true?'/admin/js/buttons.flash.min.js':'https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js',
        inter_mode == true?'/admin/js/jszip.min.js':'https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js',
        '/admin/js/buttons.print.min.js',
        '/admin/js/buttons.html5.min.js',
    ],['nonce'=>get_nonce]);?>




    <script nonce="<?=get_nonce?>">
        $(document).ready(function() {
            $('#tbexample').DataTable({
                dom: 'Bfrtip',
                pageLength: 5000000000,
                buttons: ['copy', 'excel', 'pdf', 'print'],
                language:{
                    "sProcessing":"<?=__d('Admin', 'در حال جستجو')?> ...",
                    "sSearch":"<?= __d('Admin', 'جستجو')?>: ",
                    "sZeroRecords":"<?= __d('Admin', 'چیزی پیدا نشد')?>",
                    "buttons": {
                        "print":"<?= __d('Admin', 'پرینت')?>",
                        "copy":"<?= __d('Admin', 'کپی')?>",
                        "pdf":'PDF',
                        "excel":'<?= __d('Admin', 'اکسل')?>',
                    }
                }
            });
            $('div.dataTables_filter input').addClass('form-control form-control-sm');
        } );
        //------------------------------------------------
        $(document).ready(function() {$('[data-role="tags-input"]').tagsInput();});
        //------------------------------------------------
       /* var input = document.querySelector('input[id=drag-sort]');
        new Tagify(input, {
            whitelist: [1,2,3,4,5],
            userInput: false
        }) */

        /*  var dragsort = new DragSort(tagify.DOM.scope, {
            selector:'.'+tagify.settings.classNames.tag,
            callbacks: {
                dragEnd: onDragEnd
            }
        })
        function onDragEnd(elm){
            tagify.updateValueByDOMTags()
        } */
        //------------------------------------------------>
    tinymce.init({
        forced_root_block : "", 
        convert_urls: false,
        force_br_newlines : true,
        force_p_newlines : false,
        selector: "#pubEditor",  // change this value according to your HTML
        //rtl_ui:true,
        directionality: "rtl",
        plugins:[
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste directionality",
        ],
        toolbar: "ltr rtl | fontselect fontsizeselect | insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
        font_formats: "Tahoma=tahoma,arial,helvetica,sans-serif;Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Open Sans=Open Sans,helvetica,sans-serif;Symbol=symbol;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats",
        fontsize_formats: "8px 10px 11px 12px 14px 18px 24px 36px",
        setup: function (ed) {
            ed.on('init', function (ed) {
                ed.target.editorCommands.execCommand("fontName", false, "tahoma");
            });
        }
    });

    //table2excel.js
    //https://www.jqueryscript.net/demo/Export-Html-Table-To-Excel-Spreadsheet-using-jQuery-table2excel/
    ;(function ( $, window, document, undefined ) {
            var pluginName = "table2excel",
                    defaults = {
                    exclude: ".noExl",
                    name: "Table2Excel"
            };
            // The actual plugin constructor
            function Plugin ( element, options ) {
                    this.element = element;
                    // jQuery has an extend method which merges the contents of two or
                    // more objects, storing the result in the first object. The first object
                    // is generally empty as we don't want to alter the default options for
                    // future instances of the plugin
                    this.settings = $.extend( {}, defaults, options );
                    this._defaults = defaults;
                    this._name = pluginName;
                    this.init();
            }
            Plugin.prototype = {
                init: function () {
                    var e = this;
                    e.template = "<html xmlns:o=\"urn:schemas-microsoft-com:office:office\" xmlns:x=\"urn:schemas-microsoft-com:office:excel\" xmlns=\"http://www.w3.org/TR/REC-html40\"><head><!--[if gte mso 9]><xml>";
                    e.template += "<x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions>";
                    e.template += "<x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>";
                    e.tableRows = "";

                    // get contents of table except for exclude
                    $(e.element).find("tr").not(this.settings.exclude).each(function (i,o) {
                        e.tableRows += "<tr>" + $(o).html() + "</tr>";
                    });
                    this.tableToExcel(this.tableRows, this.settings.name);
                },
                tableToExcel: function (table, name) {
                    var e = this;
                    e.uri = "data:application/vnd.ms-excel;base64,";
                    e.base64 = function (s) {
                        return window.btoa(unescape(encodeURIComponent(s)));
                    };
                    e.format = function (s, c) {
                        return s.replace(/{(\w+)}/g, function (m, p) {
                            return c[p];
                        });
                    };
                    e.ctx = {
                        worksheet: name || "Worksheet",
                        table: table
                    };
                    window.location.href = e.uri + e.base64(e.format(e.template, e.ctx));
                }
            };
            $.fn[ pluginName ] = function ( options ) {
                this.each(function() {
                    if ( !$.data( this, "plugin_" + pluginName ) ) {
                            $.data( this, "plugin_" + pluginName, new Plugin( this, options ) );
                    }
                });
                // chain jQuery functions
                return this;
            };
    })( jQuery, window, document );
    </script>

    <style>
    .fw-n{
        font-weight:normal;
    }
    pre {
        background-color: #F7F7F9;
        direction: ltr;
        text-align: left;
    }
    .dataTables_wrapper .dt-buttons{
        float: right;
    }
    .dataTables_filter{
        float: left;
    }
    .dataTables_filter label{
        padding-top: 0 !important;
        margin-top: 0 !important;
    }
    .main-menu .navbar-header {
        height: initial;
    }
    .navbar-brand {
        white-space: inherit;
    }
    .main-menu .navbar-header .navbar-brand .brand-text {
        padding-right: 0.6rem;
    }
    .tagify{
        padding-right: 5px;
        padding-left: 5px;
    }
    .tags-look .tagify__dropdown__item{
        display: inline-block;
        border-radius: 3px;
        padding: .3em .5em;
        border: 1px solid #CCC;
        background: #F3F3F3;
        margin: .2em;
        font-size: .85em;
        color: black;
        transition: 0s;
    }
    .tags-look .tagify__dropdown__item--active{
        color: black;
    }
    .tags-look .tagify__dropdown__item:hover{
        background: lightyellow;
        border-color: gold;
    }
    .tagify__tag>div {
        padding: 0 !important;
        padding-right: 13px !important;
    }
    .tagify__tag__removeBtn{
        margin-right: -3px;
    }
    .tagify__tag{
        background: #e5e5e5;
    }
    .tagify__tag--editable{
        background:#FFF !important;
    }
    .nav-vertical .tagify{
        height: 45px !important;
    }
    .error-message{
        background: #f44336;
        color: #FFF;
        padding: 5px;
    }
    
    </style>
</body>
<!-- END: Body-->
</html>