<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title1 float-right mb-0">
                    <?= __d('Admin', 'چندرسانه ای');?>&nbsp;
                </h2>
                <div class="breadcrumb-wrapper">
                    <?php
                    $def = isset($result['gallery_size'])?unserialize($result['gallery_size']):'';
                    if($def == null)
                        echo '<span class="badge badge-warning">'.__d('Admin', 'غیرفعال') .'</span>';
                    else
                        echo '<span class="badge badge-success">'.__d('Admin', 'فعال'). '</span>';
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->Form->create(null, ['class'=>'','url'=>['action'=>'SaveSetting']]);?>
<div class="row">

    <div class="col-sm-6">
        <div class="card"><div class="card-body">
            <h4 class="pb-1">
                <?=__d('Admin', 'تنظیمات  بارگذاری پرونده‌ها')?>
            </h4>
            <div class="custom-control custom-switch custom-control-inline" >
                <input type="hidden" name="uploads_folders" value="0" />
                <input type="checkbox" class="custom-control-input" name="uploads_folders" id="customSwitch1" value="0" disabled
                    <?= (isset($result['uploads_folders']) and $result['uploads_folders']==1)?'checked':''?> />
                <label class="custom-control-label" for="customSwitch1">
                    <?= __d('Admin', 'پرونده‌ها را ماهانه و سالانه سازماندهی کن')?>
                </label>
            </div><br><br>

            <div class="custom-control custom-switch custom-control-inline" >
                <input type="hidden" name="white_png_background" value="0" />
                <input type="checkbox" class="custom-control-input" name="white_png_background" id="white_png_background" value="1"
                    <?= (isset($result['white_png_background']) and $result['white_png_background']==1)?'checked':''?> />
                <label class="custom-control-label" for="white_png_background">
                    <?= __d('Admin', 'سفیدرنگ شدن پس زمینه تصاویر png هنگام آپلود')?>
                </label>
            </div><br><br>


            <div class="custom-control custom-switch custom-control-inline" >
                <input type="hidden" name="media_renamefile" value="0" />
                <input type="checkbox" class="custom-control-input" name="media_renamefile" id="media_renamefile" value="1"
                    <?= (isset($result['media_renamefile']) and $result['media_renamefile']==1)?'checked':''?> />
                <label class="custom-control-label" for="media_renamefile">
                    <?= __d('Admin', 'نام فایل آپلود شده به اسمی بی مسما تغییر نام پیدا کند')?>
                    <Br>
                    <?= __d('Admin', 'مثلا')?> (<?=$this->Func->UniqId().'.jpg'?>)
                </label>
            </div><br><br>

            
        </div></div>
    </div>

    <div class="col-sm-6">
        <div class="card"><div class="card-body">
            <h4 class="pb-1">
                <?=__d('Admin', 'تنظیمات صفحه آپلود')?>
            </h4>
            <?= $this->Form->control('media_zone', [
                'type'=>'select',
                'label'=>__d('Admin', 'فرم نمایش آپلود'),
                'class'=>'form-control mb-2',
                'empty'=>'-- '.__d('Admin', 'انتخاب کنید').' --',
                'options'=>[
                    1 =>__d('Admin', 'دستی') , 
                    2 =>__d('Admin', 'درگ دراپ'),
                    3 =>__d('Admin', 'انتخاب چندتایی')
                ],
                'default'=>isset($result['media_zone'])?$result['media_zone']:'']);
            ?>
        </div></div>
    </div>

    <div class="col-sm-6">
        <div class="card"><div class="card-body">
            <h4 class="pb-1">
                <?= __d('Admin', 'تنظیمات برش تصویر')?>
            </h4>
            
            <div class="row pl-2">
                <?php foreach($this->Func->gallery_size() as $lk => $lv){ ?>
                    <div class="col-md-4 col-sm-3 custom-control custom-control-primary custom-checkbox mb-1">
                        <input class="custom-control-input" 
                            type="checkbox" 
                            name="gallery_size[<?=$lk?>]" 
                            id="gallery_size-<?=$lk?>" 
                            value="1" 
                            <?= (isset($def[$lk]) and $def[$lk] == 1)?'checked':'';?> >

                        <label class="custom-control-label"  style="min-width:100px"
                            for="gallery_size-<?=$lk?>">
                                <div style="text-transform: capitalize;">&nbsp;&nbsp;<b><?=$lk;?></b></div>
                                <div class="" style="font-family:tahoma;">
                                    Width: <?= $lv['width']?>px <br>
                                    Height:<?= $lv['height']?>px <br>
                                    Crop: <?= $lv['mode']?>
                                </div>
                        </label>
                    </div><bR>
                <?php }?>


            </div><br>
            
            <div class="alert alert-primary">
                <?= __d('Admin', 'در صورتی برای این صفحه تنظیماتی ثبت نشود، برای همه سایز ها (ابعاد) تصاویر برش خواهند خورد')?>
            </div>
        </div></div>
    </div>

    <div class="col-sm-6">
        <div class="card"><div class="card-body">
            <h4 class="pb-1">
                <?=__d('Admin', 'تنظیمات واترمارک آپلود')?>
            </h4>

            <div class="custom-control custom-switch custom-control-inline" >
                <input type="hidden" name="watermark_enable" value="0" />
                <input type="checkbox" class="custom-control-input" name="watermark_enable" id="watermark_enable" value="1"
                    <?= (isset($result['watermark_enable']) and $result['watermark_enable']==1)?'checked':''?> />
                <label class="custom-control-label" for="watermark_enable">
                    <?= __d('Admin', 'فعال سازی افزودن واترمارک به تصاویر')?>
                </label>
            </div><br><br>

            <?= $this->Form->control('watermark_url', [
                'placeholder'=>'https://',
                'label'=>__d('Admin', 'آدرس تصویر واترمارک (فقط پسوند png)'),
                'class'=>'form-control mb-2 ltr',
                'default'=>isset($result['watermark_url'])?$result['watermark_url']:'']);
            ?>
            
            <div class="row">
                <div class="col-sm-6">
                    <?= $this->Form->control('marge_right', [
                        'type'=>'number',
                        'placeholder'=>'100 پیشفرض',
                        'label'=>__d('Admin', 'فاصله از راست'),
                        'class'=>'form-control mb-2 ltr',
                        'default'=>isset($result['marge_right'])?$result['marge_right']:'']);?>
                </div>
                <div class="col-sm-6">
                    <?= $this->Form->control('marge_bottom', [
                        'type'=>'number',
                        'placeholder'=>'100 پیشفرض',
                        'label'=>__d('Admin', 'فاصله از پایین'),
                        'class'=>'form-control mb-2 ltr',
                        'default'=>isset($result['marge_bottom'])?$result['marge_bottom']:'']);?>
                </div>
            </div>
        </div></div>
    </div>

</div>

<?= $this->Form->button(__d('Admin', 'ثبت اطلاعات'),['class'=>'btn btn-sm btn-success']);?>
<?= $this->Form->end(); ?>

<style>
@media (min-width: 576px){
    .col-sm-6 {
        display: grid;
    }
}
</style>