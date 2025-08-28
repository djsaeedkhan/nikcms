<?= $this->Form->create($challengetimeline,['class'=>'col-sm-6']) ?>
<fieldset class="mb-2">
    <legend><?= __('افزودن به زمانبندی') ?></legend>
    <?php
        echo $this->Form->control('title',['label'=>'عنوان', 'class'=>'form-control']);
        echo $this->Form->control('types',['type'=>'hidden', 'class'=>'form-control']);
        echo $this->Form->control('dates',[
            'id'=>'pdpGregorian',
            'type'=>'text',
            'dir'=>'ltr',
            'label'=>'انتخاب تاریخ',
            'class'=>'form-control'
        ]);
        echo $this->Form->control('dates',[
            'id'=>'gdate',
            'type'=>'hidden',
        ]);
    ?>
</fieldset>
<?= $this->Form->button(__('ثبت اطلاعات'),['class'=>'btn btn-success']) ?>
<?= $this->Form->end() ?>

<script nonce="<?=get_nonce?>">
    $("#pdpGregorian").persianDatepicker({ 
        onSelect: function () {
            $('#gdate').val( $("#pdpGregorian").attr("data-gdate") ) ;
        },
        formatDate: "YYYY-0M-0D 0h:0m:0s",
        fontSize: 13, // by px
        selectableMonths: [01, 02, 03, 04, 05, 06, 07, 08, 09, 10, 11, 12],
        persianNumbers: !0,
        isRTL: !1,  //  isRTL:!0 => because of persian words direction
        //onSelect: function () {alert('asd')},
        showGregorianDate: <?=$this->Func->Optionget('admin_calender') == 1?'true':'false'?> 
    });
</script>