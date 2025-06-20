<?php use Admin\View\Helper\ModuleHelper; ?>
<div class="row">
    <div class="col-lg-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-header">
                <div>
                    <h2 class="font-weight-bolder mb-0"><?= $count_post;?></h2>
                    <p class="card-text"><?= __d( 'Admin', 'نوشته' ) ?></p>
                </div>
                <div class="avatar bg-light-primary p-50 m-0">
                    <div class="avatar-content">
                        <i data-feather="edit" class="font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-header">
                <div>
                    <h2 class="font-weight-bolder mb-0"><?= $count_comment;?></h2>
                    <p class="card-text"><?= __d( 'Admin', 'دیدگاه' ) ?></p>
                </div>
                <div class="avatar bg-light-success p-50 m-0">
                    <div class="avatar-content">
                        <i data-feather="message-square" class="font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-header">
                <div>
                    <h2 class="font-weight-bolder mb-0"><?= $count_users;?></h2>
                    <p class="card-text"><?= __d( 'Admin', 'کاربر' ) ?></p>
                </div>
                <div class="avatar bg-light-danger p-50 m-0">
                    <div class="avatar-content">
                        <i data-feather="users" class="font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-header">
                <div>
                    <h2 class="font-weight-bolder mb-0"><?= $count_media;?></h2>
                    <p class="card-text"><?= __d( 'Admin', 'رسانه' ) ?></p>
                </div>
                <div class="avatar bg-light-warning p-50 m-0">
                    <div class="avatar-content">
                        <i data-feather="server" class="font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="animated fadeIn">
    <div class="row match-height">
    <?php 
    $list  = (array) ModuleHelper::admin_dashboard();
    while( count($list) > 0 ){
        foreach($list as $id => $widget){
            if($widget['order'] == 'hight2'){
                unset($list[$id]);
                echo $this->cell($widget['widget'],[$widget]);
            }
        }
        foreach($list as $id => $widget){
            if($widget['order'] == 'hight'){
                unset($list[$id]);
                echo $this->cell($widget['widget'],[$widget]);
            }
        }
        foreach($list as $id => $widget){
            if($widget['order'] == 'medium'){
                unset($list[$id]);
                echo $this->cell($widget['widget'],[$widget]);
            }
        }
        foreach($list as $id => $widget){
            if($widget['order'] == 'low'){
                unset($list[$id]);
                echo $this->cell($widget['widget'],[$widget]);
            }
        }
        $list = [];
    }
    ?>
    <!-- <script nonce="<?=get_nonce?>">
    $.ajax({ 
        type: "GET", 
        url: "http://mahancms.ir/my/news.php", 
        data: {}, 
        xhrFields: {
            withCredentials: true
        },
        headers: {"Access-Control-Allow-Origin": "http://localhost" },
        crossDomain: true,
        dataType: "json",
        success: function (data) { 
            alert("asd");
            /* $.each(data, function(index, element) {
                $('body').append($('<div>', {
                    text: element.name
                }));
            }); */
        },
        error: function (xhr, status) {
            alert(status);
            console.log(xhr);
        }
    });
    </script> -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <i class="icon-link"></i> <?= __d( 'Admin', 'اخبار و رویداد' ) ?>
                <span class="badge badge-dark float-left"><?=__d('Admin', 'نسخه آلفا')?></span>
            </div>
            <div class="card-body p-0">
                <div class="list-group">
                    <ul class="list-group">
                        <?php 
                        $news = [];
                        try {
                            $news = @json_decode(file_get_contents("https://mahancms.ir/update/news.php", 0, stream_context_create(["http"=>["timeout"=>1]])));
                        }catch(Exception $e) {
                            echo __d('Admin', 'متاسفانه خبری برای نمایش وجود ندارد');
                        }
                        if(is_array($news) and count($news) > 0):foreach($news as $news):?>
                        <a class="list-group-item list-group-item-action flex-column align-items-start" 
                            href="<?= $news->link;?>" target="_blank">
                            <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1"><?= $news->title;?></h6>
                            <small><?= $news->date;?></small>
                            </div>
                            <p class="mb-1">
                                <?= $news->body;?>
                            </p> 
                        </a>
                        <?php endforeach;else:?>
                            <a class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between">
                                <?= __d('Admin', 'متاسفانه خبری برای نمایش وجود ندارد'); ?>
                            </div>
                        </a>
                        <?php endif;?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <i class="icon-refresh"></i> 
            </div>
            <div class="card-body"></div>
        </div>
    </div>
</div>
</div>

<!-- BEGIN: Page JS-->
<?= $this->html->script([
    '/admin/app-assets/js/scripts/cards/card-analytics.js?6'
    ],['nonce'=>get_nonce])?>
<!-- END: Page JS-->