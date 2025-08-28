<?php
use Challenge\Predata;
use Cake\Routing\Router;
$predata = new Predata();
try {
    echo $this->element('Challenge.ch_modal');
} catch (\Throwable $th) {
    //throw $th;
}
?>

<div class="challenge">
    <h4>
        <div class="float-right" style="display: flex;align-items: center;column-gap: 5px;">
            <span style="letter-spacing: -0.5px;"><?= h($challenge->title) ?></span>

            <?= $this->html->link('ویرایش اطلاعات پایه',
                ['action'=>'edit', $challenge->id],
                ['class'=>'btn btn-sm btn-dark'])?>

            <?= $this->html->link('نمایش در سایت',
                '/challenge/'.$challenge->slug,
                ['class'=>'btn btn-sm btn-secondary','target'=>'_blank','title'=>'صفحه '.__d('Template', 'همیاری')])?>

            <?= $this->Form->postlink('حذف',
                ['action'=>'delete',$challenge->id],
                ['class'=>'btn btn-sm btn-danger','confirm'=>'برای حذف مطمئن هستید؟'])?>
        </div>

        <div class="float-left">

            <!-- <div class="btn-group pull-right" style="margin-right:5px;" role="group">
                <button class="btn btn-success dropdown-toggle " style="padding: 6px !important;" id="btnGroupVerticalDrop2" type="button" 
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">دسترسی</button>
                <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2" >
                    
                    <?= $this->html->link('ویرایش',
                        ['action'=>'edit',$challenge->id],
                        ['class'=>'dropdown-item'])?>

                    <?= $this->html->link('سوالات',
                        ['controller'=>'challengequests','action'=>'index',$challenge->id],
                        ['class'=>'dropdown-item'])?>

                    <?= $this->html->link('نمایش در سایت',
                        '/challenge/'.$challenge->slug,
                        ['class'=>'dropdown-item','target'=>'_blank','title'=>'صفحه '.__d('Template', 'همیاری')])?>
                    
                    <?= $this->html->link('تبادل نظر',
                        ['controller'=>'Challengeforums','action'=>'index','?'=>[
                            'action' =>'unapproved',
                            'challenge_id'=>$challenge->id] ],
                        ['class'=>'dropdown-item','target'=>'_blank'])?>

                    <?= $this->Form->postlink('حذف',
                        ['action'=>'delete',$challenge->id],
                        ['class'=>'dropdown-item','confirm'=>'برای حذف مطمئن هستید؟'])?>
                </div>
            </div> -->

            

            <div class="btn-group pull-left" style="margin-right:5px;" role="group">
                <button class="btn btn-secondary dropdown-toggle " style="padding: 6px !important;" id="btnGroupVerticalDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">خروجی Export </button>
                <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1" >
                    <?= $this->Form->postlink('خروجی شماره همراه',
                        ['controller'=>'challengeuserforms','action'=>'index','?'=>['chid'=>$challenge->id,'getmobile'=>1]],
                        ['class'=>'dropdown-item'])?>

                    <?= $this->Form->postlink('خروجی آدرس ایمیل',
                        ['controller'=>'challengeuserforms','action'=>'index','?'=>['chid'=>$challenge->id,'getemail'=>1]],
                        ['class'=>'dropdown-item'])?>

                    <?= $this->Form->postlink('ایجاد فایل Word  مشارکت ها',
                        ['controller'=>'challengeuserforms','action'=>'index','?'=>['chid'=>$challenge->id,'createword'=>1]],
                        ['class'=>'dropdown-item'])?> 
                        
                    <?= $this->Form->postlink('ایجاد فایل Pdf  مشارکت ها',
                        ['controller'=>'challengeuserforms','action'=>'index','?'=>['chid'=>$challenge->id,'createpdf'=>1]],
                        ['class'=>'dropdown-item'])?>  


                    <?= $this->Form->postlink('ایجاد فایل ادغام شده Word',
                        ['controller'=>'challengeuserforms','action'=>'index','?'=>['chid'=>$challenge->id,'createAllword'=>1]],
                        ['class'=>'dropdown-item'])?>  

                </div>
            </div>

        </div>
        <div class="clearfix"></div>
    </h4>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-7">
            <h4 style="color: transparent;"><?= __('.'); ?></h4>
            <div class="table-responsive"><table class="table table-bordered table-hover bg-white">
            <tr>
                <th width="150" scope="row"><?= __('عنوان') ?></th>
                <td colspan="3">
                    <?= h($challenge->title) ?>
                    <?= $challenge->enable ?'<span class="badge badge-success">'. __('آرشیو نشده').'</span>' :
                    '<span class="badge badge-danger">'. __('آرشیو شده').'</span>' ; ?>

                    <?= isset($challenge->challengestatus->id)?'<span class="badge badge-primary">'.$challenge->challengestatus->title.'</span>' :null ; ?>
                </td>
            </tr>
            <tr>
                <th scope="row"><?= __('نامک') ?></th>
                <td colspan="3"><?= h($challenge->slug) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('توضیحات') ?></th>
                <td colspan="3" class="text-justify"><?= nl2br($challenge->descr) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('میزان جایزه') ?></th>
                <td colspan="3" class="text-justify"><?= nl2br($challenge->price) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('وضعیت') ?></th>
                <td colspan="3"><?= $challenge->has('challengestatus') ? $challenge->challengestatus->title : '' ?></td>
            </tr>
            <tr>
                <th scope="row">وضعیت مشارکت</th>
                <td>
                    <?= __('تعداد مشارکت') ?> : 
                    <?=isset($challenge->challengeuserforms)?count($challenge->challengeuserforms):'-' ?>
                <td>
                    <?= __('تعداد فالوور') ?> : 
                    <?=$follower?></td>
                <td>
                    <?= __('تعداد بازدید') ?> : 
                    <?=isset($challenge->challengeviews[0]['views'])?$challenge->challengeviews[0]['views']:'-' ?>
                </td>
            </tr>
            <tr>
                <th scope="row">زمانبندی</th>
                <td><?= __(' شروع') ?>: <?= h($challenge->start_date) ?></td>
                <td colspan="2"><?= __(' پایان ') ?>: <?= h($challenge->end_date) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('پسورد نمایش') ?></th>
                <td colspan="3"><?= ($challenge->password) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('نمایش به') ?></th>
                <td colspan="3"><?= $predata->getvalue('chtype',$challenge->chtype) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('تاریخ ثبت') ?></th>
                <td colspan="3"><?= $this->Query->the_time($challenge) ?></td>
            </tr>
            </table></div>

        </div>

        <div class="col-5">
            <h5>سطوح <?=__d('Template','همیاری')?></h5>
            <?php if (!empty($challenge->challengecats)): ?>
            <div class="table-responsive"><table class="table table-bordered bg-white">
                <tr><td>
                <?php $i=1;foreach ($challenge->challengecats as $challengecats): ?>
                    <span class="badge badge-light-primary mb-1"><?= h($challengecats->title) ?></span>
                <?php endforeach; ?>
                </td></tr>
            </table></div>
            <?php endif; ?>
        
            <h5><?= __('برچسب  ها') ?></h5>
            <?php if (!empty($challenge->challengetags)): ?>
            <div class="table-responsive"><table class="table table-bordered bg-white">

                <tr><td>
                    <?php $i=1;foreach ($challenge->challengetags as $challengetags): ?>
                        <span class="badge badge-light-primary mb-1"><?= h($challengetags->title) ?></span>
                    <?php endforeach; ?>
                </td></tr>

            </table></div>
            <?php endif; ?>


            <div class="related">
                <h5><?= __('موضوع ها') ?></h5>
                <?php if (!empty($challenge->challengetopics)): ?>
                    <div class="table-responsive"><table class="table table-bordered bg-white">
                        
                        <tr><td>
                            <?php $i=1;foreach ($challenge->challengetopics as $challengetopics): ?>
                                <span class="badge badge-light-primary mb-1"><?= h($challengetopics->title) ?></span>
                            <?php endforeach; ?>
                        </td></tr>
                        
                    </table></div>
                <?php endif; ?>
            </div>


            <div class="related">
                <h5><?= __('حوزه های ماموریتی') ?></h5>
                
                    <div class="table-responsive"><table class="table table-bordered bg-white">
                        <tr><td>
                            <?php if (!empty($challenge->challengefields)): ?>
                            <?php $i=1;foreach ($challenge->challengefields as $challengefields): ?>
                                <span class="badge badge-light-primary mb-1"><?= h($challengefields->title) ?></span>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </td></tr>
                    </table></div>
                
            </div>

            <div class="related"><br>
                <h5><?= __d('Template', 'همیاری').' های مرتبط' ?> 
                    <?= $this->html->link('افزودن',
                        ['controller'=>'Challengerelateds','action'=>'add',$challenge->id],
                        [
                            'class'=>'btn btn-success btn-sm',
                            'target'=>'_blank',
                            'data-toggle'=>'modal',
                            'data-target'=>'#exampleModalll',
                            'data-whatever'=>Router::url(['controller'=>'Challengerelateds','action'=>'add',$challenge->id,'?'=>['nonav'=>1]])]
                    );?>
                    
                    </h5>
                <?php if (!empty($challenge->challengerelateds)): ?>
                    <div class="table-responsive"><table class="table table-bordered bg-white">
                        <tr><td>
                            <?php $i=1;foreach ($challenge->challengerelateds as $challengerelateds): ?>
                                <span class="badge badge-light-primary mb-1 text-right" style="white-space: normal;">
                                    <?=$this->Form->postlink('X',['controller'=>'Challengerelateds','action'=>'delete',$challengerelateds->id],[
                                        'confirm'=>'مطمئن هستید؟','class'=>'badge badge-danger float-left btn-sm','title'=>'حذف'
                                    ])?>
                                    <?= h($challengerelateds->challenge->title) ?>
                                    
                                </span>
                            <?php endforeach; ?>
                        </td></tr>
                    </table></div>
                <?php endif; ?>
            </div>

        </div>
    </div><Br>
    
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active show" data-toggle="tab" href="#question" role="tab" aria-controls="question" 
                aria-selected="true"><?= __('لیست سوالات') ?>
                <!-- <span class="badge badge-warning badge-pill"><?=count($challenge->challengetexts)?></span> -->
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#overview" role="tab" aria-controls="overview" 
                aria-selected="true"><?= __('شرح موضوع') ?>
                <span class="badge badge-warning badge-pill"><?=count($challenge->challengetexts)?></span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#chresource" role="tab" aria-controls="chresource" 
                aria-selected="true"><?= __('اسناد پشتیبان') ?>
                <span class="badge badge-warning badge-pill"><?=count($chresource)?></span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link " data-toggle="tab" href="#timeline" role="tab" aria-controls="timeline" 
                aria-selected="true">زمان بندی 
                <span class="badge badge-warning badge-pill"><?=count($challenge->challengetimelines)?></span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#forumtitle" role="tab" aria-controls="forumtitle" 
                aria-selected="true"><?= __('عناوین تبادل نظر') ?>
                <span class="badge badge-warning badge-pill"><?=count($challenge->challengeforumtitles)?></span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#chupdates" role="tab" aria-controls="chupdates" 
                aria-selected="true"><?= __('اخبار و اطلاعیه ها') ?>
                <span class="badge badge-warning badge-pill"><?=count($chupdates)?></span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#partner" role="tab" aria-controls="partner" 
                aria-selected="true">
                <?= __('نقشه مشارکت ') ?>
                <span class="badge badge-warning badge-pill"><?=count($challenge->challengepartners)?></span>
            </a>
        </li>

        <!-- <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#news" role="tab" aria-controls="news" 
                aria-selected="true"><?= __('خبرها') ?>
                <span class="badge badge-warning badge-pill"><?=count($chnews)?></span>
            </a>
        </li> -->

        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#files" role="tab" aria-controls="files" 
                aria-selected="true"><?= __('فایل ها') ?>
                <span class="badge badge-warning badge-pill"><?=count($challenge->challengeimages)?></span>
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <!-- ------------------------------------------->
        <!-- ------------------------------------------->
        <div class="tab-pane" id="timeline" role="tabpanel">
            <?php if (!empty($challenge->challengetimelines)): ?>
            <div class="table-responsive"><table class="table table-striped table-bordered table-hover bg-white">
                <tr>
                    <th scope="col"><?= __('عنوان') ?></th>
                    <!-- <th scope="col"><?= __('نوع') ?></th> -->
                    <th scope="col"><?= __('تاریخ') ?></th>
                </tr>
                <?php foreach ($challenge->challengetimelines as $challengetimelines): ?>
                <tr>
                    <td><?= h($challengetimelines->title) ?>
                        <div class="hidme">
                            <?= $this->Html->link(__('ویرایش'), 
                                ['controller' => 'Challengetimelines', 'action' => 'edit', $challengetimelines->id],
                                [
                                    'data-toggle'=>'modal',
                                    'data-target'=>'#exampleModalll',
                                    'data-whatever'=>Router::url(['controller' => 'Challengetimelines', 'action' => 'edit', $challengetimelines->id, '?'=>['nonav'=>1]]),
                                ]) ?>
                            <?= $this->Form->postlink(__('حذف'), ['controller' => 'Challengetimelines', 'action' => 'delete', $challengetimelines->id], ['confirm' => __('Are you sure you want to delete # {0}?', $challengetimelines->id)]) ?>
                        </div>
                    </td>
                    <!-- <td><?= h($challengetimelines->types) ?></td> -->
                    <td><?= $this->Func->date2($challengetimelines->dates,'Y-m-d') ?></td>
                </tr>
                <?php endforeach; ?>
            </table></div>
            <?php endif; ?>
            <?= $this->html->link('+ زمان بندی',
                ['controller'=>'Challengetimelines','action'=>'add',$challenge->id], [
                    'data-toggle'=>'modal',
                    'data-target'=>'#exampleModalll',
                    'data-whatever'=>Router::url(['controller'=>'Challengetimelines','action'=>'add',$challenge->id,'?'=>['nonav'=>1]]),
                    'class'=>'btn btn-success'
                ])?>
        </div>
        <!-- ------------------------------------------->
        <!-- ------------------------------------------->
        <div class="tab-pane active show" id="question" role="tabpanel"><br>
            
            <div id="content-section"><?= $this->cell('Challenge.Questions',[$challenge->id]);?></div>

            <script>
            $('#exampleModalll').on('hidden.bs.modal', function () {
                $('#content-section').css({ 'opacity' : 0.25 });
                $.ajax({
                    url: '<?= Router::url('/admin/challenge/challengequests/index/'.$challenge->id.'/?render=false&nonav=1')?>', // آدرس فایل یا API که اطلاعات را برمی‌گرداند
                    method: "GET",
                    success: function(data) {
                        $("#content-section").html(data);
                        $('#content-section').css({ 'opacity' :1 });
                    },
                    error: function() {
                        alert("خطا در دریافت اطلاعات");
                        $('#content-section').css({ 'opacity' :1 });
                    }
                });
            });
            /* $(document).ready(function() {
                $(".close").on("click", function() {
                    
                });
            }); */
            </script>

            <?= $this->html->link('+ مدیریت سوالات',
                ['controller'=>'challengequests','action'=>'index',$challenge->id],
                ['class'=>'btn btn-success'])?>

        </div>
        <!-- ------------------------------------------->
        <!-- ------------------------------------------->
        <div class="tab-pane" id="partner" role="tabpanel">
            <?php if (!empty($challenge->challengepartners)): ?>
            <div class="table-responsive"><table class="table table-striped table-bordered table-hover bg-white">
                <tr>
                    <th scope="col"><?= __('تصویر') ?></th>
                    <th scope="col"><?= __('عنوان') ?></th>
                    <th scope="col"><?= __('لینک') ?></th>
                </tr>
                <?php foreach ($challenge->challengepartners as $challengepartners): ?>
                <tr>
                    <td width="70"><?= $this->html->image($challengepartners->image,['target'=>'_blank','style'=>'max-width:50px;max-height:50px;']) ?></td>
                    <td>
                        <?= h($challengepartners->title) ?>
                        <div class="hidme">
                            <?= $this->Html->link(__('ویرایش'), ['controller' => 'Challengepartners', 'action' => 'edit', $challengepartners->id]) ?>
                            <?= $this->Form->postlink(__('حذف'), ['controller' => 'Challengepartners', 'action' => 'delete', $challengepartners->id], ['confirm' => __('Are you sure you want to delete # {0}?', $challengepartners->id)]) ?>
                        </div>
                    </td>
                    <td><?= h($challengepartners->link) ?></td>
                </tr>
                <?php endforeach; ?>
            </table></div>
            <?php endif; ?>
            <?= $this->html->link('+  نقشه مشارکت',
                ['controller'=>'Challengepartners','action'=>'add',$challenge->id],
                ['class'=>'btn btn-success'])?>
        </div>
        <!-- ------------------------------------------->
        <!-- ------------------------------------------->
        <div class="tab-pane" id="forumtitle" role="tabpanel">

            <?= $this->html->link('تبادل نظر',
                ['controller'=>'Challengeforums','action'=>'index','?'=>[
                    'action' =>'unapproved',
                    'challenge_id'=>$challenge->id] ],
                ['class'=>'btn btn-success','target'=>'_blank'])?>

            <?= $this->html->link('+ عناوین تبادل نظر',
                ['controller'=>'Challengeforumtitles','action'=>'add',$challenge->id],
                ['class'=>'btn btn-success'])?>
            
            <?php if (!empty($challenge->challengeforumtitles)): ?>
            <div class="table-responsive"><table class="table table-striped table-bordered table-hover bg-white">
                <tr>
                    <th scope="col"><?= __('عنوان') ?></th>
                    <th scope="col"><?= __('توضیحات') ?></th>
                    <th scope="col"><?= __('اولویت') ?></th>
                </tr>
                <?php foreach ($challenge->challengeforumtitles as $challengeforumtitles): ?>
                <tr>
                    <td><?= h($challengeforumtitles->title) ?>
                        <div class="hidme">
                            <?= $this->Html->link(__('ویرایش'), ['controller' => 'Challengeforumtitles', 'action' => 'edit', $challengeforumtitles->id]) ?>
                            <?= $this->Form->postlink(__('حذف'), ['controller' => 'Challengeforumtitles', 'action' => 'delete', $challengeforumtitles->id], ['confirm' => __('Are you sure you want to delete # {0}?', $challengeforumtitles->id)]) ?>
                        </div>
                    </td>
                    <td><?= h($challengeforumtitles->descr) ?></td>
                    <td><?= h($challengeforumtitles->priority) ?></td>
                </tr>
                <?php endforeach; ?>
            </table></div>
            <?php endif; ?>
            
        </div>
        <!-- ------------------------------------------->
        <!-- ------------------------------------------->
        <div class="tab-pane" id="news" role="tabpanel">
            <?php if (!empty($chnews)): ?>
            <div class="table-responsive"><table class="table table-striped table-bordered table-hover bg-white">
                <tr>
                    <th scope="col"></th>
                    <th scope="col"><?= __('عنوان') ?></th>
                    <th scope="col"><?= __('توضیحات') ?></th>
                </tr>
                <?php $i=1;foreach ($chnews as $news):?>
                <tr>
                    <td width="10"><?= $i++ ?></td>
                    <td><?= h($news['title']) ?>
                        <div class="hidme">
                            <?= $this->Html->link(__('ویرایش'), ['plugin'=>'Admin','controller' => 'Posts', 'action' => 'edit', $news['id']]) ?>
                            <?= $this->Form->postlink(__('حذف'), ['plugin'=>'Admin','controller' => 'Posts', 'action' => 'delete', $news['id']], 
                            ['confirm' => __('Are you sure you want to delete # {0}?')]) ?>
                        </div>
                    </td>
                    <td><?= h($this->Query->the_excerpt($news)) ?></td>
                </tr>
                <?php endforeach; ?>
            </table></div>
            <?php endif; ?>

            <?= $this->html->link('+ اطلاع رسانی',
                ['plugin'=>'Admin','controller'=>'Posts','action'=>'add',
                '?'=>[
                    'post_type'=>'chnews',
                    'challenge_id' =>$challenge['id'] ,
                    'ret'=>'/admin/challenge/admin/view/'.$challenge['id'] ]],
                ['class'=>'btn btn-success'])?>
        </div>
        <!-- ------------------------------------------->
        <!-- ------------------------------------------->
        <div class="tab-pane" id="chupdates" role="tabpanel">
            <?php if (!empty($chupdates)): ?>
            <div class="table-responsive"><table class="table table-striped table-bordered table-hover bg-white">
                <tr>
                    <th scope="col"></th>
                    <th scope="col"><?= __('عنوان') ?></th>
                    <th scope="col"><?= __('توضیحات') ?></th>
                </tr>
                <?php $i=1;foreach ($chupdates as $news):?>
                <tr>
                    <td width="10"><?= $i++ ?></td>
                    <td><?= h($news['title']) ?>
                        <div class="hidme">
                            <?= $this->Html->link(__('ویرایش'), ['plugin'=>'Admin','controller' => 'Posts', 'action' => 'edit', $news['id']]) ?>
                            <?= $this->Form->postlink(__('حذف'), ['plugin'=>'Admin','controller' => 'Posts', 'action' => 'delete', $news['id']], 
                            ['confirm' => __('Are you sure you want to delete # {0}?')]) ?>
                        </div>
                    </td>
                    <td><?= h($this->Query->the_excerpt($news)) ?></td>
                </tr>
                <?php endforeach; ?>
            </table></div>
            <?php endif; ?>

            <?= $this->html->link('+ بروز رسانی',
                ['plugin'=>'Admin','controller'=>'Posts','action'=>'add',
                '?'=>[
                    'post_type'=>'chupdates',
                    'challenge_id' =>$challenge['id'] ,
                    'ret'=>'/admin/challenge/admin/view/'.$challenge['id'] ]],
                ['class'=>'btn btn-success'])?>
        </div>
        <!-- ------------------------------------------->
        <!-- ------------------------------------------->
        <div class="tab-pane" id="chresource" role="tabpanel">
            <?php if (!empty($chresource)): ?>
            <div class="table-responsive"><table class="table table-striped table-bordered table-hover bg-white">
                <tr>
                    <th scope="col"></th>
                    <th scope="col"><?= __('عنوان') ?></th>
                    <th scope="col"><?= __('توضیحات') ?></th>
                </tr>
                <?php $i=1;foreach ($chresource as $post):?>
                <tr>
                    <td width="10"><?= $i++ ?></td>
                    <td><?= h($post['title']) ?>
                        <div class="hidme">
                            <?= $this->Html->link(__('ویرایش'), ['plugin'=>'Admin','controller' => 'Posts', 'action' => 'edit', $post['id']]) ?>
                            <?= $this->Form->postlink(__('حذف'), ['plugin'=>'Admin','controller' => 'Posts', 'action' => 'delete', $post['id']], 
                            ['confirm' => __('برای حذف این مورد مطمئن هستید؟}?')]) ?>
                        </div>
                    </td>
                    <td><?= h($this->Query->the_excerpt($post)) ?></td>
                    
                </tr>
                <?php endforeach; ?>
            </table></div>
            <?php endif; ?>

            <?= $this->html->link('+ اسناد پشتیبان',
                ['plugin'=>'Admin','controller'=>'Posts','action'=>'add',
                '?'=>[
                    'post_type'=>'chresource',
                    'challenge_id' =>$challenge['id'] ,
                    'ret'=>'/admin/challenge/admin/view/'.$challenge['id'] ]],
                ['class'=>'btn btn-success'])?>
        </div>
        <!-- ------------------------------------------->
        <!-- ------------------------------------------->
        <div class="tab-pane" id="overview" role="tabpanel">
            <?php if (!empty($challenge->challengetexts)): ?>
            <div class="table-responsive"><table class="table table-striped table-bordered bg-white">
                <tr>
                    <th scope="col"><?= __('توضیحات') ?></th>
                </tr>
                <?php foreach ($challenge->challengetexts as $challengetexts): ?>
                <tr>
                    <td class="text-justify">
                        <?= nl2br($challengetexts->title) ?>
                        <div class="hidme">
                            <?= $this->Html->link(__('ویرایش'), ['controller' => 'challengetexts', 'action' => 'edit', $challengetexts->id]) ?>
                            <?= $this->Form->postlink(__('حذف'), ['controller' => 'challengetexts', 'action' => 'delete', $challengetexts->id], ['confirm' => __('Are you sure you want to delete # {0}?', $challengetexts->id)]) ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table></div>
            <?php endif; ?>
            <?= $this->html->link('+ راهنمای '.__d('Template', 'همیاری'),
                ['controller'=>'Challengetexts','action'=>'add',$challenge->id],
                ['class'=>'btn btn-success'])?>
        </div>
        <!-- ------------------------------------------->
        <!-- ------------------------------------------->
        <div class="tab-pane" id="files" role="tabpanel">
            <?php if (!empty($challenge->challengeimages)): ?>
            <div class="table-responsive"><table class="table table-striped table-bordered table-hover bg-white">
                <tr>
                    <th scope="col"><?= __('عنوان') ?></th>
                    <th scope="col"><?= __('آدرس') ?></th>
                    <th scope="col"><?= __('نوع') ?></th>
                    <th scope="col" class="actions"><?= __('عملیات') ?></th>
                </tr>
                <?php foreach ($challenge->challengeimages as $challengeimages): ?>
                <tr>
                    <td><?= h($challengeimages->title) ?></td>
                    <td><?= h($challengeimages->src) ?></td>
                    <td><?= h($challengeimages->types==1?'تصویر':
                    'فیلم') ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('ویرایش'), ['controller' => 'Challengeimages', 'action' => 'edit', $challengeimages->id]) ?>
                        <?= $this->Form->postlink(__('حذف'), ['controller' => 'Challengeimages', 'action' => 'delete', $challengeimages->id], ['confirm' => __('Are you sure you want to delete # {0}?', $challengeimages->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table></div>
            <?php endif; ?>

            <?= $this->html->link('+ فایل ها',
                ['controller'=>'Challengeimages','action'=>'add',$challenge->id],
                ['class'=>'btn btn-success'])?>
        </div>
        
        <!-- ------------------------------------------->
        <!-- ------------------------------------------->
    </div>
    <br><br><br>
<style>
    .challenge .badge{
        font-size:14px;
        font-weight: normal;
    }
    .challenge .table td {
        padding-left: 10px;
        border-top: 1px solid #EBE9F1;
        padding-right: 10px;
    }
    .challenge .dropdown-toggle::after {
        margin-left: 10px;
    }
    .challenge .btn-group .dropdown-menu {
        left: 0 !important;
    }
    .challenge .nav-item .badge{
        font-size: 15px;
        font-weight: normal;
        font-family: sans-serif;
        background:#9087f1;
        margin-left:-10px;
        margin-right:5px;
    }
</style>
</div>