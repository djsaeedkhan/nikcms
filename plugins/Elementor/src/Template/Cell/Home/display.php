<div class="card cart1" id="cart-elementor"><div class="card-body">
  <h3>مدیریت المنتور</h3>
<?php
use Admin\View\Helper\ModuleHelper;
use Cake\Routing\Router;
global $post_id;
?>
<style nonce="<?=get_nonce?>">
  #basic-list-groups{
    min-height: 200px;
    border: 2px dashed #cac6f5;
    background: #F8F8F8;
    position: relative;
  }
  #basic-list-groups .dz-message {
    z-index: 999;
    font-size: 2rem;
    position: absolute;
    top: 0;
    right: 0;
    width: 100%;
    height: 100%;
    color: #7367F0;
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: center;
    -webkit-justify-content: center;
    -ms-flex-pack: center;
    justify-content: center;
    -webkit-box-align: center;
    -webkit-align-items: center;
    -ms-flex-align: center;
    align-items: center;
    margin: 0;
  }
  #basic-list-groups li{
    margin-bottom:10px;
    border-radius: 5px;
  }
  .ondelete{
    visibility: hidden;
  }
  .ondelete:after{
    content: " | ";
    color:black;
  }
  .list-group-item:hover .ondelete{
    visibility: visible;
  }
</style>
<div id="basic-list-groups" class="p-1">
  <div class="dz-message d-none">
    برای افزودن المنت کلیک کنید
  </div>
  <ul class="list-group" id="basic-list-group">

    <!-- <li class="list-group-item draggable" data-section-id="text-3">
        <div class="media">
            <div class="media-body">
                <h5>افزونه متنی</h5>
                <span>Chupa chups tiramisu apple pie biscuit sweet roll bonbon macaroon toffee icing.</span>
            </div>
        </div>
    </li> -->

    <?php 
    if(isset($post_meta_list['elementor']) and $post_meta_list['elementor'] != null){
      foreach(explode(',',$post_meta_list['elementor']) as $item){
        $itm = explode(':',$item);
        $itm_name = explode('.',$itm[0]);

        foreach(ModuleHelper::register_elementor() as $name => $element):
          if($element['plugin'].'.'.$element['name'] == $itm[0]){
            echo 
              '<li class="list-group-item draggable" 
                data-plugin="'.$itm[0].'" 
                data-name="'.$itm_name[1].'" 
                data-section-id="'.$item.'">
                  <div class="media">
                      <div class="media-body">
                        <div style="float: left;">
                          <a class="text-danger ondelete">حذف</a>
                          <a data-toggle="modal" id="onshowbtn" data-target="#settingModal">تنظیمات</a>
                        </div>
                        <h5>'.$element['title'].'</h5>
                        <span>'.$element['descr'].'</span>
                      </div>
                  </div>
              </li>';
          }
        endforeach;
      }
    }?>
  </ul>

  <button type="button" class="btn btn-outline-primary btn-sm d-block" data-toggle="modal" data-target="#animation">
    + افزودن
  </button>
</div>
<?= $this->form->control('PostMetas.elementor',[
  'id'=>'elementor',
  //'class'=>'form-control',
  'type'=>'hidden',
  'defaults'=>(isset($post_meta_list['elementor'])?$post_meta_list['elementor']:'')]);
?>
<div class="display d-none">
  <details open>
    <summary>Data</summary>
    <pre class="data">{}</pre>
  </details>
</div>
 
<div class="modal text-left" id="animation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel6" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title" id="myModalLabel6">لیست المنت های در دسترس</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body pt-2">
              <div class="row">
                <?php
                foreach(ModuleHelper::register_elementor() as $name => $element):?>
                  <div class="col-sm-4" style="padding: 0 5px;"><div class="list-group-item mb-1 text-center" 
                    style="border-radius:5px;padding-right:0;letter-spacing: -0.3px;padding-left: 5px;">
                    <?= $element['title']?>
                    <button type="button" 
                      data-plugin="<?= $element['plugin'].'.'.$element['name']?>" 
                      data-name="<?= $element['name']?>" 
                      data-title="<?= $element['title']?>"
                      data-descr="<?= $element['descr']?>"
                      id="myBtn" 
                      style="float:left;margin-left:0 !important;padding-top:9px;"
                      class="btn btn-sm btn-outline-primary mx-1 btn-icon rounded-circle" 
                      data-dismiss="modal">+</button>
                  </div></div>

                <?php endforeach?>
              </div>

          </div>
          <div class="modal-footer">
              <!-- <button type="button" class="btn btn-primary" data-dismiss="modal">Accept</button> -->
          </div>
      </div>
  </div>
</div>

<script nonce="<?=get_nonce?>">
  $(function() {
  function updateData(obj) {
    var data = JSON.stringify(obj['sectionList'], null, 3);
    $('.data').text(data);
    $('#elementor').val(obj['sectionList']);
  }
  $("#basic-list-group").sortable({
    items: "> li",
    handle: ".media",
    revert: false,
    create: hello(),
    stop: function(e, ui) {
      var list = new Array();
      $('#basic-list-group li').each(function(){
        list.push($(this).attr('data-section-id'));
      });
      updateData({sectionId: 'text-1', sectionList:  list});
      updateElementor();
    }
  });
  function hello(){
    var list = new Array();
    $('#basic-list-group li').each(function(){
      list.push($(this).attr('data-section-id'));
    });
    updateData({sectionId: 'text-1', sectionList:  list});
  }
  let cnt = 1;
  var elements = document.getElementsByClassName("rounded-circle");
  Array.from(elements).forEach(function(element) {
    element.addEventListener('click', displayDate);
  });
  function displayDate(){
    var dt = new FrozenDate();
    var time = dt.getHours() +""+ dt.getMinutes() +""+ dt.getSeconds();
    $('#basic-list-group').append(
    `<li class="list-group-item draggable" 
      data-plugin="`+$(this).attr('data-plugin')+`" 
      data-name="`+$(this).attr('data-name')+`" 
      data-section-id="`+$(this).attr('data-plugin')+":"+$(this).attr('data-name')+time+`">
          <div class="media">
              <div class="media-body">
                <div style="float: left;">
                  <a class="text-danger ondelete">حذف</a>
                  <a data-toggle="modal" id="onshowbtn" data-target="#settingModal">تنظیمات</a>
                </div>
                <h5>`+$(this).attr('data-title')+`</h5>
                <span>`+$(this).attr('data-descr')+`</span>
              </div>
          </div>
      </li>`);
      hello();
      updateElementor();
      cnt +=1;
  }
});

$( document ).delegate( ".ondelete", "click", function(event) {
  //duplicate
  if (confirm("آیا برای حذف  مطمین هستید؟") === true) {  
      var button = $(event.currentTarget);
      let setting  = button.parent().parent().parent().parent().attr('data-section-id');
      var name  = button.parent().parent().parent().parent().attr('data-name');
      var plugin  = button.parent().parent().parent().parent().attr('data-plugin');
      $.ajax({
        type : 'GET',
        data: 'action=setting&plugin='+plugin+'&name='+name+"&setting="+setting,
        url : "<?=Router::url('/admin/elementor/home/deletesetting/'.$post_id);?>",
        beforeSend: function() {},
        success : function(data){
          if(data == 1 || data == 2){
            $('li[data-section-id="'+setting+'"]').remove();
            function updateData(obj) {
              var data = JSON.stringify(obj['sectionList'], null, 3);
              $('.data').text(data);
              $('#elementor').val(obj['sectionList']);
            }
            function hello(){
              var list = new Array();
              $('#basic-list-group li').each(function(){
                  list.push($(this).attr('data-section-id'));
              });
              updateData({sectionId: 'text-1', sectionList:  list});
            }
            hello();
            updateElementor();
          }
        },
        error:function (XMLHttpRequest, textStatus, errorThrown) {
          console.log(textStatus);
          console.log(errorThrown);
          alert("متاسفانه حذف انجام نشد");
        }
      });


      function updateElementor(){
        ///alert($('#elementor').val());
        $.ajax({
          type : 'POST',
          data: {'data':$('#elementor').val()},
          url : "<?=Router::url('/admin/elementor/home/savestatus/'.$post_id);?>",
          success : function(data){
            if(data == 1){}
            else{alert("2- بروزرسانی وضعیت المنتور انجام نشد");}
          },
          error:function (XMLHttpRequest, textStatus, errorThrown) {
            alert("بروزرسانی وضعیت المنتور انجام نشد");
          }
        });
      }
    } 

});

/* $(".ondelete").live("click", function(){
  alert("asd");
}); */

function updateElementor(){
  //alert($('#elementor').val());
  $.ajax({
    type : 'POST',
    data: {'data':$('#elementor').val()},
    url : "<?=Router::url('/admin/elementor/home/savestatus/'.$post_id);?>",
    success : function(data){
      if(data == 1){}
      else{alert("2- بروزرسانی وضعیت المنتور انجام نشد");}
    },
    error:function (XMLHttpRequest, textStatus, errorThrown) {
      alert("بروزرسانی وضعیت المنتور انجام نشد");
    }
  });
}
</script>

<div class="modal text-left" id="settingModal" tabindex="-1" role="dialog" aria-labelledby="settingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content"><div id="settingModalLabel" class="p-2">
        ...
      </div></div>
  </div>
</div>
<script nonce="<?=get_nonce?>">
(function (window, document, $) {
  'use strict';
  var onShowEvent = $('#settingModal');
  onShowEvent.on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var setting  = button.parent().parent().parent().parent().attr('data-section-id');
    var name  = button.parent().parent().parent().parent().attr('data-name');
    var plugin  = button.parent().parent().parent().parent().attr('data-plugin');
    $.ajax({
      type : 'GET',
      data: 'action=setting&plugin='+plugin+'&name='+name+"&setting="+setting,
      url : "<?=Router::url('/admin/elementor/home/savesetting/'.$post_id);?>",
      beforeSend: function() {
        $("#settingModalLabel").html('<p class="text-center">درحال دریافت اطلاعات</p>');
      },
      success : function(data){
        $("#settingModalLabel").html(data);
        $("#settingModal").modal("show");
      },
      error:function (XMLHttpRequest, textStatus, errorThrown) {
        $("#settingModalLabel").html('<br><p class="text-center">متاسفانه امکان دریافت اطلاعات وجود ندارد</p><br>');
        $("#settingModal").modal("show");  
      }
    });
  });

  /* var onletet = $('.ondelete');
  onletet.on('click', function (event) {
    if (confirm("آیا برای حذف  مطمین هستید؟") === true) {  
      var button = $(event.currentTarget);
      let setting  = button.parent().parent().parent().parent().attr('data-section-id');
      var name  = button.parent().parent().parent().parent().attr('data-name');
      var plugin  = button.parent().parent().parent().parent().attr('data-plugin');
      $.ajax({
        type : 'GET',
        data: 'action=setting&plugin='+plugin+'&name='+name+"&setting="+setting,
        url : "<?=Router::url('/admin/elementor/home/deletesetting/'.$post_id);?>",
        beforeSend: function() {},
        success : function(data){
          if(data == 1 || data == 2){
            $('li[data-section-id="'+setting+'"]').remove();
            function updateData(obj) {
              var data = JSON.stringify(obj['sectionList'], null, 3);
              $('.data').text(data);
              $('#elementor').val(obj['sectionList']);
            }
            function hello(){
              var list = new Array();
              $('#basic-list-group li').each(function(){
                  list.push($(this).attr('data-section-id'));
              });
              updateData({sectionId: 'text-1', sectionList:  list});
            }
            hello();
            updateElementor();
          }
        },
        error:function (XMLHttpRequest, textStatus, errorThrown) {
          console.log(textStatus);
          console.log(errorThrown);
          alert("متاسفانه حذف انجام نشد");
        }
      });


      function updateElementor(){
        ///alert($('#elementor').val());
        $.ajax({
          type : 'POST',
          data: {'data':$('#elementor').val()},
          url : "<?=Router::url('/admin/elementor/home/savestatus/'.$post_id);?>",
          success : function(data){
            if(data == 1){}
            else{alert("2- بروزرسانی وضعیت المنتور انجام نشد");}
          },
          error:function (XMLHttpRequest, textStatus, errorThrown) {
            alert("بروزرسانی وضعیت المنتور انجام نشد");
          }
        });
      }
    }  
  }); */
})(window, document, jQuery);
</script>
</div></div>