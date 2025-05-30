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

                            ['name'=>'PostMetas.scholars_name','fname'=>'scholars_name','col'=> 12, 'title'=>'پدیدآورندگان'] ,
                            [],
                            
                            ['name'=>'PostMetas.country','fname'=>'country','col'=> 12, 'title'=>'عنوان کشور '] ,
                            [],

                            ['name'=>'PostMetas.topics',
                                'fname'=>'topics',
                                'col'=> 12,
                                'title'=>' موضوعات مرتبط',
                                'class'=>'select2',
                                'multiple'=>'multiple',
                                'type'=>'select',
                                'data'=>$this->Query->post("topics",['field'=>['id','title'],'limit'=>0, 'find_type'=>'list'])
                            ],
                            [],
                            
                            ['name'=>'PostMetas.author_label','fname'=>'author_label','col'=> 6, 'title'=>'لیبل ناشر'] ,
                            ['name'=>'PostMetas.author','fname'=>'author','col'=> 6, 'title'=>'ناشر'] ,
                            ['name'=>'PostMetas.year_label','fname'=>'year_label','col'=> 6, 'title'=>'لیبل سال'] ,
                            ['name'=>'PostMetas.year','fname'=>'year','col'=> 6, 'id'=>'pdpGregorian', 'title'=>'سال نشر','class'=>'ltr'] ,
                            [],                          

                        ]
                    ],
                ],
            ],

            'about'=>[
                'name'=>'about' , 
                'title'=>'درباره نویسنده', 
                'submenu'=>[
                    [
                        'title'=>'',
                        'fields'=>[
                            ['name'=>'PostMetas.author_name','fname'=>'author_name','col'=> 7, 'title'=>'عنوان ','class'=>'ltr'] ,
                            ['name'=>'PostMetas.author_pos','fname'=>'author_pos','col'=> 5, 'title'=>'سِمت'] ,
                            [],
                            ['name'=>'PostMetas.author_desc','fname'=>'author_desc','col'=> 12, 
                                'id'=>'edittextarea1',
                                'title'=>'توضیحات متنی','type'=>'textarea'] ,
                            [],
                            ['name'=>'PostMetas.author_image','fname'=>'author_image','col'=> 12, 
                            'title'=>'تصویر شخص', 'pholder'=>'https://','class'=>'ltr', 'select_img'=> true,]

                        ]
                    ],
                ],
            ],

            
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

            'sections'=>[
                'name'=>'sections' , 
                'title'=>'سکشن متنی', 
                'submenu'=>[
                    [
                        'title'=>'',
                        'fields'=>[
                            ['name'=>'PostMetas.data_title1','fname'=>'data_title1','col'=> 12, 'title'=>'عنوان سکشن 1'],
                            ['name'=>'PostMetas.data_text1','fname'=>'data_text1','col'=> 12,'style'=>'min-height:400px;min-height:400px', 'title'=>' ','type'=>'textarea', 'id'=>'edittextarea2'],
                            [],

                            ['name'=>'PostMetas.data_title2','fname'=>'data_title2','col'=> 12, 'title'=>'عنوان سکشن 2'],
                            ['name'=>'PostMetas.data_text2','fname'=>'data_text2','col'=> 12, 'title'=>' ','type'=>'textarea', 'id'=>'edittextarea3'],
                            [],

                            ['name'=>'PostMetas.data_title3','fname'=>'data_title3','col'=> 12, 'title'=>'عنوان سکشن 3'],
                            ['name'=>'PostMetas.data_text3','fname'=>'data_text3','col'=> 12, 'title'=>' ','type'=>'textarea', 'id'=>'edittextarea4'],
                            [],


                            ['name'=>'PostMetas.data_title4','fname'=>'data_title4','col'=> 12, 'title'=>'عنوان سکشن 4'],
                            ['name'=>'PostMetas.data_text4','fname'=>'data_text4','col'=> 12, 'title'=>' ','type'=>'textarea', 'id'=>'edittextarea5'],
                            [],


                            ['name'=>'PostMetas.data_title5','fname'=>'data_title5','col'=> 12, 'title'=>'عنوان سکشن 5'],
                            ['name'=>'PostMetas.data_text5','fname'=>'data_text5','col'=> 12, 'title'=>' ','type'=>'textarea', 'id'=>'edittextarea6'],
                            [],


                            ['name'=>'PostMetas.data_title6','fname'=>'data_title6','col'=> 12, 'title'=>'عنوان سکشن 6'],
                            ['name'=>'PostMetas.data_text6','fname'=>'data_text6','col'=> 12, 'title'=>' ','type'=>'textarea', 'id'=>'edittextarea7'],
                            [],


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
<style>
#msections-0 div.mce-edit-area {
    min-height: 300px !important;
}
#msections-0 div.mce-edit-area iframe{
    min-height: 300px !important;
}
</style>