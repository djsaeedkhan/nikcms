<div class="alert alert-primary">
    <h2>فاکتور <?=$factor['id']?>#</h2>
    شما یک فاکتور پرداخت نشده برای مشاهده این دوره دارید
    <br>
    برای دسترسی به این دوره، ابتدا نسبت به پرداخت این فاکتور اقدام نمایید.
    <br><br>
    <?= $this->html->link('مشاهده فاکتور',
        '/lms/client/factors?id='. $factor['lms_factor_id'],
        ['class'=>'btn btn-sm btn-primary']);?>
</div>