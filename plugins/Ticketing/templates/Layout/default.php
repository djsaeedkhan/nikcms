<?= $this->Element('Template.header')?>

<section id="content">
    <div class="content-wrap pt-3">
        <div class="container" style="direction:rtl;text-align:right">
            <?= $this->Flash->render() ?>
        </div>
        <div class="container clearfix">
            <h2>مدیریت تیکت </h2>
            <div class="row gutter-40 col-mb-80">
                <div class="sidebar col-lg-3 ">
                    <div class="sidebar-widgets-wrap pbox">
                        <div class="widget widget_links clearfix">
                            <ul>
                                <?php
                                    $lists = [
                                        __d('Ticketing', 'تیکت جدید') => '/tickets/new',
                                        __d('Ticketing', 'تیکت‌های من') => '/tickets/index',
                                        __d('Ticketing', 'تیکت‌های بسته ') => '/tickets/closed',
                                        /* 'پروفایل من'=>'/shop/profile/', */
                                    ];
                                    foreach($lists as $k=>$list)
                                        echo '<li '.($current == $list?'class="current"':'').' >'.
                                            $this->html->link($k,$list).'</li>';
                                ?>
                                <li class="mt-1"><?= $this->html->link(
                                    __d('Ticketing', 'خروج'),
                                    '/users/logout',
                                    ['confirm'=> __d('Ticketing', 'برای خروج مطمئن هستید؟') ])?></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="postcontent col-lg-9 pbox" style="font-size:14px;">
                    <?= $this->fetch('content');?>
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
</style>
</section>
<?= $this->Element('Template.footer')?>
