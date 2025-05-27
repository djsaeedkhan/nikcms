<?php 
try {
    if($this->Func->OptionGet('template_viewin') == 1):
        echo $this->element('Template.header');
    else:
        echo $this->element('header');
    endif;
} catch (\Throwable $th) {echo $this->element('header');}

echo $this->fetch('content');

echo '<style>'. ($this->Func->OptionGet('template_style')).'</style>';

try {
    if($this->Func->OptionGet('template_viewin') == 1):
        echo $this->element('Template.footer');
    else:
        echo $this->element('footer');
    endif;
} catch (\Throwable $th) {echo $this->element('footer');}