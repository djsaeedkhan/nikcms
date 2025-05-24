<div class="card cart1">
    <div class="card-header">توضیحات فرش ها</div>
    <div class="card-body">
    <div class="row">
        <?php
        $lists = [
            'pr_tarh' =>'نام طرح',
            'pr_collection' => 'کلکسیون',
            'pr_sabk' => 'سبک',
            'pr_zemanat' => 'ضمانت',
            'pr_hazine' => 'هزینه ارسال',
            'pr_tech' => 'تکنولوژی تولید',
            'pr_baft' => 'نوع بافت',
            'pr_color' => 'تعداد رنگ به کار رفته در فرش',
            'pr_shane' => 'شانه',
            'pr_gereh' => 'تعداد گره بر متر مربع',
            'pr_height' => 'ارتفاع نخ خاب',
            'pr_jens' => 'جنس نخ',
            'pr_time' => 'حداکثر زمان ارسال',
        ];
        foreach($lists as $k=>$list){
            echo '<div class="col-md-4 col-6">';
            echo $this->Form->control('PostMetas.'.$k,[
                'class'=>'form-control mb-3',
                'label' => $list,
                'default'=>(isset($post_meta_list[$k])?$post_meta_list[$k]:'') ]);
            echo '</div>';
        }
        ?>
    </div>
    </div>
</div>