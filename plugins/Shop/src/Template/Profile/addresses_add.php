<?php use Cake\Routing\Router;
$pp = new Shop\ProvinceCity();
?>
<div class="container" style="direction:rtl;text-align:right">
        <?php isset($shopAddress['id']) ?
            $this->assign('shop_title','بروز رسانی آدرس'):
            $this->assign('shop_title','ثبت آدرس جدید')?>
    <?= $this->Form->create(isset($shopAddress)?$shopAddress:null); ?>
    <div class="row">
        <div class="col-sm-6">
            <?= $this->Form->control('billing_state', ['label'=>'استان',
                'options' => $this->Func->province_list(), 'empty' => '-- انتخاب کنید --',
                'class' => 'form-control',
                'id'=>'province','required']); ?><br />
        </div>
        <div class="col-sm-6">
            <?= $this->Form->control('billing_city', ['type'=>'select',
                'label'=>'شهرستان','class' => 'city form-control','required',
                'options'=>(isset($shopAddress['billing_state']))?
                    $pp->getlist($shopAddress['billing_state']):[],]); ?><br />
        </div>
        <div class="col-sm-6">
            <?= $this->Form->control('billing_address', [
                'type'=>'textarea','label'=>'آدرس','class' => 'form-control','required','style'=>'height:60px;']); ?><br />
        </div>
        <div class="col-sm-6">
            <?= $this->Form->control('billing_zip', [
                'label'=>'کدپستی','dir'=>'ltr','class' => 'form-control','required']); ?><br />
        </div>
    </div>
    
    <?php
    echo $this->form->submit('ثبت اطلاعات',['class'=>'btn btn-success btn-sm']);
    echo $this->Form->end(); ?>
</div>
<script nonce="<?=get_nonce?>">
$('#province').on('change', function() {
    get_param( this.value );
});
/* $(document).ready(function(){
    if($("#province").length > 0){
        get_param( $("#province").val());
    }
}); */


function get_param(id){
    $.ajax({
        type : 'GET',data: 'province='+id,
        url : "<?= Router::url() ?>",
        success : function(data){
            var obj = $.parseJSON(data);
            console.log(obj);
            var $select = $('.city'); 
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