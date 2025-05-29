<div class="paginator">
    <p class="float-left pt-1">
        <?= $this->Paginator->counter(['format' => __d('Admin', 'صفحه {{page}} از {{pages}} / درحال نمایش {{current}} رکورد از {{count}} ')]) ?>
    </p>

    <ul class="pagination pagination-rounded pagination mt-4">
        <?php
        $this->Paginator->setTemplates([
            'prevDisabled' => '<li class="page-item disabled"><a class="page-link disabled" href="{{url}}">قبلی</a></li>',
            'prevActive' => '<li class="page-item"><a class="page-link" href="{{url}}">قبلی</a></li>',
            'nextDisabled' => '<li class="page-item disabled"><a class="page-link disabled">بعدی</a></li>',
            'nextActive' => '<li class="page-item"><a class="page-link" href="{{url}}">بعدی</a></li>',
            'first' => '<li class="page-item"><a class="page-link" href="{{url}}">اولین</a></li>',
            'last' => '<li class="page-item"><a class="page-link" href="{{url}}">آخرین</a></li>',
            'number' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
            'current' => '<li class="page-item active"><a class="page-link" href="{{url}}">{{text}}</a></li>' ]); ?>
        <?= $this->Paginator->first('<< ' . __d('Admin', 'اولین'),['class'=>'page-link']) ?>
        <?= $this->Paginator->prev('< ' . __d('Admin', 'قبلی'),['class'=>'page-link']) ?>
        <?= $this->Paginator->numbers() ?>
        <?= $this->Paginator->next(__d('Admin', 'بعدی') . ' >',['class'=>'page-link']) ?>
        <?= $this->Paginator->last(__d('Admin', 'آخرین') . ' >>',['class'=>'page-link']) ?>
    </ul>
</div>