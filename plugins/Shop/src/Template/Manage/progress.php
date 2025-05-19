<ul class="process-steps row col-mb-30 p-0 m-0 justify-content-center">
    <li class="col-sm-6 col-3 col-lg-3 <?= (isset($progress) and $progress == 'cart')?'active':''?>">
        <a class="i-circled i-alt mx-auto">1</a>
        <h5>سبد خرید</h5>
    </li>
    <li class="col-sm-6 col-3 col-lg-3 p-0 m-0 <?= (isset($progress) and $progress == 'send')?'active':''?>">
        <a class="i-circled i-alt mx-auto">2</a>
        <h5>زمانبندی ارسال</h5>
    </li>
    <li class="col-sm-6 col-3 col-lg-3 p-0 m-0 <?= (isset($progress) and $progress == 'payment')?'active':''?>">
        <a class="i-circled i-alt mx-auto">3</a>
        <h5>پرداخت</h5>
    </li>
    <li class="col-sm-6 col-3 col-lg-3 p-0 m-0 <?= (isset($progress) and $progress == 'tracker')?'active':''?>">
        <a class="i-circled i-alt mx-auto">4</a>
        <h5>پیگیری</h5>
    </li>
</ul>
<style>
.process-steps li::after {
    right: auto;
    left: -26px;
}
.process-steps a{
    color:#FFF;
}
.process-steps li:hover a{
    color:#FFF;
}
</style>