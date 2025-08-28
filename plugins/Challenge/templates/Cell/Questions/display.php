<?php
use Admin\View\Helper\QueryHelper;
use Cake\Routing\Router;
use Cake\View\Helper\FormHelper;
use Cake\View\View;
use Cake\View\Helper\HtmlHelper;
use Challenge\Predata;
$predata = new Predata();
?>

<!-- <h3><?=isset($challenge['title'])?
        $this->html->link($challenge['title'],['controller'=>'admin','action'=>'view',$challenge['id']]):'';?></h3><hr> -->
<div class="row">
    <div class="col-sm-6">
        <h3 style="font-size:22px;letter-spacing: -0.5px;">ویرایش سوالات</h3>
        
            <div id="exa" data-children=".item">
                <?php show( $ch_id, $parentCategory); ?>
                <div>
                    <!-- <a href="<?php //Router::url(['action' => 'add', $ch_id , 0 ])?>">
                        + ثبت سوال
                    </a> -->
                    <?= $this->Html->link('+ ثبت سوال',
                        '/admin/challenge/challengequests/add/'.$ch_id.'/0',
                        ['data-toggle'=>'modal','data-target'=>'#exampleModalll',
                        'id'=>"openModal",
                        'data-whatever'=>Router::url('/admin/challenge/challengequests/add/'.$ch_id.'/0/'.'?nonav=1')]);?>
                </div>
            </div>
        
    </div>

    <div class="col-sm-6">
        <?= $this->Form->create(null,['type' => 'file']) ?>
            <h3 style="font-size:22px;letter-spacing: -0.5px;;">پیش نمایش</h3>
            <div class="box box-primary"><div class="card-body">
                <div class="mlist"></div><br>
                <?php //$this->Form->button(__('ثبت اطلاعات'));?>
            </div></div>
        <?= $this->Form->end() ?>
    </div>
</div>

<?php
function show( $ch_id = null, $parentCategory = null){ 
    global $types;
    $view = new View();
    $html = new HtmlHelper($view);
    $Query = new QueryHelper(new \Cake\View\View());
    $Form = new FormHelper(new \Cake\View\View());
    
    foreach($parentCategory as $parent):
        $count = count(($Query->category_crumb($parent->id,[
            'table' => 'Challenge.Challengequests',
            'return'=>'array' ])))?>
        <div class="box box-primary"><div class="card-body">
        <div class="item">
            <span data-toggless="collapse" data-parent="#exa" href="#exa<?= $parent->id;?>" aria-expanded="true" aria-controls="exa<?= $parent->id;?>" style="cursor:pointer">
                <?='<span class="badge badge-dark badge-pill">'.$parent->priority.'</span>'?>
                <?= ($parent->title);?>
                <?= (isset($types[$parent->types]) and !in_array($parent->types,[]) )?
                    '<span class="badge badge-warning badge-pill">'.$types[$parent->types].'</span>':''?>

                <span class="hidme d-flex">
                    <?php if(in_array($parent->types,[1, 4])):?>
                        <?= $html->link(
                        'ثبت ' . ($count%2==0?'سوال':'زیرگزینه'),
                        ['controller'=>'challengequests','action' => 'add', $ch_id, $parent->id ],
                        [
                            'data-toggle'=>'modal',
                            'data-target'=>'#exampleModalll',
                            'id'=>"openModal",
                            'data-whatever'=>Router::url(['controller'=>'challengequests', 'action' => 'add', $ch_id, $parent->id, '?'=>['nonav'=>1] ])
                        ]);?>
                    <?php endif?>

                    <?= $html->link(
                        'تغییرعنوان',
                        ['controller'=>'challengequests','action' => 'edit', $ch_id, $parent->id ],
                        [
                            'data-toggle'=>'modal',
                            'data-target'=>'#exampleModalll',
                            'id'=>"openModal",
                            'data-whatever'=>Router::url(['controller'=>'challengequests', 'action' => 'edit', $ch_id, $parent->id,'?'=>['nonav'=>1] ])
                        ]);?>

                    <a>
                        <?php
                        echo $Form->create(null,['class'=>'deletes d-flex','url'=>[
                            'plugin'=>'Challenge',
                            'controller'=>'Challengequests',
                            'action'=>'delete', $ch_id, $parent->id ]]);

                        echo $Form->control('_method',[
                            'type'=>'hidden','default'=>'POST'
                        ]);
                        echo $Form->submit('حذف',[
                            'class'=>'text-danger bg-white py-0 btn-sm delete_button border-0',
                            'confirm'=>'برای حذف مطمئن هستید؟' ]);
                        echo $Form->end();
                        ?>
                    </a>

                    <?php /* $Form->postlink('حذف',
                        ['action' => 'delete', $ch_id, $parent->id ],
                        ['confirm'=>'برای حذف مطمئن هستید؟']) */?>
                </span>
            </span>

            <?php if(in_array($parent->types,[1,4])):?>
            <div class="show1 collapse 
            <?= (isset($parent['children']) and count($parent['children']))?'show':''?>" id="exa<?= $parent->id;?>">
                <?php 
                if(isset($parent['children']) and count($parent['children'])) :
                    show($ch_id , $parent['children']);
                endif;?>
            </div>
            <?php endif;?>
        </div></div></div>
    <?php
    endforeach;
}
?>
<script nonce="<?=get_nonce?>">
$(function() {
    $(document).ready(function() {
        $(".delete_button").click(function(event) {
            if( !confirm('Are you sure that you want to submit the form') ) 
                event.preventDefault();
        });
    });
    /* $(document).on('submit','form.deletes',function(){
        if (confirm("آیا برای حذف مطمین هستید؟") == true) {
            return true;
        } else {
            e.preventDefault();
            return false;
        }
        e.preventDefault();
        return false;
        return false;
    }); */

    /* $(".delete_button").click(function(){
        if (confirm("آیا برای حذف مطمین هستید؟") == true) {
            return true
        } else {
            e.preventDefault();
            return false;
        }
        e.preventDefault();
        return false;
    }); */
});
function get_data(parent,mclass){
    var all_data;
    $.ajax({
        type : 'GET',
        async: false,
        data: 'ajax=1&parent='+parent,
        url : '<?= Router::url('/admin/challenge/challengequests/index/'.$ch_id.'?render=false&nonav=1')?>' ,
        beforeSend: function(){
            $('.'+mclass).html('درحال دریافت اطلاعات');
        },
        complete: function(){
            $('.'+mclass).html('');
        },
        success : function(data){
            all_data = data;
        },
        error:function (XMLHttpRequest, textStatus, errorThrown) {
            //alert("در دریافت اطلاعات خطایی رخ داده است");
            all_data = false;
        }
    });
    createform(all_data,mclass);
}

function createform(data,cclass){
    if (data === false){
        $('.'+cclass).html('<span class="badge badge-danger">در دریافت اطلاعات خطایی رخ داده است</span>');
        return false;
    }

    var string = '';
    var array = $.map(data, function(value, index) {
        if(value['types'] == 1){
            string += '<div class="input radio"><label><b>'+(value['title'])+'</b></label><br><div class="mquest">';

            var array = $.map(value['children'], function(value1, index1) {
                string += '<label for="fields-'+value1['id']+'" style="margin-left: 15px;">'+
                    '<input type="radio" name="radio_'+value['id']+'" value="'+value1['id']+'" id="fields-'+value1['id']+'" nonce="<?=get_nonce?>" onclick="onclicker('+"'"+value1['id']+"'"+','+"'"+'mlist'+value['id']+"'"+')" class="putt form-control1"> '+value1['title']+'</label> ';
            });
            string += '</div></div><div style1="padding-right:20px;" class="mlist'+(value['id'])+'"></div>';
        }
        
        else if(value['types'] == 2){
            string += '<br><div class="input textareaa radio"><label><b>'+value['title']+'</b></label><br>'+
                '<textarea name="textarea_'+value['id']+'" class="form-control"></textarea></div>';
        }
        
        else if(value['types'] == 3){
            string += '<br><div class="input filee radio"><label><b>'+(value['title'])+'</b></label><br>'+
            '<label><input type="file" name="file_'+value['id']+'" value="'+value['id']+'" class="form-control"></label></div>';
        }

        else if(value['types'] == 4){
            string += '<br><div class="input select selectt radio">'+
                        '<label for="eeee"><b>'+value['title']+'</b></label><br>';
            var array = $.map(value['children'], function(value1, index1) {
                string +=
                '<div class="checkbox">'+
                    '<label for="eeee-'+value1['id']+'">'+
                        '<input type="checkbox" name="check_'+value['id']+'[]" value="'+value1['id']+'" id="eeee-'+value1['id']+'"> '+value1['title']+
                    '</label>'+
                '</div>';
            });
            string += '</div>';
        }
        
        else if(value['types'] == 5){
            string += '<br><h1>'+(value['title'])+'</h1>';
        }
        else if(value['types'] == 6){
            string += '<br><h2>'+(value['title'])+'</h2>';
        }
        else if(value['types'] == 7){
            string += '<br><h3>'+(value['title'])+'</h3>';
        }
        else if(value['types'] == 8){
            string += '<br><p>'+(value['title'])+'</p>';
        }

    });
    $('.'+cclass).html(string);
}
function onclicker(a,b){
    createform(get_data(a , b));
}
get_data("no",'mlist');
</script>

<style>
    .item .card-body{
        padding: 10px;
    }
    #openModal{
        padding-right: 5px;
    }
    .text-danger.bg-white{
        padding-right: 5px !important;
    }
    .item .hidme {
        visibility: visible;
    }
    .show1{
        padding-right: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        padding-top: 10px;
        margin-bottom: 10px;
        padding-bottom: 0;
    }
    span:hover .hidme{visibility:visible;}
    .filee label{width:100%;}
    .radio{
        border: 1px solid #000;
        padding: 10px;
        margin-top:5px;
        border-radius: 10px;
    }
    .selectt .checkbox{
        display: inline;
        margin-left:20px;
    }
</style>