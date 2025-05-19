<?php
set_time_limit(0);
ini_set('max_execution_time', '3000'); //300 seconds = 5 minutes
?>

<h3><?= __d('Admin', 'بروز رسانی سامانه')?></h3>
<div class="box box-primary">
    <div class="card-body">

    <ul class="timeline">
        <?php
        if($_POST){
            $ch = curl_init();
            $source = "https://mahancms.ir/update/update.zip";
            curl_setopt($ch, CURLOPT_URL, $source);
            curl_setopt($ch, CURLOPT_TIMEOUT, 6000);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FILE, $ch); 
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            $data = curl_exec ($ch);
            curl_close ($ch);

            echo '
            <li class="timeline-item">
                <span class="timeline-point timeline-point-secondary timeline-point-indicator"></span>
                <div class="timeline-event">
                    <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                        <h4>'.__d('Admin', 'دریافت فایل آپدیت از سرور').'</h4>
                        <span class="timeline-event-time">'.__d('Admin', 'همین الان').'</span>
                    </div>
                    <p class="text-success">'.__d('Admin', 'دریافت فایل آپدیت با موفقیت انجام شد').'</p>
                </div>
            </li>';
            $name = uniqid(time(), true) .".zip";
            $destination = WWW_ROOT.'..'.DS."/";
            $file = fopen($destination.$name, "w+");
            fputs($file, $data);
            fclose($file);
//---------------------------------------------------------------
            
            $zip = new ZipArchive;
            echo '
            <li class="timeline-item">
                <span class="timeline-point timeline-point-secondary timeline-point-indicator"></span>
                <div class="timeline-event">
                    <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                        <h4>'.__d('Admin', 'اکستراکت فایل آپدیت').'</h4>
                        <span class="timeline-event-time">'.__d('Admin', 'همین الان').'</span>
                    </div>';
            $delete = true;
            if ($zip->open($destination. $name) === TRUE) {
                $zip->extractTo($destination);
                $zip->close();
                echo '<p class="text-success">'.__d('Admin', 'فایل آپدیت با موفقیت  اکستراکت شد').'</p>';
            } else {
                $delete = false;
                echo '<p class="text-danger">'.__d('Admin', 'فایل اکستراکت نشد').'</p>';
            }
            echo '</div>
                </li>';
//---------------------------------------------------------------
            echo '
            <li class="timeline-item">
                <span class="timeline-point timeline-point-secondary timeline-point-indicator"></span>
                <div class="timeline-event">
                    <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                        <h4>'.__d('Admin', 'حذف فایل های موقت ایجاد شده').'</h4>
                        <span class="timeline-event-time">'.__d('Admin', 'همین الان').'</span>
                    </div>';
            if($delete == true and !$this->request->getQuery('getfile')):
                if( !unlink($destination. $name)) { 
                    echo '<p class="text-danger">'.__d('Admin', 'فایل های اضافه حذف نشدند').'</p>';
                } 
                else {
                    echo '<p class="text-success">'.__d('Admin', 'فایل های اضافه حذف شدند').'</p>';
                }
            else: 
                echo '<p class="text-success">'.__d('Admin', 'به دلیل عدم امکان اکستراکت، فایل آپدیت روی سرور نگهداری شد').'</p>';
            endif;
            echo '</div>
                </li>';
//---------------------------------------------------------------
            echo '
            <li class="timeline-item">
                <span class="timeline-point timeline-point-secondary timeline-point-indicator"></span>
                <div class="timeline-event">
                    <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                        <h4>'.__d('Admin', 'فرایند بروزرسانی به پایان رسید').'</h4>
                        <span class="timeline-event-time">'.__d('Admin', 'همین الان').'</span>
                    </div>
                </div>
            </li>';
        }
        else{?>
            <div class="alert alert-info">
                <p class="pb-1">- <?= __d('Admin', 'برای شروع بروزرسانی روی کلید زیر کلیک کنید')?></p>
                <p class="pb-1">- <?= __d('Admin', 'تغییرات انجام شده امکان بازیابی و یا لغو نخواهند داشت')?></p>
                <p class="pb-1">- <?= __d('Admin', 'برای جلوگیری از مشکلات سامانه، در حین انجام بروزرسانی صفحه را رفرش نکنید')?></p>
                <p class="pb-1">- <?= __d('Admin', 'این فرایند ممکن است مدت زمان طولانی به طول بکشد. لطفا تا پایان فرایند صبر کنید')?></p>
            </div>
            <?php
            if($this->request->getQuery('getfile'))
                echo $this->Form->postlink(
                    __d('Admin', 'انتقال فایل بروزرسانی روی سرور'),
                    '',
                    ['class'=>'btn btn-primary btn-sm']);
            else
                echo $this->Form->postlink(
                    __d('Admin', 'شروع بروزرسانی'),
                    '',
                    ['class'=>'btn btn-primary btn-sm']);
            ?>
        <?php
        }
        ?>
        </ul>
    </div>
</div>