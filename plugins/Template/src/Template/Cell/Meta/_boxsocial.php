<?php
/*
return [
    ['name'=>'PostMetas.sc_address','fname'=>'sc_address','col'=> 12, 'title'=>'آدرس', 'pholder'=>'https://','class'=>'ltr',],
    ['name'=>'PostMetas.sc_phone','fname'=>'sc_phone','col'=> 12, 'title'=>'شماره تلفن', 'pholder'=>'https://','class'=>'ltr',],
    ['name'=>'PostMetas.sc_email','fname'=>'sc_email','col'=> 12, 'title'=>'آدرس ایمیل', 'pholder'=>'https://','class'=>'ltr',],
    ['name'=>'PostMetas.sc_personal','fname'=>'sc_personal','col'=> 12, 'title'=>'صفحه شخصی', 'pholder'=>'https://','class'=>'ltr',],
    ['name'=>'PostMetas.sc_instagram','fname'=>'sc_instagram','col'=> 12, 'title'=>'اینستاگرام', 'pholder'=>'https://','class'=>'ltr',],
    ['name'=>'PostMetas.sc_twitter','fname'=>'sc_twitter','col'=> 12, 'title'=>'توییتر', 'pholder'=>'https://','class'=>'ltr',],
    ['name'=>'PostMetas.sc_facebook','fname'=>'sc_facebook','col'=> 12, 'title'=>'فیسبوک', 'pholder'=>'https://','class'=>'ltr',],
    ['name'=>'PostMetas.sc_telegram','fname'=>'sc_telegram','col'=> 12, 'title'=>'تلگرام', 'pholder'=>'https://','class'=>'ltr',],
    ['name'=>'PostMetas.sc_linkedin','fname'=>'sc_linkedin','col'=> 12, 'title'=>'لینکدین', 'pholder'=>'https://','class'=>'ltr',],
    ['name'=>'PostMetas.sc_youtube','fname'=>'sc_youtube','col'=> 12, 'title'=>'یوتیوب', 'pholder'=>'https://','class'=>'ltr',],
    ['name'=>'PostMetas.sc_aparat','fname'=>'sc_aparat','col'=> 12, 'title'=>'آپارات', 'pholder'=>'https://','class'=>'ltr',],
    ['name'=>'PostMetas.sc_bale','fname'=>'sc_bale','col'=> 12, 'title'=>'بله', 'pholder'=>'https://','class'=>'ltr',],
    ['name'=>'PostMetas.sc_rg','fname'=>'sc_rg','col'=> 12, 'title'=>'ریسرچ گیت', 'pholder'=>'https://','class'=>'ltr',],
    ['name'=>'PostMetas.sc_orc','fname'=>'sc_orc','col'=> 12, 'title'=>'ارکید', 'pholder'=>'https://','class'=>'ltr',],
    ['name'=>'PostMetas.sc_gosc','fname'=>'sc_gosc','col'=> 12, 'title'=>'گوگل اسکالر', 'pholder'=>'https://','class'=>'ltr',],
];*/

$list = [
    'sc_address'=>'آدرس',
    'sc_phone'=>'شماره تلفن',
    'sc_email'=>'آدرس ایمیل',
    'sc_link'=>'صفحه شخصی',
    'sc_instagram'=>'اینستاگرام',
    'sc_twitter'=>'توییتر',
    'sc_facebook'=>'فیسبوک',
    'sc_telegram'=>'تلگرام',
    'sc_linkedin'=>'لینکدین',
    //'sc_youtube'=>'یوتیوب',
    /* 'sc_aparat'=>'آپارات',
    'sc_bale'=>'بله',
    'sc_rg'=>'ریسرچ گیت',
    'sc_orc'=>'ارکید',
    'sc_gosc'=>'گوگل اسکالر', */
];
$soc = [];
foreach($list as $ks=> $ls){
    $soc[] = ['name'=>'PostMetas.'.$ks,'fname'=>$ks,'col'=> 12, 'title'=>$ls, 
        'pholder'=>(!in_array($ks,['sc_email','sc_phone','sc_address'])?'https://':''),'class'=>'ltr mb-2',];
}  
return $soc ;