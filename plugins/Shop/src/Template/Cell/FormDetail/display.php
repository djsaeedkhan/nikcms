<?php
    global $count;
    global $p_label2;
    $pattern = isset($data['pattern'])?$data['pattern']:null;
?>

<div class="formdetails"><div class="row">
    <div class="col-sm-12">
        <?= $this->Form->control('Meta.'.($pattern!=null?$pattern.'.':'').'image',[
            'class'=>'form-control form-control-sm ltr',
            'default'=> (isset($data['image'])?$data['image']:''),
            'label'=>'تصویر محصول','id'=>'dtimg'.($pattern!=null?str_replace(',','',$pattern):''),
            'style'=>'padding-right:30px;']);?>
            
        <?= '<div class="mb-2" style="cursor:pointer;margin-top: -25px;float: right;margin-right: 10px;">
            <a data-toggle="modal" data-target="#exampleModal" data-action="select_src" 
                title="انتخاب تصویر" data-dest="dtimg'.($pattern!=null?str_replace(',','',$pattern):'').'" style="color:#9e9e9e;cursor:pointer">
                <i data-feather="camera"></i></a></div>';?>
    </div>
    <div class="col-sm-6 mb-1">
        <?= $this->Form->control('Meta.'.($pattern!=null?$pattern.'.':'').'sku',[
            'default'=> (isset($data['sku'])?$data['sku']:''),
            'class'=>'form-control form-control-sm ltr','label'=>'شناسه محصول (SKU)']);?>
    </div>
    <div class="col-sm-6 mb-1">
        <?= $this->Form->control('Meta.'.($pattern!=null?$pattern.'.':'').'stock',[
            //'default'=> (isset($data['stock'])?$data['stock']:''),
            'default'=> (isset($product_data['stocks'][$pattern])?$product_data['stocks'][$pattern]:''),
            'type'=>'number','class'=>'form-control form-control-sm ltr','label'=>'موجودی انبار']);?>
    </div>
    <div class="col-sm-6 mb-1">
        <?= $this->Form->control('Meta.'.($pattern!=null?$pattern.'.':'').'price',[
            'default'=> (isset($data['price'])?$data['price']:''),'type'=>'number',
            'class'=>'form-control form-control-sm ltr numeral-mask','label'=>'قیمت فروش ('.$p_label2.')']);?>
    </div>
    <div class="col-sm-6 mb-1">
        <!-- <?php $this->Form->control('Meta.'.($pattern!=null?$pattern.'.':'').'special_price',[
            'default'=> (isset($data['special_price'])?$data['special_price']:''),'type'=>'number',
            'class'=>'form-control form-control-sm ltr numeral-mask','label'=>'قیمت فروش ویژه ('.$p_label2.')']);?> -->
    </div>
    
    <!-- <div class="col-sm-12 pt-2">
        <?= $this->Form->control('Meta.'.($pattern!=null?$pattern.'.':'').'disable',[
            'default'=> (isset($data['disable'])?$data['disable']:''),'type'=>'checkbox',
            'class'=>'form-control form-control-sm','label'=>'غیرفعال شود']);?>
    </div>
    <div class="col-sm-12 pb-2">
        <?= $this->Form->control('Meta.'.($pattern!=null?$pattern.'.':'').'description',[
            'type'=>'textarea','class'=>'form-control form-control-sm',
            'default'=> (isset($data['descr'])?$data['descr']:''),
            'style'=>'height:60px;','label'=>false , 'placeholder'=>'توضیحات']);?>
    </div> -->
    <?= $this->Form->control('Meta.'.($pattern!=null?$pattern.'.':'').'pattern',[
        'type'=>'hidden',
        'default'=> (isset($data['pattern'])?$data['pattern']:'')]);?>
        
</div></div>

<div class="major">
    <br>
    <div class="cls13">مدیریت بخش فروش عمده</div>
    <hr>
    <div class="mojudi-single" data-pattern="<?= $pattern?>">
        <?php
        if(isset($product_data['major_list'])):
            foreach($product_data['major_list'] as $k => $p):
                if($p['pattern'] == $pattern):?>
                <div class="row">
                    <?= $this->Form->control("big_price.{$count}.pattern",[
                        'type'=>'hidden',
                        'default'=> $pattern ]);?>
                    <div class="col-sm-5">
                        <?= $this->Form->control("big_price.{$count}.start",[
                            'type' => 'number',
                            'class' => 'form-control form-control-sm mb-1 ltr',
                            'default' => $p['start'],
                            'label' => 'از تعداد'])?>
                    </div>
                    <div class="col-sm-6">
                        <?= $this->Form->control("big_price.{$count}.price",[
                            'type' => 'number',
                            'class' => 'form-control form-control-sm mb-1 ltr',
                            'default' => $p['price'],
                            'label' => 'قیمت هرعدد ('.$p_label2.')'])?>
                    </div>
                    <div class="col-sm-1 wholed" title="حذف" style="color:#F00"> x </div>
                </div>
                <?php 
                $count += 1;
                endif;
            endforeach;
        else:
            //echo '<script>$(document).ready(function(){$(".btnadds").trigger("click");});</script>';
        endif;?>
    </div>
        <a class="btn btn-success btn-sm btnadds text-white" id="btnadds">افزودن سطر جدید</a><br><br>
</div>
<script nonce="<?=get_nonce?>">
    //document.getElementById("btnadds").dispatchEvent(new Event('change',{}));
</script>