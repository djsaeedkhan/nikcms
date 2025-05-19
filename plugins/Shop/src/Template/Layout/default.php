<?php
use Shop\View\Helper\CartHelper;
use Shop\View\Helper\ShopHelper;?>
<?= $this->Element('Template.header')?>
<div class="container text-right rtl" style="margin-top:20px;margin-bottom:0px">
    <?= $this->Flash->render() ?>
</div>
<style>
.alert{text-align: right;}
#content .text-right {text-align: right !important;}
#content .float-left {float: left !important;}
#content .float-right {float: right !important;}
.shp_icn{
    font-size: 20px;
    vertical-align: inherit;
    padding-right: 10px;
    padding-left: 10px;
}

.tmpclass1 input[type=radio]:checked+ label {
    background-color: rgba(0,191,214,.03);
    color: #00bfd6;
    border-color: #00bfd6;
    border-width: 2px;
    padding: 9px 19px;
    -webkit-box-shadow: 0 8px 13px -7px rgb(0 191 214 / 35%);
    box-shadow: 0 8px 13px -7px rgb(0 191 214 / 35%);
}

.bg-secondary label{color:#FFF;}
.tmpclass1{
    border: 1px solid #dee2e6;
    background: #FFF;
    margin-bottom: 10px;
    text-align: center;
    margin-left: 10px;
    float: right;
    
}
.tmpclass2{
    width: 19%;
    display: initial;
    padding-right: 0px;
    padding-left: 10px;
    padding-bottom: 5px;
}
.useraddress label{
    font-weight: normal;
    letter-spacing: 0;
    font-size: 14px;
    text-align: justify;
}
.error-message{
    color: #F00;
    font-size: 14px;
}
</style>


<?= $this->fetch('content');?>
<?= $this->Element('Template.footer')?>