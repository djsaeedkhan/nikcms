
<div class="card setting-card"><div class="card-body">
    <div class="nav-vertical">
        <ul class="nav nav-tabs nav-left flex-column" role="tablist">
            <?php $i=0;foreach($menu as $mnu):?>
                <li class="nav-item">
                    <a href="#<?=$mnu['name']?>" class="nav-link <?=$i==0?'active':''?>" data-toggle="tab" role="tab" aria-controls="<?=$mnu['name']?>">
                        <?=$mnu['title']?>
                    </a>
                </li>
            <?php $i+=1;endforeach?> 
            <br><br>

            <?= $this->Form->submit(
                __d('Admin', 'ثبت اطلاعات'),
                ['class'=>'btn btn-primary col-xs-3 mt-10','id'=>'submited'])?>

            <!-- <?= $this->html->link(
                __d('Admin', 'ثبت اطلاعات'),
                '#',
                ['class'=>'btn btn-primary col-xs-3 mt-10','id'=>'submited'])?>  -->
        </ul>
        <div class="tab-content">
        <!- ----------------------- -->
            <?php $i=0;foreach($menu as $mnu):?>
                <div class="tab-pane fade <?=$i==0?'show active':''?>" id="<?=$mnu['name']?>" role="tabpanel" style="overflow: inherit;">
                    <div class="row">
                    <?php
                    if(isset($mnu['fields']) and count($mnu['fields'])):
                        foreach($mnu['fields'] as $sm):
                            if(count($sm) == 0){
                                echo '<div class="col-sm-12 px-1"><hr></div>';continue;
                            }
                            echo '<div class="col-sm-'.( isset($sm['col'])?$sm['col']:'12' ).'">';
                            if(isset($sm['break'])){
                                echo '<br><div><strong style="font-size:20px;">'.$sm['break'].'</strong></div><br1>';
                            }
                            else{
                                echo $this->Form->control('setting'.(defined('template_slug')?'_'.template_slug :'').'.hsite.'.$sm['name'], [
                                    'type'=> isset($sm['type'])? $sm['type']: 'text',
                                    'options'=> isset($sm['data']) ?$sm['data']: false,
                                    'style'=>isset($sm['select_img'])?'padding-right: 30px;':false,
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
                                    echo '<div class="mb-1" style="margin-top:-50px;float: right;margin-right: 10px;">'.
                                        $this->Html->link(
                                            '<i data-feather="camera"></i>',
                                            false, [
                                                'data-toggle'=>'modal', 
                                                'data-target'=>'#exampleModal',
                                                'data-action'=>'select_src', 
                                                'title'=>__d('Admin', 'انتخاب تصویر'), 
                                                'escape'=>false,
                                                'data-dest'=> $sm['name'],
                                                'style'=>'color:#9e9e9e'
                                            ]).'</div>';
                                }
                            }
                            echo '</div>';
                        endforeach;
                    endif;?>
                    </div>
                </div>
            <?php $i+=1;endforeach?>
        </div>
    </div>
</div></div>