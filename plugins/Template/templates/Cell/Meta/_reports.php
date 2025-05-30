<?php
$list = [];
for($i=1;$i<20;$i++):
    $list['report'.$i] =[
        'name'=>'report'.$i ,
        'title'=>'نمودار '.$i, 
        'submenu'=>[
            [
                'title'=>'تنظیمات نمودار '.$i,
                'fields'=>[
                    ['name'=>'PostMetas.rep_title_'.$i,'fname'=>'rep_title_'.$i,'col'=> 9, 
                        'title'=>'عنوان نمودار','class'=>'mb-2'],

                    ['name'=>'PostMetas.rep_col_'.$i,'fname'=>'rep_col_'.$i,'col'=> 3, 
                        'type'=>'select',
                        'data'=>[
                            1 => 1,
                            2 => 2,
                            3 => 3,
                            4 => 4,
                            5 => 5,
                            6 => 6,
                            7 => 7,
                            8 => 8,
                            9 => 9,
                            10 => 10,
                            11 => 11,
                            12 => 12],
                        'title'=>'تعداد ستون','class'=>'mb-2 center'
                    ],

                    /* ['name'=>'PostMetas.rep_prio_'.$i,'fname'=>'rep_prio_'.$i,'col'=> 2, 
                        'type'=>'number',
                        'title'=>'اولویت','class'=>'mb-2'
                    ], */

                    ['name'=>'PostMetas.rep_canvaid_'.$i,'fname'=>'rep_canvaid_'.$i,'col'=> 8, 
                        'title'=>'آیدی منحصر به فرد آمار (هم اسم با بخش اسکریپت باید باشد)<br><div class="small" style="font-family: sans-serif;">&lt;canvas id="1234" height="142"&gt;&lt;/canvas&gt;</div>',
                        'class'=>'mb-2 ltr'] ,

                    ['name'=>'PostMetas.rep_canvah_'.$i,'fname'=>'rep_canvah_'.$i,'col'=> 4, 
                        'title'=>'ارتفاع نمودار<br><div class="small">فقط عدد</div>',
                        'class'=>'mb-2 ltr'] ,
                        

                    ['name'=>'PostMetas.rep_data_'.$i,'fname'=>'rep_data_'.$i,'col'=> 12, 'title'=>'اسکریپت نمودار ( کدهای بین اسکریپت را وارد کنید)', 
                        'type'=>'textarea','style'=>'min-height: 500px;
                        line-height: 20px;
                        font-size: 12px;
                        font-family: sans-serif;',
                        'pholder'=>'<script></script>','class'=>'ltr mb-2'],

                    ['name'=>'PostMetas.rep_alert_'.$i,'fname'=>'rep_alert_'.$i,'col'=> 12, 'title'=>'توضیحات پاپ آپ','class'=>'mb-2'] ,
                    ['name'=>'PostMetas.rep_file_'.$i,'fname'=>'rep_file_'.$i,'col'=> 12, 'title'=>'فایل برای دانلود', 'pholder'=>'https://','class'=>'ltr mb-2'] ,
                    ['name'=>'PostMetas.rep_html_'.$i,'fname'=>'rep_html_'.$i,'col'=> 12, 'title'=>'فراخوانی نمودار از html', 'pholder'=>'https://','class'=>'ltr mb-2'] ,
                    
                ]
            ],
        ],
    ];
endfor;
return $list;
