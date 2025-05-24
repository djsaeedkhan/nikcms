<?php
global $menu;
global $version;
global $maxrow;
$product = $this->Query->post('product',['field'=>['id','title'],'limit'=>0, 'find_type'=>'list']);
$productc = $this->Query->category('product',['field'=>['id','title'],'limit'=>0, 'find_type'=>'list']);
$postc = $this->Query->category('post',['field'=>['id','title'],'limit'=>0, 'find_type'=>'list']);

$maxrow = 15;
$version = 2;
$options = [
    '1'=>'تمام صفحه',
];
$menu = [
    'header'=>['name'=>'header' , 'title'=>'هدر', 
        'submenu'=>[
            [
                'title'=>'-',
                'fields'=>[

                    ['break'=>'تصویر لوگو'],
                    ['name'=>'header_logo','col'=> 12, 'title'=>'لوگو صفحه نخست', 'class'=>'ltr', 'pholder'=> 'http://', 'select_img'=> true] ,
                    ['name'=>'header_rlogo','col'=> 12, 'title'=>'لوگو موبایل ', 'class'=>'ltr', 'pholder'=> 'http://', 'select_img'=> true] ,
                    [],

                    ['break'=>'باکس تماس'],
                    ['name'=>'header_call_t1','col'=> 6, 'title'=>'عنوان 1',] ,
                    ['name'=>'header_call_t2','col'=> 6, 'title'=>'عنوان 2',] ,
                    ['name'=>'header_call_link','col'=> 12, 'title'=>'لینک مقصد', 'class'=>'ltr', 'pholder'=> 'http://'] ,
                    [],

                    ['break'=>'منو هدر'],
                    ['type'=>'select', 'name'=>'topmenu','title'=>'منوی هدر', 'data'=> $AllMenu ,'col'=> 12],
                ],
            ],
        ],
    ],
    //------------------------------------
    'box1'=>['name'=>'box1' , 'title'=>'نخست  - اسلایدر ', 
        'submenu'=>[
            [
                'title'=>'بخش اسلایدر',
                'repeat'=>true,
                'fields'=>[
                    ['name'=>'bx1_stitle', 'title'=>'عنوان تصویر (اختیاری)', 'col'=> 12, ] ,
                    ['name'=>'bx1_slimg', 'title'=>'آدرس تصویر', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 12, 'select_img'=> true] ,
                    ['name'=>'bx1_sllink', 'title'=>'لینک مقصد', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 12] ,
                ]
            ],

            [
                'title'=>'باکس چپ',
                'fields'=>[
                    ['name'=>'bx1_spc_cat', 'title'=>'انتخاب دسته بندی', 'type'=>'select', 'data'=>$productc, 'col'=> 6] ,
                    ['name'=>'bx1_spc_num', 'title'=>'تعداد نمایشی (فقط عدد)', 'col'=> 6, 'type'=>'number'] ,
                ]
            ],
        ],
    ],
    //-----------------------------------
    'boxc'=>['name'=>'boxc' , 'title'=>'نخست - دسته بندی  ', 
        'submenu'=>[
            [
                'title'=>'تنظیمات',
                'fields'=>[
                    ['name'=>'bxc_title', 'title'=>'عنوان باکس', 'col'=> 12] ,
                    ['name'=>'bxc_desc', 'title'=>'توضیحات باکس', 'col'=> 12] ,
                    [],
                    ['name'=>'bxc_linkt', 'title'=>'عنوان لینک بیشتر', 'col'=> 6] ,
                    ['name'=>'bxc_link', 'title'=>'لینک مقصد', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 6] ,
                ]
            ],
            [
                'title'=>'دیتا',
                'repeat'=>true,
                'fields'=>[
                    ['name'=>'bxc_dtitle', 'title'=>'عنوان دسته بندی', 'col'=> 4] ,
                    ['name'=>'bxc_dimg', 'title'=>'آدرس تصویر', 'col'=> 4, 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 4, 'select_img'=> true] ,
                    ['name'=>'bxc_dlink', 'title'=>'لینک مقصد', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 4] ,
                ]
            ],
        ],
    ],

    //-----------------------------------
    'box2'=>['name'=>'box2' , 'title'=>'نخست - برندها  ', 
        'submenu'=>[
            [
                'title'=>'-',
                'fields'=>[
                    ['name'=>'bx2_title', 'title'=>'عنوان باکس', 'col'=> 12] ,
                    ['name'=>'bx2_desc', 'title'=>'توضیحات باکس', 'col'=> 12] ,
                    [],
                    ['name'=>'bx2_linkt', 'title'=>'عنوان لینک بیشتر', 'col'=> 6] ,
                    ['name'=>'bx2_link', 'title'=>'لینک مقصد', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 6] ,
                    [],
                    ['name'=>'bx2_count', 'title'=>'تعداد نمایشی', 'col'=> 6, 'type'=>'number'] ,
                ]
            ],
        ],
    ],
    //-----------------------------------
    'box3'=>['name'=>'box3' , 'title'=>'نخست - تبلیغات 1 ', 
        'submenu'=>[
            [
                'title'=>'-',
                'fields'=>[
                    ['name'=>'bx3_image1', 'title'=>'آدرس تصویر 1', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 8, 'select_img'=> true] ,
                    ['name'=>'bx3_title1', 'title'=>'عنوان (اختیاری)',  'col'=> 4] ,
                    ['name'=>'bx3_link1', 'title'=>'لینک مقصد', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 12 ],
                    [],
                    ['name'=>'bx3_image2', 'title'=>'آدرس تصویر 2', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 8, 'select_img'=> true] ,
                    ['name'=>'bx3_title2', 'title'=>'عنوان (اختیاری)',  'col'=> 4] ,
                    ['name'=>'bx3_link2', 'title'=>'لینک مقصد', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 12 ],
                    [],
                    ['name'=>'bx3_image3', 'title'=>'آدرس تصویر 3', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 8, 'select_img'=> true] ,
                    ['name'=>'bx3_title3', 'title'=>'عنوان (اختیاری)',  'col'=> 4] ,
                    ['name'=>'bx3_link3', 'title'=>'لینک مقصد', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 12 ],

                ]
            ],
        ],
    ],
    //------------------------------------
    'box5last'=>['name'=>'box5last' , 'title'=>'نخست - نمایش محصولات ', 
        'submenu'=>[
            [
                'title'=>'-',
                'fields'=>[
                    ['name'=>'bx5last_title', 'title'=>'عنوان باکس', 'col'=> 12] ,
                    ['name'=>'bx5last_desc', 'title'=>'توضیحات باکس', 'col'=> 12] ,
                    [],
                    ['name'=>'bx5last_linkt', 'title'=>'عنوان لینک', 'col'=> 6] ,
                    ['name'=>'bx5last_link', 'title'=>'لینک مقصد', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 6] ,

                    [],
                    ['name'=>'bx5last_cat', 'title'=>'انتخاب دسته بندی', 'type'=>'select', 'data'=>$productc, 'col'=> 6] ,
                    ['name'=>'bx5last_num', 'title'=>'تعداد نمایشی (فقط عدد)', 'col'=> 6, 'type'=>'number'] ,

                ]
            ],
        ],
    ],
    //------------------------------------
    'box5'=>['name'=>'box5' , 'title'=>'نخست - نمایش محصولات 1 ', 
        'submenu'=>[
            [
                'title'=>'-',
                'fields'=>[
                    ['name'=>'bx5_title', 'title'=>'عنوان باکس', 'col'=> 12] ,
                    ['name'=>'bx5_desc', 'title'=>'توضیحات باکس', 'col'=> 12] ,
                    [],
                    ['name'=>'bx5_linkt', 'title'=>'عنوان لینک', 'col'=> 6] ,
                    ['name'=>'bx5_link', 'title'=>'لینک مقصد', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 6] ,

                    [],
                    ['name'=>'bx5_cat', 'title'=>'انتخاب دسته بندی', 'type'=>'select', 'data'=>$productc, 'col'=> 6] ,
                    ['name'=>'bx5_num', 'title'=>'تعداد نمایشی (فقط عدد)', 'col'=> 6, 'type'=>'number'] ,

                ]
            ],
        ],
    ],
    //------------------------------------
    
    'box55'=>['name'=>'box55' , 'title'=>'نخست - نمایش محصولات 2 ', 
        'submenu'=>[
            [
                'title'=>'-',
                'fields'=>[
                    ['name'=>'bx55_title', 'title'=>'عنوان باکس', 'col'=> 12] ,
                    ['name'=>'bx55_desc', 'title'=>'توضیحات باکس', 'col'=> 12] ,
                    [],
                    ['name'=>'bx55_linkt', 'title'=>'عنوان لینک', 'col'=> 6] ,
                    ['name'=>'bx55_link', 'title'=>'لینک مقصد', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 6] ,

                    [],
                    ['name'=>'bx55_cat', 'title'=>'انتخاب دسته بندی', 'type'=>'select', 'data'=>$productc, 'col'=> 6] ,
                    ['name'=>'bx55_num', 'title'=>'تعداد نمایشی (فقط عدد)', 'col'=> 6, 'type'=>'number'] ,

                ]
            ],
        ],
    ],
    'box4'=>['name'=>'box4' , 'title'=>'نخست - تبلیغات 2 ', 
        'submenu'=>[
            [
                'title'=>'-',
                'fields'=>[
                    ['name'=>'bx4_image1', 'title'=>'آدرس تصویر 1', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 8, 'select_img'=> true] ,
                    ['name'=>'bx4_title1', 'title'=>'عنوان (اختیاری)',  'col'=> 4] ,
                    ['name'=>'bx4_link1', 'title'=>'لینک مقصد', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 12 ],
                    [],

                    ['name'=>'bx4_image2', 'title'=>'آدرس تصویر 2', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 8, 'select_img'=> true] ,
                    ['name'=>'bx4_title2', 'title'=>'عنوان (اختیاری)',  'col'=> 4] ,
                    ['name'=>'bx4_link2', 'title'=>'لینک مقصد', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 12 ],
                    [],

                    ['name'=>'bx4_image3', 'title'=>'آدرس تصویر 3', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 8, 'select_img'=> true] ,
                    ['name'=>'bx4_title3', 'title'=>'عنوان (اختیاری)',  'col'=> 4] ,
                    ['name'=>'bx4_link3', 'title'=>'لینک مقصد', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 12 ],
                    [],

                    ['name'=>'bx4_image4', 'title'=>'آدرس تصویر 4', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 8, 'select_img'=> true] ,
                    ['name'=>'bx4_title4', 'title'=>'عنوان (اختیاری)',  'col'=> 4] ,
                    ['name'=>'bx4_link4', 'title'=>'لینک مقصد', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 12 ],

                ]
            ],
        ],
    ],
    //------------------------------------
    'box6'=>['name'=>'box6' , 'title'=>'نخست - درباره ما ', 
        'submenu'=>[
            [
                'title'=>'-',
                'fields'=>[
                    ['name'=>'bx6_title1', 'title'=>'عنوان اصلی 1', 'col'=> 12] ,
                    ['name'=>'bx6_title2', 'title'=>'زیرعنوان 1', 'col'=> 12] ,
                    ['name'=>'bx6_desc', 'title'=>'توضیحات متنی', 'col'=> 12,'type'=>'textarea'] ,
                    [],

                    ['name'=>'bx6_linkt', 'title'=>'عنوان لینک 1' ,  'col'=> 6] ,
                    ['name'=>'bx6_link', 'title'=>'لینک مقصد', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 6] ,
                    [],
                    ['name'=>'bx6_linkt2', 'title'=>'عنوان لینک 2' , 'col'=> 6] ,
                    ['name'=>'bx6_link2', 'title'=>'لینک مقصد', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 6] ,
                    [],

                    /* ['name'=>'bx6_ttitle1', 'title'=>'عنوان اصلی 2', 'col'=> 12] ,
                    ['name'=>'bx6_ttitle2', 'title'=>'زیرعنوان 2', 'col'=> 12,'type'=>'textarea'] ,
                    [],

                    ['name'=>'bx6_film', 'title'=>'آدرس فیلم', 'col'=> 12, 'pholder'=>'http://', 'class'=>'ltr', 'select_img'=> true] ,
                    ['name'=>'bx6_filmc', 'title'=>'تصویر کاور فیلم', 'col'=> 12, 'pholder'=>'http://', 'class'=>'ltr', 'select_img'=> true] ,
                    [], */
                ]
            ],
            [
                'title'=>'باکس چپ',
                'fields'=>[
                    
                    ['name'=>'bx6_film', 'title'=>'عنوان', 'col'=> 12, ],//'pholder'=>'http://', 'class'=>'ltr', 'select_img'=> true] ,
                    ['name'=>'bx6_filmc', 'title'=>'تصویر کاور فیلم', 'col'=> 12, 'pholder'=>'http://', 'class'=>'ltr', 'select_img'=> true] ,

                    [],

                    ['name'=>'bx6_icont1', 'title'=>'عنوان آیکن', 'col'=> 6,] ,
                    ['name'=>'bx6_icon1', 'title'=>'عدد', 'col'=> 6,'type'=>'number' ] ,

                    ['name'=>'bx6_icont2', 'title'=>'عنوان آیکن', 'col'=> 6,] ,
                    ['name'=>'bx6_icon2', 'title'=>'عدد', 'col'=> 6,'type'=>'number' ] ,

                    ['name'=>'bx6_icont3', 'title'=>'عنوان آیکن', 'col'=> 6,] ,
                    ['name'=>'bx6_icon3', 'title'=>'عدد', 'col'=> 6,'type'=>'number' ] ,


                ]
            ],
        ],
    ],
    //------------------------------------
    'box7'=>['name'=>'box7' , 'title'=>'نخست - باکس لیبل ', 
        'submenu'=>[
            [
                'title'=>'-',
                'fields'=>[
                    ['name'=>'bx7_count', 'title'=>'تعداد نمایشی', 'col'=> 6, 'type'=>'number'] ,
                ]
            ],
        ],
    ],
    //------------------------------------

    'box8'=>['name'=>'box8' , 'title'=>'نخست - باکس فروش ویژه ', 
        'submenu'=>[
            [
                'title'=>'-',
                'fields'=>[
                    ['name'=>'bx8_title1', 'title'=>'عنوان 1', 'col'=> 12] ,
                    ['name'=>'bx8_title2', 'title'=>'عنوان 2', 'col'=> 12] ,
                    [],

                    ['name'=>'bx8_image', 'title'=>'آدرس تصویر ', 'col'=> 12, 'pholder'=>'http://', 'class'=>'ltr', 'select_img'=> true] ,
                    [],

                    ['name'=>'bx8_linkt', 'title'=>'عنوان لینک' , 'col'=> 6] ,
                    ['name'=>'bx8_link', 'title'=>'لینک مقصد', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 6] ,
                    [],

                    ['name'=>'bx8_cat', 'title'=>'انتخاب دسته بندی', 'type'=>'select', 'data'=>$productc, 'col'=> 6] ,
                    ['name'=>'bx8_num', 'title'=>'تعداد نمایشی (فقط عدد)', 'col'=> 6, 'type'=>'number'] ,


                ]
            ],
        ],
    ],
    //------------------------------------
    'box9'=>['name'=>'box9' , 'title'=>'نخست - مقالات ', 
        'submenu'=>[
            [
                'title'=>'-',
                'fields'=>[
                    ['name'=>'bx9_title', 'title'=>'عنوان باکس', 'col'=> 12] ,
                    ['name'=>'bx9_desc', 'title'=>'توضیحات باکس', 'col'=> 12] ,
                    [],
                    ['name'=>'bx9_linkt', 'title'=>'عنوان لینک', 'col'=> 6] ,
                    ['name'=>'bx9_link', 'title'=>'لینک مقصد', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 6] ,

                    [],
                    ['name'=>'bx9_cat', 'title'=>'انتخاب دسته بندی', 'type'=>'select', 'data'=>$postc, 'col'=> 6] ,
                    ['name'=>'bx9_num', 'title'=>'تعداد نمایشی (فقط عدد)', 'col'=> 6, 'type'=>'number'] ,

                ]
            ],
        ],
    ],
    //------------------------------------

    /* 'sidebar'=>['name'=>'sidebar' , 'title'=>'سایدبار کناری', 
        'submenu'=>[
            [
                'title'=>'-',
                'fields'=>[
                    ['name'=>'side_title', 'title'=>'عنوان باکس', 'col'=> 12] ,
                ]
            ],
            [
                'repeat'=>true,
                'title'=>'لیست گزینه ها',
                'fields'=>[
                    ['name'=>'side_title', 'title'=>'عنوان', 'col'=> 9] ,
                    ['name'=>'side_date', 'title'=>'تاریخ', 'col'=> 3, 'class'=>'ltr'] ,
                    ['name'=>'side_img', 'title'=>'آدرس تصویر', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 12, 'select_img'=> true] ,
                    ['name'=>'side_link', 'title'=>'لینک مقصد', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 12] ,
                ]
            ],
        ],
    ], */
    //------------------------------------
    'footer'=>['name'=>'footer' , 'title'=>'فوتر', 
        'submenu'=>[
            [
                'title'=>'منو فوتر',
                'fields'=>[
                    ['break'=>'انتخاب منو'],
                    ['type'=>'text', 'name'=>'footer_title1','title'=>'عنوان منو فوتر 1', 'col'=> 6],
                    ['type'=>'select', 'name'=>'footer_menu1','title'=>'منوی فوتر', 'data'=> $AllMenu ,'col'=> 6],

                    ['type'=>'text', 'name'=>'footer_title2','title'=>'عنوان منو فوتر 2', 'col'=> 6],
                    ['type'=>'select', 'name'=>'footer_menu2','title'=>'منوی فوتر', 'data'=> $AllMenu ,'col'=> 6],
                ],
            ],

            [
                'title'=>'خبرنامه فوتر',
                'fields'=>[
                    ['type'=>'text', 'name'=>'footer_newst','title'=>'عنوان فرم خبرنامه', 'col'=> 12],
                    ['type'=>'text', 'name'=>'footer_newspl','title'=>'متن داخل فیلد ایمیل', 'col'=> 12],
                    ['type'=>'text', 'name'=>'footer_news_btn','title'=>'عنوان کلید', 'col'=> 12],

                   /*  ['type'=>'text', 'name'=>'footer_menut2','title'=>'عنوان منو فوتر 2', 'col'=> 6],
                    ['type'=>'select', 'name'=>'footer_menu2','title'=>'منوی فوتر', 'data'=> $AllMenu ,'col'=> 6], */
                ],
            ],

            [
                'title'=>'باکس توضیحات',
                'fields'=>[
                    ['name'=>'footer_info_title', 'title'=>'عنوان ', 'col'=> 12],
                    ['name'=>'footer_info_desc', 'title'=>'توضیحات', 'col'=> 12],
                    [],
                    ['name'=>'footer_call_title1', 'title'=>'عنوان 1', 'col'=> 6],
                    ['name'=>'footer_call_title2', 'title'=>'عنوان 2', 'col'=> 6],
                    ['name'=>'footer_call_link', 'title'=>'آدرس مقصد', 'col'=> 12],
                    [],
                ],
            ],

            [
                'title'=>'باکس درباره ما',
                'fields'=>[
                    ['name'=>'footer_about_title', 'title'=>'عنوان ', 'col'=> 12],
                    ['name'=>'footer_about_desc', 'title'=>'توضیحات', 'col'=> 12, 'type'=>'textarea'],
                ],
            ],

            [
                'title'=>'شبکه اجتماعی',
                'fields'=>[
                    ['name'=>'footer_soc_title', 'title'=>'عنوان توضیحات','pholder'=> 'http://', 'class'=>'ltr', 'col'=> 12],

                    ['name'=>'footer_soc_insta', 'title'=>'لینک اینستاگرام','pholder'=> 'http://', 'class'=>'ltr', 'col'=> 12],
                    ['name'=>'footer_soc_twitt', 'title'=>'لینک توییتر','pholder'=> 'http://', 'class'=>'ltr', 'col'=> 12],
                    ['name'=>'footer_soc_faceb', 'title'=>'لینک فیسبوک','pholder'=> 'http://', 'class'=>'ltr', 'col'=> 12],
                    ['name'=>'footer_soc_teleg', 'title'=>'لینک','pholder'=> 'http://', 'class'=>'ltr', 'col'=> 12],
                    ['name'=>'footer_soc_linked', 'title'=>'لینک لینکدین','pholder'=> 'http://', 'class'=>'ltr', 'col'=> 12],
                    ['name'=>'footer_soc_aprt', 'title'=>'لینک','pholder'=> 'http://', 'class'=>'ltr', 'col'=> 7],
                ],
            ],

            [
                'title'=>'کپی رایت',
                'fields'=>[
                    ['name'=>'footer_copyt', 'title'=>'متن کپی رایت', 'col'=> 12 ] ,
                ],
            ],
        ],
    ],
    //------------------------------------
    'extra'=>['name'=>'extra' , 'title'=>'سایر ویژگی ها', 
        'submenu'=>[
            [
                'title'=>'استایل اضافه',
                'fields'=>[
                    ['type'=>'textarea', 'name'=>'morecss','style'=>'height:300px;','title'=>'More CSS','class'=>'ltr','col'=>12],
                ]
            ],
        ],
    ],
    //------------------------------------
];   
?>