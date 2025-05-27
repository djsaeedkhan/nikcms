<!DOCTYPE html>
    <html class="loading" lang="en" data-textdirection="rtl">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>
            <?= $this->Func->OptionGet('name');?>
            <?= $this->fetch('title')!=''?' - '.$this->fetch('title'):'';?>
        </title>
        <?php if(($icon = $this->Query->info('site_favicon'))!= ''):?>
            <link rel="shortcut icon" type="image/x-icon" href="<?= $icon;?>">
        <?php endif?>

        <?php
        echo $this->Html->css([
            '/admin/app-assets/vendors/css/vendors-rtl.min.css']);
        echo $this->Html->css([
            '/admin/app-assets/css-rtl/bootstrap.css',
            '/admin/app-assets/css-rtl/bootstrap-extended.css',
            '/admin/app-assets/css-rtl/colors.css',
            '/admin/app-assets/css-rtl/components.css',
            '/admin/app-assets/css-rtl/themes/dark-layout.css',
            '/admin/app-assets/css-rtl/themes/bordered-layout.css',
            '/admin/app-assets/css-rtl/themes/semi-dark-layout.css',
            ]);
        echo $this->Html->css([
            '/admin/app-assets/css-rtl/core/menu/menu-types/vertical-menu.css',
            '/admin/app-assets/css-rtl/plugins/forms/form-validation.css',
            '/admin/app-assets/css-rtl/pages/page-auth.css',
            ]);
        echo $this->Html->css([
            '/admin/app-assets/css-rtl/custom-rtl.css',
            '/admin/assets/css/style-rtl.css',
            '/admin/css/css/style.css?'.date('his'),
        ]);
        echo $this->Html->script([
            '/admin/app-assets/vendors/js/vendors.min.js',

            ])?>
    </head>

    <body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static" data-open="click" data-menu="vertical-menu-modern" data-col="blank-page">
        <!-- BEGIN: Content-->
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            <div class="content-wrapper">
                <div class="content-header row"></div>
                <div class="content-body">