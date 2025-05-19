<?php

use Cake\Routing\Router;
use Shop\View\Helper\CartHelper;
use Shop\Predata;
$predata = new Predata;
$setting = unserialize($this->Func->OptionGet('plugin_shop'));
$p_label2 = CartHelper::Predata('currency',$setting['currency']);

?>

<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title1 float-right mb-0">
                    روش های ارسال
                </h2>
            </div>
        </div>
    </div>
</div>


<?= $this->Form->create(null,[
        'url'=>['plugin'=>'Admin','controller'=>'Options', 'action'=>'SaveSetting'],
        'class'=>'col-sm-12']);
    $pp = new Shop\ProvinceCity();
    if(isset($result['plugin_transport']) and count($result)):
        $hsite = unserialize($result['plugin_transport']);
        $this->request->withData('plugin_transport',$hsite);
        @$this->request->data['plugin_transport'] = $hsite;
    endif;?>


<div class="nav-vertical shop_transport">
    <ul class="nav nav-tabs nav-left flex-column" role="tablist" style="height: 140px;">
        <?php for($i=1;$i<6;$i++):?>
        <li class="nav-item">
            <a class="nav-link" id="bleft-tab<?=$i?>" data-toggle="tab" aria-controls="tableft<?=$i?>" href="#tableft<?=$i?>" role="tab" aria-selected="false">
                روش  <?=$i?> 
                <?= (isset($hsite[$i]['title']) and $hsite[$i]['title']!= '')?' : '.$hsite[$i]['title']:''?>
                <?= (isset($hsite[$i]['enable']) and $hsite[$i]['enable']== 1)?
                '<span class="badge badge-success ml-1" style="padding: 2px 3px;" title="فعال"><i data-feather="check"></i></span>':
                '<span class="badge badge-danger ml-1" style="padding: 2px 3px;" title="غیرفعال"><i data-feather="x"></i></span>'?>
            </a>
        </li>
        
        <?php endfor?>
        <br>
        <?= $this->Form->submit('ذخیره تغییرات',['class'=>'btn btn-success btn-sm col-xs-12 mb-3']);?>
        <div class="d-none d-md-block"><br><br><br><br><br><br><br><br><br></div>
    </ul>
    <div class="tab-content">
        <?php for($i=1;$i<6;$i++):?>
        <div class="tab-pane" id="tableft<?=$i?>" role="tabpanel" aria-labelledby="bleft-tab<?=$i?>">
        
            <div class="row">
                <div class="col-sm-5">
                    <?= $this->Form->control('plugin_transport.'.$i.'.title',[
                        'label'=>'عنوان روش '.$i.' *',
                        'class'=>'form-control form-control-sm2 mb-2']);?>
                </div>
                <div class="col-sm-4">
                    <?= $this->Form->control('plugin_transport.'.$i.'.slug',[
                        'label'=>'Slug *',
                        'maxlength'=>10,
                        'class'=>'form-control form-control-sm2 ltr']);?>
                        <div class="small mb-2 text-center"> (کاراکتر انگلیسی و کوچک / هرگزتغییرندهید)</div>
                </div>
                <div class="col-sm-3">
                    <?= $this->Form->control('plugin_transport.'.$i.'.enable',[
                    'label'=>'وضعیت نمایش',
                    'options'=>[
                        0 =>'عدم نمایش (غیرفعال)',
                        1=> 'نمایش (فعال)' ],
                    'class'=> 'form-control form-control-sm2 ']);?>
                </div>
            </div>
            

            <div class="card transport_page"><div class="card-body">
                <script nonce="<?=get_nonce?>">
                    $('#type').on('change', function() {
                    if( this.value == 'fixed'){
                        $('.type1<?=$i?>').addClass('d-none');$('.type1<?=$i?>').addClass('p-0');$('.fixed<?=$i?>').removeClass('d-none');
                    }else if( this.value == 'percent'){
                        $('.type1<?=$i?>').addClass('d-none');$('.type1<?=$i?>').addClass('p-0');$('.percent<?=$i?>').removeClass('d-none');

                    }else if( this.value == 'province'){
                        $('.type1<?=$i?>').addClass('d-none');$('.type1<?=$i?>').addClass('p-0');$('.province<?=$i?>').removeClass('d-none');
                    }
                    });
                    $(document).ready(function() {
                        $('.type1<?=$i?>').addClass('d-none');$('.type1<?=$i?>').addClass('p-0');$('.<?=$hsite[$i]['type']?><?=$i?>').removeClass('d-none');
                    });
                </script>
                <div class="row mb-1">
                    <div class="col-sm-6">
                        <?= $this->Form->control('plugin_transport.'.$i.'.descr',[
                            'label'=>'توضیحات',
                            'class'=>'form-control form-control-sm mb-2']);?>
                    </div>
                    <div class="col-sm-6">
                        <?= $this->Form->control('plugin_transport.'.$i.'.image',[
                            'label'=>'تصویر','placeholder'=>'http://',
                            'class'=>'form-control form-control-sm1  ltr']);?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4 mb-1">
                        <?= $this->Form->control('plugin_transport.'.$i.'.type',[
                            'id'=>'type',
                            'label'=>'نحوه محاسبه قیمت',
                            'options'=>[
                                'fixed'=>'مبلغ ثابت',
                                'percent'=>'درصد از کل مبلغ',
                                'province'=>'براساس استان'
                            ],
                            'class'=> 'form-control form-control-sm1 ']);?>
                    </div>
                    <div class="col-sm-4">
                        <?= $this->Form->control('plugin_transport.'.$i.'.count',[
                            'type'=>'number',
                            'label'=>'حداکثر تعداد سفارش روزانه','placeholder'=>'فقط عدد',
                            'class'=>'form-control form-control-sm1 ltr']);?>
                    </div>
                    <div class="col-sm-4">
                        <?= $this->Form->control('plugin_transport.'.$i.'.day',[
                            'type'=>'number',
                            'label'=>'حداکثر زمانبندی ارسال (روز)','placeholder'=>'فقط عدد',
                            'class'=>'form-control form-control-sm1 ltr']);?>
                    </div>
                </div>
                </div></div>

                <div class="row" >
                    <div class="col-sm-12 fixed<?=$i?> type1<?=$i?>">
                        <div class="card"><div class="card-body">
                            <h3>مبلغ ثابت</h3><hr>
                            <div class="row mb-1">
                                <div class="col-sm-6" style="padding-top: 8px;">
                                    مبلغ ثابت (<?= $p_label2?>)
                                </div>
                                <div class="col-sm-6">
                                    <?= $this->Form->control('plugin_transport.'.$i.'.fixed_price',[
                                        'label'=>false,
                                        'type'=>'number',
                                        'class'=> 'form-control form-control-sm1  ltr mb-2' ]);?>
                                </div>
                            </div>
                            <div class="small">این مبلغ به عنوان هزینه ارسال به فاکتور اصلی اضافه خواهد شد</div>
                        </div></div>
                    </div>

                    <div class="col-sm-12 percent<?=$i?> type1<?=$i?>">
                        <div class="card"><div class="card-body">
                            <h3>مبلغ درصدی</h3><hr>
                            <div class="row mb-1">
                                <div class="col-sm-6" style="padding-top: 8px;">
                                    مبلغ درصدی %
                                </div>
                                <div class="col-sm-6">
                                    <?= $this->Form->control('plugin_transport.'.$i.'.percent_price',[
                                        'label'=> false,
                                        'type'=>'text',
                                        'maxlength'=>2,
                                        'placeholder'=>'فقط عدد',
                                        'class'=> 'form-control form-control-sm1  ltr mb-2' ]);?>
                                </div>
                            </div>

                            <div class="small">درصد از مبلغ کل فاکتور به عنوان هزینه ارسال محاسبه خواهد شد<br>
                                مثلا اگر فاکتور 100 هزارتومان باشد و 10درصد مشخص کنید، مبلغ 10 هزارتومان به عنوان هزینه ارسال محاسبه میگردد
                            </div>
                        </div></div>
                    </div>

                    <div class="col-sm-12 province<?=$i?> type1<?=$i?>">
                        <div class="card"><div class="card-body">
                            <h3>براساس استان</h3><hr>
                            <div class="row mb-1">
                                <div class="col-sm-3" style="padding-top: 8px;">
                                    داخل استانی (فروشگاه)
                                </div>
                                <div class="col-sm-3">
                                    <?= $this->Form->control('plugin_transport.'.$i.'.province_inside',[
                                        'Placeholder'=>'مبلغ ثابت ('.$p_label2.')',
                                        'label'=>false,
                                        'type'=>'number',
                                        'class'=> 'form-control form-control-sm1 ltr' ]);?>
                                </div>
                                <div class="col-sm-1 d-none d-sm-block small"><?= $p_label2?></div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-sm-3" style="padding-top: 8px;">
                                    استان همجوار (فروشگاه)
                                </div>
                                <div class="col-sm-3">
                                    <?= $this->Form->control('plugin_transport.'.$i.'.province_near',[
                                        'Placeholder'=>'مبلغ ثابت ('.$p_label2.')',
                                        'label'=>false,
                                        'type'=>'number',
                                        'class'=> 'form-control form-control-sm1  ltr' ]);?>
                                </div>
                                <div class="col-sm-1 d-none d-sm-block small"><?= $p_label2?></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3" style="padding-top: 8px;">
                                    سایر استان ها
                                </div>
                                <div class="col-sm-3">
                                    <?= $this->Form->control('plugin_transport.'.$i.'.province_other',[
                                        'Placeholder'=>'مبلغ ثابت ('.$p_label2.')',
                                        'label'=>false,
                                        'type'=>'number',
                                        'class'=> 'form-control form-control-sm1  ltr' ]);?>
                                </div>
                                <div class="col-sm-1 d-none d-sm-block small"><?= $p_label2?></div>
                            </div>
                        </div></div>

                        <div class="card"><div class="card-body">
                            <h3>موارد استثنا استان</h3><hr>
                            <?php for($j=1;$j<10;$j++):?>
                            <div class="row mb-1">
                                <div class="col-sm-3">
                                    <?= $this->Form->control('plugin_transport.'.$i.'.province_exc'.$j.'province',[
                                        'label'=>'استان',
                                        'empty'=>'---',
                                        'options'=>$this->Func->province_list(),
                                        'type'=>'select',
                                        'class'=> 'province form-control form-control-sm1' ]);?>
                                </div>
                                <div class="col-sm-3">
                                    <?= $this->Form->control('plugin_transport.'.$i.'.province_exc'.$j.'city',[
                                        'label'=>'شهرستان',
                                        'type'=>'select',
                                        'options'=>(isset($hsite[$i]['province_exc'.$j.'province']) and $hsite[$i]['province_exc'.$j.'province'] != '')?
                                            $pp->getlist($hsite[$i]['province_exc'.$j.'province']):[],
                                        'class'=> 'city form-control form-control-sm1' ]);?>
                                </div>
                                <div class="col-sm-2">
                                    <?= $this->Form->control('plugin_transport.'.$i.'.province_exc'.$j.'price',[
                                        'Placeholder'=> $p_label2,
                                        'label'=>'مبلغ ثابت ('. $p_label2.')',
                                        'type'=>'number',
                                        'class'=> 'form-control form-control-sm1  ltr' ]);?>
                                </div>
                                <div class="col-sm-2">
                                    <?= $this->Form->control('plugin_transport.'.$i.'.province_exc'.$j.'count',[
                                        'label'=>'حداکثرسفارش روزانه',
                                        'type'=>'number',
                                        'placeholder'=>'عدد',
                                        'class'=> 'form-control form-control-sm1  ltr' ]);?>
                                </div>
                                <div class="col-sm-2">
                                    <?= $this->Form->control('plugin_transport.'.$i.'.province_exc'.$j.'day',[
                                        'label'=>'زمانبندی ارسال',
                                        'type'=>'number',
                                        'placeholder'=>'عدد',
                                        'class'=> 'form-control form-control-sm1  ltr' ]);?>
                                </div>
                                
                            </div><hr>
                            <?php endfor?>

                        </div></div>
                    </div>
                </div>
        </div>
        <?php endfor?>
    </div>
</div>


<?php 
//echo $this->Form->submit('ذخیره تغییرات',['class'=>'btn btn-success col-xs-3 mb-3']);
echo $this->Form->end();?>

<style>
.shop_transport .nav-item svg{margin:0;}
.nav-vertical .nav.nav-tabs.nav-left ~ .tab-content .tab-pane {
    overflow-y: initial !important;    }

.col-sm-12 label {
    font-size: 13px !important;
    letter-spacing: -0.5px;
}
</style>

<script nonce="<?=get_nonce?>">
$('.province').on('change', function() {
    get_param( this.value , this );
});
function get_param(id , ids){
    //console.log(ids);
    $.ajax({
        type : 'GET',data: 'province='+id,
        url : "<?= Router::url('/shop/profile/addresses/') ?>",
        success : function(data){
            var obj = $.parseJSON(data);
            var $select = $(ids).parent().parent().next(".col-sm-3").find('select');
            $select.find('option').remove(); 
            $select.append('<option>-- انتخاب کنید --</option>');
            $.each(obj,function(key, value) {
                $select.append('<option value=' + key + '>' + value + '</option>');
            });
        },
        error:function (XMLHttpRequest, textStatus, errorThrown) {
            $('.paramlists').html("متاسفانه امکان دریافت اطلاعات وجود ندارد");
        }
    });
}
</script>