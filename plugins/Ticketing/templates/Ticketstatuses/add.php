<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    <?= __d('Ticketing', ' وضعیت تیکت') ?>
                </h2>
            </div>
        </div>
    </div>
</div>

<div class="card"><div class="card-body">
    <?= $this->Form->create($ticketstatus, ['class'=>'col-sm-6']) ?>
    <?php
        echo $this->Form->control('title', ['label'=>__d('Ticketing', 'عنوان وضعیت تیکت'), 'class'=>'form-control']);
        /* echo $this->Form->control('color'); */
    ?>
</div></div>
    <?= $this->Form->button(__d('Ticketing', 'ثبت اطلاعات'), ['class'=>'btn btn-primary btn-sm']) ?>
    <?= $this->Form->end() ?>
