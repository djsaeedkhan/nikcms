
<div class="content-header row">
    <div class="content-header-right col-md-10 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    <?= __('مدیریت آزمون') ?>
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
<?= $this->Form->create($lmsExam);
    $lmsExam['options'] = $lmsExam['myoptions'];
?>

<div class="card"><div class="card-body">
    <div class="row">
        <div class="col-sm-8">
            <?php
            echo $this->Form->control('title',['label'=>'عنوان','class'=>'form-control']);
            echo $this->Form->control('descr',['label'=>'توضیحات ','type'=>'textarea','class'=>'form-control']);
            ?>
        </div>
        <div class="col-sm-4">
            <?= $this->Form->control('timer',[
                'label'=>'زمان (دقیقه)',
                'type'=>'number',
                'dir'=>'ltr',
                'class'=>'form-control']);?>

            <?= $this->Form->control('reexam',[
                'label'=>'تعداد مجاز آزمون (عدد)',
                'type'=>'number',
                'dir'=>'ltr',
                'class'=>'form-control']);?>

            <?= $this->Form->control('fail_count',[
                'label'=>'حداکثر تعداد جواب غلط',
                'type'=>'number',
                'dir'=>'ltr',
                'class'=>'form-control','style'=>'margin-bottom:-20px !important']);?>
            <div class="alert alert-secondary small"> بیش از این مقدار غلط باشد، آزمون مردود خواهد شد</div>
        </div>
    </div>
</div></div>

<div class="card"><div class="card-body">
    <div class="row">
        <div class="col-sm-5">
            <h4 class="mb-2">امکان شرکت مجدد در آزمون با پرداخت هزینه</h4>
            <div class="col-12">
                <?= $this->Form->control('options.can_exampay',[
                    'label'=>'امکان شرکت مجدد با پرداخت هزینه',
                    'options'=> $this->Func->Predata('yesno'),
                    'class'=>'form-control']);?>

                <?= $this->Form->control('options.can_exampay_alert',[
                    'label'=>'متن نمایشی جهت شرکت مجدد با پرداخت هزینه',
                    'type'=> "textarea",
                    'class'=>'form-control']);?>
            </div>
        </div>
        <div class="col-sm-7">
            <div class="alert alert-secondary small">
                در صورتی که عنوان فیلد مجدد خالی باشد، آن سطر نمایش داده نمی شود
            </div>
            <div class="row">
                
            <?php foreach([1,2,3,4,5] as $time_again):
                echo $this->Form->control('options.again.'.$time_again.'m_number',[
                    'type'=>'hidden',
                    'value' =>$time_again ]);?>
            <div class="col-sm-8">
                <?= $this->Form->control('options.again.'.$time_again.'m_title',[
                    'type'=>'text',
                    'label'=>'عنوان مجدد '.$time_again.' دفعه',
                    'class'=>'form-control']);?>
            </div>
            <div class="col-sm-4">
                <?= $this->Form->control('options.again.'.$time_again.'m_price',[
                    'type'=>'number',
                    'label'=>'مبلغ تمدید (فقط عدد)',
                    'class'=>'form-control ltr']);?>
            </div>
            <?php endforeach?>
        </div></div>
    </div>
</div></div>

<?= $this->Form->button(__('ثبت'),['class'=>'btn btn-sm btn-success']) ?>
<?= $this->Form->end() ?>
<style>.input{margin-bottom:20px;}</style>