<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    <?= __d('Ticketing', ' اولویت تیکت') ?>
                </h2>
            </div>
        </div>
    </div>
</div>

<?= $this->Form->create($ticketpriority, ['class'=>'col-sm-6']) ?>
<div class="card"><div class="card-body">
        <?php
            echo $this->Form->control('title', [
                'label'=> __d('Ticketing', 'عنوان اولویت'),
                'class'=>'form-control' ]);
                
            echo $this->Form->control('color', [
                'type'=>'hidden',
                'default'=>'1' ]);
        ?>
</div></div>
    <?= $this->Form->button(
        __d('Ticketing', 'ثبت اطلاعات'),
        ['class'=>'btn btn-primary btn-sm']) ?>
    <?= $this->Form->end() ?>
