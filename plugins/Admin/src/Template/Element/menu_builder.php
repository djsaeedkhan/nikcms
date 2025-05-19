<div class="dd-handle dd3-handle"></div>
<div class="dd3-content colorFFF">
    <a class="text-right" href="#" data-toggle="collapse" data-target="#item_<?= $i;?>" aria-expanded="true" aria-controls="item_<?= $i;?>">
        <span class="d-none">
            <?= __d('Admin', 'عنوان')?> : </span><span class="title_span"><?= $menu_data[$i]['title'];?></span>
    </a>
    <div id="item_<?= $i;?>" class="collapse">
        <?php 
        echo $this->Form->control("data.$i.id", [
            'type'=>'hidden',
            'value'=> $menu_data[$i]['id']]);

        echo $this->Form->control("data.$i.title", [
            'type'=>'text',
            'label'=>($menu_data[$i]['type']=='link'?__d('Admin', 'عنوان'):__d('Admin', 'عنوان') ),
            'class'=>'form-control d-title mb-1',
            'value'=> $menu_data[$i]['title']]);

        echo $this->Form->control("data.$i.type", [
            'type'=>'hidden',
            'label'=>'type',
            'value'=> $menu_data[$i]['type']]);

        echo $this->Form->control("data.$i.link", [
            'type'=>($menu_data[$i]['type']=='link'?'text':'hidden'),
            'label'=>__d('Admin', 'آدرس پیوند (لینک)'),
            'class'=>'form-control',
            'dir'=>'ltr',
            'value'=> $menu_data[$i]['link']]);

        echo $this->Form->control("data.$i.post_type", [
            'type'=>'hidden',
            'label'=>'ptype',
            'value'=> $menu_data[$i]['post_type']]);
        ?>
    </div>   
</div>