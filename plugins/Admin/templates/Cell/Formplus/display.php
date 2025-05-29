<?php global $maxrow;if($maxrow == null) $maxrow = 15;?>

<div class="nav-vertical">
    <ul class="nav nav-tabs nav-justified" role="tablist">
        <?php $jj=0;foreach($menu as $kmenu => $vmnu):?>
            <li class="nav-item">
                <a href="#<?=$kmenu?>" class="nav-link <?=$jj==0?'active':''?>" data-toggle="tab" role="tab" aria-controls="<?=$kmenu?>">
                    <?= isset($vmnu['title'])?$vmnu['title']:'-'?>
                </a>
            </li>
        <?php $jj+=1;endforeach?> 
    </ul>

    <div class="tab-content">
        <?php $jj=0;foreach($menu as $kmenu => $vmnu)://foreach($vmnu['sublevel'] as $sbmenu => $sbmnu):?>
            
            <div class="tab-pane fade <?=$jj==0?'show active':''?>" id="<?=$kmenu?>" role="tabpanel" style="overflow: inherit;">
                <div class="card p-0"><div class="card-body" style="padding: 20px 10px;">
                    <?php include('display_menu.php')?>
                </div></div>
            </div>

        <?php 
        //break;endforeach;
        $jj+=1;endforeach?> 
    </div>
</div>


<!-- </div></div> -->

<script nonce="<?=get_nonce?>">
    var rows = 2;
    $(".addRow").click(function () {
        var parent = $(this).parent().parent().attr('id');
        var enable = 0;
        $("#"+parent).find("div.row").each(function(){
            if(this.className == "row rbx d-none" && enable == 0){
                $(this).removeClass('d-none');
                enable =1;
            }
        });
       
        $("#"+parent).find(".row").each(function(i){
            $(this).attr('name',"b"+i);
            $(this).find('input').each(function(j){
                let text = $(this).attr('name');
                let result = text.replace($(this).attr('id'),$(this).attr('data-id')+ i);
                $(this).attr('name',result);
            });
        });

    });

    $(".remRow").click(function () {
        var parent = $(this).parent().parent().attr('id');
        var enable = 0;
        $($("#"+parent).find("div.row").get().reverse()).each(function(){
            if(this.className == "row rbx" && enable == 0){
                $(this).addClass('d-none');
                enable =1;
                $("#"+this.id +" input").each(function() {
                    $(this).val('');
                });
            }
        });
        
        
        $("#"+parent).find(".row").each(function(i){
            $(this).attr('name',"b"+i);
            $(this).find('input').each(function(j){
                let text = $(this).attr('name');
                let result = text.replace($(this).attr('id'),$(this).attr('data-id')+ i);
                $(this).attr('name',result);
            });
        });

    });

    $(".d-me").click(function () {
        if (confirm('<?= __d('Admin', 'برای حذف این سطر مطمئن هستید؟')?>')) {
            var parent = $(this).parent().parent().attr('id');
            $(this).parent().remove();


            $("#"+parent).find(".row").each(function(i){
                $(this).attr('name',"b"+i);
                $(this).find('input').each(function(j){
                    let text = $(this).attr('name');
                    let result = text.replace($(this).attr('id'),$(this).attr('data-id')+ i);
                    $(this).attr('name',result);
                });
            });
            
        }
    });
</script>
<style>
    .nav-vertical .nav.nav-tabs.nav-left {
        margin-left: 0rem;
    }
    .nav-vertical .nav.nav-tabs .nav-item .nav-link {
        margin-bottom: 0;
        padding-right: 10px;
        padding-left: 10px;
    }
    .nav.nav-lefts .nav-item .nav-link {
        background: #FFF;
        margin-bottom: 4px !important;
        border-radius: 3px;
        margin-left: 10px;
    }
    ul.nav-lefts{
        background: #f1f1f1;
        padding: 5px 5px 0 0;
    }
    .nav-vertical .nav.nav-tabs .nav-item .nav-link:after {
        right: 78%;
        top: 20px;
    }
    .nav-tabs.nav-justified .nav-item a.nav-link.active {
        border: none;
        background: #7367F0;
        color: white;
        border-radius: 5px;
    }
    .nav-tabs.nav-justified .nav-item a.nav-link:hover {
        background: #7367f063;
    }
    .nav-tabs.nav-justified .nav-link:after{
        content:none;
    }
    .nav-tabs.nav-justified .nav-item {
        padding-right: 1px;
        padding-left: 1px;
    }

    .nav-tabs.nav-justified .nav-item a.nav-link {
        border: 1px solid #7367F0;
        border-radius: 5px;
    }
    .camerap{
        margin-top:-30px;
        float: right;
        margin-right: 10px;
    }
    hdr{
        border-top: 1px solid #EBE9F1;
        display: block;
    }
    .d-me{
        position: absolute;
        left: 0;
        margin-left: 15px;
        margin-top: -10px;
        display: none;
        cursor: pointer;
    }
    .rbx{
        border:1px solid transparent;
        padding-bottom: 10px;
        width: 100%;
    }
    .rbx:hover{
        border:1px solid #7e73ef;
        border-radius: 15px;
    }
    .rbx:hover .d-me{
        display: block;
    }
    .nav-vertical {
        overflow: inherit !important;
    }
</style>