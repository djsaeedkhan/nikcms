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
                            ['name'=>'PostMetas.en_title','fname'=>'en_title','col'=> 12, 'title'=>'عنوان انگلیسی '] ,
                            [],
                            
                            ['name'=>'PostMetas.sec_title','fname'=>'sec_title','col'=> 12, 'title'=>'عنوان سکشن '] ,
                            [],

                            ['name'=>'PostMetas.organizations',
                                'fname'=>'organizations',
                                'col'=> 12,
                                'title'=>'نهاد مرتبط',
                                'class'=>'select2',
                                'multiple'=>'multiple',
                                'type'=>'select',
                                'data'=>$this->Query->post("organizations",['field'=>['id','title'],'limit'=>0, 'find_type'=>'list'])
                            ],
                            [],

                            ['name'=>'PostMetas.topics',
                                'fname'=>'topics',
                                'col'=> 12,
                                'title'=>'موضوعات',
                                'class'=>'select2',
                                'multiple'=>'multiple',
                                'type'=>'select',
                                'data'=>$this->Query->post("topics",['field'=>['id','title'],'limit'=>0, 'find_type'=>'list'])
                            ],


                            /* ['name'=>'PostMetas.scholars_name','fname'=>'scholars_name','col'=> 12, 'title'=>'پدیدآورندگان'] ,
                            [],
                            
                            ['name'=>'PostMetas.author','fname'=>'author','col'=> 6, 'title'=>'ناشر'] ,
                            ['name'=>'PostMetas.year','fname'=>'year','col'=> 6, 'id'=>'pdpGregorian', 'title'=>'سال نشر','class'=>'ltr']  */

                        ]
                    ],
                ],
            ],

            'tsection'=>[
                'name'=>'tsection' , 
                'title'=>'فیلدهای مرتبط', 
                'submenu'=>[
                    [
                        'title'=>'',
                        'fields'=>[

                            ['name'=>'PostMetas.sectab_title','fname'=>'sectab_title','col'=> 12, 'title'=>'عنوان اصلی سکشن'] ,
                            [],
                            ['break'=>'لیست تب ها'],
                            ['name'=>'PostMetas.tab_title1','fname'=>'tab_title1','col'=> 12, 'title'=>'عنوان تب دانشی ','class'=>'mb-1'] ,
                            ['name'=>'PostMetas.tb_sources',
                                'fname'=>'tb_sources',
                                'col'=> 12,
                                'title'=>'پایگاه دانشی',
                                'class'=>'select2',
                                'multiple'=>'multiple',
                                'type'=>'select',
                                'data'=>$this->Query->post("sources",['field'=>['id','title'],'limit'=>0, 'find_type'=>'list'])
                            ],
                            [],
                            ['name'=>'PostMetas.tab_title2','fname'=>'tab_title2','col'=> 12, 'title'=>'عنوان تب پایگاه داده ','class'=>'mb-1'] ,
                            ['name'=>'PostMetas.tb_data',
                                'fname'=>'tb_data',
                                'col'=> 12,
                                'title'=>'پایگاه داده',
                                'class'=>'select2',
                                'multiple'=>'multiple',
                                'type'=>'select',
                                'data'=>$this->Query->post("data",['field'=>['id','title'],'limit'=>0, 'find_type'=>'list'])
                            ],
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
                                'ids'=>'edittextarea1'] ,
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
    'item2'=>[
        'title'=>'فیلدهای مرتبط',
        'sublevel'=>[
            'boxx3'=>[
                'name'=>'boxx3' ,
                'title'=>'داشبورد داده', 
                'submenu'=>[
                    [
                        'title'=>'',
                        'fields'=>[
                            ['name'=>'PostMetas.dashboard_title','fname'=>'dashboard_title','col'=> 12, 
                                'title'=>'عنوان سکشن داشبورد (dashboard)','class'=>'mb-2',
                            ],
                            ['name'=>'PostMetas.dashboard',
                                'fname'=>'dashboard',
                                'col'=> 12,
                                'title'=>'داشبورد های مرتبط (dashboard)',
                                'class'=>'select2',
                                'multiple'=>'multiple',
                                'type'=>'select',
                                'data'=>$this->Query->post("dashboard",['field'=>['id','title'],'limit'=>0, 'find_type'=>'list'])
                            ],
                        ]
                    ],
                ],
            ],

            'boxxx3'=>[
                'name'=>'boxxx3' ,
                'title'=>'مدل مرتبط', 
                'submenu'=>[
                    [
                    'title'=>'',
                    'fields'=>[

                        ['name'=>'PostMetas.sources_title','fname'=>'sources_title','col'=> 12, 
                            'title'=>'عنوان سکشن پایگاه دانشی (sources)','class'=>'mb-2',
                        ],
                        ['name'=>'PostMetas.sources',
                            'fname'=>'sources',
                            'col'=> 12,
                            'title'=>'پایگاه دانشی مرتبط (sources)',
                            'class'=>'select2',
                            'multiple'=>'multiple',
                            'type'=>'select',
                            'data'=>$this->Query->post("sources",['field'=>['id','title'],'limit'=>0, 'find_type'=>'list'])
                        ],

                        [],
                        ['name'=>'PostMetas.data_title','fname'=>'data_title','col'=> 12, 
                            'title'=>'عنوان سکشن پایگاه داده (data)','class'=>'mb-2',
                        ],
                        ['name'=>'PostMetas.data',
                            'fname'=>'data',
                            'col'=> 12,
                            'title'=>'پایگاه داده مرتبط (data)',
                            'class'=>'select2',
                            'multiple'=>'multiple',
                            'type'=>'select',
                            'data'=>$this->Query->post("data",['field'=>['id','title'],'limit'=>0, 'find_type'=>'list'])
                        ],

                    ]
                ],
                ],
            ],
        ]
    ],
];
echo $this->cell('Admin.Formplus',[$menu,$post_meta_list]);
?>