<!doctype html>
<html lang="fa">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $result['title']?></title>
    <?= $this->Html->css([
        '/formbuilder/css/bootstrap.min.css',
        '/formbuilder/css/custom.css',
    ]);
    
    echo $this->Html->script([
        inter_mode == true?'/admin/js/jquery.min2.1.3.js':'https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js',
        //'/formbuilder/js/custom.js',
    ],['nonce'=>get_nonce]);
    ?>
    <style>
        body{direction:rtl;}
        .form-check label{padding-right: 20px;}
        .form-check input{margin-right: -20px;}
        <?= $item['css'] != null?$item['css']:'';?>
    </style>
</head>
<body class="bg-light">
    <div class="container">
        <div class="py-5 text-center">
            <?= $item['logo'] != null?$this->html->image($item['logo'],['class'=>'d-block mx-auto mb-4']):''?>
            <h2><?= $result['title']?></h2>
            <?= $item['uinfo'] != null?'<p class="lead">'.$item['uinfo'].'</p>':''?>
            <?= $this->Flash->render() ?>
        </div>
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8 order-md-4" style="direction:rtl;text-align:right">
                <?= $this->Form->create(null,['id'=>'forms','type'=>'file']);?>
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
                ]);
                
                ?>

                <?php if($item['submit'] != ''):?>
                    <hr class="mb-4">
                    <button class="btn btn-primary btn-lg btn-block" type="submit" id="btnSubmit">
                        <?= $item['submit'] != null?$item['submit']: __d('Template', 'ثبت فرم')?>
                    </button>
                <?php endif?>

                <?= $this->Form->end()?>
            </div>
        </div>
        <footer class="my-5 pt-5 text-muted text-center text-small">
            <p class="mb-1">
                <?= $item['footer'] != null?$item['footer']:''?>
            </p>
        </footer>
    </div>
    <?= $this->Html->script([
        //'/formbuilder/js/jquery-3.2.1.slim.min.js',
        '/formbuilder/js/popper.min.js',
        '/formbuilder/js/holder.min.js',
        '/formbuilder/js/bootstrap.min.js',
    ],['nonce'=>get_nonce])?>
    <?= $this->Html->script(['/formbuilder/js/modal.js'],['nonce'=>get_nonce])?>
    <?= $this->Html->css(['/formbuilder/css/modal.css'],['nonce'=>get_nonce])?>

<script type="text/javascript" nonce="<?=get_nonce?>">
$(document).ready(function () {
    $("#forms").submit(function (e) {
        //e.preventDefault();
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
        if ($.inArray(fileName.split('.').pop(), extlist) >= 0) {}
        else {
          alert('<?= __d('Template', 'فقط فایل های دارای پسوند  zip و rar و pdf آپلود خواهند شد')?>');
          $(this).val('');
        }
     });
  });

function confirm(){
    $().timedDialog({
        //type: 'confirmation',
        title: '',
        body: '<?= __d('Template', '<br>فرم در حال ثبت اطلاعات می باشد.<br>لطفا کمی صبر کنید')?>',
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

</body>
</html>