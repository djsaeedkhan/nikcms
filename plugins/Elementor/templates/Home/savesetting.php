<!-- <script nonce="<?=get_nonce?>" src="/cake3/cms/hoorsun/admin/app-assets/vendors/js/vendors.min.js?2"></script> -->
<?php
use Cake\Routing\Router;
$setting = str_replace('.','_',$setting);
$this->request = $this->request->withData($setting,$data);

global $settings;
global $datas;
$settings = $setting;
$datas = $data;

if($element != null){
  echo $this->form->create(null,['id'=>'saveforms']);?>
  <ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" id="elmhome-tab" data-toggle="tab" href="#elmhome" aria-controls="elmhome" role="tab" aria-selected="true">تنظیمات</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="elmprofile-tab" data-toggle="tab" href="#elmprofile" aria-controls="elmprofile" role="tab" aria-selected="false">بیشتر</a>
    </li>
  </ul>

  <div class="tab-content elementor-tab">
    <div class="tab-pane active" id="elmhome" aria-labelledby="elmhome-tab" role="tabpanel">
      <?= $this->cell($element['admin']);?>
    </div>
    <div class="tab-pane" id="elmprofile" aria-labelledby="elmprofile-tab" role="tabpanel">
      <p>
          
      <?php
      /* global $settings;
      global $datas; */
      $this->request = $this->request->withData($setting, $data);
      echo $this->form->control($settings.'.id',[
          'label'=>'عنوان Class',
          'class'=>'form-control mb-1'
      ]);
      echo $this->form->control($settings.'.class',[
          'type'=>'text',
          'label'=>'عنوان ID',
          'class'=>'form-control mb-1'
      ]);
      ?>
</p>
    </div>
  </div>


  <hr>
  <?php
  echo $this->form->submit('ثبت تنظیمات',['class'=>'btn btn-sm btn-secondary']);
  echo $this->form->end();
}?>
<script nonce="<?=get_nonce?>">
$(document).ready(function () {
  $("#saveforms").submit(function (event) {
    var formData = $(this);
    $.ajax({
        type : 'POST',
        url : "<?= Router::url(false);?>",
        data: formData.serialize(),
        encode: true,
        beforeSend: function() {
          $('#saveforms .btn-secondary').val('در حال ارسال اطلاعات ...');
        },
        success : function(data){
          $('#saveforms .btn-secondary')
            .removeClass('btn-secondary')
            .addClass('btn-success')
            .val('ثبت اطلاعات انجام شد');
          setTimeout(function() {
            $('#saveforms .btn-success')
              .removeClass('btn-danger')
              .removeClass('btn-success')
              .addClass('btn-secondary');
            $('#saveforms .btn-secondary').val('ثبت اطلاعات');
          }, 1200);
        },
        error:function (XMLHttpRequest, textStatus, errorThrown) {
            $('#saveforms .btn-secondary').removeClass('btn-secondary').addClass('btn-danger');
            $('#saveforms .btn-secondary').val('متاسفانه ثبت انجام نشد');
            setTimeout(function() {
            $('#saveforms .btn-success')
              .removeClass('btn-danger')
              .removeClass('btn-success')
              .addClass('btn-secondary');
            $('#saveforms .btn-secondary').val('ثبت اطلاعات');
          }, 1200);
        }
    });
    event.preventDefault();
  });
});
</script>
<style>
  .elementor-tab .tab-pane .row{
    margin:0 !important;
  }
</style>
