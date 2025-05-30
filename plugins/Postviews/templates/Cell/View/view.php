<?php
$st = [];
$st = $this->Func->OptionGet('postviews_plugin');
if($st != '' ) $st = unserialize($st);

if($views == null)
    echo ((isset($st['title_view0']) and $st['title_view0'] !='')?
        $st['title_view0']:
        ' '.__d('Postviews','بدون بازدید') );
elseif($views == 1)
    echo ((isset($st['title_view1']) and $st['title_view1'] !='')?
        $st['title_view1']:
        ' 1 '.__d('Postviews','بازدید') );
else
    echo ((isset($st['title_view2']) and $st['title_view2'] !='')?
        $views.$st['title_view2']:
        $views.' '.__d('Postviews','بازدید'));
?> 