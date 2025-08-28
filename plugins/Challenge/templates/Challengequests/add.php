<?= $this->Form->create($challengequest) ?>
<fieldset>
    <legend><?= __('افزودن سوال  / متن میان سوالات') ?></legend>
<div class="row">
    <div class="col-sm-6">
        <div class="row">
            <div class="col-sm-6">
                <?= $this->Form->control('types',[
                    'label' =>'نوع فیلد',
                    'empty'=> '-- --',
                    'required',
                    'default'=> false,
                    'options' => $types,
                    'class'=>'form-control']);?>
            </div>
            <div class="col-sm-6">
                <?= $this->Form->control('priority',[
                    'class'=>'form-control',
                    'value'=> isset($total)?$total:false,
                    'label'=>'ترتیب نمایش (فقط عدد)',
                    'default'=>false,
                    'type'=>'number']);?>
            </div>
        </div>
    <?php
        /* echo '<div class="alert alert-danger">
        بعد از ایجاد فیلد <b>چندگزینه ای</b> نسبت به درج زیرمجموعه (زیرسوال) اقدام نمایید</div>';

         echo '<div class="alert alert-danger">
        برای سوال <b>چندانتخابی</b> ابتدا یک سرتیتر ایجاد کرده و سپس گزینه ها را یکی یکی اضافه کنید</div>'; */

        echo $this->Form->control('title',[
            'class'=>'form-control',
            'label'=>'عنوان',
            'style'=>'height: 70px;',
            'type'=>'textarea']).'<br>';
    
       
       /*  echo '<div class="alert alert-primary"> اگر خالی باشد، پیشفرض در آخر لیست نمایش داده می شود.</div>'; */

        /* echo $this->Form->control('description',[
            'class'=>'form-control',
            'style'=>'height:100px;',
            'label'=>'توضیح مختصر']);
        echo '<div class="alert alert-primary">
        هر گزینه میتواند یک توضیح مختصر را نمایش بدهد</div>'; */

        /* if($parent_id == null)
            echo $this->Form->control('parent_id', [
                'class'=>'form-control select2',
                'label'=>'زیرمجموعه',
                'options' => $parentChallengequests,'empty'=>'--']).'<br>'; */
    ?>
    </div>
    <div class="col-sm-6 d-none itembox">
        <div id="inputContainer"></div>
        <button type="button" id="addInput" class="btn">➕ افزودن گزینه جدید برای سوال</button>
    </div>
</div>
</fieldset>
<?= $this->Form->button(__('ثبت اطلاعات'),['class'=>'btn btn-success']) ?>
<?= $this->Form->end() ?>

<script>
$(document).ready(function() {

$('#types').on('change', function() {
    var val = $(this).val();
    console.log(val);
    $('.itembox').addClass('d-none'); // همه divها مخفی شوند
    if (val == 1) {
        $('.itembox').removeClass('d-none');
    } else if (val == 4) {
        $('.itembox').removeClass('d-none');
    }
});


  $('#addInput').click(function() {
    let newInput = `
      <div class="input-group badge badge-light-danger" style="margin-bottom: 5px;">
        <input type="text" style="width: 60%;" name="items[]" placeholder="عنوان را وارد کنید" />
        <button type="button" class="btn remove">حذف</button>
        <button type="button" class="btn up">
            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-up"><polyline points="18 15 12 9 6 15"></polyline></svg>
        </button>
        <button type="button" class="btn down">
            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
        </button>
      </div>`;
    $('#inputContainer').append(newInput);
  });

  // Remove input group
  $(document).on('click', '.remove', function() {
    $(this).closest('.input-group').remove();
  });

  // Move input group up
  $(document).on('click', '.up', function() {
    let group = $(this).closest('.input-group');
    group.prev('.input-group').before(group);
  });

  // Move input group down
  $(document).on('click', '.down', function() {
    let group = $(this).closest('.input-group');
    group.next('.input-group').after(group);
  });

  // Optional: form submit log
  $('#myForm').submit(function(e) {
    console.log($(this).serialize()); // check submitted values in console
    // e.preventDefault(); // uncomment if you want to prevent actual submission
  });
});
</script>