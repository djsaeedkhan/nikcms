<div class="content-header row">
  <div class="content-header-right col-md-10 col-12 mb-2">
    <div class="row breadcrumbs-top">
      <div class="col-12">
        <h2 class="content-header-title float-right mb-0">
          <?= __('افزودن سوال') ?>
        </h2>
      </div>
    </div>
  </div>
</div>

<div class="card"><div class="card-body">
  <?= $this->Form->create($lmsExamquest,['class'=>'col-12 col-md-9']); ?>
      <?php
          echo $this->Form->control('title',['default'=>'11','type'=>'hidden']);
        
          if($id == null)
              echo $this->Form->control('lms_exam_id', ['options' => $lmsExams]);
          echo $this->Form->control('title',[
            'label'=>'عنوان سوال',
            'class'=>'form-control form-control-sm',
            'type'=>'textarea',
            'id'=>'edittextarea6'
          ]);
            
          echo $this->Form->control('types',[
              'label'=>'نوع سوال',
              'class'=>'form-control form-control-sm',
              'required',
              'empty'=>'-- انتخاب کنید --',
              'default'=>'',
              'options'=> $lms_examquests_type,
              'id'=>'tpes']);

          echo '<div class="types '.((isset($lmsExamquest->types) and $lmsExamquest->types !=0)?'':'d-none').'">';
              echo $this->Form->control('q1',[
                'label'=>'پاسخ 1','type'=>'textarea','class'=>'form-control form-control-sm',
                'id'=>'edittextarea1']);echo '<hr>';

              echo $this->Form->control('q2',[
                'label'=>'پاسخ 2','type'=>'textarea','class'=>'form-control form-control-sm',
                'id'=>'edittextarea2']);echo '<hr>';

              echo $this->Form->control('q3',[
                'label'=>'پاسخ 3','type'=>'textarea','class'=>'form-control form-control-sm',
                'id'=>'edittextarea3']);echo '<hr>';

              echo $this->Form->control('q4',[
                'label'=>'پاسخ 4','type'=>'textarea','class'=>'form-control form-control-sm',
                'id'=>'edittextarea4']);echo '<hr>';

              echo $this->Form->control('q5',[
                'label'=>'پاسخ 5','type'=>'textarea','class'=>'form-control form-control-sm',
                'id'=>'edittextarea5']);echo '<hr>';

          echo '</div><div class="types2 '.((isset($lmsExamquest->types) and $lmsExamquest->types !=0)?'':'d-none').'">';
              echo $this->Form->control('correct',[
                'label'=>'گزینه صحیح','class'=>'form-control form-control-sm text-white bg-success',
                'options'=>[
                  1=>"گزینه 1",
                  2=>"گزینه 2",
                  3=>"گزینه 3",
                  4=>"گزینه 4",
                  5=>"گزینه 5"]]);
          echo '</div>';
          echo $this->Form->control('priority',['label'=>'اولویت نمایش','class'=>'form-control form-control-sm',]);
          echo $this->Form->control('images',['label'=>'تصویر سوال','dir'=>'ltr','placeholder'=>'http://','class'=>'form-control form-control-sm',]);
      ?>
  <?= $this->Form->button(__('ثبت'),['class'=>'btn btn-sm btn-success']) ?>
  <?= $this->Form->end() ?>
</div></div>
<script nonce="<?=get_nonce?>">

$(document).ready(function (){
    $('#edittextarea6').each(function() {    
    $(this).removeAttr('required');
    });
}); 

$('#tpes').on('change', function() {
  if(this.value == 0){
    $(".types").addClass('d-none');
    $(".types2").addClass('d-none');
  }
  if(this.value == 1){
    $(".types").addClass('d-none');
    $(".types2").addClass('d-none');
    $(".types").removeClass('d-none');
    $(".types2").removeClass('d-none');
  }
  if(this.value == 2){
    $(".types").addClass('d-none');
    $(".types2").addClass('d-none');
    $(".types").removeClass('d-none');
  }
});
<?php for($i=1;$i<7;$i++):?>
tinymce.init({
    forced_root_block : "", 
    convert_urls: false,
    force_br_newlines : true,
    force_p_newlines : false,
    selector: "#edittextarea<?=$i?>",  // change this value according to your HTML
    //rtl_ui:true,
    directionality: 'rtl',
    plugins:[
      "advlist autolink lists link image charmap print preview anchor",
      "searchreplace visualblocks code fullscreen",
      "insertdatetime media table contextmenu paste directionality",
    ],
    toolbar: "ltr rtl  | fontselect fontsizeselect | insertfile | bold italic underline | alignleft aligncenter alignright alignjustify | link image media",
    font_formats: "Tahoma=tahoma,arial,helvetica,sans-serif;Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Open Sans=Open Sans,helvetica,sans-serif;Symbol=symbol;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats",
    fontsize_formats: "8px 10px 11px 12px 14px 18px 24px 36px",
    setup: function (ed) {
        ed.on('init', function (ed) {
            ed.target.editorCommands.execCommand("fontName", false, "tahoma");
        });
    }
});
<?php endfor?>
</script>
<style>.input{margin-bottom:20px;}.mce-branding{display:none !important}</style>