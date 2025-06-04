<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    <?= __('بازسازی تصاویر بندانگشتی');?>
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-4">
        <div class="row">
        <?php 
        foreach($this->Func->gallery_size() as $k=>$size):?><div class="col-md-6">
            <div class="card ltr pb-0">
                <div class="card-header pb-0 ltr" data-toggle="collapse" role="button"  aria-expanded="true" aria-controls="collapseTwo">
                    <span class="lead collapse-title" style="text-transform:capitalize;font-family:tahoma;"><b><?=$k?></b></span>
                </div>
                <div id="collapseTwo" class="collapse show ltr">
                    <div class="card-body pt-0"style="text-align: left;font-family:tahoma;">
                        Width: <?= $size['width']?><br>
                        Height: <?= $size['height']?><br>
                        Mode: <?= $size['mode']?><br>
                    </div>
                </div>
            </div></div>
        <?php endforeach;?>
        </div>
    </div>
    
    <div class="col-sm-8">
        <div class="card">
            <div class="ltr bx1" style="height : 60vh !important;">
            <?php 
            $i=0;
            foreach ($result  as $key => $value) {
                echo '<span data-id="'.$key.'" id="p'.$key.'" data-url="'.$value.'">'.
                    $this->html->link(
                        $value,
                        '/'.$upload_path.'/'.$value,
                        ['target'=>'_blank']).
                        '</span><hr class="my-0">';
                /* if($i == 5)
                    break;
                $i+=1; */
            }?>
            </div>
            <!-- <div class="progress progress-bar-primary">
                <div class="progress-bar progress-bar-striped progress-bar-animated1" 
                    role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" 
                    style="width: 0%;"></div>
            </div> -->
        </div>

        <?php 
        /* $this->Form->postlink('شروع فرایند ('.count($result).' تصویر)',
            ['?'=>['do'=>'create']],
            ['class'=>'btn btn-success',
            'confirm'=>'برای شروع عملیات موافق هستید؟ این فرایند ممکن است زمانبر باشد']); */

        echo $this->html->link('شروع فرایند ('.count($result).' تصویر)','#',
            ['class'=>'btn btn-success','id'=>'startbox']);
        ?>
    </div>
</div><br>

<script nonce="<?=get_nonce?>">
    var myEl = document.getElementById('startbox');
    myEl.addEventListener('click', function(e) {
        if (confirm('برای انجام این فرایند موافق هستید؟')) {
            var total = $('.bx1 span').length;
            total = Math.ceil(100 / total);

            /* setInterval(function() {
                console.log("asd11");
                var color = $(".progress-bar").attr('aria-valuenow');
                color = parseInt(color) + parseInt(total) ;
                $(".progress-bar").attr('aria-valuenow',color)
                $(".progress-bar").css("width",color+'%')
            }, 2000); */

            var dicts = []; // create an empty array
            var hash = {};
            var i =0;
            $('.bx1 span').each(function() {
                hash[i] = {
                    key:   $(this).attr('data-id'),
                    value: $(this).attr('data-url')
                };

                /* var id = $(this).attr('data-id');
                var url = $(this).attr('data-url');
                var i = 0;
                setTimeout(function() {
                    i++;
                    if (i < 5) {
                        get_data(id , url, total); 
                    }
                    //$('html, body').animate({scrollTop: $("#p"+id).offset().top}, 5000);
                }, 7000); */

                i+=1;
            });
            get_data(hash , 0); 

            //console.log(hash[0]);
            //console.log(Object.keys(dicts)[0]);
            
            e.preventDefault();
        }
    }, false);

    function get_data(id, url,total){
        $.ajax({type : 'POST',async: false,data: 'id='+id+'&url='+url,url : "",
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', "<?= $this->request->getParam('_csrfToken')?>");
                $("#startbox").text("در حال انجام فرایند ...") ;
                $("#startbox").attr('disabled','disabled') ;
                $('#startbox').removeAttr('id');
                setTimeout(function() {console.log("wait4");}, 2000);
            },
            success : function(data) {
                $("#p"+id).css("color","#CCC");
                $("#p"+id +" a").css("color","#CCC");
                setTimeout(function() {console.log("wait3");}, 2000);
            },
            error:function (XMLHttpRequest, textStatus, errorThrown) {
                alert("متاسفانه اطلاعاتی پیدا نشد");
            },
            complete: function (data) {
                var color = $(".progress-bar").attr('aria-valuenow');
                color = parseInt(color) + parseInt(total);
                $(".progress-bar").attr('aria-valuenow',color);
                $(".progress-bar").css("width",color+'%');
                $("#p"+id).css("color","#CCC");
                $("#p"+id+" a").css("color","#CCC");
                setTimeout(function() {console.log("wait2");}, 2000);
            }
        });
        setTimeout(function() {console.log("wait1");}, 2000);
    }
</script>
<style>
.bx1{
    height: 60vh !important;
    font-family: tahoma;
    line-height: 22px;
    padding: 10px 15px;
    overflow: auto;
    text-align:left;
}
</style>