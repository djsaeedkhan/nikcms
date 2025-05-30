<?php use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
?>
<div class="client_index">
    <div class="content-header row">
        <div class="content-header-right col-md-10 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-right mb-0">
                    پیشخوان سامانه آموزشی
                    </h2>
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-right col-md-2 col-12 d-md-block d-none"></div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4 col-sm-6 col-12">
        <div class="card">
            <a href="<?=Router::url('/lms/client/course');?>" title="نمایش لیست دوره ها"><div class="card-header">
                <div>
                    <h1 class="font-weight-bolder mb-0">
                        <?php echo TableRegistry::getTableLocator()->get('Lms.LmsCourseusers')->find('all')
                            ->contain(['LmsCourses'])
                            ->where(['LmsCourseusers.user_id'=> $guser_id])
                            ->count();
                         ?>
                    </h1>
                    <p class="card-text"><?= __d( 'lms', 'دوره های من' ) ?></p>
                </div>
                <div class="avatar bg-light-primary p-50 m-0">
                    <div class="avatar-content">
                        <i data-feather="book-open" class="font-medium-5"></i>
                    </div>
                </div>
            </div></a>
        </div>
    </div>

    <div class="col-lg-4 col-sm-6 col-12">
        <div class="card">
            <a href="<?=Router::url('/lms/client/factors');?>" title="نمایش لیست فاکتور ها"><div class="card-header">
                <div>
                    <h1 class="font-weight-bolder mb-0">
                        <?php echo TableRegistry::getTableLocator()->get('Lms.LmsFactors')->find('all')
                            ->where([
                                'user_id'=>$guser_id,
                                'LmsFactors.paid'=>0])
                            ->count();
                        ?>
                    </h1>
                    <p class="card-text"><?= __d( 'lms', 'فاکتور پرداخت نشده من' ) ?></p>
                </div>
                <div class="avatar bg-light-success p-50 m-0">
                    <div class="avatar-content">
                        <i data-feather="clipboard" class="font-medium-5"></i>
                    </div>
                </div>
            </div></a>
        </div>
    </div>
    <div class="col-lg-4 col-sm-6 col-12">
        <a href="<?=Router::url('/lms/client/payments');?>" title="نمایش لیست پرداخت ها"><div class="card">
            <div class="card-header">
                <div>
                    <h1 class="font-weight-bolder mb-0">
                        <?php echo TableRegistry::getTableLocator()->get('Lms.LmsPayments')->find('all')
                            ->where([
                                'user_id'=>$guser_id,
                                'LmsPayments.enable'=>1])
                            ->count();
                        ?>
                    </h1>
                    <p class="card-text"><?= __d( 'lms', 'پرداخت ثبت شده من' ) ?></p>
                </div>
                <div class="avatar bg-light-danger p-50 m-0">
                    <div class="avatar-content">
                        <i data-feather="shopping-bag" class="font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div></a>
    </div>
    <!-- <div class="col-lg-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-header">
                <div>
                    <h2 class="font-weight-bolder mb-0">0</h2>
                    <p class="card-text"><?= __d( 'admin', 'resane' ) ?></p>
                </div>
                <div class="avatar bg-light-warning p-50 m-0">
                    <div class="avatar-content">
                        <i data-feather="server" class="font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
</div>

<?php 
if(isset($plugin_lms['dashboard_topalert']) and $plugin_lms['dashboard_topalert'] !=""):
    echo '<div class="alert alert-'.($plugin_lms['dashboard_topalert_type']).'">';
    echo nl2br($plugin_lms['dashboard_topalert']);
    echo '</div>';
endif?>

<div class="row rows">
    <div class="col-sm-6">
        <h2 class="content-header-title1 float-right mb-0">
            لیست دوره های من
        </h2>
        <?= $this->cell('Lms.Home::user_dashboard');?>
    </div>
    <div class="col-sm-6">
        <h2 class="content-header-title1 float-right mb-0">
            اعلانات من
        </h2>
        <?= $this->cell('Ticketing.Home::user_dashboard');?>
    </div>
</div>
<script nonce="<?=get_nonce?>">
    $('.rows .content-header-title').addClass('d-none');
</script>

<?php
/* echo $this->Html->image(
    ['plugin'=>'Admin','controller'=>'Users','action'=>'Profile','?'=>['thumbnail'=>'6.jpg']],
['class'=>'round','width'=>'40','height'=>'40']); */
?>