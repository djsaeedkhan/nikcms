<?php
use Cake\View\Cell;
use Cake\Routing\Router;
use Lms\Checker;
$next = new Checker();
if(isset($this->request->getQuery()['file']) and $this->request->getQuery()['file']!='')
    echo $this->cell('Lms.Cansee::checkfilecan',[$results['id'], $this->request->getQuery()['file']]);

$lmsCourse = $results;
$option = [];
if($lmsCourse['options'] != ""){
    $option = json_decode($lmsCourse['options'],true);
}
?>
<!-- <script nonce="<?=get_nonce?>">
    $(document).ready(function (){
        if ($(window).width() < 960) {
            $('html, body').animate({
                scrollTop: $(".col-sm-8").offset().top
            }, 2000);
        }
    });
</script> -->
<div class="content-header row client_course_index">
    <div class="content-header-right">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    دوره: <?= $results['title']?>
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                        
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="d-none d-sm-block" style="position: absolute;left: 0;">
        <?= (array_search('descr', $option['roles']) !== NULL)?$this->Html->link(__('نمایش توضیحات'), 
            '/lms/detail/'. $lmsCourse['id'].'/'.$lmsCourse['slug'],
            ['class'=>'btn btn-sm btn-secondary mb-2','style'=>'font-size: 12px;'] ):'' ?>

        &nbsp;
        <?= (array_search('register', $option['roles']) !== NULL)?$this->Form->postlink(
            __('ثبت نام دوره'),
            '/lms/subscribe/'.$lmsCourse['id'].'/'.$lmsCourse['slug'],
            [
                'class'=>'btn btn-sm btn-success d-block d-md-inline-block mb-2',
                'style'=>'font-size: 12px;'
                //'confirm'=>'برای ثبت نام در این دوره مطمئن هستید؟'
            ]):'';?>
    </div>
    
        
</div>


<div class="course_index">
    
<?php
echo (!$this->request->getQuery('file') and isset($plugin_lms['guest_course_detail_top_alert']))?
    $plugin_lms['guest_course_detail_top_alert']:'';
    
if(isset($file['top_content']) and $file['top_content'] !=""):
    echo '<div class="d-none d-sm-block course_topalert alert alert-'.($plugin_lms['course_topalert_type']).'">';
    echo nl2br($file['top_content']);
    echo '</div>';
endif;
?><br><br>

    
<div class="card"><div class="card-body"><div class="row">
    <div class="col-sm-4 mb-4">
        <div class="accordion" id="accordion" role="tablist">
            
            <?php if($results['lms_courseweeks']):foreach ($results['lms_courseweeks'] as $temp): ?>
            <div class="mb-1">
                <?php
                $show = null;
                if($temp['lms_coursefiles']):
                    foreach ($temp['lms_coursefiles'] as $temp2):
                        if($page == $temp2['id']) $show = 'show';
                    endforeach;
                endif;?>

                <div class="collapse-border" id="accordionExample0">
                    <div class="card">
                        <div class="card-header <?=$show != null?'alert alert-primary':''?>" id="#he<?=$temp['id']?>" data-toggle="collapse" 
                            role="button" data-target="#co<?=$temp['id']?>" aria-expanded="false" 
                            aria-controls="collapse200">
                            <span class="lead collapse-title" style="color: #444444;font-weight: normal;">
                                <?= $temp['title']?>
                            </span>
                        </div>

                        <div id="co<?=$temp['id']?>" class="collapse <?=$show?>" aria-labelledby="#he<?=$temp['id']?>" data-parent="#accordionExample0">
                            <div class="card-body py-0">
                                <div class="list-group list-group-circle">
                                    <?php 
                                    if($temp['lms_coursefiles']):
                                        foreach ($temp['lms_coursefiles'] as $temp2):
                                            echo '<div class="'. 
                                                    ($page == $temp2['id']?'crnt ':'').
                                                    ((isset($temp2['lms_courseexams']) and count($temp2['lms_courseexams']) )?'has-exam ':'').
                                                    '">';
                                            ///echo $temp2['show_in_list'] == 1?'':'';
                                            echo $this->cell('Lms.GuestCansee',[$results['id'], $temp2]);
                                            echo '</div>';
                                        endforeach;
                                    endif;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach;endif; ?>
        </div>

    </div>
    <div class="col-sm-8">
        
        <?php
        if($file != null){?>
            <h5>
                <?= isset($file['LmsCourseweeks'])?$file['LmsCourseweeks']['title']:''?>
                <?= isset($file['title'])?' / '.$file['title']:''?>
            </h5><br>

            <?php
            if(isset($show_current) and $show_current == true){
                if(!isset($qty)){
                    $current = null;
                    for($i=1;$i<5;$i++){
                        if($file['filesrc_'.$i] != null){
                            $current = $i;
                            break;
                        }
                    }
                }
                else
                    $current = $qty;
            
                if(isset($file['filesrc_extra']) and $file['filesrc_extra'] != ''):?>
                    <iframe src="https://player.arvancloud.com/index.html?config=<?= $file['filesrc_extra']?>" frameborder="0" 
                        allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" 
                        allowFullScreen="true" 
                        webkitallowfullscreen="true" 
                        mozallowfullscreen="true" style="width: 100%;height:400px;"></iframe>
                <?php
                elseif(isset($file['filesrc_'.$current]) and $file['filesrc_'.$current] != null):?>
                    <video id='myVideo' width="100%" controls poster="<?= $file['image']!=''?$file['image']:''?>" 
                        oncontextmenu="return false;" controlsList="nodownload">
                        <source src="<?= Router::url($file['preview'] !=""?$file['preview']: $file['filesrc_'.$current])?>" type="video/mp4">
                        امکان نمایش فیلم وجود ندارد
                    </video>
                   
                    <!-- <video style="width:100%;/* height:375px; */" id="myVideo" class="video-js" controls oncontextmenu="return false;" preload="false" controlsList="nodownload" poster="<?= $file['image']!=''?$file['image']:''?>" data-setup='{}'>
                        <source src="<?php // Router::url($file['filesrc_'.$current])?>" type="video/mp4"></source>
                        <p class="vjs-no-js">متاسفانه امکان نمایش فیلم وجود ندارد / از طریق مرورگر دیگری امتحان کنید و یا با پشتیبانی بگیرید</p>
                    </video><br> -->

                    <!-- <video style="width:100%;" id="myVideo" class="video-js" controls oncontextmenu="return false;" preload="false" controlsList="nodownload" poster="<?= $file['image']!=''?$file['image']:''?>" data-setup='{}'>
                        <source src="<?= Router::url('/lms/client/video/'.$file['id'].','.$current);?>" type="video/mp4"></source>
                        <p class="vjs-no-js">متاسفانه امکان نمایش فیلم وجود ندارد / از طریق مرورگر دیگری امتحان کنید و یا با پشتیبانی بگیرید</p>
                    </video><br> -->

                    <?php
                $count = 0;
                for($i=1;$i<5;$i++){
                    if($file['filesrc_'.$i] != null)
                        $count += 1;
                }
                for($i=1;$i<5;$i++){
                    if($file['filesrc_'.$i] != null){
                        echo $this->html->link(
                            ($i ==1?'کیفیت پایین':'').
                            ($i ==2?'کیفیت مناسب':'').
                            ($i >= 3?'کیفیت عالی':'') ,
                            '?'.(isset($file_id)?'file='.$file_id.'&':'').('qty='.$i),[
                                'class'=>'btn '.
                                (($i == $this->request->getQuery('qty') or $count == 1)?'btn-success ':'btn-light ')
                                .'btn-sm ']).' ';
                    }
                }?>

                <?php 
                else: 
                    //echo '<div class="alert alert-warning">محتوایی برای نمایش وجود ندارد</div>';
                endif;?>

                <?php /*<video controls preload="false" src="http://localhost/cake3/cms/tadabor/lms/client/" width="100%"  oncontextmenu="return false;" controlsList="nodownload"></video>*/?>

                <script nonce="<?=get_nonce?>" type='text/javascript'>
                    var nextfile = null;
                    var video = document.getElementById('myVideo');
                    var send = true;
                    var visit = true;
                    var show_toast = true;
                    var supposedCurrentTime = 0;
                    video.addEventListener('timeupdate', function() {
                        if( (video.duration - 20) < video.currentTime){
                            if(send == true){
                                $.ajax({type : 'POST',url : "<?= Router::url('',false) ?>",
                                    success : function(data){
                                        nextfile = data;
                                    },
                                    error:function (XMLHttpRequest, textStatus, errorThrown) {}});
                                send = false;
                            }
                        }

                        if( 15 < video.currentTime){
                            if(visit == true){
                                $.ajax({type : 'POST',url : "<?= Router::url('',false) ?>&visit=1",
                                    success : function(data){
                                        nextfile = data;
                                        //console.log(nextfile);
                                    },
                                    error:function (XMLHttpRequest, textStatus, errorThrown) {}});
                                visit = false;
                            }
                        }

                        /* if( (video.duration - 1) < video.currentTime && show_toast == true){
                            //myFunction(nextfile);
                            setTimeout(function () {
                                toastr.options.progressBar = true;
                                toastr.options.rtl = true;
                                //toastr.options.hideDuration = 200000;
                                toastr.options.showDuration = 100000;
                                toastr.options.timeOut = 100000;
                                toastr.options.extendedTimeOut = 100000;
                                toastr.options.closeButton = false;
                                toastr.options.tapToDismiss = true;
                                toastr.options.positionClass = "toast-bottom-left";

                                if(nextfile == 'time_not_come'){
                                    toastr.info(`<div style="color:#000;font-size:14px;text-align:justify">
                                        شما هنوز فیلم را بصورت کامل مشاهده نکرده اید. 
                                        مرحله بعد پس از اتمام مدت زمان پخش فیلم در دسترس خواهد بود
                                        </div>`);
                                }
                                else{
                                    toastr.info(`<div style="color:#000;font-size:14px;text-align:justify">
                                        مرحله بعدی برای شما فعال شده است.
                                        لطفاً برای باز شدن
                                        <a class="btn btn-success btn-sm" href="`+ nextfile +`">اینجا</a>
                                        کلیک کنید.
                                        </div>`);
                                }
                            }, 1000);
                            show_toast = false;
                        } */
                        //if (!video.seeking) {supposedCurrentTime = video.currentTime;}
                    });
                    video.addEventListener('seeking', function() {
                        var delta = video.currentTime - supposedCurrentTime;
                        //if( (video.duration - 20) < video.currentTime){video.currentTime = supposedCurrentTime;}
                        /* if (Math.abs(delta) > 0.01) {video.currentTime = supposedCurrentTime; } */
                    });
                    video.addEventListener('ended', function() {supposedCurrentTime = 0;});
                </script>
            
                
            
                <div class="client_course_index_descr">
                <?php
                    echo '<br><b>توضیحات: </b>';
                    if($file['content'] != null)
                        echo '<div class="mb-2 text-justify">'.nl2br($file['content']).'</div>';
                    
                    if($file['lms_coursefilenotes']): 
                        echo '<hr>';
                        foreach($file['lms_coursefilenotes'] as $temp):
                            switch ($temp['types']) {
                                case 1: //متنی
                                    echo '<div class="mb-2 text-justify">'.$temp['descr'].'</div>';
                                    break;

                                case 2: //دانلود فایل
                                    echo '<div class="mb-2">';
                                    echo $this->html->link('دانلود فایل',$temp['descr'],[]);
                                    echo '</div>';
                                    break;

                                case 3: //تصویر
                                    echo '<div class="mb-2">';
                                    echo $this->html->image($temp['descr'],['class'=>'img-responsive']);
                                    echo '</div>';
                                    break;

                                case 4: //لینک
                                    echo '<div class="mb-2">';
                                    echo $this->html->link($temp['descr'],$temp['descr'],[]);
                                    echo '</div>';
                                    break;
                            }
                            
                        endforeach;
                    endif;?>
                </div>

                <?php
            }
            else 
                echo '<div class="alert alert-secondary">
                    <b>دسترسی به این محتوا برای شما فعال نشده است. زیرا:</b><br>
                        &nbsp;&nbsp;&nbsp;1- ممکن است هنوز به زمان باز شدن این درس(یا آزمون) نرسیده ایم. لطفاً تا رسیدن زمان باز شدن صبر کنید.<br>
                        &nbsp;&nbsp;&nbsp;2- ممکن است به علت اتمام دفعات مجاز شرکت در آزمون یا دلیلی دیگر، دسترسی شما به این درس(یا آزمون) محدود شده باشد.<br>
                </div>';
        }
        else{?>
            <?= $results['image'] !=''?$this->html->image($results['image'],['style'=>'width:100%;max-height:100%;']).'<br><br>':''?>
            <p class="text-justify">
                <?= nl2br($results['text'])?>
            </p>
        <?php }?>
    </div>
</div></div></div>

    <div class="d-block d-sm-none text-center">
        <br>
        <?= (array_search('descr', $option['roles']) !== NULL)?$this->Html->link(__('نمایش توضیحات'), 
            '/lms/detail/'. $lmsCourse['id'].'/'.$lmsCourse['slug'],
            ['class'=>'btn btn-sm btn-secondary mb-2','style'=>'font-size: 12px;'] ):'' ?>

        &nbsp;
        <?= (array_search('register', $option['roles']) !== NULL)?$this->Form->postlink(
            __('ثبت نام دوره'),
            '/lms/subscribe/'.$lmsCourse['id'].'/'.$lmsCourse['slug'],
            [
                'class'=>'btn btn-sm btn-success d-block d-md-inline-block mb-2',
                'style'=>'font-size: 12px;'
                //'confirm'=>'برای ثبت نام در این دوره مطمئن هستید؟'
            ]):'';?> 
    </div>

</div>

<div class="clearfix"><Br>
    
    
</div>


<style>

#toast-container>div.rtl {
    opacity: 1 !important;
}
.toast-info{
    border: 3px solid #2fa79c;
    border-bottom: 0;
}
.toast-info .toast-progress {
    background-color: #2fa79c;
}
.has-exam{
    line-height: 0px;
}
.has-exam > a:first-child{
    display: initial;
    padding-left: 2px;
}
</style>