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
                            ['name'=>'PostMetas.year','fname'=>'year','col'=> 6, 'id'=>'pdpGregorian', 'title'=>'سال نشر','class'=>'ltr']  */

                        ]
                    ],
                ],
            ],

            /* 'asection'=>[
                'name'=>'asection' , 
                'title'=>'سکشن ها', 
                'submenu'=>[
                    [
                        'title'=>'',
                        'fields'=>[
                            ['break'=>'سکشن ها'],
                            ['name'=>'PostMetas.section_title1','fname'=>'section_title1','col'=> 12, 'title'=>'عنوان سکشن 1 '] ,
                            ['name'=>'PostMetas.section_text1','fname'=>'section_text1','col'=> 12, 'title'=>'متن سکشن (*)',
                                'style'=>'height:300px;',
                                'type'=>'textarea',
                                'id'=>'edittextarea1'] ,
                            [],

                            ['name'=>'PostMetas.section_title2','fname'=>'section_title2','col'=> 12, 'title'=>'عنوان سکشن 2'] ,
                            ['name'=>'PostMetas.section_text2','fname'=>'section_text2','col'=> 12, 'title'=>'متن سکشن (*)',
                                'style'=>'height:300px;',
                                'type'=>'textarea',
                                'id'=>'edittextarea2'] ,
                            [],

                            ['name'=>'PostMetas.section_title3','fname'=>'section_title3','col'=> 12, 'title'=>'عنوان سکشن 3'] ,
                            ['name'=>'PostMetas.section_text3','fname'=>'section_text3','col'=> 12, 'title'=>'متن سکشن (*)',
                                'style'=>'height:300px;',
                                'type'=>'textarea',
                                'id'=>'edittextarea3'] ,
                            [],

                            ['name'=>'PostMetas.section_title4','fname'=>'section_title4','col'=> 12, 'title'=>'عنوان سکشن 4'] ,
                            ['name'=>'PostMetas.section_text4','fname'=>'section_text4','col'=> 12, 'title'=>'متن سکشن (*)',
                                'style'=>'height:300px;',
                                'type'=>'textarea',
                                'id'=>'edittextarea4'] ,
                            [],

                            ['name'=>'PostMetas.section_title5','fname'=>'section_title5','col'=> 12, 'title'=>'عنوان سکشن 5'] ,
                            ['name'=>'PostMetas.section_text5','fname'=>'section_text5','col'=> 12, 'title'=>'متن سکشن (*)',
                                'style'=>'height:300px;',
                                'type'=>'textarea',
                                'id'=>'edittextarea5'] ,
                        ]
                    ],
                ],
            ], */

            'secondary'=>[
                'name'=>'secondary' , 
                'title'=>'ضمیمه', 
                'submenu'=>[
                    [
                        'title'=>'',
                        'fields'=>[
                            /* ['name'=>'PostMetas.sub_related','fname'=>'sub_related','col'=> 12,'id'=>'sub_related', 
                                'title'=>'موضوعات مرتبط (بنویسید و اینتر بزنید)','class'=>'mb-2'],
                            [], */
                            ['name'=>'PostMetas.header_image','fname'=>'header_image','col'=> 12, 
                                'title'=>'تصویر  ساب هدر', 'pholder'=>'https://','class'=>'ltr', 'select_img'=> true,
                            ] ,
                        ]
                    ],
                ],
            ],

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
    'item2'=>[
        'title'=>'فیلدهای مرتبط',
        'sublevel'=>[
            'boxx3'=>[
                'name'=>'boxx3' ,
                'title'=>'', 
                'submenu'=>[
                    [
                        'title'=>'',
                        'fields'=>[
                        ]
                    ],
                ],
            ],
        ]
    ],
];
echo $this->cell('Admin.Formplus',[$menu,$post_meta_list]);
?>