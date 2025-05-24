<div class="row">
<?php
$metalist = $this->Func->MetaList($result);
for($i=1;$i<20;$i++):
    if(isset($metalist['rep_canvaid_'.$i]) and $metalist['rep_canvaid_'.$i] != ""):
        echo '<div class="col-sm-'.($metalist['rep_col_'.$i] != ""?$metalist['rep_col_'.$i]:12).'">';
        $rand = $metalist['rep_canvaid_'.$i]. rand(100,900);?>
        <canvas id="<?=$rand?>" height="<?=$metalist['rep_canvah_'.$i] != ""?$metalist['rep_canvah_'.$i]:'300'?>"></canvas>
        <script>
            <?= ($metalist['rep_data_'.$i] != "")?str_replace($metalist['rep_canvaid_'.$i], $rand, $metalist['rep_data_'.$i]):''?>
        </script>
        <?php 
        echo '</div>';
    endif;
endfor;?>
</div>