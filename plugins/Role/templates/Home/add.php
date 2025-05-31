<?php use Admin\View\Helper\ModuleHelper;?>
<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title1 float-right mb-0">
                    <?=__d('Role','ثبت / ویرایش حق دسترسی')?>
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->Form->create($roles) ?>
<div class="float-left pt-3">
    <?= $this->Form->button(
        __d('Role','ثبت اطلاعات'),
        ['class'=>'btn btn-sm btn-success']);?>

    <?= $this->Html->link(
        __d('Role','انتخاب همه'),
        '#',
        ['id'=>'selectAll','class'=>'btn btn-sm btn-secondary']);?>

    <?= $this->Html->link(
        __d('Role','عدم انتخاب'),
        '#',
        ['id'=>'selectNone','class'=>'btn btn-sm btn-secondary']);?>
</div>

<div class="row">
    <div class="col-sm-4 mb-3">
        <?= $this->Form->control('title',[
            'type'=>'text',
            'label'=>__d('Role','عنوان'),
            'class'=>'form-control',
            'required']);?>
    </div>
</div>
<div class="clearfix clearfloat"></div>

    <?php 
    foreach (ModuleHelper::options_role() as $datas):
        if(isset($datas['role']) and count($datas['role'])):
            echo '<div class="ff"><h3 class="badge badge-warning text-lg">پلاگین: '.$datas['title'].'</h3><div class="row">';
            foreach($datas['role'] as $k => $data):?> 
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="box p-2">
                        <div class="mb-2 badge badge-primary">
                            <?= $data['title'];?>
                        </div>
                        <div class="ml-1" style="max-height:150px;overflow:auto">
                            <?= $this->Form->control('data.'.strtolower($datas['plugin']).'.'.strtolower($k), [
                                'label' => false,
                                'type' => 'select',
                                'multiple' => 'checkbox',
                                'options' => $data['action'],
                                ]);?>
                        </div>
                    </div>
                </div>
            <?php 
            endforeach;
            echo '</div></div>';
        endif;
    endforeach?> 

<div class="clearfix clearfloat"></div>
<div class="float-left mb-3">
    <?= $this->Form->button(
        __d('Role','ثبت اطلاعات'),
        ['class'=>'btn btn-success','style'=>'margin-right:14px;']);?>
</div>

<?= $this->Form->end() ?>

<div class="clearfix clearfloat"></div>

<script nonce="<?=get_nonce?>">
$("#selectAll").click(function(){
    $(':checkbox').prop('checked',"checked");
});
$("#selectNone").click(function(){
    $(':checkbox').prop('checked',null);
});
</script>

<style>
.ff h3{
    font-size:15px;
}
input[type="checkbox"] {
    width: inherit;float: right;margin:0px;margin-left: 5px;
    }
</style>