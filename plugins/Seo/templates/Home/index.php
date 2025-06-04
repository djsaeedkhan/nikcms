<?php
use Cake\View\Helper\FormHelper;
use Cake\View\Helper\HtmlHelper;

echo $this->Form->create(null,['url'=>['plugin'=>'Admin','controller'=>'Options', 'action'=>'SaveSetting']]);
if(count($result)):
    $hsite = unserialize($result['seo_plugin']);
    $this->request = $this->request->withData('seo_plugin.setting',$hsite['setting']);
endif;

function view_form( $sm = []){
    $Form = new FormHelper(new \Cake\View\View());
    $Html = new HtmlHelper(new \Cake\View\View());

    foreach($sm as $sm):
        if(count($sm) == 0){
            echo '<div class="col-sm-12 p-2"><hr></div>';continue;
        }
        echo '<div class="mb-1 col-sm-'.( isset($sm['col'])?$sm['col']:'12' ).'">';
        echo $Form->control('seo_plugin.setting.'.$sm['name'], [
            'type'=> isset($sm['type'])? $sm['type']: 'text',
            'options'=> isset($sm['data']) ?$sm['data']: false,
            'style'=>isset($sm['select_img'])?'padding-right: 30px;':false,
            'empty'=> isset($sm['data']) ?' - ': false,
            'placeholder'=> isset($sm['pholder'])? $sm['pholder']: false,
            'label'=> isset($sm['title'])? $sm['title']: false,
            'class'=> 'form-control '. (isset($sm['class'])? $sm['class']: false ),
            'id'=> $sm['name'],
            'data-role'=> isset($sm['data-role'])?"tags-input":false,
            'escape'=>false,
        ]);
        if(isset($sm['select_img'])){
            echo '<div class="mb-3" style="margin-top: -25px;float: right;margin-right: 10px;margin-bottom: 4px !important;">'.
                $Html->link('<i data-feather="camera"></i>',false,['data-toggle'=>'modal', 'data-target'=>'#exampleModal',
                'data-action'=>'select_src', 'title'=>__d('Seo','انتخاب تصویر'), 'escape'=>false,'data-dest'=> $sm['name'],'style'=>'color:#9e9e9e']).'</div>';
        }
        echo '</div>';
    endforeach;
}
?>

<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    <?= __d('Seo', 'مدیریت سئو');?>
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0"></ol>
                </div>
            </div>
        </div>
    </div>
</div>


<section id="vertical-tabs">
    <div class="row match-height">
        <!-- Vertical Left Tabs start -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="nav-vertical">
                        <ul class="nav nav-tabs nav-left flex-column" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active show" data-toggle="tab" href="#home" role="tab" aria-controls="home" 
                                    aria-selected="true">Public</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" 
                                    aria-selected="false">Open Graph</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#messages" role="tab" aria-controls="messages" 
                                    aria-selected="false">Twitter</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#dublin" role="tab" aria-controls="dublin" 
                                    aria-selected="false">Dublin Code</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#favicon" role="tab" aria-controls="favicon" 
                                    aria-selected="false">iDevices & Retina Favicons</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#goa" role="tab" aria-controls="goa" 
                                    aria-selected="false">آمار GA داشبورد</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="home" role="tabpanel">

                                <div class="custom-control custom-switch custom-control-inline pl-1">
                                    <input type="checkbox" class="custom-control-input" name="seo_plugin[setting][autossl]" id="customSwitch1" value="1"
                                        <?= (isset($hsite['setting']['autossl']) and $hsite['setting']['autossl']==1)?'checked':''?> />
                                    <label class="custom-control-label" for="customSwitch1">Auto Http to Https</label>
                                </div>
                                <hr>

                                <?php 
                                view_form([
                                    ['name'=>'js_header', 'title'=>'کد Js بخش هدر','class'=>'ltr','type'=>'textarea'],
                                    ['name'=>'js_footer', 'title'=>'کد Js بخش فوتر','class'=>'ltr','type'=>'textarea'],
                                ]);?>
                                
                                <hr>
                                <?php 
                                /* view_form([
                                    ['name'=>'og_locale', 'title'=>'og_locale','class'=>'col-sm-4'],
                                    ['name'=>'og_type', 'title'=>'og_type','class'=>'col-sm-4'],
                                    ['name'=>'og_title', 'title'=>'og_title','class'=>'col-sm-4'],
                                    ['name'=>'og_description', 'title'=>'og_description','class'=>'col-sm-4'],
                                    ['name'=>'og_site_name', 'title'=>'og_site_name','class'=>'col-sm-4'],
                                ]); */?>
                                
                            </div>

                            <!-- <div class="tab-pane col-sm-6" id="google" role="tabpanel">
                                <?php 
                                /* view_form([
                                    ['name'=>'google_analytics', 'pholder'=>'UA-XXXX-Y','title'=>'Google Analytics','class'=>'ltr'],
                                    ['name'=>'google_tag', 'pholder'=>'GTM-XXXXXX','title'=>'Tag Manager','class'=>'ltr'],
                                ]); */?>
                            </div> -->

                            <div class="tab-pane col-sm-6" id="profile" role="tabpanel">
                                <?php 
                                view_form([
                                    ['name'=>'og_locale', 'title'=>'og_locale'],
                                    ['name'=>'og_type', 'title'=>'og_type'],
                                    ['name'=>'og_title', 'title'=>'og_title'],
                                    ['name'=>'og_description', 'title'=>'og_description'],
                                    ['name'=>'og_site_name', 'title'=>'og_site_name'],
                                ]);?>

                            </div>
                            <div class="tab-pane col-sm-6" id="messages" role="tabpanel">
                                <?php 
                                view_form([
                                    ['name'=>'twitter_image', 'title'=>'twitter_image'],
                                    ['name'=>'twitter_domain', 'title'=>'twitter_domain'],
                                    ['name'=>'twitter_site', 'title'=>'twitter_site'],
                                    ['name'=>'twitter_creator', 'title'=>'twitter_creator'],
                                    ['name'=>'twitter_url', 'title'=>'twitter_url'],
                                    ['name'=>'twitter_title', 'title'=>'twitter_title'],
                                    ['name'=>'twitter_description', 'title'=>'twitter_description'],

                                ]);?>
                            </div>
                            <div class="tab-pane col-sm-6" id="dublin" role="tabpanel">
                                <?php 
                                view_form([
                                    ['name'=>'dc_title', 'title'=>'dc_Title'],
                                    ['name'=>'dc_creator', 'title'=>'dc_Creator'],
                                    ['name'=>'dc_type', 'title'=>'dc_Type'],
                                    ['name'=>'dc_date', 'title'=>'dc_Date'],
                                    ['name'=>'dc_format', 'title'=>'dc_Format'],
                                    ['name'=>'dc_language', 'title'=>'dc_Format'],

                                ]);?>
                            </div>
                            <div class="tab-pane col-sm-6" id="favicon" role="tabpanel">
                                <?php 
                                view_form([
                                    ['name'=>'fav_default', 'title'=>'Default','select_img'=>true],
                                    ['name'=>'fav_72_72', 'title'=>'72x72','select_img'=>true],
                                    ['name'=>'fav_114_114', 'title'=>'114x114','select_img'=>true],
                                    ['name'=>'fav_144_144', 'title'=>'144x144','select_img'=>true],
                                ]);?>
                            </div>

                            <div class="tab-pane col-sm-6" id="goa" role="tabpanel">
                                <div class="custom-control custom-switch custom-control-inline pl-1">
                                    <input type="checkbox" class="custom-control-input" name="seo_plugin[setting][ga_enable]" id="ga_enable" value="1"
                                        <?= (isset($hsite['setting']['ga_enable']) and $hsite['setting']['ga_enable']==1)?'checked':''?> />
                                    <label class="custom-control-label" for="ga_enable">Enable Show Google Analytics in Dashboard</label>
                                </div><br><br>

                                <?php 
                                view_form([
                                    ['name'=>'ga_viewid', 'title'=>'View ID','class'=>'ltr'],
                                    ['name'=>'ga_key_json', 'title'=>'Key File Json','type'=>'textarea','class'=>'ltr'],
                                ]);?>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <!-- Vertical Left Tabs ends -->
    </div>
</section>
<!-- Vertical Tabs end -->

<?= $this->Form->submit('بروز رسانی',['class'=>'btn btn-success col-xs-3 mt-10'])?>

<?= $this->Form->end()?>

<?php $this->start('modal');?>
<?= $this->cell('Admin.Favorite::upload',[]);?>
<?php $this->end(); ?>