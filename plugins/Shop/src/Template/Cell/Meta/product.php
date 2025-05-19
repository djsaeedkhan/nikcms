<?php
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Shop\Predata;
use Shop\View\Helper\CartHelper;
$predata = new Predata;
global $product_data;
$setting = unserialize($this->Func->OptionGet('plugin_shop'));
$param_list = TableRegistry::get('Shop.ShopParamlists')
    ->find('list',['keyField'=>'id','valueField'=>'title'])
    ->toarray();

$shop_metas = isset($product_data['shop_metas'])?$product_data['shop_metas']:[] ;
global $p_label2;
$p_label2 = CartHelper::Predata('currency',$setting['currency']);
$p_label = 'قیمت  ('.$p_label2.')';
?>

<div class="card" id="vanilla-form">
    <div class="card-header"><b>تنظیمات فروشگاه</b></div>
    <div class="card-body">

        <div class="row"><div class="col-sm-4">
            <?= $this->Form->control('ShopMetas.product_type',[
                'id' =>'product_type',
                'options' => $predata->gettype('product_type'),
                'class'=>'form-control',
                'default'=>(isset($shop_metas['product_type'])?$shop_metas['product_type']:''),
                'label'=>'نوع محصول'])?>
        </div></div><bR>

        <div class="nav-vertical">
            <ul class="nav nav-tabs nav-left flex-column" role="tablist">
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home-44">مشخصات کلی</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#home-33">گزینه های بیشتر</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#picture">تصاویر محصول</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#mojudi">موجودی (انبار)</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#vijegi">ویژگی ها</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#param">مشخصات (پارامتر)</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#related">محصولات مرتبط</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#profile-55">حمل و نقل</a></li>
                <!-- <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#descr">توضیحات</a></li> -->
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#label">اتیکت (Label)</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#brands">برند (Brands)</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#logestics">نمایندگی</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#convert">تبدیل قیمت</a></li>
            </ul>
            <div class="tab-content tab-shop">
            <!-- ----------------------------------------------------------- -->
                <div class="tab-pane p-0 m-0" id="home-33" role="tabpanel" >
                    <div class="row mx-0">
                        <div class="col-sm-12">
                            <?= $this->Form->control('ShopMetas.en_title',['class'=>'form-control mb-2 ltr','label'=>'عنوان انگلیسی',
                                'default'=>(isset($shop_metas['en_title'])?$shop_metas['en_title']:'')]);?>
                            <hr>
                            <?= $this->Form->control('ShopMetas.short_descr',[
                                'class'=>'form-control mb-2',
                                'type'=>'textarea','label'=>'توضیحات مختصر',
                                'style'=>'height:220px;',
                                'default'=>(isset($shop_metas['short_descr'])?$shop_metas['short_descr']:'')]);?>
                                <small>در هر سطر یک توضیح بنویسید</small>
                            <hr>
                        </div>
                    </div>
                </div>
                <!-- ----------------------------------------------------------- -->
                <div class="tab-pane active p-0 m-0" id="home-44" role="tabpanel" >
                    <div class="row mx-0">
                        <div class="col-sm-6 simple1">
                            <?= $this->Form->control('ShopMetas.price',[
                                'class'=>'form-control mb-2 ltr numeral-mask',
                                'label'=> $p_label,
                                'default'=>(isset($shop_metas['price'])?$shop_metas['price']:'') ]);?>
                        </div>
                        <div class="col-sm-6 simple1">
                            <?= $this->Form->control('ShopMetas.special_price',[
                                'class'=>'form-control mb-2 ltr numeral-mask',
                                'label'=> 'قیمت فروش ویژه ('.$p_label2.')',
                                'default'=>(isset($shop_metas['special_price'])?$shop_metas['special_price']:'') ]);?>
                        </div>
                        <div class="col-sm-6">
                            <?= $this->Form->control('ShopMetas.sku',['class'=>'form-control mb-2 ltr','label'=>'شناسه محصول (SKU)',
                                'default'=>(isset($shop_metas['sku'])?$shop_metas['sku']:'')]);?>
                        </div>
                        <div class="col-sm-12">
                            <?= $this->Form->control('ShopMetas.special_price_check',['class'=>'form-control mb-2 ltr', 'type'=>'checkbox',
                                'label'=>'زمانبندی فروش ویژه','escape'=>false,'id'=>'special_price_check',
                                'default'=>(isset($shop_metas['special_price_check'])?$shop_metas['special_price_check']:'')]);?>

                            <div class="<?=((isset($shop_metas['special_price_check']) and $shop_metas['special_price_check'] ==1)?'':'d-none')?> special_price_check">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <?= $this->Form->control('ShopMetas.special_date_start',[
                                            'class'=>'form-control mb-2 ltr masked input',
                                            "data-mask"=>"####/##/##",
                                            'label'=>'تاریخ شروع (مثلا : '.jdate('Y/m/d').')',
                                            'placeholder'=>'0000/00/00',
                                            'default'=>(isset($shop_metas['special_date_start'])?$shop_metas['special_date_start']:'')]);?>
                                    </div>
                                    <div class="col-sm-6">
                                        <?= $this->Form->control('ShopMetas.special_date_end',[
                                            'class'=>'form-control mb-2 ltr masked input',
                                            "data-mask"=>"####/##/##",
                                            'label'=>'تاریخ پایان',
                                            'placeholder'=>'0000/00/00',
                                            'default'=>(isset($shop_metas['special_date_end'])?$shop_metas['special_date_end']:'')]);?>
                                    </div>
                                </div>
                            </div>

                            <script nonce="<?=get_nonce?>">
                            $(document).on('click', '#special_price_check', function () {
                                if ($('#special_price_check').is(':checked')) {
                                    $('.special_price_check').removeClass('d-none');
                                }
                                else{
                                    $('.special_price_check').addClass('d-none');
                                }
                            });
                            </script>
                        </div>
                    </div>
                    
                </div>
                <!-- ----------------------------------------------------------- -->
                <div class="tab-pane p-0 m-0" id="picture" role="tabpanel"><div class="row m-0 p-0">
                    <?php
                    $cnt = isset($setting['product_image_count'])?$setting['product_image_count']:5;
                    for($i=0;$i<($cnt>1?$cnt:5);$i++):
                        echo '<div class="col-sm-8">';
                        echo $this->Form->control('ShopMetas.gallery'.$i,[
                            'class'=>'form-control mb-2 ltr',
                            'type'=>'text',
                            'style'=>'padding-right: 30px;',
                            'id'=>'product_gallery'.$i,
                            'label'=>'تصویر محصول '.($i+1),
                            'default'=>(isset($shop_metas['gallery'.$i])?$shop_metas['gallery'.$i]:''),
                        ]);
                        echo '<div class="mb-2" style="cursor:pointer;margin-top: -45px;float: right;margin-right: 10px;">
                            <a data-toggle="modal" data-target="#exampleModal" data-action="select_src" title="انتخاب فایل" data-dest="'.'product_gallery'.$i.'" style="color:#9e9e9e"><i data-feather="camera"></i></a>
                            </div>';
                        echo "</div>";
                        echo '<div class="col-sm-4 p-0">';
                        echo $this->Form->control('ShopMetas.gallery'.$i.'_alt',[
                            'class'=>'form-control mb-2 ltr',
                            'type'=>'text',
                            'label'=> "توضیح",
                            'default'=>(isset($shop_metas['gallery'.$i.'_alt'])?$shop_metas['gallery'.$i.'_alt']:''),
                        ]);

                        echo "</div>";
                    endfor;
                    ?>
                </div></div>
                <!-- ----------------------------------------------------------- -->
                <div class="tab-pane p-0 m-0" id="profile-55" role="tabpanel">
                    <div class="row">
                        <div class="col-sm-4">
                            <?= $this->Form->control('ShopMetas.weight',[
                                'class'=>'form-control mb-2 ltr',
                                'label'=> "وزن محصول",//$setting['weight_unit'],//$predata->gettype('weight_unit'),//'وزن (kg)',
                                'type'=>'text',
                                'default'=>(isset($shop_metas['weight'])?$shop_metas['weight']:'') ]);?>
                        </div>
                        <div class="col-sm-4">
                            <?= $this->Form->control('ShopMetas.weight_unit',[
                                'class'=>'form-control mb-2',
                                'label'=> "واحد اندازه گیری",
                                'options'=>$predata->gettype('weight_unit'),//'وزن (kg)',
                                'type'=>'select',
                                'default'=>(isset($shop_metas['weight_unit'])?$shop_metas['weight_unit']:$setting['weight_unit']) ]);?>
                        </div>
                    </div><hr>

                    <div class="row">
                        <div class="col-sm-4">
                            <?= $this->Form->control('ShopMetas.length',[
                                'class'=>'form-control mb-2 ltr','label'=>'طول (cm)','type'=>'number',
                                'default'=>(isset($shop_metas['length'])?$shop_metas['length']:'')]);?>
                        </div>
                        <div class="col-sm-4">
                            <?= $this->Form->control('ShopMetas.width',[
                                'class'=>'form-control mb-2 ltr', 'type'=>'number','label'=>'عرض (cm)',
                                'default'=>(isset($shop_metas['width'])?$shop_metas['width']:'')]);?>
                        </div>
                        <div class="col-sm-4">
                            <?= $this->Form->control('ShopMetas.height',[
                                'class'=>'form-control mb-2 ltr', 'type'=>'number','label'=>'ارتفاع (cm)',
                                'default'=>(isset($shop_metas['height'])?$shop_metas['height']:'')]);?>
                        </div>
                    </div>
                </div>
                <!-- ----------------------------------------------------------- -->
                <div class="tab-pane p-0 m-0" id="param" role="tabpanel">
                    <div class="row1">
                        <div class="1col-sm-4 alert alert-dark">
                            <?= $this->Form->control('ShopMetas.param_id',[
                                'options' => $params,'id'=>'params','empty'=>' -- انتخاب کنید --','class'=>'form-control',
                                'default'=>(isset($shop_metas['param_id'])?$shop_metas['param_id']:''),
                                'label'=>'انتخاب پارامتر مشخصات' ])?>
                        </div><br>
                        
                        <div class="col-sm-81"><div class="paramlists"><?php 
                            if(isset($product_data['param_list']) and isset($shop_metas['param_id'])):
                                $lists = TableRegistry::get('Shop.ShopParamlists')->find('all')
                                    ->where(['shop_param_id'=> $shop_metas['param_id'] ])
                                    ->enableHydration(false)
                                    ->order(['priority'=>'asc'])
                                    ->toarray();
                            foreach($lists as $list){if($list['types'] == 1):
                                $k = $list['id'];
                                if(isset($product_data['param_list'][$list['id']])){
                                    
                                    $p = $product_data['param_list'][$list['id']];
                                    echo $this->Form->control('shop.params.list.'.$k,[
                                        'type'=>'textarea','class'=>'form-control mb-2 p_param',
                                        'default'=>$p ,
                                        'label'=> isset($param_list[$k])?$param_list[$k]:'-']);
                                }
                                else{
                                    echo $this->Form->control('shop.params.list.'.$k,[
                                        'type'=>'textarea','class'=>'form-control mb-2 p_param',
                                        'label'=> isset($param_list[$k])?$param_list[$k]:'-']);
                                }
                            endif;}

                            /* foreach($product_data['param_list'] as $k => $p):
                                echo $this->Form->control('shop.params.list.'.$k,['type'=>'textarea','class'=>'form-control mb-2 p_param',
                                    'default'=>$p ,
                                    'label'=> isset($param_list[$k])?$param_list[$k]:'-']);
                            endforeach; */endif;?>
                        </div></div>
                    </div>
                </div>
                <!-- ----------------------------------------------------------- -->
                <div class="tab-pane p-0 m-0" id="vijegi" role="tabpanel">
                    <div class="row m-0">
                        <div class="col-sm-3">
                            <?php
                            if(isset($product_data['attr_list'])){
                                echo $this->Form->control('ShopMetas.attribute',[
                                    'multiple' => 'checkbox',
                                    'class' => 'chk',
                                    'label' => 'لیست ویژگی ها',
                                    'default'=>(isset($shop_metas['attribute'])?
                                        (strpos($shop_metas['attribute'],';')?explode(';',$shop_metas['attribute']):$shop_metas['attribute'])
                                        :''),
                                    'options' => $product_data['attr_list'] ]);
                                echo $this->html->link('افزودن ویژگی','#',[
                                    'style'=>'width:100%;',
                                    'id'=>'attrbtn','class'=>'btn btn-sm btn-primary text-white px-0']);
                            }
                            ?>
                        </div>
                        <div class="col-sm-9 pr-0">
                        <div class="attrlists2"></div>
                        
                        <div class="attrlists"><?php 
                            global $count;
                            $count = 0;
                            if(isset($product_data['product_detail']) and count($product_data['product_detail'])){
                                
                                $this->ShopAttlists = TableRegistry::get('Shop.ShopAttributelists');
                                $a1 = $this->ShopAttlists->find('list',['keyField'=>'id','valueField'=>'title'])->toarray();
                                $a2 = $this->ShopAttlists->find('list',['keyField'=>'id','valueField'=>'shop_attribute_id'])->toarray();
                                foreach($this->ShopAttlists->find('all')->contain(['ShopAttributes'])->toarray() as $temp){
                                    $a3[$temp['id']] = isset($temp['shop_attribute']['title'])?$temp['shop_attribute']['title']:'';
                                }
                                
                                foreach($product_data['product_detail'] as $list){
                                    $pt = str_replace(',','',$list['pattern']);?>
                                    <div class="card mb-1"><div class="card-header" style="padding: 5px 15px;">
                                        <a class="collapsed float-right" data-toggle="collapse" href="#cEx<?=$pt?>" aria-controls="cEx<?=$pt?>">
                                        <?php foreach(explode(',',$list['pattern']) as $lst){
                                            echo '<label style="cursor:pointer">';
                                            echo isset($a1[$lst])?$a3[$lst].': ':'';
                                            echo isset($a2[$lst])?$a1[$lst]:'';
                                            echo '</label>';
                                        }?>
                                        </a>
                                        <a class="text-danger cls11" nonce="<?=get_nonce?>" onclick="deleteDetail('cEx<?=$pt?>');" title="حذف">[X]</a><div class="clearfix"></div>

                                        <div class="collapse" id="cEx<?=$pt?>">
                                            <div class="card mb-1 card-body m-0 p-0 cls12">
                                                <?=$this->cell('Shop.FormDetail',[$list['pattern'], $list,$product_data]);?>
                                            </div>
                                        </div>
                                    </div></div>
                                <?php }
                            }?>
                    </div></div>
                    </div>
                </div>
                <!-- ----------------------------------------------------------- -->
                <div class="tab-pane p-0 m-0" id="related" role="tabpanel"><div style="min-height: 380px;">
                    <?= $this->Form->control('ShopMetas.related',[
                        'id'=>'multiple1', 
                        'multiple'=>'multiple',
                        'class'=>'select2 form-control mb-2',
                        'label'=>'محصولات مرتبط', 
                        'type'=>'select', 
                        'options'=> isset($product_data['product_list'])?$product_data['product_list']:[],
                        'default'=>(isset($shop_metas['related'])?
                            (strpos($shop_metas['related'],';')?explode(';',$shop_metas['related']):$shop_metas['related'])
                            :'')]);?><br>


                    <?= $this->Form->control('ShopMetas.suggested',[
                        'multiple'=>'multiple',
                        'class'=>'select2 form-control mb-2',
                        'label'=>'محصولات پیشنهادی',
                        'type'=>'select',
                        'options'=> isset($product_data['product_list'])?$product_data['product_list']:[],
                        'default'=>(isset($shop_metas['suggested'])?
                            (strpos($shop_metas['suggested'],';')?explode(';',$shop_metas['suggested']):$shop_metas['suggested'])
                            :'')]);?>

                </div></div>
                <!-- ----------------------------------------------------------- -->
                <div class="tab-pane p-0 m-0" id="mojudi" role="tabpanel" >
                    <div class="row m-0">
                        <div class="col-sm-6">
                            <?= $this->Form->control('ShopMetas.stock',['class'=>'form-control mb-2 ltr numeral-mask', 
                                'type'=>'number','label'=>'موجودی انبار (عدد)',
                                'default'=>(isset($product_data['stocks'][0])?$product_data['stocks'][0]:'') ]);?>
                        </div>
                        
                        <div class="col-sm-12"><hr></div>

                        <div class="col-sm-6 major">
                            <?= $this->Form->control('ShopMetas.unit',['class'=>'form-control mb-2',
                                'label'=>'واحد بسته بندی','type'=>'select',
                                'options'=> $predata->gettype('prd_unit'),
                                'empty'=>'-- انتخاب کنید --',
                                'default'=>(isset($shop_metas['unit'])?$shop_metas['unit']:'')]);?>
                        </div>
                        <div class="col-sm-6 major">
                            <?= $this->Form->control('ShopMetas.unit_box',['class'=>'form-control mb-2 numeral-mask ltr',
                                'label'=>'حداکثر تعداد در واحد بسته بندی','type'=>'number',
                                'default'=>(isset($shop_metas['unit_box'])?$shop_metas['unit_box']:'')]);?>
                        </div>

                        <div class="col-sm-4">
                            <?= $this->Form->control('ShopMetas.minimum_order',['class'=>'form-control mb-2 numeral-mask ltr',
                                'label'=>'حداقل تعداد سفارش','type'=>'number',
                                'default'=>(isset($shop_metas['minimum_order'])?$shop_metas['minimum_order']:'')]);?>
                        </div>
                        <div class="col-sm-4">
                            <?= $this->Form->control('ShopMetas.maximum_order',['class'=>'form-control mb-2 numeral-mask ltr',
                                'label'=>'حداکثر تعداد سفارش','type'=>'number',
                                'default'=>(isset($shop_metas['maximum_order'])?$shop_metas['maximum_order']:'')]);?>
                        </div>

                        <div class="col-sm-4">
                            <?= $this->Form->control('ShopMetas.low_stock_amount',['class'=>'form-control mb-2 ltr', 'type'=>'number',
                                'label'=>'آستانه کم بودن موجودی',
                                'default'=>(isset($shop_metas['low_stock_amount'])?$shop_metas['low_stock_amount']:'')]);?>
                        </div>

                        <div class="col-sm-12 simple">
                            <?= $this->Form->control('ShopMetas.sold_individually',['class'=>'form-control mb-2 ltr', 'type'=>'checkbox',
                                'label'=>'فروش تکی <small>[در هربار خرید فقط یک واحد را بتوان به سبدخرید اضافه کرد]</small>','escape'=>false,
                                'default'=>(isset($shop_metas['sold_individually'])?$shop_metas['sold_individually']:'')]);?>
                        </div>

                        <div class="col-sm-12"><hr></div>
                        <div class="col-12">

                            <div class="major m-0">
                                <div class="cls13 mb-1">مدیریت بخش فروش عمده</div>
                                <div class="clearfix"></div>

                                <div class="mojudi-single1 ">
                                    <?php
                                    $j_count = 0;
                                    if(isset($product_data['major_list'])):
                                        foreach($product_data['major_list'] as $k => $p):
                                            if($p['pattern'] == null):?>
                                                <div><div class="row">
                                                    <div class="col-sm-5 pl-1">
                                                        <?= $this->Form->control("big_price2.$j_count.start",[
                                                            'type'=>'number','class'=>'form-control form-control-sm mb-1 ltr',
                                                            'default'=>$p['start'],'label'=> 'از']);?>
                                                    </div>
                                                    <div class="col-sm-6 pr-1">
                                                        <?= $this->Form->control("big_price2.$j_count.price",[
                                                            'type'=>'number','class'=>'form-control form-control-sm mb-1 ltr',
                                                            'default'=>$p['price'],'label'=> $p_label ]);?>
                                                    </div>
                                                    <div class="col-sm-1" nonce="<?=get_nonce?>" onclick="deleteDetail('id<?=$j_count?>');" id="id<?=$j_count?>" 
                                                        title="حذف" style="cursor:pointer;color:#F00;padding-top:30px"> x </div>
                                                </div></div>
                                            <?php $j_count+=1;
                                            endif;
                                        endforeach;
                                    else:?>
                                        <script nonce="<?=get_nonce?>">$(document).ready(function(){$(".btnadds1").trigger("click");});</script>
                                    <?php endif;?>
                                </div>
                                <a class="btn btn-success btn-sm btnadds1 text-white">افزودن</a>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <!-- ----------------------------------------------------------- -->
                <div class="tab-pane p-0 m-0" id="logestics" role="tabpanel">
                    <div class="row mx-0">
                        <div class="col-12">
                        <?= $this->Form->control('ShopMetas.logesticlists',[
                            'class'=>'form-control mb-2',
                            'empty'=>'-- انتخاب کنید --',
                            'type'=>'select',
                            'label'=>'انتخاب دسته بندی نمایندگی',
                            'options'=> TableRegistry::get('ShopLogesticlists')->find('list',['keyField'=>'id','valueField'=>'title'])->toarray(),
                            'default'=>(isset($shop_metas['logesticlists'])?$shop_metas['logesticlists']:'')]);?>

                            <div class="alert alert-secondary">
                                شما در اینجا انتخاب میکنید که محصول درچه دسته بندی ای قرار دارد. 
                                در صفحه مشتری، لیست نمایندگی های دسته بندی انتخاب شده به مشتری نمایش داده خواهد شد.

                            </div>
                        </div>
                    </div>
                </div>
                <!-- ----------------------------------------------------------- -->
                <div class="tab-pane p-0 m-0" id="label" role="tabpanel">
                    <?= $this->Form->control('ShopMetas.label',[
                        'class'=>'form-control mb-2','empty'=>'-- انتخاب کنید --',
                        'type'=>'select','label'=>'انتخاب علامت',
                        'options'=> TableRegistry::get('ShopLabels')->find('list',['keyField'=>'id','valueField'=>'title'])->toarray(),
                        'default'=>(isset($shop_metas['label'])?$shop_metas['label']:'')]);?>
                </div>
                <!-- ----------------------------------------------------------- -->
                <div class="tab-pane p-0 m-0" id="brands" role="tabpanel">
                    <?= $this->Form->control('ShopMetas.brands',[
                        'class'=>'form-control mb-2','empty'=>'-- انتخاب کنید --',
                        'type'=>'select','label'=>'انتخاب برند',
                        'options'=> TableRegistry::get('ShopBrands')->find('list',['keyField'=>'id','valueField'=>'title'])->toarray(),
                        'default'=>(isset($shop_metas['brands'])?$shop_metas['brands']:'')]);?>
                </div>
                <!-- ----------------------------------------------------------- -->

                <div class="tab-pane p-0 m-0" id="convert" role="tabpanel">
                    <?= $this->Form->control('ShopMetas.price_type',[
                        'class'=>'form-control mb-2',
                        'empty'=>'-- انتخاب کنید --',
                        'type'=>'select',
                        'label'=>'نوع کالا',
                        'options'=>  $predata->gettype('price_type'),
                        'default'=>(isset($shop_metas['price_type'])?$shop_metas['price_type']:'')]);?>
                </div>
                <!-- ----------------------------------------------------------- -->
            </div>
        </div>
    </div>
</div>

<script nonce="<?=get_nonce?>">
/////////////////////////////////////
/* $(function () {
    $( "input[type=number]" ).change(function() {
        var max = parseInt($(this).attr('max'));
        var min = parseInt($(this).attr('min'));
        if ($(this).val() > max)
            $(this).val(max);
        else if ($(this).val() < min)
            $(this).val(min);
    }); 
}); */
/////////////////////////////////////
var omde = <?= $count ?>;
$(document).on('click', '#btnadds', function () {
    var pattern = $(this).parent().find('.mojudi-single').attr("data-pattern");
    $(this).parent().find('.mojudi-single').append(
        `<div class="row">
            <input type="hidden" name="big_price[`+omde+`][pattern]" value="` + pattern +`">
            <div class="col-sm-5">
                <div class="input number">
                    <label>از</label>
                    <input type="number" name="big_price[`+ omde +`][start]" class="form-control form-control-sm mb-1 ltr" >
                </div>
            </div>
            <div class="col-sm-6">
                <div class="input number">
                    <label><?=$p_label2?></label>
                    <input type="number" name="big_price[`+ omde +`][price]" class="form-control form-control-sm mb-1 ltr">
                </div>
            </div>
            <div class="col-sm-1 wholed" title="حذف" style="color:#F00"> x </div>
        </div>`
    );
    omde +=1;
});
/////////////////////////////////////
$(document).on('keyup', '.money', function() {
    $(this).val(function(index, value) {
    return value
        .replace(/\D/g,"")
        .replace(/([0-9])([0-9]{0})$/, '$1')  
        .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");
    });
});
/////////////////////////////////////
$(document).ready(function() {
    if( $('#product_type').val()  == 'simple' ){
        $('.simple').removeClass('d-none');
        $(".simple :input").prop("disabled", false);
        $('.major').addClass('d-none');
        $(".major :input").prop("disabled", true);
    }
    if( $('#product_type').val()  == 'wholesale' ){
        $('.simple').addClass('d-none');
        $(".simple :input").prop("disabled", true);
        $('.major').removeClass('d-none');
        $(".major :input").prop("disabled", false);
    }
});
$('#product_type').on('change', function() {
    if( this.value == 'simple' ){
        $('.simple').removeClass('d-none');
        $(".simple :input").prop("disabled", false);
        $('.major').addClass('d-none');
        $(".major :input").prop("disabled", true);
    }
    if( this.value == 'wholesale' ){
        $('.simple').addClass('d-none');
        $(".simple :input").prop("disabled", true);
        $('.major').removeClass('d-none');
        $(".major :input").prop("disabled", false);
    }
});

/////////////////////////////////////
$('#params').on('change', function() {
    if($('.paramlists').html() != ''){
        if (confirm("اطلاعات قبلی همگی پاک خواهند گردید و قابل بازیابی نخواهند بود")== true)
            get_param( this.value );
    }
    else get_param( this.value );
});
function get_param(id){
    $.ajax({
        type : 'GET',data: 'getlist='+id,
        url : "<?= Router::url(['plugin'=>'Shop','controller' => 'Home', 'action' => 'params'],false) ?>",
        success : function(data){
            console.log(jQuery.parseJSON(data));
            string = '';
            $.each(jQuery.parseJSON(data), function(key,value) {console.log(key);string += createform(key,value);});
            $('.paramlists').html(string);
        },
        error:function (XMLHttpRequest, textStatus, errorThrown) {
            $('.paramlists').html("متاسفانه امکان دریافت اطلاعات وجود ندارد");
        }
    });
}
function createform(id,title){
    return '<div class="input text">'+
        '<label for="p_param">'+title+'</label>'+
        '<textarea name="shop[params][list]['+id+']" id="p_param" class="form-control mb-2 p_param"></textarea>'+
        '</div>';
}
/////////////////////////////////////

var omde = <?=$j_count?>;
$(".btnadds1").click(function(){
    $('.mojudi-single1').append(
    `<div><div class="row">
        <div class="col-sm-5 pl-1">
            <div class="input number">
                <label for="big-price-`+omde+`-start">از تعداد</label>
                <input type="number" name="big_price2[`+omde+`][start]" class="form-control form-control-sm mb-1 ltr" id="big-price-`+omde+`-start">
            </div>
        </div>
        <div class="col-sm-6 pr-1">
            <div class="input number"><label for="big-price-`+omde+`-price"><?=$p_label?></label>
            <input type="number" name="big_price2[`+omde+`][price]" class="form-control form-control-sm mb-1 ltr money1"></div>
        </div>
        <div class="col-sm-1" nonce="<?=get_nonce?>" onclick="deleteDetail('id`+omde+`');" id="id`+omde+`" 
            title="حذف" style="cursor:pointer;color:#F00;padding-top:30px"> x </div>
    </div></div>`);
    omde+=1;
});

/////////////////////////////////////
$(document).on('click', '.wholed', function () {
    if (confirm("برای حذف مطمئن هستید ؟")== true)
        $(this).parent().remove();
});

$(document).on('click', '#add_attrlists', function () {
    if (confirm("آیا مقادیر قبلی حذف شوند? (Ok = بله) (Cancel = خیر)") == true){
        $('.attrlists').html('');
    }

    $('.attrlists2 input[type=checkbox]').each(function () {
        if(this.checked == true){
            var var_name = this.name;
            $.each(jQuery.parseJSON(attrlist), function(key,value) {
                var k1 = '' ;
                var k2 = '' ;
                var str = '';
                //str = '<div class="card mb-1"><div class="card-header p-1"><div class="float-right">';
                if(value != ''){
                    $.each(value, function(key1,value1) {
                        str += '<label>'+chkArray[key1]+': '+value1+'</label>';
                        k1 += key;
                        k2 = k2 + key1+',';
                    });
                }
                if(var_name == k2){
                    str = `<div class="card mb-1"><div class="card-header" style="padding: 5px 15px;"><div class="float-right">` + str;
                    k2 = k2.slice(0,-1);
                    str += '</div><a style="float:left;cursor:pointer;margin-right:5px;" nonce="<?=get_nonce?>" class="text-danger" onclick="deleteDetail('+"'cEx"+k1+"'"+');" title="حذف">[X]</a>';
                    str += '<a class="collapsed" style="float:left;" data-toggle="collapse" href="#cEx'+k1+'" aria-expanded="false" aria-controls="cEx'+k1+'">نمایش</a>';
                    str += '<div class="clearfix"></div><div class="collapse" id="cEx'+k1+'"><div class="card card-body m-0 p-0" style="border-radius: 5px;">';
                        message = $('.tests').html();
                        message = message.replaceAll('name="Meta', 'name="Meta['+k2+']');
                        message = message.replaceAll('data-pattern=""', 'data-pattern="'+k2+'"');
                    str += message +'</div></div></div>'; 
                    $('.attrlists').append(str);
                }
            });
        }
    });
    $('.attrlists2').html('');
    $('.attrlists2').removeClass('alert alert-primary');
});

$("#attrbtn").click(function(){
    var chkArray = [];  
    $(".chk:checked").each(function() {chkArray.push($(this).val());});
    var selected = chkArray.join(',') ;
    if(selected != ''){
        if($('.attrlists').html() != ''){
            //if (confirm("اطلاعات قبلی همگی پاک خواهند گردید و قابل بازیابی نخواهند بود")== true)
            get_attr(selected);
        }
        else get_attr(selected);
    }
    else alert('هنوز گزینه ای انتخاب نکرده اید');
});
var attrlist = '';
var chkArray = [];
function get_attr(id){
      
    $.ajax({
        type : 'GET', data: 'gettitle='+id,async: false,
        url : "<?= Router::url(['plugin'=>'Shop','controller' => 'Home', 'action' => 'attributes'],false) ?>",
        success : function(data){chkArray = jQuery.parseJSON(data);},
        error:function (XMLHttpRequest, textStatus, errorThrown) {}
    });

    $.ajax({
        type : 'GET', data: 'getlist='+id,
        url : "<?= Router::url(['plugin'=>'Shop','controller' => 'Home', 'action' => 'attributes'],false) ?>",
        success : function(data){
            attrlist = data;
            $('.attrlists2').html('');
            $.each(jQuery.parseJSON(data), function(key,value) {
                $('.attrlists2').addClass('alert alert-primary'); 
                /* var k1 = '' ;
                var k2 = '' ;
                str = '<div class="card mb-1"><div class="card-header p-1"><div class="float-right">';
                if(value != ''){
                    $.each(value, function(key1,value1) {
                        str += '<label>'+chkArray[key1]+': '+value1+'</label>';
                        k1 += key;
                        k2 = k2 + key1+',';
                    });
                }
                k2 = k2.slice(0,-1);
                str += '</div><a style="float:left;cursor:pointer;margin-right:5px;" class="text-danger" onclick="deleteDetail('+"'cEx"+k1+"'"+');" title="حذف">[X]</a>';
                str += '<a class="collapsed" style="float:left;" data-toggle="collapse" href="#cEx'+k1+'" aria-expanded="false" aria-controls="cEx'+k1+'">نمایش</a>';
                str += '<div class="clearfix"></div><div class="collapse" id="cEx'+k1+'"><div class="card card-body m-0 p-0" style="border-radius: 5px;">';

                    message = $('.tests').html();
                    message = message.replaceAll('name="Meta', 'name="Meta['+k2+']');
                    message = message.replaceAll('data-pattern=""', 'data-pattern="'+k2+'"');

                str += message +'</div></div></div>'; 
                $('.attrlists').append(str);*/

                
                str = '';
                var k1 = '' ;
                var k2 = '' ;
                if(value != ''){
                    str += `<label>`;
                    $.each(value, function(key1, value1) {
                        str += '<span>'+chkArray[key1]+' : '+value1 + '</span> ';
                        k1 += key;
                        k2 = k2 + key1+',';
                    });
                    str += `<input type="checkbox" name="`+k2+`" value=""></label>`;
                }
                k2 = k2.slice(0,-1);
                $('.attrlists2').append(str);
            });

            $('.attrlists2').append(`<br>
                <a id="add_attrlists" class="btn btn-secondary btn-sm float-left">
                افزودن موارد انتخاب شده</a>
                <div class="clearfix"></div>
                <div class="mt-1 alert alert-primary small"style="padding: 5px !important;">
                    ویژگی های تکراری بصورت اتوماتیک هنگام ثبت حذف می شوند. همیشه آخرین تکراری ثبت خواهد شد.
                </div>
                <div class="clearfix"></div>`);
        },
        error:function (XMLHttpRequest, textStatus, errorThrown) {
            $('.attrlists').html("متاسفانه امکان دریافت اطلاعات وجود ندارد");
        }
    });

    //console.log(attrlist);
}
/////////////////////////////////////
function deleteDetail(id){
    if (confirm("برای حذف مطمئن هستید ؟")== true)
        $("#"+id).parent().parent().remove();
}

/////////////////////////////////////
$('#myform').submit(function() {
    $('.tests').remove();
});
$('.tab-content input').addClass('form-control-sm');
$('.tab-content select').addClass('form-control-sm');
$('.tab-content textarea').addClass('form-control-sm');
</script>

<div class="tests d-none">
    <?= $this->cell('Shop.FormDetail')?>
</div>

<style>
.tab-shop label{
    letter-spacing: -0.5px;
}
.cls11{
    cursor:pointer;
    position: absolute;
    left: 0;
    margin-left: 10px;
    top: 0;
    margin-top: 10px;
}
.cls12{
    border-radius: 5px;
}
.cls13{
    float: right;
    background: #eef1f3;
    padding-top: 5px;
    padding-left: 10px;
    font-weight: bold;
}
.wholed{
    max-width: 10px;
    padding: 0 !important;
    padding-top: 35px !important;
    cursor: pointer;
}
.card{
    border:0px !important;
    margin-top:0 !important;
}
.p_param{
    height:50px !important;
}
.attrlists .card-header:hover .text-danger{
    opacity:1;
}
.attrlists .card-header .text-danger{
    opacity:0;
}
.attrlists .card-header .collapsed label:after,
.attrlists .card-header .float-right label:after
{
    content: '|' !important;
    padding: 0 5px;
}
.attrlists .card-header .collapsed label:last-child:after,
.attrlists .card-header .float-right label:last-child:after
{
    content:' ' !important;
}

.attrlists .card-header{
    border: 1px solid #c2cfd6;
    border-radius: 10px;
}
.attrlists2 label span{margin-left:5px;}
.nav-tabs-boxed.nav-tabs-boxed-right{display:-ms-flexbox;display:flex}
.nav-tabs-boxed.nav-tabs-boxed-left .nav-item,.nav-tabs-boxed.nav-tabs-boxed-right .nav-item{z-index:1;-ms-flex-positive:1;flex-grow:1;margin-bottom:0}
*[dir=rtl] .nav-tabs-boxed.nav-tabs-boxed-left{-ms-flex-direction:row-reverse;flex-direction:row-reverse}
.nav-tabs-boxed.nav-tabs-boxed-left .nav-item{margin-right:-1px}
.nav-tabs-boxed.nav-tabs-boxed-left .nav-link{border-radius:.25rem 0 0 .25rem}
.nav-tabs-boxed.nav-tabs-boxed-left .nav-link.active{border-color:#d8dbe0 #fff #d8dbe0 #d8dbe0}
.c-legacy-theme .nav-tabs-boxed.nav-tabs-boxed-left .nav-link.active{border-color:#c8ced3 #fff #c8ced3 #c8ced3}
.c-dark-theme .nav-tabs-boxed.nav-tabs-boxed-left .nav-link.active{border-color:rgba(255,255,255,.075)}
html:not([dir=rtl]) .nav-tabs-boxed.nav-tabs-boxed-right{-ms-flex-direction:row-reverse;flex-direction:row-reverse}
*[dir=rtl] .nav-tabs-boxed.nav-tabs-boxed-right{-ms-flex-direction:row;flex-direction:row}
html:not([dir=rtl]) .nav-tabs-boxed.nav-tabs-boxed-right .nav-item{margin-right:-1px}
*[dir=rtl] .nav-tabs-boxed.nav-tabs-boxed-right .nav-item{margin-right:-1px}
.nav-tabs-boxed.nav-tabs-boxed-right .nav-link{border-radius:0 .25rem .25rem 0}
.nav-tabs-boxed.nav-tabs-boxed-right .nav-link.active{border-color:#d8dbe0 #d8dbe0 #d8dbe0 #fff}
.c-legacy-theme .nav-tabs-boxed.nav-tabs-boxed-right .nav-link.active{border-color:#c8ced3 #c8ced3 #c8ced3 #fff}
.c-dark-theme .nav-tabs-boxed.nav-tabs-boxed-right .nav-link.active{border-color:#282933 #282933 #282933 #282933}
.nav-tabs-boxed.nav-tabs-boxed-right .tab-content{border-radius:.25rem 0 .25rem .25rem}
</style>