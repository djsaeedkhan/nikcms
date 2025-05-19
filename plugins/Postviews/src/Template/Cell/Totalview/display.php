<div class="col-12">
    <div class="card card-revenue-budget">
        <div class="row mx-0">
            <div class="col-md-8 col-12 revenue-report-wrapper">
                <div class="d-sm-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-50 mb-sm-0">
                        <?= isset($setting['title'])?$setting['title']:__d('Postviews','نامشخص')?>
                    </h4>
                    <div class="d-flex align-items-center">
                        <div class="d-flex align-items-center mr-2">
                            <span class="bullet bullet-primary font-small-3 mr-50 cursor-pointer"></span>
                            <span><?= __d('Postviews','کاربران مهمان')?></span>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="bullet bullet-warning font-small-3 mr-50 cursor-pointer"></span>
                            <span><?= __d('Postviews','کاربران عضو')?></span>
                        </div>
                    </div>
                </div>
                <div id="revenue-report-chart"></div>
            </div>
            <div class="col-md-4 col-12 budget-wrapper">
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-primary btn-sm dropdown-toggle budget-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        2020
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="javascript:void(0);">1400</a>
                        <a class="dropdown-item" href="javascript:void(0);">1399</a>
                        <a class="dropdown-item" href="javascript:void(0);">1398</a>
                    </div>
                </div>
                <h2 class="mb-25">25,852</h2>
                <div class="d-flex justify-content-center">
                    <span class="font-weight-bolder mr-25"><?= __d('Postviews','بازدید')?>:</span>
                    <span>56,800</span>
                </div>
                <div id="budget-chart"></div>
                <button type="button" class="btn btn-primary"><?= __d('Postviews','افزایش بازدید')?></button>
            </div>
        </div>
    </div>
</div>