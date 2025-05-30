<?php
global $menu;
global $version;
global $maxrow;
$knowledge = $this->Query->post('knowledge',['field'=>['id','title'],'limit'=>0, 'find_type'=>'list']);
$topics = $this->Query->post('topics',['field'=>['id','title'],'limit'=>0, 'find_type'=>'list']);


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
                    ['name'=>'header_logow','col'=> 12, 'title'=>'لوگو صفحه نخست', 'class'=>'ltr', 'pholder'=> 'http://', 'select_img'=> true] ,
                    ['type'=>'select', 'name'=>'topmenu','title'=>'منوی هدر', 'data'=> $AllMenu ,'col'=> 12],

                    [],
                    ['name'=>'index_topic_img','col'=> 12, 'title'=>'تصویر پس زمینه پست های topics', 'class'=>'ltr', 'pholder'=> 'http://', 'select_img'=> true] ,

                ],
            ],
        ],
    ],
    //------------------------------------
    'box1'=>['name'=>'box1' , 'title'=>'نخست  - اسلایدر ', 
        'submenu'=>[
            [
                'title'=>'بخش متنی',
                'fields'=>[
                    ['name'=>'bx1_title', 'title'=>'عنوان', 'col'=> 12] ,
                    ['name'=>'bx1_title2', 'title'=>'عنوان 2', 'col'=> 12] ,
                    ['name'=>'b1_desc', 'title'=>'توضیحات','type'=>'textarea', 'col'=> 12],
                    [],
                    ['name'=>'b1_linkt', 'title'=>'عنوان لینک 1', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 6] ,
                    ['name'=>'b1_link', 'title'=>'لینک مقصد', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 6] ,
                    [],
                    ['name'=>'b2_linkt', 'title'=>'عنوان لینک 2', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 6] ,
                    ['name'=>'b2_link', 'title'=>'لینک مقصد', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 6] ,
                    
                    
                ]
            ],
            [
                'title'=>'بخش اسلایدر',
                'repeat'=>true,
                'fields'=>[
                    ['name'=>'bx1_sltitle', 'title'=>'عنوان', 'col'=> 12] ,
                    ['name'=>'bx1_sldesc', 'title'=>'عنوان', 'col'=> 12] ,
                    ['name'=>'bx1_slimg', 'title'=>'آدرس تصویر', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 6, 'select_img'=> true] ,
                    ['name'=>'bx1_sllink', 'title'=>'لینک مقصد', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 6] ,
                    
                ]
            ],
        ],
    ],
    //-----------------------------------
    'box2'=>['name'=>'box2' , 'title'=>'نخست - جمع سپاری ', 
        'submenu'=>[
            [
                'title'=>'-',
                'fields'=>[
                    ['name'=>'bx2_title', 'title'=>'عنوان باکس', 'col'=> 12] ,
                    ['name'=>'bx2_desc', 'title'=>'توضیحات باکس', 'col'=> 12] ,
                    [],
                    ['name'=>'bx2_linkt', 'title'=>'عنوان لینک 1', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 6] ,
                    ['name'=>'bx2_link', 'title'=>'لینک مقصد', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 6] ,
                    [],
                    ['name'=>'bx2_posts', 'title'=>'انتخاب از لیست جمع سپاریها', 
                        'multiple'=>'multiple',
                        'class'=>'select2',
                        'col'=> 12,'type'=>'select','data'=> 
                        \Cake\ORM\tableregistry::getTableLocator()
                            ->get('Challenge.Challenges')
                            ->find('list',['keyField'=>'id','valueField'=>'title'])
                            ->where(['Challenges.enable'=>1])
                            ->order(['Challenges.priority'=>'asc'])
                            ->toarray()] ,

                ]
            ],
            /* [
                'repeat'=>true,
                'title'=>'لیست گزینه ها',
                'fields'=>[
                    ['name'=>'bx2ac_title', 'title'=>'عنوان', 'col'=> 12] ,
                    ['name'=>'bx2ac_desc', 'title'=>'توضیحات', 'col'=> 12,'type'=>'textarea'] ,
                    ['name'=>'bx2ac_linkt', 'title'=>'عنوان لینک مقصد', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 6] ,
                    ['name'=>'bx2ac_link', 'title'=>'لینک مقصد', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 6] ,
                    ['name'=>'bx2ac_icimg', 'title'=>'آدرس تصویر', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 12, 'select_img'=> true] ,
                ]
            ], */
        ],
    ],
    //-----------------------------------
    'box3'=>['name'=>'box3' , 'title'=>'نخست - گام مشارکت', 
        'submenu'=>[
            [
                'title'=>'-',
                'fields'=>[
                    ['name'=>'bx3_title', 'title'=>'عنوان باکس', 'col'=> 12] ,
                    ['name'=>'bx3_desc', 'title'=>'توضیحات باکس', 'col'=> 12] ,
                    [],
                    ['name'=>'bx3_linkt', 'title'=>'عنوان لینک 1', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 6] ,
                    ['name'=>'bx3_link', 'title'=>'لینک مقصد', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 6] ,
                ]
            ],
            [
                'repeat'=>true,
                'title'=>'لیست گزینه ها',
                'fields'=>[
                    ['name'=>'bxx3_num', 'title'=>'عدد', 'col'=> 3] ,
                    ['name'=>'bxx3_title', 'title'=>'عنوان', 'col'=> 3] ,
                    ['name'=>'bxx3_desc', 'title'=>'توضیحات', 'col'=> 6] ,
                    ['name'=>'bxx3_img', 'title'=>'لینک تصویر (سفید)', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 6, 'select_img'=> true] ,
                    ['name'=>'bxx3_img2', 'title'=>'لینک تصویر هاور', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 6, 'select_img'=> true] ,
                    //['name'=>'bxx3_link', 'title'=>'لینک مقصد', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 6] ,
                ]
            ],

        ],
    ],
    //------------------------------------
    'box5'=>['name'=>'box5' , 'title'=>'نخست -  پایگاه دانشی - تب ', 
        'submenu'=>[
            [
                'title'=>'-',
                'fields'=>[
                    ['name'=>'bx5_title', 'title'=>'عنوان باکس', 'col'=> 12] ,
                    ['name'=>'bx5_desc', 'title'=>'توضیحات باکس', 'col'=> 12] ,
                    [],
                    ['name'=>'bx5_linkt', 'title'=>'عنوان لینک', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 6] ,
                    ['name'=>'bx5_link', 'title'=>'لینک مقصد', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 6] ,

                ]
            ],
            [
                'repeat'=>true,
                'title'=>'لیست تب ها',
                'fields'=>[
                    ['name'=>'bx5t_tab_title', 'title'=>'عنوان تب', 'col'=> 12] ,

                    ['name'=>'bx5t_post1', 'title'=>'انتخاب knowledge راست', 'col'=> 6,'type'=>'select','data'=> $knowledge] ,
                    ['name'=>'bx5t_image1', 'title'=>'انتخاب تصویر راست', 'col'=> 6, 'pholder'=>'http://', 'class'=>'ltr', 'select_img'=> true] ,

                    ['name'=>'bx5t_posts', 'title'=>'انتخاب knowledge چپ', 
                        'multiple'=>'multiple',
                        'class'=>'select2',
                        'col'=> 12,'type'=>'select','data'=> $knowledge] ,

                    ['name'=>'bx5t_posts_topic', 'title'=>'انتخاب Topics چپ', 
                        'multiple'=>'multiple',
                        'class'=>'select2',
                        'col'=> 12,'type'=>'select','data'=> $topics] ,
                ]
            ],

        ],
    ],
    //------------------------------------
    'box6'=>['name'=>'box6' , 'title'=>'نخست - مولتی مدیا ', 
        'submenu'=>[
            [
                'title'=>'-',
                'fields'=>[
                    ['name'=>'bx6_title1', 'title'=>'عنوان اصلی 1', 'col'=> 12] ,
                    ['name'=>'bx6_title2', 'title'=>'زیرعنوان 1', 'col'=> 12] ,
                    [],

                    ['name'=>'bx6_linkt', 'title'=>'عنوان لینک', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 6] ,
                    ['name'=>'bx6_link', 'title'=>'لینک مقصد', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 6] ,
                    [],

                    ['name'=>'bx6_ttitle1', 'title'=>'عنوان اصلی 2', 'col'=> 12] ,
                    ['name'=>'bx6_ttitle2', 'title'=>'زیرعنوان 2', 'col'=> 12,'type'=>'textarea'] ,
                    [],

                    ['name'=>'bx6_film', 'title'=>'آدرس فیلم', 'col'=> 12, 'pholder'=>'http://', 'class'=>'ltr', 'select_img'=> true] ,
                    ['name'=>'bx6_filmc', 'title'=>'تصویر کاور فیلم', 'col'=> 12, 'pholder'=>'http://', 'class'=>'ltr', 'select_img'=> true] ,
                    [],
                ]
            ],
            [
                'repeat'=>true,
                'title'=>'لیست پست ها',
                'fields'=>[
                    ['name'=>'bxx6_title', 'title'=>'عنوان', 'col'=> 12] ,
                    ['name'=>'bxx6_desc', 'title'=>'توضیحات متنی', 'col'=> 12] ,
                    ['name'=>'bxx6_image', 'title'=>'تصویر', 'col'=> 6, 'pholder'=>'http://', 'class'=>'ltr', 'select_img'=> true] ,
                    ['name'=>'bxx6_link', 'title'=>'لینک مقصد', 'col'=> 6, 'pholder'=>'http://', 'class'=>'ltr'] ,

                ]
            ],
        ],
    ],
    //------------------------------------
    'box7'=>['name'=>'box7' , 'title'=>'نخست - متنی ', 
        'submenu'=>[
            [
                'title'=>'-',
                'fields'=>[
                    ['name'=>'bx7_title', 'title'=>'عنوان باکس', 'col'=> 12] ,
                    ['name'=>'bx7_desc', 'title'=>'توضیحات متنی باکس', 'col'=> 12,'type'=>'textarea'] ,
                    ['name'=>'bx7_image', 'title'=>'تصویر', 'col'=> 6, 'pholder'=>'http://', 'class'=>'ltr', 'select_img'=> true] ,

                ]
            ],
        ],
    ],
    //------------------------------------

    'sidebar'=>['name'=>'sidebar' , 'title'=>'سایدبار کناری', 
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
    ],
    //------------------------------------
    'footer'=>['name'=>'footer' , 'title'=>'فوتر', 
        'submenu'=>[
            [
                'title'=>'اصلی',
                'fields'=>[
                    ['name'=>'footer_title1', 'title'=>'عنوان فوتر 1', 'col'=> 6],
                    ['name'=>'footer_title2', 'title'=>'عنوان فوتر 2', 'col'=> 6],
                    ['name'=>'footer_desc', 'title'=>'توضیحات فوتر', 'col'=> 12,'type'=>'textarea'],
                    [],
                    ['break'=>'انتخاب منو'],
                    ['type'=>'text', 'name'=>'footer_menut1','title'=>'عنوان منو فوتر 1', 'col'=> 6],
                    ['type'=>'select', 'name'=>'footer_menu1','title'=>'منوی فوتر', 'data'=> $AllMenu ,'col'=> 6],

                    ['type'=>'text', 'name'=>'footer_menut2','title'=>'عنوان منو فوتر 2', 'col'=> 6],
                    ['type'=>'select', 'name'=>'footer_menu2','title'=>'منوی فوتر', 'data'=> $AllMenu ,'col'=> 6],
                ],
            ],
            [
                'title'=>'اسلایدر فوتر',
                'repeat'=>true,
                'fields'=>[
                    ['name'=>'footer_slide_title', 'title'=>'عنوان تصویر', 'col'=> 12],
                    ['name'=>'footer_slide_image', 'title'=>'آدرس تصویر','pholder'=> 'http://', 'class'=>'ltr', 'col'=> 12],
                ],
            ],
            [
                'title'=>'شبکه اجتماعی',
                'fields'=>[
                    ['name'=>'footer_soc_insta', 'title'=>'لینک اینستاگرام','pholder'=> 'http://', 'class'=>'ltr', 'col'=> 12],
                    ['name'=>'footer_soc_twitt', 'title'=>'لینک توییتر','pholder'=> 'http://', 'class'=>'ltr', 'col'=> 12],
                    ['name'=>'footer_soc_faceb', 'title'=>'لینک فیسبوک','pholder'=> 'http://', 'class'=>'ltr', 'col'=> 12],
                    ['name'=>'footer_soc_teleg', 'title'=>'لینک','pholder'=> 'http://', 'class'=>'ltr', 'col'=> 12],
                    ['name'=>'footer_soc_linked', 'title'=>'لینک لینکدین','pholder'=> 'http://', 'class'=>'ltr', 'col'=> 12],
                    ['name'=>'footer_soc_aprt', 'title'=>'لینک','pholder'=> 'http://', 'class'=>'ltr', 'col'=> 7],
                ],
            ],
            /* [
                'title'=>'کپی رایت',
                'fields'=>[
                    ['name'=>'footer_copyt', 'title'=>'متن کپی رایت', 'col'=> 12 ] ,
                    //['name'=>'footer_img', 'title'=>'تصویر فوتر', 'pholder'=>'http://', 'class'=>'ltr', 'col'=> 12, 'select_img'=> true] ,
                    //['type'=>'select', 'name'=>'footer_cpmenu','title'=>'منو کپی رایت', 'data'=> $AllMenu ,'col'=> 4],
                    
                ],
            ], */
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