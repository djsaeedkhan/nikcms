<?php
if(isset($options['ga_enable']) and $options['ga_enable'] == 1){
  if(!in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1','::1'])){
    if(!isset($options['ga_viewid']) or $options['ga_viewid'] ==''){
      echo '<div class="col-sm-12">
      <div class="alert alert-secondary small">لطفا تنظیمات مربوط به نمایش آمار گوگل آنالایتیکس را فعال کنید</div>
      </div>';
    }
    elseif(!isset($options['ga_key_json']) or $options['ga_key_json'] ==''){
      echo '<div class="col-sm-12">
      <div class="alert alert-secondary small">لطفا تنظیمات مربوط به نمایش آمار گوگل آنالایتیکس را فعال کنید</div>
      </div>';
    }
    else{
      include_once('google.php');
    }
    
  }else{
    echo '<div class="col-sm-12">
      <div class="alert alert-secondary small">آمار گوگل آنالایتیک در Localhost نمایش داده نمی شود.</div>
      </div>';
  }
}