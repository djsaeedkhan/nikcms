<?= $this->Element('Template.header')?>
<section id="content">
    <div class="content-wrap pt-3">
        <div class="container" style="direction:rtl;text-align:right">
            <?= $this->Flash->render() ?>
        </div>
        <div class="container clearfix px-0 px-md-2">
            <h2 class="profile_page" style="font-size: 20px;">
                <?= $this->fetch('shop_title') != ''? $this->fetch('shop_title'): 'حساب کاربری'?>
            </h2>

            <div class="row gutter-40 col-mb-80">
                <div class="postcontent col-lg-9 pbox" style="font-size:14px;">
                    <?= $this->fetch('content');?>
                </div>
                <div class="sidebar col-lg-3 ">

                    <?php 
                    $temp = Cake\ORM\TableRegistry::getTableLocator()->get('Shop.ShopLogesticusers')->find('all')
                        ->where([
                            'user_id'=> $this->request->getAttribute('identity')->get('id')
                            ])
                        ->toarray();
                    if(is_array($temp) and count($temp) > 0):?>
                    <div class="sidebar-widgets-wrap pbox">
                        <div class="widget widget_links clearfix">
                            <h3 class="pb-3 mb-1" style="font-size:15px">تنظیمات مدیریتی</h3>
                            <ul>
                                <?php
                                    $lists = [
                                        'نمایندگی من'=>'/shop/profile/logestic',
                                    ];
                                    foreach($lists as $k=>$list)
                                        echo '<li '.(isset($current) and $current == $list?'class="current"':'').' >'.
                                            $this->html->link($k,$list).
                                        '</li>';
                                ?>
                            </ul>
                        </div>
                    </div>
                    <?php endif?>

                    <div class="sidebar-widgets-wrap pbox">
                        <div class="widget widget_links clearfix">
                            <ul>
                                <?php
                                    $lists = [
                                        'مشخصات پایه'=>'/shop/profile/my',
                                        'سفارش‌های من'=>'/shop/profile/orders',
                                        'علاقه‌‌مندی ها'=>'/shop/profile/favorites',
                                        'آدرسهای من'=>'/shop/profile/addresses',
                                        'پیام ها (تیکت)'=>'/tickets/index',
                                        //'بازدیدهای اخیر'=>'user-history',
                                        //'اطلاعات حساب'=>'personal-info',
                                    ];
                                    foreach($lists as $k=>$list)
                                        echo '<li '.(isset($current) and $current == $list?'class="current"':'').' >'.
                                            $this->html->link($k,$list).
                                        '</li>';
                                ?>
                                <li class="mt-1"><?= $this->html->link('خروج','/users/logout',['confirm'=>'برای خروج مطمئن هستید؟'])?></li>
                            </ul>
                        </div>
                    </div>
                </div>

                
            </div>
        </div>
    </div>
    <style>
    .pbox{
        border-radius: 8px;
        border: 1px solid #ededed;
        background-color: #fff;
        padding: 16px;
        margin-bottom: 20px;;
    }
    .widget ul li.current a{
        color:#007e7d;
    }
    .table td {
        vertical-align: middle;
    }
    .error-message{
        color: #F00;
        font-size: 14px;
    }
</style>
</section>


<style>
<?php 
if($this->request->getQuery('nonav')):?>
    #header,
    #footer,
    h2,
    .promo-full,
    .sidebar
    {display: none !important;}
<?php endif?>
</style>
<?= $this->Element('Template.footer')?>
