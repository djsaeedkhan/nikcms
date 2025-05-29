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
                        'title'=>'لیست سکشن متنی',
                        'repeat'=>true,
                        'fields'=>[
                            [
                                'name'=>'PostMetas.box2_title',
                                'fname'=>'box2_title',
                                'col'=> 12,
                                'title'=>'عنوان باکس متنی',
                            ] ,
                            [
                                'name'=>'PostMetas.box2_desc',
                                'fname'=>'box2_desc',
                                'type'=>'textarea',
                                'col'=> 12,
                                'title'=>'توضیحات مطلب',
                            ] ,

                            ['name'=>'PostMetas.box2_image','fname'=>'box2_image','col'=> 12, 
                                'title'=>'آدرس تصویر', 'pholder'=>'https://','class'=>'ltr', 'select_img'=> true,
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
            'box3'=>[
                'name'=>'box3' ,
                'title'=>'مطالب مرتبط', 
                'submenu'=>[
                    [
                        'title'=>'عنوان',
                        'fields'=>[
                            [
                                'name'=>'PostMetas.topic_title',
                                'fname'=>'topic_title',
                                'col'=> 12,
                                'title'=>'عنوان سکشن',
                            ] ,
                        ]
                    ],
                    [
                        'title'=>'لیست مطالب',
                        'repeat'=>true,
                        'fields'=>[
                            [
                                'name'=>'PostMetas.tp_title',
                                'fname'=>'tp_title',
                                'col'=> 12,
                                'title'=>'عنوان مطلب',
                            ] ,
                            [
                                'name'=>'PostMetas.tp_desc',
                                'fname'=>'tp_desc',
                                'type'=>'textarea',
                                'col'=> 12,
                                'title'=>'توضیحات مطلب',
                            ] ,

                            ['name'=>'PostMetas.tp_image','fname'=>'tp_image','col'=> 6, 
                                'title'=>'آدرس تصویر', 'pholder'=>'https://','class'=>'ltr', 'select_img'=> true,
                            ] ,

                            ['name'=>'PostMetas.tp_link','fname'=>'tp_link','col'=> 6, 
                                'title'=>'آدرس لینک مقصد', 'pholder'=>'https://','class'=>'ltr',
                            ] ,
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