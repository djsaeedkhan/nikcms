<?php
use Cake\ORM\TableRegistry;
use Lms\Predata;
$pd = new Predata();
$this->LmsExamresults = TableRegistry::getTableLocator()->get('Lms.LmsExamresults');
?>

<div class="card"><div class="card-body">
    <div class="table-responsive"><table class="table table-striped table-bordered table-hover" id="example">
        <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col">نام فایل</th>
                <th scope="col">اولویت</th>
                <th scope="col">نام هفته</th>
                <th scope="col" width="200">دسترسی</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=1;foreach ($results as $us):?>
            <tr>
                <td><?=$i++?></td>
                <td><?=$us['title'] !=""?$us['title']:'<span class="badge badge-secondary">بدون عنوان</span>'?></td>
                <td><?=$us['priority']?></td>
                <td><?= isset($us['lms_courseweek']['title'])?$us['lms_courseweek']['title']:''?></td>
                <td>
                    <?= $this->Form->postlink("حذف",
                    ['controller'=>'Coursefiles','action'=>'delete',$us['id']],
                    ['confirm'=>'are You Sure?'])?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table></div>
</div></div>

    <?= $this->Html->script([
        'https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js',
        'https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js',
        'https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js',
        'https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js',
        'https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js',
    ],['nonce'=>get_nonce])?>
    <script nonce="<?=get_nonce?>">
    $(document).ready(function() {
        $('#example').DataTable({
            dom: 'Bfrtip',
            pageLength: 5000000000,
            buttons: [
                'copy', 'excel', 'pdf', 'print'
                ],
            language:
            {
                "sProcessing":      "در حال جستجو ...",
                "sSearch":          "جستجو: ",
                "sZeroRecords":     "چیزی پیدا نشد",
                "buttons": {
                    "print":    "پرینت",
                    "copy":     "کپی",
                    "pdf":'PDF',
                    "excel":'اکسل',
                }
            }
        });
    } );
    </script>
    <style>
        .dt-buttons{float:left}
        .dataTables_info, #example_paginate{display: none}
    </style>