<?php 
use Admin\View\Helper\ModuleHelper;
use Cake\Routing\Router;
$json = $this->Func->OptionGet('site_widgetdata');
$tmp = [];
$setting = (array) json_decode($json, true);
foreach($setting as $tmps){
    $arr = $tmps; 
    unset($arr[0]);
    if(isset($tmps[0]['sidebars']) and $tmps[0]['sidebars'] != ''){
        foreach($arr as $key => $val){
            $tmp[$tmps[0]['sidebars']][$val['name']] = $arr[$key];
        }
    }
}
$setting_value = $tmp;
$sidebar_list= [];
?>

<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title1 float-right mb-0">
                    <?= __d('Widget','مدیریت ابزارک')?>
                </h2>
            </div>
        </div>
    </div>
</div>

<div class="row widget-plugin">
    <div class="col-md-4 widget-list"><div class="card">
        <div class="card-header" style="background: none;border:0;">
            <?= __d('Widget','ابزارک های قابل استفاده')?>
        </div>
        <div class="card-body text-justify">
            <ol class="simple_with_no_drop vertical">
                <?php foreach(ModuleHelper::register_widgets() as $widget): 
                    $sidebar_list[$widget['widget']] = $widget;?>
                    <?= $this->cell('Widget.View::admin',[$widget])?>
                <?php endforeach;?>
            </ol>
        </div>
    </div></div>

    <div class="col-md-8 widget-data"><div class="row">
        <?php foreach(ModuleHelper::register_sidebars() as $widget): ?>
            <div class="col-sm-6"><div class="card">
            <div class="card-header bg-secondary text-white p-1"><?= $widget['title']?></div>
            <div class="card-body text-justify pt-1">
                <ol class="simple_with_drop vertical">
                    <li class="d-none" data-sidebars="<?= $widget['name']?>"></li>
                    <?php
                    foreach($setting as $result){
                        if(isset($result[0]['sidebars']) and $result[0]['sidebars'] == $widget['name']){
                            $temp_widget = $result[0]['sidebars'];
                            unset($result[0]);

                            foreach($result as $temp2_widget){
                                if(isset($temp2_widget['widget'])){
                                    echo $this->cell('Widget.View::admin',[
                                        $sidebar_list[$temp2_widget['widget']] , 
                                        isset($setting_value[$widget['name']][$temp2_widget['name']])?$setting_value[$widget['name']][$temp2_widget['name']]:null
                                        ]
                                    );
                                }
                            }
                        }
                    }
                    ?>
                </ol>
            </div>
            </div></div>
        <?php endforeach; ?>
    </div></div>
    <!-- <div><pre>BB: <?php //$json?></pre></div>
    <div><pre id="serialize_output2">show here</pre></div> -->
    <?= $this->Html->script(['/widget/js/jquery-sortable.js'],['nonce'=>get_nonce])?>
    <script nonce="<?=get_nonce?>">
    $(document).on("click", ".widget-data .fa-caret-down", function() {
        var nclas = $(this).closest('li').attr('id');
        $(".widget-data #" + nclas).removeClass('mb-2');
        $(".widget-data #" + nclas + " .wgt-text").toggle();
        $(".widget-data #" + nclas + " .card-body").addClass('p-0');
        $(".widget-data #" + nclas + " .fa-caret-down").attr('class', 'fa fa-caret-up pull-left');
    });
    $(document).on("click", ".widget-data .fa-caret-up", function() {
        var nclas = $(this).closest('li').attr('id');
        $(".widget-data #" + nclas).addClass('mb-2');
        $(".widget-data #" + nclas + " .wgt-text").toggle();
        $(".widget-data #" + nclas + " .card-body").removeClass('p-0');
        $(".widget-data #" + nclas + " .fa-caret-up").attr('class', 'fa fa-caret-down pull-left');
    });
    var group = $("ol.simple_with_drop").sortable({
        group: 'no-drop',
        handle: '.feather-more-vertical',
        onDragStart: function ($item, container, _super) {
            var old_id = $item[0]['id'];
            $id = "wigt" + Math.floor((Math.random() * 100000) + 1);
            if(old_id === ""){
                $item[0]['id'] = $id;
                $("#" + $item[0]['id']).attr('data-name',  $id);
                $("#" + $item[0]['id']).attr('data-id',  $id);
                $("#" + $item[0]['id'] + " form").attr('id', "f" + $id);
                $("#" + $item[0]['id'] + " form").attr('class', $id);
            }
            if(!container.options.drop)
                $item.clone().insertAfter($item);
            _super($item, container);
        },
        onDrop: function ($item, container, _super) {
            var data = group.sortable("serialize").get();
            save('site_widgetdata',serializ());
            //$('#serialize_output2').text(JSON.stringify(data, null, ' '));
            _super($item, container);
        }
    });
    $("ol.simple_with_no_drop").sortable({
        group: 'no-drop',
        drop: false,
    });
    $("ol.simple_with_no_drag").sortable({
        group: 'no-drop',
        drag: false
    });
    $(document).on("click", ".wid", function() {
        if (confirm("<?=__d('Widget','برای حذف مطمئن هستید ؟')?>") == true) {
            $(this).parent().parent().fadeOut(300, function(){ 
                $(this).remove();
                serializ();
                save('site_widgetdata' , serializ());
            });
            
            var nclas = 'sidebar_' + $(this).closest('li').attr('id');
            save("name" , nclas ,'delete');
        } 
    });
    $(document).ready(function() {
        serializ();
    });
    $("form").submit(function() {
        var id = $(this).attr('id');
        var classe = $(this).attr('class');
        var arr = {};
        $.each($(this).serializeArray(), function(i, field){
            var nam = field.name.replace("sidebar_[", "sidebar_"+ classe +'[')
            arr[nam] = field.value;
        });
        save('sidebar_' + classe , JSON.stringify(arr) ,'save' ,id);
        return false;
    });
    function serializ(){
        var data = group.sortable("serialize").get();
        var jsonString = (JSON.stringify(data, null, ' '));
        $('#serialize_output2').text(jsonString);
        return jsonString;
    }
    function save(field_name , field_data , action ='save', id = null){
        var form_data = new FormData();
        form_data.append(field_name, field_data);
        var urls = "<?= Router::url(['plugin'=>'Admin','controller' => 'Options', 'action' => 'SaveSetting','?'=>['show_error'=>0]],false) ?>";
        if(action === 'delete')
            urls = "<?= Router::url(['plugin'=>'Admin','controller' => 'Options', 'action' => 'DeleteSetting','?'=>['show_error'=>0]],false) ?>";
        $.ajax({
            type : 'POST',
            dataType: 'html',
            cache: false,
            async:true,
            contentType: false,
            processData: false,
            data: form_data ,
            url : urls,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', "<?=$this->request->getParam('_csrfToken')?>");
                if(id != null){
                    $("#" + id + " .submit .btn").val("<?=__d('Widget','در حال ذخیره')?> ...") ;
                }
            },
            success : function(data){
                $("#" + id + " .submit .btn")
                    .removeClass('btn-primary')
                    .addClass('btn-success')
                    .val("<?=__d('Widget','انجام شد')?>")
                    .wait(800)
                    .removeClass('btn-success')
                    .addClass('btn-primary')
                    .val("<?=__d('Widget','ذخیره')?>") ;
            },
            error:function (XMLHttpRequest, textStatus, errorThrown) {
                $("#" + id + " .submit .btn")
                    .removeClass('btn-primary')
                    .addClass('btn-danger')
                    .val("<?=__d('Widget','متاسفانه انجام نشد')?>")
                    .wait(1200)
                    .removeClass('btn-danger')
                    .addClass('btn-primary')
                    .val("<?=__d('Widget','ذخیره')?>");
                alert("<?=__d('Widget','هنگام انجام عملیات اطلاعات خطایی رخ داده است')?>");
                /* console.log(errorThrown);
                console.log(XMLHttpRequest['responseText']); */
            }
        });
    }
    (function ($) {
        function jQueryDummy ($real, delay, _fncQueue) {
            var dummy = this;
            this._fncQueue = (typeof _fncQueue === 'undefined') ? [] : _fncQueue;
            this._delayCompleted = false;
            this._$real = $real;
            if (typeof delay === 'number' && delay >= 0 && delay < Infinity)
                this.timeoutKey = window.setTimeout(function () {
                    dummy._performDummyQueueActions();
                }, delay);
            else if (delay !== null && typeof delay === 'object' && typeof delay.promise === 'function')
                delay.then(function () {
                    dummy._performDummyQueueActions();
                });
            else if (typeof delay === 'string')
                $real.one(delay, function () {
                    dummy._performDummyQueueActions();
                });
            else
                return $real;
        }
        jQueryDummy.prototype._addToQueue = function(fnc, arg){
            this._fncQueue.unshift({ fnc: fnc, arg: arg });
            if (this._delayCompleted)
                return this._performDummyQueueActions();
            else
                return this;
        };
        jQueryDummy.prototype._performDummyQueueActions = function(){
            this._delayCompleted = true;
            var next;
            while (this._fncQueue.length > 0) {
                next = this._fncQueue.pop();
                if (next.fnc === 'wait') {
                    next.arg.push(this._fncQueue);
                    return this._$real = this._$real[next.fnc].apply(this._$real, next.arg);
                }
                this._$real = this._$real[next.fnc].apply(this._$real, next.arg);
            }
            return this;
        };
        $.fn.wait = function(delay, _queue) {
            return new jQueryDummy(this, delay, _queue);
        };
        for (var fnc in $.fn) {
            if (typeof $.fn[fnc] !== 'function' || !$.fn.hasOwnProperty(fnc))
                continue;
            jQueryDummy.prototype[fnc] = (function (fnc) {
                return function(){
                    var arg = Array.prototype.slice.call(arguments);
                    return this._addToQueue(fnc, arg);
                };
            })(fnc);
        }
    })(jQuery);
    </script>
</div>