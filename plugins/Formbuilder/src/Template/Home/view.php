<div class="content-header-right col-md-9 col-12 mb-2">
    <div class="row breadcrumbs-top">
        <div class="col-12">
            <h3 class="content-header-title1 float-right mb-0">
                <?= __d('Formbuilder', 'نمایش نتایج فرم');?>
                <?= isset($form['title'])?
                    ' » '.$form['title']:
                    ' » '.__d('Formbuilder', 'نمایش لیست')?>
            </h3>
            <div class="breadcrumb-wrapper">
                <ol class="breadcrumb pt-0">

                </ol>
            </div>
        </div>
    </div>
</div>

<div class="card"><div class="card-body">
    <div class="table-responsive"><table class="table table-striped table-bordere1d table-hover">
        <thead>
            <tr>
                <!-- <th scope="col"><?= $this->Paginator->sort('id',__d('Formbuilder', 'ردیف') ) ?></th> -->
                <?php if(!isset($form['title'])):?><th scope="col"><?=__d('Formbuilder', 'نام فرم')?></th><?php endif?>
                <th scope="col"><?=__d('Formbuilder', 'نمایش')?></th>
                <th scope="col"><?=__d('Formbuilder', 'IP ثبتی')?></th>
                <th scope="col"><?=__d('Formbuilder', 'کاربر')?></th>
                <th scope="col"><?=__d('Formbuilder', 'تاریخ')?></th>
            </tr>
        </thead>
        <tbody>
            <?php $i=0;foreach ($results as $result):?>
            <tr>
                <!-- <td><?= ++$i;?></td> -->
                <?php if(!isset($form['title'])): ?>
                    <td>
                        <?= h($result['formbuilder']['title']);?>
                    </td>
                <?php endif?>
                <td>
                    <?=$this->html->link(
                        __d('Formbuilder', 'نمایش ریز فرم'),
                        ['action'=>'viewForm',$result->id]);?>
                </td>
                <td style="font-family:sans-serif">
                    <?= $result->ips;?>
                </td>
                <td>
                    <?= $result->user?$result->user['family'].' ('.$result->user['username'].')':$result['user_id'];?>
                </td>
                <td>
                    <?= $this->Func->date2($result->created);?>
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table></div>
</div></div>