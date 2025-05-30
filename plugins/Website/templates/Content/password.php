<title><?= $this->Query->info('name');?> - <?= $this->fetch('title') ?></title>
<?php
    $this->assign('title', __d('Website','لطفا رمز را وارد کنید') );
?>
<!DOCTYPE html>
<html lang="fa"  dir="rtl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php echo $this->Html->css([
        '/admin/css/css/font-awesome.min.css',
        '/admin/css/css/simple-line-icons.css',
        '/admin/css/css/style.css',
        ]);
        echo $this->Html->script(['/admin/js/jquery/dist/jquery.min.js',],['nonce'=>get_nonce]);
    ?>
    <style>
    body{
        direction: rtl;
        text-align: center;
        font-family: tahoma;
        line-height: 30px;
        padding-top: 40px;
    }
    input[type="submit" i] {
        font-family: tahoma;
    }
    </style>
</head>
<body class="align-items-center">
    <div class="clearfix"></div>
    <div class="alert alert-warning" style="width: 400px;margin: 0 auto;">
        <?=$this->Query->the_content()?>
    </div>

    <?= $this->Html->script([
        '/admin/js/bootstrap/dist/js/bootstrap.min.js',
        ],['nonce'=>get_nonce]);
    ?>
</body>
</html>