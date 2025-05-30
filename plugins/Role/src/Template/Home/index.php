<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    <?=__d('Role','افزونه مدیریت دسترسی')?>
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                        <?=$this->Auths->link(
                            __d('Role','افزودن'),
                            ['action'=>'Add'],
                            ['class'=>'btn btn-sm btn-primary']);?>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card"><div class="card-body">
    <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th scope="col" style="width:200px;">
                    <?=__d('Role','عنوان دسترسی')?>
                </th>
                <th scope="col" style="width:200px;">
                    <?=__d('Role','دسترسی به پنل مدیریت')?>
                </th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php $i=1;foreach ($result as $data): ?>
            <tr>
                <td><?= h($data->title) ?></td>
                <td>

                    <?php
                    if( $this->request->getAttribute('identity')->get('role_id') != $data->id):
                    echo $this->Form->create(null, ['url'=>['plugin'=>'Admin','controller'=>'Options','action'=>'SaveSetting']]);?>
                    <div class="custom-control custom-switch custom-switch-success">
                        <input type="hidden" value="0" name="role<?=$data->id?>"/>
                        <input type="checkbox" class="custom-control-input change_role" id="role<?=$data->id?>" value="1" name="role<?=$data->id?>" 
                            <?=$this->Func->OptionGet('role'.$data->id)==1?'checked':''?> />
                        <label class="custom-control-label" for="role<?=$data->id?>">
                            <span class="switch-icon-left"><i data-feather="check"></i></span>
                            <span class="switch-icon-right"><i data-feather="x"></i></span>
                        </label>
                        <?= $this->Form->submit(
                            __d('Role','ثبت تغییرات'),
                            ['class'=>'btn btn-light btn-sm d-none float-left'
                        ])?>
                    </div>
                    <?= $this->Form->end();
                    endif;?>
                </td>
                <td>
                    <div class="hidme">
                        <?= $this->Auths->link(
                            __d('Role','ویرایش'), 
                            ['action'=>'Add', $data->id]) ?>

                        <?= $this->Form->postlink(
                            __d('Role','حذف'), 
                            ['action'=>'Delete', $data->id ], 
                            ['confirm' => __d('Role','آیا برای حذف مطمئن هستید؟')]) ?>
                    </div>
                </td>
            </tr>
            <?php $i+=1;endforeach; ?>
        </tbody>
    </table></div>
</div></div>

<style>
    table div.submit{
        float: left;
    }
</style>
<script nonce="<?=get_nonce?>">
$(function() {
    $('.change_role').change(function(){
        //alert(this.value);
        $(this).parent().find('.d-none').removeClass('d-none');
        if($(this).prop('checked') == true){
            $('#send_sms_price').prop('disabled',false);
            $('#send_sms_price').prop( "checked", true );
            $('#send_sms_price').removeAttr('required');
        }
        else{
            $('#send_sms_price').prop('disabled',true);
            $('#send_sms_price').prop( "checked", false );
            $('#send_sms_price').removeAttr('required');
        }
    });
});
</script>