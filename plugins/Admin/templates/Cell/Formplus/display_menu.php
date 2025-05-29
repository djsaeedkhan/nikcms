<div class="nav-vertical">
    <ul class="nav nav-tabs nav-left flex-column" role="tablist">
        <?php $i=0;foreach($vmnu['sublevel'] as $mnu):?>
            <li class="nav-item">
                <a href="#<?=$mnu['name']?>" class="nav-link <?=$i==0?'active':''?>" data-toggle="tab" role="tab" aria-controls="<?=$mnu['name']?>">
                    <?=$mnu['title']?>
                </a>
            </li>
        <?php $i+=1;endforeach?> 
    </ul>
    <div class="tab-content">
    <!- ------------------------ ->
        <?php $i=0;foreach($vmnu['sublevel'] as $k1=>$mnu):?>
            
            <div class="tab-pane fade <?=$i==0?'show active':''?>" id="<?=$mnu['name']?>" role="tabpanel" style="overflow: inherit;">
                <div class="card p-0"><div class="card-body" style="padding:  0px 10px 20px 10px;">

                <div class="nav-vertical">
                    
                    <ul class="nav nav-tabs <?=(count($mnu['submenu']) > 1)?'nav-lefts':''?>" role="tablist">
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
                        <div class="tab-pane fade <?=($j==0)?'show active':'show active'?>" id="m<?=$k1.'-'.$k2?>" role="tabpanel" style="overflow: inherit;">
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

                                            if(
                                                (isset($post_meta_list[$sm['name']]) and $post_meta_list[$sm['name']] != '') or  
                                                (isset($post_meta_list[str_replace('PostMetas.','',$sm['name']) ]) and 
                                                    $post_meta_list[str_replace('PostMetas.','',$sm['name']) ] != '')  
                                                ){
                                                    $en = true;
                                                }

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
                                                    'id'=> isset($sm['id'])?$sm['id']:(isset($sm['select_img'])?str_replace('.','_',$sm['name']):$sm['name']),
                                                    'data-id'=> $name,
                                                    'data-role'=> isset($sm['data-role'])?"tags-input":false,
                                                    'multiple' =>  isset($sm['multiple'])?"multiple":false,
                                                    'escape'=>false,
                                                ]);
                                                
                                                if(isset($sm['select_img'])){
                                                    echo '<div class="mb-1 camerap">'.
                                                        $this->Html->link('<i data-feather="camera"></i>',false,['data-toggle'=>'modal', 'data-target'=>'#exampleModal',
                                                        'data-action'=>'select_src', 'title'=>'انتخاب تصویر', 'escape'=>false,'data-dest'=> str_replace('.','_',$sm['name']),
                                                        'style'=>'color:#9e9e9e']).'</div>';
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
                                        <button type="button" class="addRow btn btn-info" style="font-size: 20px;padding: 5px 5px 0 !important;" title="'. __d('Admin', 'افزودن سطر جدید'). '">+</button>
                                        <button type="button" class="remRow btn btn-danger d-none" style="font-size: 20px;padding: 5px 7px 0 !important;" title="'. __d('Admin', 'حذف آخرین سطر'). '">-</button>
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
                                                'id'=> isset($sm['id'])?$sm['id']:(isset($sm['select_img'])?str_replace('.','_',$sm['name']):$sm['name']),
                                                'data-role'=> isset($sm['data-role'])?"tags-input":false,
                                                'multiple' =>  isset($sm['multiple'])?"multiple":false,
                                                'escape'=>false,
                                            ]);
                                            
                                            if(isset($sm['select_img'])){
                                                echo '<div class="mb-1 camerap">'.
                                                    $this->Html->link('<i data-feather="camera"></i>',false,['data-toggle'=>'modal', 
                                                    'data-target'=>'#exampleModal',
                                                    'data-action'=>'select_src', 
                                                    'title'=> __d('Admin', 'انتخاب تصویر'), 
                                                    'escape'=>false,
                                                    'data-dest'=> str_replace('.','_',$sm['name']),'style'=>'color:#9e9e9e']).'</div>';
                                            }
                                        }
                                        echo '</div>';
                                    endforeach;
                                }
                                
                            endif;?>
                            
                            </div>
                            <!-- <div class="row"><div class="col-12"><hr></div></div> -->
                        </div>
                        <?php $j++;endforeach;?>
                    </div>
                </div>
                </div></div>
            </div>
            
        <?php $i+=1;endforeach?>
    </div>
</div>