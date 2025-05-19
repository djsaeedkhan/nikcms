<div class="exam_start">
    <h3>
    عنوان : <?=$results['LmsExams']['title'];$exam = $results['LmsExams']; ?>
    <div class="taba">
            <span class="pull-right" style="padding-top: 5px;font-size:14px;">مانده تا پایان آزمون</span>
            <ol class="breadcrumb1 text-center pull-left">
                <div class="lead" id="clock">00:00:00</div>
            </ol>
        </div>
    </h3><div class="clearfix clear clearfloat"></div>
    
    <?= $this->Form->create(null) ?>
    <div class="alert alert-primary">
        توجه: پس از پایان زمان شرکت در آزمون اطلاعات ثبت نخواهند شد.
    </div>
    <?php foreach($questions['LmsExams']['lms_examquests'] as $qs):?>
    <div class="card"><div class="card-body p-0">
        <div class="table-responsive"><table class="table table-striped table-bordered table-hover1">
            <tbody>
                <tr>
                    <td><strong><?= ($qs['title'])?></strong></td>
                </tr>
                <tr>
                    <td style="padding-right: 5px;">
                        <?php
                        if($qs['types'] == 0){
                            echo $this->form->controll('q.'.$qs['id'],['type'=>'textarea','label'=>false,'class'=>'form-control']);
                        }
                        elseif($qs['types'] == 1){
                            $list = [];
                            for($i=1;$i<6;$i++){
                                if($qs['q'.$i]!='') $list[$i] = $qs['q'.$i];
                            }
                            echo $this->Form->controll('q.'.$qs['id'],[
                                'escape'=>false,
                                'required','options'=> $list,'type'=>'radio','style'=>'margin-right:15px;']);
                        }?>
                    </td>
                </tr>
            </tbody>
        </table></div>
    </div></div>
    <?php endforeach;?>
           
    <?= $this->Form->button(__('ثبت نتایج آزمون'),['class'=>'btn btn-sm btn-success']) ?>
    <?= $this->Form->end() ?>
        
</div>
<?= $this->Html->script(['Admin.jquery.countdown.min.js'],['nonce'=>get_nonce]);?>

<script nonce="<?=get_nonce?>" type="text/javascript"> var $clock = $('#clock');
    $clock.countdown("<?=$time?>", function(event) {
        $(this).html(event.strftime('<li><span>%S</span><p>ثانیه</p></li><li><span>%M</span><p>دقیقه</p></li><li><span>%H</span><p>ساعت</p></li></li>'));
    });
</script>
<style>
.exam_start .table td:first-child{
  font-weight: normal !important;
}
</style>