<?php 
if(strtolower($this->request->getParam('controller')) =='dashboard' and 
    strtolower($this->request->getParam('action')) =='index'){?>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><?= __d('Admin', 'پیشخوان')?></li>
    <li class="breadcrumb-item active"><?= __d('Admin', 'صفحه نخست')?></li>
    <li class="breadcrumb-menu d-md-down-none">
        <div class="btn-group" role="group" aria-label="Button group">
            <a class="btn" href="#"><i class="icon-speech"></i></a>
            <a class="btn" href="#"><i class="icon-graph"></i> &nbsp;<?= __d('Admin', 'میزکار')?></a>
            <a class="btn" href="#"><i class="icon-settings"></i> &nbsp;<?= __d('Admin', 'تنظیمات')?></a>
        </div>
    </li>
</ol>
<?php }else{ ?>
    <br><br>
<?php }?>