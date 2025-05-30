<?php
if(isset($this->request->getParam('?')['saved'])){
    echo '<div class="alert alert-success">
    ثبت اطلاعات پروفایل شما با موفقیت انجام شد
    </div>';
}
?>
<table class="table table-bordered table-striped">
    <tbody>
    <tr>
        <td width="110">نام و نام خانوادگی</td>
        <td><?php // ($user and $user->gender!='')?($user->gender=='m'?'آقای':'خانم'):''?>
            <?=$public['family'];?>

            <?= $this->html->link(__('ویرایش نام خانوادگی'),
                '/challenge/profile/password',
                ['class'=>'btn btn-sm btn-primary']);?>
        </td>
    </tr>
    <tr>
        <td>نام کاربری</td>
        <td><?=$public['username'];?></td>
    </tr>
    <?php if($user and $user['extra'] != ''):?>
    <?php if($user and $user->birth_date):?>
    <tr>
        <td>تاریخ تولد </td>
        <td><?=($user and $user->birth_date)?$user->birth_date:' - '?></td>
    </tr>
    <?php endif?>
    <tr>
        <td>کدملی</td>
        <td><?=($user and $user->codemeli)?$user->codemeli:' - '?></td>
    </tr>
    <tr>
        <td>شماره موبایل </td>
        <td><?=($user and $user->mobile)?$user->mobile:' - '?></td>
    </tr>
    <tr>
        <td>استان محل زندگی </td>
        <td><?=$user?$this->Func->province_list($user->provice):''?></td>
    </tr>
    <tr>
        <td>آدرس ایمیل </td>
        <td><?=($user and $user->email)?$user->email:' - '?></td>
    </tr>

    <!-- <tr>
        <td>آخرین مدرک تحصیلی </td>
        <td><?= ($user and isset($eductions[$user->eductions]))?$eductions[$user->eductions]:'-'?></td>
    </tr>
    <tr>
        <td>رشته تحصیلی </td>
        <td><?= ($user and isset($eductions[$user->field]))?$eductions[$user->field]:'-'?></td>
    </tr>
    <tr>
        <td>دانشگاه محل تحصیل</td>
        <td><?= ($user and isset($eductions[$user->univercity]))?$eductions[$user->univercity]:'-'?></td>
    </tr> -->
    
    <tr>
        <td>نوع مشارکت در <?=__d('Template', 'همیاری')?> ها</td>
        <td><strong><?= (isset($user->single) and isset($group[$user->single]))? $group[$user->single] :''?></strong></td>
    </tr>

    <!-- <tr>
        <td>توصیف کلی پیرامون موقعیت شغلی خود</td>
        <td><?=($user and $user->descr)?$user->descr:' - '?></td>
    </tr> -->


    <?php /* if($user and $user->single == 2):?>
        <tr>
            <td>نام مرکز</td>
            <td>
                <?= isset($center[$user->center])? $center[$user->center] :''?> 
                <?= $user->center_name?>
            </td>
        </tr>
        <tr>
            <td>سمت</td>
            <td><?= $user->semat?></td>
        </tr>
    <?php endif */?>
    

    <!-- <tr>
        <td>موضوعات مورد علاقه </td>
        <td>
            <?php
            /* if($user):
                foreach($user->challengetopics as $topic){
                    echo '<span class="badge badge-info ml-2">';
                    echo   $topic->title;
                    echo '</span>';
                }
            endif; */
            ?>
        </td>
    </tr> -->

    <tr>
        <td colspan="2"><br>
            <?=$this->html->link('نمایش / ویرایش پروفایل',
                '/challenge/profile/edit',['class'=>'btn btn-sm btn-primary'])?>
        </td>
    </tr>
    
    <?php else:?>
        <tr>
            <td colspan="2">
                متاسفانه پروفایل کاربری شما وارد نشده است. لطفا جهت تکمیل پروفایل کلیک کنید 
                <?= $this->html->link('تکمیل پروفایل',
                    '/challenge/profile/edit',['class'=>'btn btn-sm btn-primary'])?>
            </td>
        </tr>
    <?php endif?>

    </tbody>
</table>