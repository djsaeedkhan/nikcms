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
                            ['name'=>'PostMetas.en_title','fname'=>'en_title','col'=> 12, 'title'=>'عنوان انگلیسی ','class'=>'ltr'] ,
                            [],
                            
                            ['name'=>'PostMetas.author','fname'=>'author','col'=> 12, 'title'=>'ناشر'] ,
                            [],

                            ['name'=>'PostMetas.disciplines',
                                'fname'=>'disciplines',
                                'col'=> 12,
                                'multiple'=>'multiple',
                                'title'=>'انتخاب رشته',
                                'class'=>'select2',
                                'type'=>'select',
                                'data'=>$this->Query->post("disciplines",['field'=>['id','title'],'limit'=>0, 'find_type'=>'list'])
                            ],

                            [],
                            ['break'=>'فیلد ها'],
                            ['name'=>'PostMetas.field_title1','fname'=>'field_title1','col'=> 6, 'title'=>'عنوان فیلد 1'] ,
                            ['name'=>'PostMetas.field_text1','fname'=>'field_text1','col'=> 6, 'title'=>'متن فیلد'] ,

                            ['name'=>'PostMetas.field_title2','fname'=>'field_title2','col'=> 6, 'title'=>'عنوان فیلد 2'] ,
                            ['name'=>'PostMetas.field_text2','fname'=>'field_text2','col'=> 6, 'title'=>'متن فیلد'] ,

                            ['name'=>'PostMetas.field_title3','fname'=>'field_title3','col'=> 6, 'title'=>'عنوان فیلد 3'] ,
                            ['name'=>'PostMetas.field_text3','fname'=>'field_text3','col'=> 6, 'title'=>'متن فیلد'] ,

                            ['name'=>'PostMetas.field_title4','fname'=>'field_title4','col'=> 6, 'title'=>'عنوان فیلد 4'] ,
                            ['name'=>'PostMetas.field_text4','fname'=>'field_text4','col'=> 6, 'title'=>'متن فیلد'] ,
                        
                        ]
                    ],
                ],
            ],

            'asection'=>[
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
                                'ids'=>'edittextarea1'
                                ] ,
                            [],

                            ['name'=>'PostMetas.section_title2','fname'=>'section_title2','col'=> 12, 'title'=>'عنوان سکشن 2'] ,
                            ['name'=>'PostMetas.section_text2','fname'=>'section_text2','col'=> 12, 'title'=>'متن سکشن (*)',
                                'style'=>'height:300px;',
                                'type'=>'textarea',
                                'ids'=>'edittextarea2'] ,
                            [],

                            ['name'=>'PostMetas.section_title3','fname'=>'section_title3','col'=> 12, 'title'=>'عنوان سکشن 3'] ,
                            ['name'=>'PostMetas.section_text3','fname'=>'section_text3','col'=> 12, 'title'=>'متن سکشن (*)',
                                'style'=>'height:300px;',
                                'type'=>'textarea',
                                'ids'=>'edittextarea3'] ,
                            [],

                            ['name'=>'PostMetas.section_title4','fname'=>'section_title4','col'=> 12, 'title'=>'عنوان سکشن 4'] ,
                            ['name'=>'PostMetas.section_text4','fname'=>'section_text4','col'=> 12, 'title'=>'متن سکشن (*)',
                                'style'=>'height:300px;',
                                'type'=>'textarea',
                                'ids'=>'edittextarea4'] ,
                            [],

                            ['name'=>'PostMetas.section_title5','fname'=>'section_title5','col'=> 12, 'title'=>'عنوان سکشن 5'] ,
                            ['name'=>'PostMetas.section_text5','fname'=>'section_text5','col'=> 12, 'title'=>'متن سکشن (*)',
                                'style'=>'height:300px;',
                                'type'=>'textarea',
                                'ids'=>'edittextarea5'] ,
                        ]
                    ],
                ],
            ],


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

            'social'=>[
                'name'=>'social' , 
                'title'=>'اجتماعی', 
                'submenu'=>[
                    [
                        'title'=>'',
                        'fields'=> include_once("_boxsocial.php")
                    ],
                ],
            ],

        ]
    ],
    /* 'item2'=>[
        'title'=>'گالری تصاویر',
        'sublevel'=>[
            'boxx3'=>[
                'name'=>'boxx3' ,
                'title'=>'گالری تصاویر', 
                'submenu'=> include_once('_sub_gallery.php'),
            ],
        ]
    ], */
];
echo $this->cell('Admin.Formplus',[$menu,$post_meta_list]);
?>