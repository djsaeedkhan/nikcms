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
                            /* ['name'=>'PostMetas.sec_title','fname'=>'sec_title','col'=> 12, 'title'=>'عنوان سکشن '] ,
                            [], */

                            ['name'=>'PostMetas.topics',
                                'fname'=>'topics',
                                'col'=> 12,
                                'title'=>'موضوعات مرتبط',
                                'class'=>'select2',
                                'multiple'=>'multiple',
                                'type'=>'select',
                                'data'=>$this->Query->post("topics",['field'=>['id','title'],'limit'=>0, 'find_type'=>'list'])
                            ],
                            [],

                            /* ['name'=>'PostMetas.scholars_name','fname'=>'scholars_name','col'=> 12, 'title'=>'پدیدآورندگان'] ,
                            [],
                            
                            ['name'=>'PostMetas.author','fname'=>'author','col'=> 6, 'title'=>'ناشر'] ,
                            ['name'=>'PostMetas.year','fname'=>'year','col'=> 6, 'id'=>'pdpGregorian', 'title'=>'سال نشر','class'=>'ltr'] */
                        ]
                    ],
                ],
            ],

            'asection'=>[
                'name'=>'asection' , 
                'title'=>'سکشن ها', 
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

            /* 'secondary'=>[
                'name'=>'secondary' , 
                'title'=>'ضمیمه', 
                'submenu'=>[
                    [
                        'title'=>'',
                        'fields'=>[
                            ['name'=>'PostMetas.sub_related','fname'=>'sub_related','col'=> 12,'id'=>'sub_related', 
                                'title'=>'موضوعات مرتبط (بنویسید و اینتر بزنید)','class'=>'mb-2'],
                            [],
                            ['name'=>'PostMetas.header_image','fname'=>'header_image','col'=> 12, 
                                'title'=>'تصویر  ساب هدر', 'pholder'=>'https://','class'=>'ltr', 'select_img'=> true,
                            ] ,
                        ]
                    ],
                ],
            ], */

            /* 'social'=>[
                'name'=>'social' , 
                'title'=>'اجتماعی', 
                'submenu'=>[
                    [
                        'title'=>'',
                        'fields'=> include_once("_boxsocial.php")
                    ],
                ],
            ], */

        ]
    ],
    'item3'=>[
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