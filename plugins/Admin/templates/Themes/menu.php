<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title1 float-right mb-0">
                    <?= __d('Admin', 'مدیریت فهرست ها');?>
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0"></ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card"><div class="card-body">
    <?php echo $this->Form->create(null,array('url'=>['action'=>'menu'],'type'=>'get'));?>
    <div class="row">
        <div class="col-sm-5">
            <?php echo $this->Form->control('menu', array(
                'type'=>'select',
                'options'=>$menu_list,
                'default'=>isset($menu_current_id)?$menu_current_id:'',
                'label'=>__d('Admin', 'انتخاب فهرست برای نمایش'),
                'class'=>'form-control showflex',
                'style'=>'width:200px;',
                'div'=>'form-group-sm'));?>
        </div>
        <div class="col-sm-1">
            <?php echo $this->Form->submit(
                __d('Admin', 'نمایش'),
                [
                    'type'=>'submit',
                    'label'=>false,
                    'class'=>'btn btn-primary btn-sm',
                    'div'=>'form-group-sm'
                    ]);?>
        </div>
        <div class="col-sm-3" style="padding: 5px;">
            <?= $this->Auths->link(
                __d('Admin', 'یا فهرست جدیدی بسازید'),
                ['New']);?>
        </div>
    </div>
    <?php echo $this->Form->end();?>
</div></div>

<div class="row">
    <div class="col-sm-4">
        <!--  ------------------------>
        <div id="accordion">
            <?php
            foreach((array) $this->Func->admin_navmenu() as $data1){
                foreach($data1 as $key => $data){
                    if($key !='')
                        echo $this->cell($key, [$data , $this->Module->post_type()]);
                    else
                        echo '<br><h4>'.($data[0]).'</h4>'; //create gap or title
                }
            }
            ?>
            <script nonce="<?=get_nonce?>">$('#accordion .card div:first').addClass('show');</script>
            <div class="card">
                <button class="btn btn-link text-right" data-toggle="collapse" data-target="#coll_link" aria-expanded="true" aria-controls="coll_link">
                    <?= __d('Admin', 'پیوند دلخواه')?>
                </button>
                <div id="coll_link" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        <?php 
                        if(isset($menu)) 
                            echo $this->Form->create(null,array(
                                'url'=>array('controller'=>'Theme','action'=>'SaveNavMenu',$menu)
                            ));

                        echo $this->Form->control('post_type', [
                            'type'=>'text', 
                            'label'=>__d('Admin', 'نشانی'),
                            'value'=>'http://',
                            'dir'=>'ltr',
                            'class'=>'post_type form-control']);

                        echo $this->Form->control('link', [
                            'type'=>'text', 
                            'label'=>__d('Admin', 'متن پیوند'),
                            'class'=>'link form-control']);

                        echo $this->Form->control('type', [
                            'type'=>'hidden', 
                            'default'=>'link',
                            'class'=>'type']);

                        echo '<div class="sareee"></div>';
                        //echo $this->Form->control('groups', ['type'=>'select','label'=>false,'class'=>'sareee', 'multiple'=>'checkbox','options'=>$data]);
                        echo '<br>';
                        echo $this->Form->submit(
                            __d('Admin', 'افزودن به لیست'),
                            array('type'=>'submit','label'=>false,'class'=>'pull-left linker btn btn-sm btn-primary mb-2',));
                        
                            echo $this->Form->end();
                        ?>
                    </div>
                </div>
            </div>
            
        </div> 
        <!--  ------------------------>
    </div>
    <div class="col-sm-8">
        <?php echo $this->Form->create(null);?>
        <?php $this->Form->unlockField('nav');?>
        <div class="card"><div class="card-body">
            <div class="row">
            <div class="col-sm-6">
                <?= $this->Form->control('id',[
                    'type'=>'hidden',
                    'value'=>isset($menu_current['id'])?$menu_current['id']:false
                ]);?>

                <?= $this->Form->control('name',[
                    'type'=>'text',
                    'label'=>__d('Admin', 'نام فهرست').': ',
                    'required',
                    'value'=>isset($menu_current['name'])?$menu_current['name']:false,
                    'class'=>'form-control showflex']);?>
            </div>
            <div class="col-sm-6">
                <?= $this->Form->submit(
                    !isset($new_menu)?'ذخیره فهرست':'ساخت فهرست',
                    ['type'=>'submit','label'=>false,'class'=>'btn btn-primary btn-sm pull-left']);?>
            </div>
            <?php //echo $this->Form->control("id", ['type'=>'text','default'=>'']);?>
	        </div>
            <div class="clearfix"></div><bR><br>
        
        <div class="rt1l">
            <!- ---------------------------- ->
            <?php if(!isset($new_menu)):
            $menu_data = isset($menu_current['value'])?unserialize($menu_current['value']):false;
            $menu_level = isset($menu_data['serial'])?json_decode($menu_data['serial'],true):false;
            ?>
            <div class="body">
            <div class="dd nestable-with-handle">

                <!-- level 1 ----------------------------------------------------------------->
                <ol class="dd-list dd-list-one">
                <?php if(($menu_level)):foreach($menu_level as $value1):$i=$value1['id'];?>
                    <li class="dd-item dd3-item" data-id="<?= $i;?>">
                        <span class="dnode"><i data-feather="trash-2"></i></span>
                        <?php echo $this->element('Admin.menu_builder',['i'=>$i,'menu_data'=>$menu_data]);?>
                        
                        <!-- level 2 ----------------------------------------------------------------->
                        <?php if(isset($value1['children']) and count($value1['children'])):?>
                        <ol class="dd-list">    
                            <?php foreach($value1['children'] as $value2):$i=$value2['id'];?>    
                            <li class="dd-item dd3-item" data-id="<?= $i;?>">
                                <span class="dnode"><i data-feather="trash-2"></i></span>
                                <?php echo $this->element('Admin.menu_builder',['i'=>$i,'menu_data'=>$menu_data]);?>

                                <!-- level 3----------------------------------------------------------------->
                                <?php if(isset($value2['children']) and count($value2['children'])):?>
                                <ol class="dd-list">    
                                    <?php foreach($value2['children'] as $value3):$i=$value3['id'];?>    
                                    <li class="dd-item dd3-item" data-id="<?= $i;?>"><span class="dnode"><i data-feather="trash-2"></i></span>
                                        <?php echo $this->element('Admin.menu_builder',['i'=>$i,'menu_data'=>$menu_data]);?>

                                        <!-- level 4 ----------------------------------------------------------------->
                                        <?php if(isset($value3['children']) and count($value3['children'])):?>
                                        <ol class="dd-list">    
                                            <?php foreach($value3['children'] as $value4):$i=$value4['id'];?>    
                                            <li class="dd-item dd3-item" data-id="<?= $i;?>">
                                                <span class="dnode"><i data-feather="trash-2"></i></span>
                                                <?php echo $this->element('Admin.menu_builder',['i'=>$i,'menu_data'=>$menu_data]);?>
                                            </li><?php endforeach;?>
                                            
                                        </ol><?php endif;?><!-- end-level-4 -->
                                        
                                    </li><?php endforeach;?>
                                    
                                </ol><?php endif;?><!-- end-level-3 -->
                                
                            </li><?php endforeach;?>
                            
                        </ol><?php endif;?><!-- end-level-2 -->
                        
                    </li><?php endforeach;endif;?>
                
                </ol><!-- end-level-1 -->
            </div>
            <?php echo $this->Form->control("data.serial", [
                'type'=>'textarea',
                'class'=>'d-none no-resiz',
                'label'=>false,
                'default'=>isset($menu_data['serial'])?$menu_data['serial']:null]);?>

            <div class="clearfix"></div>
            <?php echo isset($menu_current['id'])?$this->Auths->link(
                __d('Admin', 'حذف فهرست'),
                ['delete'=>$menu_current['id']],
                [
                    'confirm'=>__d('Admin', 'Are U sure to delete ?'),
                    'style'=>'color:#F00',
                    'class'=>'btn btn-default btn-sm pull-left'
                ]) : false;?>
            <div class="clearfix"></div>

            </div>
            <?php else:?>
                <div class="alert alert-info">
                    <?= __d('Admin', 'لطفا عنوان فهرست را وارد کرده و سپس کلید "ساخت فهرست" را بزنید')?>
                </div>
            <?php endif;?>
            <!- ---------------------------- ->
        </div>
        </div></div>
    </div>
</div>
<?php echo $this->Form->end();?>

<script nonce="<?=get_nonce?>">
function new_get_text(pos,post_type,text,type,id,link){
    return ''+ 
    '<li class="dd-item dd3-item" data-id="'+pos+'">' +
        '<span class="dnode"><i data-feather="trash-2"></i></span>' +
        '<div class="dd-handle dd3-handle"></div>' +
        '<div class="dd3-content colorFFF">' +
            '<a class="text-right" href="#" data-toggle="collapse" data-target="#item_'+pos+'" aria-expanded="true" aria-controls="item_'+pos+'">' +
                '<span class="d-none"><?= __d('Admin', 'عنوان')?>: </span><span class="title_span">'+text+'</span>' +
            '</a>' +
            '<div id="item_'+pos+'" class="collapse">' +
                '<input type="hidden" name="data['+pos+'][id]" id="data-'+pos+'-id" value="'+id+'">' +
                '<div class="input text">' +
                    '<label for="data-'+pos+'-title"><?= __d('Admin', 'عنوان')?></label>' +
                    '<input type="text" name="data['+pos+'][title]" id="data-'+pos+'-title" class="form-control d-title mb-1" value="'+text+'">' +
                '</div>' +
                '<div class="input text">' +
                    '<label for="data-'+pos+'-title"><?= __d('Admin', 'آدرس پیوند (لینک)')?></label>' +
                    '<input type="text" name="data['+pos+'][link]" id="data-'+pos+'-link" value="'+link+'" class="form-control">' +
                '</div>' +
                '<input type="hidden" name="data['+pos+'][type]" id="data-'+pos+'-type" value="'+type+'">' +
                '<input type="hidden" name="data['+pos+'][post_type]" id="data-'+pos+'-post_type" value="'+post_type+'">' +
            '</div>' +
        '</div>' +                        
    '</li>';
}
count_id = 1;
$(".mihaan").click(function(){
    var $this = $(this).parent().parent();
    $(this).parent().parent().parent().find('input[type=checkbox]').each(function() {    
        if ($(this).is(":checked")) {
            var text = $(this).parent().text();
            var type = $(this).parent().parent().parent().parent().find('.type').val();
            var post_type = $(this).parent().parent().parent().parent().find('.post_type').val();
            var id = $(this).attr('value');
            $(this).prop('checked', false);
            $('.dd-list li').each(function(){
                var dataLayer = $(this).data('id');
                if(dataLayer >=  count_id)    
                    count_id = dataLayer + 1;
            });
            $(".dd-list-one").append(new_get_text(count_id,post_type,text,type,id,'')).children(':last').hide().fadeIn(500);
            create_new_dd_json();
        }
    });
});
$(".linker").click(function(){
    var $this = $(this).parent();
    var text = $(this).parent().text();
    var post_type = $(this).parent().parent().parent().parent().find('.post_type').val();
    var link = $(this).parent().parent().parent().parent().find('.link').val();
    if(link ==''){
        alert('<?= __d('Admin', 'متن پیوند نمیتواند خالی باشد')?>');
        return ;
    }
    var type = $(this).parent().parent().parent().parent().find('.type').val();
    var id = $(this).attr('value');
    $(this).prop('checked', false);
    $('.dd-list li').each(function(){
        var dataLayer = $(this).data('id');
        if(dataLayer >=  count_id) count_id = dataLayer + 1;
    });
    $(".dd-list-one").append(new_get_text(count_id,text,link,type,'0',post_type)).children(':last').hide().fadeIn(500);
    create_new_dd_json();

    $(this).parent().parent().parent().parent().find('.post_type').val('http://') ;
    $(this).parent().parent().parent().parent().find('.link').val('');
})
</script>
<script nonce="<?=get_nonce?>">
function create_new_dd_json(){    
    var $this = $('.dd');
    var serializedData = window.JSON.stringify($($this).nestable('serialize'));
    $this.parents('div.body').find('textarea').val(serializedData);
}
$("li .dnode").click(function(e) {
    e.preventDefault();
    if (confirm("<?= __d('Admin', 'همه منو و زیر منوها حذف خواهند شد. برای حذف مطمئن هستید؟')?>") == true) {
        $(this).parent().remove();
    } 
    create_new_dd_json();
});
$('input').on('input', function() {
    if($(this).hasClass('d-title')){
        $(this).parent().parent().parent().find('a span').text($(this).val());
    }
    
});
</script>
<!- --------------------------- ->
<?php 
echo $this->Html->css(['/admin/css/jquery-nestable.css',]);
echo $this->Html->script(['/admin/js/jquery.nestable.js','/admin/js/sortable-nestable.js'],['nonce'=>get_nonce]);
?>
<style>
.rtl{direction:rtl}
.rtl .dd3-handle{left:auto;right:0}
.rtl .dd3-handle::before{left:auto;right:0}
.rtl .dd3-item>button{float:right}
.rtl .full .rs-bar,.rtl .half.left .rs-bar,.rtl .half.right .rs-bar{left:0}
.rtl .rs-handle{float:right}
.rtl div.dataTables_wrapper div.dataTables_filter input{margin-left:0;margin-right:0.5em}
.showflex{display: initial;width: initial;}
.colorFFF{background:#dbdbde;}
.dd-handle:hover {color: #2ea8e5;background:inherit;}
.dd3-content a, #accordion button{color:#000;}
.checkbox label input{margin-left: 6px;}
.checkbox label{margin: 0 !important;}
.dnode{float: right;margin-top: 11px;padding: 0 10px 0 5px;cursor:pointer;}
.dnode:hover{color:#F00;}
#accordion2 {padding:10px;}
#accordion .card{margin: 0 0 6px 0 !important;padding: 2px;}
#accordion .list_data{max-height:230px;overflow:auto;}
</style>