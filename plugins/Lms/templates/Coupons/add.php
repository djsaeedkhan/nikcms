<?php use Lms\Predata;$predata = new Predata;?>
<div class="content-header row">
    <div class="content-header-right col-md-10 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    <?= __('مدیریت کد تخفیف') ?>
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-right col-md-2 col-12 d-md-block d-none">
    </div>
</div>

<div class="card"><div class="card-body">
    <?= $this->Form->create($lmsCoupon,['class'=>'col-sm-6']) ?>
    <?php
        echo $this->Form->control('title',[
            'label'=>'عنوان کد تخفیف',
            'dir'=>'ltr',
            'class'=>'form-control'
        ]);
        echo'<div class="small mb-1 alert alert-primary">از حروف و اعداد انگلیسی استفاده شود</div>';

        if(isset($lmsCoupon['id'])){
            $lmsCoupon['product_ids'] = json_decode($lmsCoupon['product_ids']);
        }
        echo $this->Form->control('product_ids',[
            'label'=>'دوره قابل استفاده',
            'class'=>'form-control mb-1 select2',
            'multiple'=>'multiple',
            'type'=>'select','options'=> $courselist
        ]).'<br>';

        echo $this->Form->control('usage_limit_per_user',[
            'label'=>'تعداد استفاده هر کاربر','type'=>'number',
            'dir'=>'ltr',
            'class'=>'form-control mb-1'
        ]);
        /* echo $this->Form->control('usage_limit_price',[
            'label'=>'حداکثر مبلغ تخفیف',
            'class'=>'form-control'
        ]); */
        echo $this->Form->control('usage_count',[
            'label'=>'تعداد دفعات قابل استفاده','type'=>'number',
            'dir'=>'ltr',
            'class'=>'form-control mb-1'
        ]);
        echo $this->Form->control('discount_type',[
            'label'=>'نوع تخفیف',
            'type'=>'select','options'=> $predata->gettype('discount_type'),
            'class'=>'form-control mb-1'
        ]);
        echo $this->Form->control('maximum_amount',[
            'label'=>'حداکثر هزینه','type'=>'number',
            'dir'=>'ltr',
            'class'=>'form-control'
        ]);
        echo'<div class="small mb-1 alert alert-primary">
        این گزینه به شما اجازه می‌دهد که حداکثر مقدار خرید برای استفاده از کدتخفیف را تعیین کنید.<br>
        مثلا اگر درصدی هست، میشود 20درصد و اگر عددی هست، می شود 20000</div>';
        /* echo $this->Form->control('product_categories',[
            'label'=>'',
            'class'=>'form-control'
        ]); */
        
        if(isset($lmsCoupon['id'])){
            try {
                $lmsCoupon['expiry_date'] = $this->Func->mil_to_shm($lmsCoupon['expiry_date'],'/');
            } catch (Exception $th) {
                throw $th;
            }
        }

        echo $this->Form->control('descr',[
            'type'=>'textarea',
            'label'=>'توضیحات نمایشی بعد از اعمال کد تخفیف به کاربر',
            'class'=>'form-control mb-1'
        ]);

        echo $this->Form->control('expiry_date',[
            'id'=>'pdpGregorian','type'=>'text',
            'label'=>'تاریخ انقضا',
            'dir'=>'ltr',
            'class'=>'form-control mb-1'
        ]);
    ?>
    <?= $this->Form->button(__('ثبت'),['class'=>'btn btn-sm btn-success']) ?>
    <?= $this->Form->end() ?>
</div></div>


<script nonce="<?=get_nonce?>">//https://behzadi.github.io/persianDatepicker/
    $("#pdpGregorian").persianDatepicker({ 
        //formatDate: "YYYY/0M/0D hh:mm:ss",
        formatDate: "YYYY/0M/0D",
        fontSize: 13, // by px
        selectableMonths: [01, 02, 03, 04, 05, 06, 07, 08, 09, 10, 11, 12],
        persianNumbers: !0,
        isRTL: !1,  //  isRTL:!0 => because of persian words direction
        //onSelect: function () {alert('asd')},
        showGregorianDate: <?=$this->Func->Optionget('admin_calender') == 1?'true':'false'?> 
    });
    $("#pdpGregorian2").persianDatepicker({ 
        //formatDate: "YYYY/0M/0D hh:mm:ss",
        formatDate: "YYYY/0M/0D 0h:0m:0s",
        fontSize: 13, // by px
        selectableMonths: [01, 02, 03, 04, 05, 06, 07, 08, 09, 10, 11, 12],
        persianNumbers: !0,
        isRTL: !1,  //  isRTL:!0 => because of persian words direction
        //onSelect: function () {alert('asd')},
        showGregorianDate: <?=$this->Func->Optionget('admin_calender') == 1?'true':'false'?> 
    });
</script>
