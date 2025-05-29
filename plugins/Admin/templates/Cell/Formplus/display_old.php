<?php global $maxrow;if($maxrow == null) $maxrow = 15?>
<!-- <div class="card setting-card"><div class="card-body"> -->
<div class="nav-vertical">
        <ul class="nav nav-tabs nav-left flex-column" role="tablist">
            <?php $i=0;foreach($menu as $mnu):?>
                <li class="nav-item">
                    <a href="#<?=$mnu['name']?>" class="nav-link <?=$i==0?'active':''?>" data-toggle="tab" role="tab" aria-controls="<?=$mnu['name']?>">
                        <?=$mnu['title']?>
                    </a>
                </li>
            <?php $i+=1;endforeach?> 
        </ul>
        <div class="tab-content">
        <!- ----------------------- -->
            <?php $i=0;foreach($menu as $k1=>$mnu):?>
                
                <div class="tab-pane fade <?=$i==0?'show active':''?>" id="<?=$mnu['name']?>" role="tabpanel" style="overflow: inherit;">
                    <div class="card p-0"><div class="card-body" style="padding: 20px 10px;">

                    <div class="nav-vertical">
                        <ul class="nav nav-tabs nav-left flex-column" role="tablist">
                            <?php $j=0; foreach($mnu['submenu'] as $k2=>$sbmenu):?>
                            <li class="nav-item">
                                <?php if($sbmenu['title'] != ''):?>
                                <a href="#m<?=$k1.'-'.$k2?>" class="nav-link <?=($j==0)?'active':''?>" 
                                    data-toggle="tab" role="tab" aria-controls="m<?=$k1.'-'.$k2?>">
                                    <?=$sbmenu['title']?>
                                </a>
                                <?php endif?>
                            </li>
                            <?php $j++;endforeach;?>
                        </ul>

                        <div class="tab-content">

                            <?php $j=0; foreach($mnu['submenu'] as $k2=>$smenu): ?>
                            <div class="tab-pane fade <?=($j==0)?'show active':''?>" id="m<?=$k1.'-'.$k2?>" role="tabpanel" style="overflow: inherit;">
                                <div class="row">
                                <?php
                                if(isset($smenu['fields']) and is_array($smenu['fields']) and count($smenu) > 0):

                                    if(isset($smenu['repeat'])){
                                        echo '<div class="col-sm-12" id="repbox'.($i.$j).'"><Br>';
                                        
                                        for($rep = 0;$rep <$maxrow;$rep++):
                                            echo '<div class="row rbx'.($rep == 0?'':' d-none').'" id="'.('box'.$i.$j.$rep).'">';
                                            echo '<span class="badge badge-danger d-me">X</span>';

                                            $en = false;
                                            foreach($smenu['fields'] as $sm):
                                                $name = null;
                                                if(isset($sm['name']))
                                                    $name = $sm['name'];
                                                $sm['name'] = $name.$rep;

                                                $fname = isset($sm['fname'])?$sm['fname'].$rep:(isset($sm['name'])?$sm['name']:'');

                                                if(isset($hsite[$sm['name']]) and $hsite[$sm['name']] != '')
                                                    $en = true;

                                                if(count($sm) == 0){
                                                    echo '<div class="col-sm-12 px-1"><hdr></div>';continue;
                                                }
                                                echo '<div class="col-sm-'.( isset($sm['col'])?$sm['col']:'12' ).'">';
                                                if(isset($sm['break'])){
                                                    echo '<div><strong style="font-size:20px;">'.$sm['break'].'</strong></div><br1>';
                                                }
                                                else{
                                                    echo $this->Form->control($sm['name'], [
                                                        'type'=> isset($sm['type'])? $sm['type']: 'text',
                                                        'default'=>(isset($post_meta_list[$sm['name']])?$post_meta_list[$sm['name']]:(isset($post_meta_list[$fname])?$post_meta_list[$fname]:false)),
                                                        'options'=> isset($sm['data']) ?$sm['data']: false,
                                                        'style'=>isset($sm['select_img'])?'padding-right: 30px;':false,
                                                        'empty'=> isset($sm['data']) ?' - ': false,
                                                        'placeholder'=> isset($sm['pholder'])? $sm['pholder']: false,
                                                        'label'=> isset($sm['title'])? $sm['title']: false,
                                                        'class'=> 'form-control '. (isset($sm['class'])? $sm['class']: false ),
                                                        'id'=> isset($sm['id'])?$sm['id']:$sm['name'],
                                                        'data-id'=> $name,
                                                        'data-role'=> isset($sm['data-role'])?"tags-input":false,
                                                        'multiple' =>  isset($sm['multiple'])?"multiple":false,
                                                        'escape'=>false,
                                                    ]);
                                                    
                                                    if(isset($sm['select_img'])){
                                                        echo '<div class="mb-1 camerap">'.
                                                            $this->Html->link('<i data-feather="camera"></i>',false,['data-toggle'=>'modal', 'data-target'=>'#exampleModal',
                                                            'data-action'=>'select_src', 'title'=>'انتخاب تصویر', 'escape'=>false,'data-dest'=> $sm['name'],'style'=>'color:#9e9e9e']).'</div>';
                                                    }
                                                }
                                                if($en == true){
                                                    echo "<script nonce='".get_nonce."'>$('#box".($i.$j.$rep)."').removeClass('d-none');</script>";
                                                    $en = false;
                                                }
                                                echo '</div>';

                                            endforeach;
                                            echo '<div class="col-sm-12 bg-white"><hr></div>';
                                            echo '</div>';//row
                                        endfor;

                                        echo '<div class="col-sm-12">
                                            <button type="button" class="addRow btn btn-info" style="font-size: 20px;padding: 5px 5px 0 !important;" title="افزودن سطر جدید">+</button>
                                            <button type="button" class="remRow btn btn-danger d-none" style="font-size: 20px;padding: 5px 7px 0 !important;" title="حذف آخرین سطر">-</button>
                                        </div>';

                                        echo '</div>';

                                    }else{
                                        foreach($smenu['fields'] as $sm):
                                            $fname = isset($sm['fname'])?$sm['fname']:(isset($sm['name'])?$sm['name']:'');
                                            if(count($sm) == 0){
                                                echo '<div class="col-sm-12 px-1"><hr></div>';continue;
                                            }
                                            echo '<div class="col-sm-'.( isset($sm['col'])?$sm['col']:'12' ).'">';
                                            if(isset($sm['break'])){
                                                echo '<div><strong style="font-size:20px;">'.$sm['break'].'</strong></div>';
                                            }
                                            else{
                                                echo $this->Form->control($sm['name'], [
                                                    'default'=>(isset($post_meta_list[$sm['name']])?$post_meta_list[$sm['name']]:(isset($post_meta_list[$fname])?$post_meta_list[$fname]:false)),
                                                    'type'=> isset($sm['type'])? $sm['type']: 'text',
                                                    'options'=> isset($sm['data']) ?$sm['data']: false,
                                                    'style'=>(isset($sm['select_img'])?'padding-right: 30px;':false). (isset($sm['style'])?$sm['style']:false),
                                                    'empty'=> isset($sm['data']) ?' - ': false,
                                                    'placeholder'=> isset($sm['pholder'])? $sm['pholder']: false,
                                                    'label'=> isset($sm['title'])? $sm['title']: false,
                                                    'class'=> 'form-control '. (isset($sm['class'])? $sm['class']: false ),
                                                    'id'=> isset($sm['id'])?$sm['id']:$sm['name'],
                                                    'data-role'=> isset($sm['data-role'])?"tags-input":false,
                                                    'multiple' =>  isset($sm['multiple'])?"multiple":false,
                                                    'escape'=>false,
                                                ]);
                                                
                                                if(isset($sm['select_img'])){
                                                    echo '<div class="mb-1 camerap">'.
                                                        $this->Html->link('<i data-feather="camera"></i>',false,['data-toggle'=>'modal', 'data-target'=>'#exampleModal',
                                                        'data-action'=>'select_src', 'title'=>'انتخاب تصویر', 'escape'=>false,'data-dest'=> $sm['name'],'style'=>'color:#9e9e9e']).'</div>';
                                                }
                                            }
                                            echo '</div>';
                                        endforeach;
                                    }
                                    
                                endif;?>
                                </div>
                            </div>
                            <?php $j++;endforeach;?>


                        </div>
                    </div>


                    </div></div>
                </div>
                
            <?php $i+=1;endforeach?>
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
        if (confirm('برای حذف این سطر مطمئن هستید؟')) {
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
    }
    .rbx:hover{
        border:1px solid #7e73ef;
        border-radius: 15px;
    }
    .rbx:hover .d-me{
        display: block;
    }
</style>