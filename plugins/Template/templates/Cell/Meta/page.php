<?php 
$this->Func->getSiteSetting();
global $post_type;
global $maxrow;
$maxrow = 10;
$menu = [
    'item1'=>[
        'title'=>'مشخصات زمینه ای',
        'sublevel'=>[
            'primary'=>[
                'name'=>'primary' , 
                'title'=>'اصلی', 
                'submenu'=>[
                    [
                        'title'=>'',
                        'fields'=>[
                            [
                                'name'=>'PostMetas.menu_id',
                                'fname'=>'menu_id',
                                'col'=> 12,
                                'type'=>'select',
                                'data'=>$this->Func->AllMenu(),
                                'title'=>'انتخاب منو نمایشی',
                            ] ,
                        ]
                    ],
                ],
            ],
        ]
    ],

    'item2'=>[
        'title'=>'فیلدهای بیشتر',
        'sublevel'=>[

            'video'=>[
                'name'=>'video' , 
                'title'=>'ویدئو', 
                'submenu'=>[
                    [
                        'title'=>'',
                        'fields'=>[
                            ['name'=>'PostMetas.video_src','fname'=>'video_src','col'=> 12, 'title'=>'آدرس ویدئو', 
                                'pholder'=>'https://','class'=>'ltr', 'select_img'=> true,],
                            ['name'=>'PostMetas.video_cover','fname'=>'video_cover','col'=> 12, 'title'=>'تصویر کاور', 
                                'pholder'=>'https://','class'=>'ltr', 'select_img'=> true,],
                            ['name'=>'PostMetas.video_title','fname'=>'video_title','col'=> 12, 'title'=>'عنوان ویدئو'] ,

                        ]
                    ],
                ],
            ],

            'boxx3'=>[
                'name'=>'boxx3' ,
                'title'=>'گالری تصاویر', 
                'submenu'=> include_once('_sub_gallery.php'),
            ],
        ]
    ],
];
echo $this->cell('Admin.Formplus',[$menu,$post_meta_list]);
?>