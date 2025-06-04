<div class="content-header-right col-md-9 col-12 mb-2">
    <div class="row breadcrumbs-top">
        <div class="col-12">
            <h2 class="content-header-title1 float-right mb-0">
                <?= __d('Formbuilder', 'جزئیات فرم ثبت شده');?>
                <?= isset($result['formbuilder']['title'])?
                    ' » '.$result['formbuilder']['title']:
                    '-'?>
            </h2>
            <div class="breadcrumb-wrapper">
                <ol class="breadcrumb pt-0">

                </ol>
            </div>
        </div>
    </div>
</div>

<div class="card"><div class="card-body">
    <div class="table-responsive"><table class="table table-bordered">
        <tbody>
            <tr>
                <th style="width:200px;"> <?=__d('Formbuilder', 'نام فیلد')?> </th>
                <th><?=__d('Formbuilder', 'مقادیر ورودی')?></th>
            </tr>
            <?php
            $field = unserialize($result['data']);
            $data = unserialize($result['field']);

            foreach($field as $kfld => $fld){
                if(isset($data[$kfld]) or isset($data[str_replace('_',' ',$kfld)])){
                    $f_name = isset($data[$kfld])?$data[$kfld]:$data[str_replace('_',' ',$kfld)];
                    echo '<tr>
                            <td>'. h($f_name) .'</td>
                            <td>';
                    if(filter_var($fld, FILTER_VALIDATE_URL))
                        echo $this->html->link(
                                h($fld),
                                h($fld),
                                ['target'=>'_blank']);
                    else
                        echo h($fld);
                    echo '</td>
                        </tr>';
                }
            }
            ?>
        </tbody>
    </table></div>
</div></div>