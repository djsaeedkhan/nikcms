<div class="content-header row mb-2">
    <div class="content-header-right col-md-5 col-12 mt-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title1 float-right mb-0">
                    مدیریت گزارشات
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                        <?= $this->Form->create(null, ['type' => 'get','class'=>'d-flex']); ?>
                        <?= $this->Form->control('action', [
                            'label'=> false,'required','type' => 'select','id'=>'action1','style'=>'width: inherit;',
                            'empty'=>'-- انتخاب گزارش --',
                            'options'=>[
                                'stocks' =>'موجودی ',
                                'sell' =>'فروش محصولات',
                                'exit' =>'خروجی سفارشات ',
                                'daily' =>'گزارش مالی روزانه',
                                'monthly' =>'گزارش مالی ماهانه',
                                'year' =>'گزارش مالی سالانه',
                            ],
                            'class' => 'form-control float-right mr-1 pr-1',
                            'default'=>($this->request->getQuery('action')?$this->request->getQuery('action'):'')
                            ]);?>

                        <?= $this->Form->control('نمایش', [
                            'type' => 'submit','label'=>false,'style'=>'max-height:30px !important;',
                            'class' => 'btn btn-sm btn-primary' ]);?>
                        <?= $this->Form->end()?>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>