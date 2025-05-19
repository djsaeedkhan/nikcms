<div>
    <style>
        .form-check label{
            padding-right: 20px;
        }
        .form-check input{
            margin-right: -20px;
        }
        <?= $item['css'] != null?$item['css']:'';?>
    </style>

    <div class="py-5 text-center">
        <?= $item['logo'] != null?$this->html->image($item['logo'],['class'=>'d-block mx-auto mb-4']):''?>
        <?= $result['title'] != ''?'<h2>'.$result['title'].'</h2>':''?>
        <?= $item['uinfo'] != null?'<p class="lead">'.$item['uinfo'].'</p>':''?>
        <?= $this->Flash->render() ?>
    </div>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8 order-md-4" style="direction:rtl;text-align:right">
            <?= $this->Form->create(null,['url'=>'/form/'.$item['formbuilder_id'],'id'=>'forms','type'=>'file']);?>
            <?php
            $item['data'] = str_replace('<span class="upload_notify"></span>',
                '<span class="small upload_notify">'.__d('Template', 'پسوند مجاز: zip | rar | pdf | jpg | jpeg
                <Br>اندازه فایل: حداکثر 30 مگابایت').'</span>',$item['data']);
            echo $item['data'].'<br><br>';
                
            echo $this->Captcha->create('securitycode', [
                'reload_txt' => __d('Template', 'تصویر جدید'),
                'clabel'=> __d('Template', 'کد امنیتی نشان داده شده در بالا را وارد کنید:'),
                'type'=>'number', // 'recaptcha' , 'math', 'image', 'number'
                //'sitekey'=>'xxxxxxxxxxxxxxxxxxxxxx-xx', //set if it is recaptcha
                //'theme'=>'random'
            ]);?>

            <?php if($item['submit'] != ''):?>
                <!-- <hr class="mb-4"> --><br><br>
                <button class="btn btn-primary btn-lg btn-block" type="submit" id="btnSubmit">
                    <?= $item['submit'] != null?$item['submit']:__d('Template', 'ثبت فرم')?>
                </button>
            <?php endif?>

            <?= $this->Form->end()?>
        </div>
    </div>
</div>

<?= $this->Html->script(['/formbuilder/js/modal.js'],['nonce'=>get_nonce])?>
<?= $this->Html->css(['/formbuilder/css/modal.css'],['nonce'=>get_nonce])?>

<script nonce="<?=get_nonce?>" type="text/javascript">
$(document).ready(function () {
    $("#forms").submit(function (e) {
        $("#btnSubmit").attr("disabled", true);
        $("#btnSubmit").text("<?= __d('Template',"لطفا صبر کنید")?>");
        confirm();
        return true;
    });
});
var extlist = ['zip', 'rar', 'pdf','jpg','jpeg'];
  $(function() {
     $("input:file").change(function (){
        var fileName = $(this).val();
        if ($.inArray(fileName.split('.').pop(), extlist) >= 0){}
        else {
          alert('<?=__d('Template', 'فقط فایل های با پسوندهای مشخص شده قابلیت آپلود دارند')?>');
          $(this).val('');
        }
     });
  });

function confirm(){
    $().timedDialog({
        //type: 'confirmation',
        title: '',
        body: '<?=__d('Template', '<br>فرم در حال ثبت اطلاعات می باشد.<br>لطفا کمی صبر کنید')?>',
        width: 400,
        height: 300,
        //closeOnTimer: true,
        //timeout:0,
        /* btnConfirm: {
            text: 'Proceed',
            action: () => {
                alert('done')
        }} */
    });
}
jQuery('.creload').on('click', function() {
    var mySrc = $(this).prev().attr('src');
    var glue = '?';
    if(mySrc.indexOf('?')!=-1)  {
        glue = '&';
    }
    $(this).prev().attr('src', mySrc + glue + new Date().getTime());
    return false;
});  
</script>
