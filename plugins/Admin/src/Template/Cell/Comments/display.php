<?php if($viewlist == true):?>
    <ol class="commentlist clearfix">
        <?php foreach($comments as $comment):?>
        <li class="comment even thread-even mr-0" id="li-comment-1">
            <div id="comment-<?=$comment['id']?>" class="comment-wrap clearfix pr-0">
                <div class="row">
                    <div class="col-sm-2">
                        <div class="comment-meta" style="float: inherit;">
                            <div class="comment-author vcard text-center mb-2">
                                <span class="comment-avatar " style="position: initial;border: 0 !important">
                                    <img alt='Image' src='https://0.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536?s=60' height='70' width='70' style="display: inherit;" />
                                </span>
                            </div>
                        </div>

                        <?php /*<span class="badge badge-info py-2" style="color: #FFF;font-style: inherit;font-weight: normal;letter-spacing: 0;">
                            20 بسته عمده خریداری شده است
                        </span>
                        <div class="mt-2 fs-14">
                            رنگ: قرمز<br>
                            بسته بندی: 10 تایی
                        </div>*/?>
                    </div>
                    <div class="col-sm-10">
                        <div class="comment-content clearfix">
                            <div class="comment-author">
                                <?php
                                if(isset($comment['author'])){
                                    echo $this->html->link($comment['author'],$comment['author_url'],['target'=>'_blank']);
                                }
                                else{
                                    isset($comment['user']['id'])?$comment['user']['family']:'';
                                }
                                ?>
                                
                                <span><a href="#" title=""><?=__d('Admin', 'در تاریخ')?>
                                 <?= $this->Func->date2($comment['created'])?></a></span>
                            </div>
                            <p><?=  nl2br($comment['content'])?></p>

                            <?php /*<div class="review-comment-ratings">
                                <i class="icon-star3"></i>
                                <i class="icon-star3"></i>
                                <i class="icon-star3"></i>
                                <i class="icon-star3"></i>
                                <i class="icon-star-half-full"></i>
                            </div>*/?>
                        </div>
                    </div>
                    <div class="col-12"><hr></div>
                </div>
                <div class="clear"></div>
            </div>
        </li>
        <?php endforeach?>
    </ol>
    
    <!-- <a href="#" data-toggle="modal" data-target="#reviewFormModal" class="button button-3d m-0 float-right">ثبت نظر جدید</a> -->
<?php endif?>

<?php
if($form == true):
    echo $this->Form->create(null,['url'=>'/savecomments','id'=>'cmntforms']);
    echo $this->Form->control('post_id',['type'=>'hidden','default'=> $id]);
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <textarea id="pcomment-body" name="body" class="form-control" rows="6" placeholder="<?= __d('Admin', 'بنویسید...')?>" required=""></textarea>
                <div class="text-danger"><?=__d('Admin', 'دیدگاه خود را بنویسید.')?></div>
            </div>
        </div>

        <?php if(!isset($user['id'])):?>
        <div class="col-md-6 col-lg-4">
            <div class="form-group">
                <label for="pcomment-name" class="form-control-label">
                    <?= __d('Admin', 'نام و نام خانوادگی')?>
                </label>
                <input type="text" id="pcomment-name" name="name" class="form-control required" required>
                <div class="text-danger"></div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="form-group">
                <label for="pcomment-email" class="form-control-label">
                    <?=__d('Admin', 'پست الکترونیک')?>
                </label>
                <input type="text" id="pcomment-email" name="email" class="form-control required" dir="ltr" required placeholder="email@domain.com">
                <div class="text-danger"></div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-4">
            <div class="form-group">
                <label for="pcomment-website" class="form-control-label" placeholder="http://">
                    <?=__d('Admin', 'آدرس وب‌سایت')?>
                </label>
                <input type="text" id="pcomment-website" name="website" class="form-control" dir="ltr" >
                <div class="text-danger"></div>
            </div>
        </div>
        <?php endif?>
    </div>
    <button class="btn btn-primary btn-sm cmntformbtn">
        <?= __d('Admin', 'ارسال دیدگاه')?>
    </button>
    <?= $this->Form->end();?>

    <script nonce="<?=get_nonce?>">$("#cmntforms").submit(function() {$(".cmntformbtn").attr('disabled','disabled');});</script>
<?php endif?>
