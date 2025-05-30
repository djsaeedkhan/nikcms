<?php use Lms\Predata;$predata = new Predata;?>
<div class="content-header row">
    <div class="content-header-right col-md-10 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    <?= __('افزودن فاکتور جدید') ?>
                </h2>
            </div>
        </div>
    </div>
</div>

<?= $this->Form->create($lmsFactor,['class'=>'col-sm-8']) ?>
<div class="card"><div class="card-body">
        <div class="row mb-2">
            <div class="col-sm-5">
                <?= $this->Form->control('user_id', [
                    'label'=>'نام کاربری',
                    'empty'=>'-- انتخاب کنید --',
                    'required',
                    'options' => $users,
                    'class'=>'select2 form-control']);?>
            </div>

            <div class="col-sm-4">
                <?= $this->Form->control('price',[
                    'label'=>'مبلغ',
                    'required',
                    'class'=>'form-control ltr mb-2']);?>
            </div>
            <div class="col-sm-3">
                <?= $this->Form->control('paid',[
                    'type'=>'select',
                    'label'=>'پرداخت شده',
                    'required',
                    'empty'=>' - ',
                    'options'=>$predata->gettype('paid'),
                    'class'=>'form-control']);?>
            </div>

            <div class="col-sm-12">
                <?php
                if(!$lmsFactor->id){
                    echo $this->Form->control('lms_course_id',[
                    'label'=>'انتخاب دوره',
                    'required',
                    'type'=>'select',
                    'options'=>$course,
                    'class'=>'form-control ltr mb-2 select2']);
                }?>
            </div>

            
            <div class="col-sm-6">
                <?php /* $this->Form->control('status',[
                    'label'=>'وضعیت پرداخت',
                    'class'=>'form-control ltr']); */?>
            </div>
        </div>

        <?php
        echo $this->Form->control('descr',[
            'label'=>'توضیحات',
            'type'=>'textarea','class'=>'form-control']);
    ?>
</div></div>
<?= $this->Form->button(__('ثبت'),['class'=>'btn btn-success']) ?>
<?= $this->Form->end() ?>
