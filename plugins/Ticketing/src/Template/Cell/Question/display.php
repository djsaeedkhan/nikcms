<?php
global $result;
?>
<div class="text-center">
    برای سفارشی سازی محصولات و یا  سوالات دیگر درباره محصولات ما<br>
    <button title="کابل سیار میرا مدل MKS2M" class="button button-circle button-reveal button-border btn button-small ls0 " 
        data-toggle="collapse" href="#collapseExample" aria-controls="collapseExample">
        <i class="icon-envelope21 ml-1" aria-hidden="true" ></i>استعلام قیمت
    </button>
</div>

<div class="collapse" id="collapseExample">
    <?php
        echo $this->Form->create(null,['url'=>'/tickets/question/']);
        
        echo $this->Form->control('subject',['label'=>'عنوان تیکت',
            'default'=>__d('Ticketing', 'استعلام قیمت').' ' .(isset($result['title'])?$result['title']:''),
            'type'=>'hidden',
            'class'=>'form-control'] );

        echo $this->Form->control('post_id',[
            'type'=>'hidden',
            'default'=> (isset($result['id'])?$result['id']:'') ] );

        echo $this->Form->control('alert_type',[
            'label'=>__d('Ticketing', 'نحوه اطلاع رسانی'),
            'type'=>'select',
            'options'=>[
                1 => __d('Ticketing', 'پیامک')
            ],
            'class'=>'form-control mb-2'] );

        echo $this->Form->button(
            __d('Ticketing', 'ثبت  استعلام قیمت'),[
            'class'=>'btn btn-sm btn-success form-control']);

        echo $this->Form->end() 
    ?>
</div>
