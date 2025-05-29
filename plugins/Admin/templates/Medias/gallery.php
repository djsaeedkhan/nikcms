<?php use Cake\Routing\Router; ?>

<div id="continit">
    <?php if(!isset( $this->request->getParam('?')['name'])):?>
        <div class="row dataTables_wrapper " style="float:left">
            <div id="DataTables_Table_0_filter" class="dataTables_filter">
                <label>
                    <?=__d('Admin', 'جستجو نام فایل')?> :
                     <input type="search" class="form-control form-control-sm" placeholder="" id="search_name"></label>
            </div>
        </div>
    <?php endif;?>
    <ul class="nav nav-tabs" role="tablist3">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#home1" role="tab" aria-controls="home1">
                <?= __d('Admin', 'گالری رسانه');?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#profile2" role="tab" aria-controls="profile2">
                <?=__d('Admin', 'افزودن رسانه');?></a>
        </li>
    </ul>

	<div class="tab-content">
		<div class="tab-pane active" id="home1" role="tabpanel">
			<div class="row">
				<?php foreach ($media as $media):
				$extension= strtolower(pathinfo($media->title, PATHINFO_EXTENSION));
				$path = $this->request->getAttribute("webroot") . $upload_path;
				if(in_array($extension,['jpg','jpeg','png','gif'])){
					$thumbfile = $this->Func->show_post_thumbnail($media);
					$thumb =  $path .$thumbfile ;
					$medium = $path . $this->Func->show_post_thumbnail($media,'medium');
					$full = Router::url('/',true) . $upload_path . $media->title;
				}
				else{
					$thumbfile = "ext-$extension.jpg";
					$thumb = $medium = $this->request->getAttribute("webroot").'admin/img/'. $thumbfile ;
					$full = Router::url('/',true) .$upload_path . $media->title;
				}
				if($thumbfile == '' /* or  !file_exists(WWW_ROOT.'uploads/'.$thumbfile) */) $thumb = ' ';
				?>
				<div class="col-md-2" style="margin-bottom:10px;">
					<a style="height: 150px; width: 100%; background:#FFF" >
						<img 
							class="card-img-top img-thumbnail" 
							style="background:#FFF;font-size: 12px;;" 
							title="<?=$media->title;?>" 
							src="<?= @$thumb;?>"
							srcfull="<?= $media->id;?>"
							imgfull = '<?=$full;?>'
							alt1="<?= $thumb == ' '?__d('Admin', 'فایل پیدا نشد'):$media->title;?>" 
							data-holder-rendered="true">
                    </a>
				</div>
				<?php endforeach; ?>
			</div>

			<div class="pagn">
				<?= $this->element('Admin.paginate')?>
			</div>
		</div>
	  
		<!-- ------------------------------------------------- --->
		<div class="tab-pane" id="profile2" role="tabpanel">
			
            

                <div class="card-body ath_container">
                    <div class="dropzone dropzone-area dz-clickable">
                        
                        <?= $this->Form->create(null, ['type' => 'file']);?>
                        <div id="drop-area">
                            <div class="dz-message" style="flex-direction: column;;position: inherit;font-size:20px;"> <br>
                                <?= __d('Admin', 'پرونده (فایل) ها را کشیده و در صفحه رها کنید<br> 
                                و یا از فرم زیر بصورت تکی یا چندتایی انتخاب کرده و سپس  کلید شروع آپلود را بزنید')?>
                                <div id="success-message-info" class="message success display-none"></div>
                                <br>
                            </div>
                        </div>
                        <?= $this->Form->end(); ?>
                        <br>
                        
                        <div class=" tile-container text-center" style="display: flex;justify-content: center;">
                            <div id="uploadStatus"></div>
                            <input type="file" id="fileUpload" required multiple placeholder="choose file or browse" /><br>
                            <button class="btn btn-success" onclick="uploadFiles()">شروع آپلود</button>
                        </div>
                    </div>

                    <div class="show_result">
                        <div>
                            <table id="progressBarsContainer"></table>
                        </div>
                    </div>
                </div>

                <?php //include_once('upload_kit.php');?>

                <!-- <div class="row">
                    <div class="col-sm-6">
                        <?= $this->Form->control('file', [
                            'type' => 'file',
                            'label'=>false,
                            'style'=>'padding-top: 6px;',
                            'id'=>'sortpicture',
                            'templates'=> ['inputContainer' => ' {{content}} <span class="badge badge-danger upload_status"></span>'],
                            'class' => 'form-control form-control-sm']);?>
                    </div>
                    <div class="col-sm-6">
                        <?= $this->Form->control(
                            __d('Admin', 'شروع آپلود'), [
                            'type' => 'button',
                            'id'=>'upload',
                            'class' => 'btn btn-success btn-sm',
                            'label'=>false ]);?>
                    </div>
                </div> -->
            

            
			
			<!-- ------------------------------------------------- --->
			<div class="clearfix"></div><br>
			<div class="col-sm-12">
				<div class="ajax_upload_box"></div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>

</div>
<input type="hidden" id="post_cover_id">
<input type="hidden" id="post_cover_image">
<input type="hidden" id="image_full">

<script nonce="<?=get_nonce?>">
function uploadFiles() {
    var fileInput = document.getElementById('fileUpload');
    var files = fileInput.files;

    for (var i = 0; i < files.length; i++) {
        var allowedExtensions = ['.jpg', '.jpeg', '.png', '.pdf', '.svg','.gif', '.zip', '.rar', '.docx','.doc', '.xlsx','.xls','.mp4','.mp3'];
        var fileExtension = files[i].name.substring(files[i].name.lastIndexOf('.')).toLowerCase();

        if (allowedExtensions.includes(fileExtension)) {
            uploadFile(files[i]);
        } else {
            alert('Invalid file type: ' + fileExtension);
        }
    }
}

    var typingTimer;                //timer identifier
    var doneTypingInterval = 100;  //time in ms (5 seconds)
    $('#search_name').keyup(function(){
        clearTimeout(typingTimer);
        typingTimer = setTimeout(doneTyping, doneTypingInterval);
    });

    //user is "finished typing," do something
    function doneTyping () {
        $.ajax({
            data: {'name':$("#search_name").val()},                         
            type: 'GET',
            url:"<?= Router::url(['controller' => 'Medias', 'action' => 'Gallery'],false) ?>",
            dataType:"html", 
            evalScripts:true,
            success:function (data, textStatus) {
                $("#continit").html(data);
            },error(XMLHttpRequest, textStatus, errorThrown) {
                alert('<?= __d('Admin', 'در دریافت اطلاعات مشکلی پیش آمده است')?>');
            }   
        });
        return false;
    }
    /* ------------------------------------------------------------ */
    $(".pagination a").bind("click", function (event) {
        if(!$(this).attr('href'))
            return false;
        $('#continit .nav-item .active').html($('.nav-item .active').html() + '&nbsp; <small style="color:#000;"> درحال دریافت ...</small> ');
        $.ajax({
            dataType:"html", 
            evalScripts:true,
            success:function (data, textStatus) {
                //var page_content = $('.paginator',data).get(0);
                $("#continit").html(data);
            },error(){
                alert('<?= __d('Admin', 'در دریافت اطلاعات مشکلی پیش آمده است')?>');
            }, 
            url:$(this).attr('href')
        });
        return false;
    });
    /* ------------------------------------------------------------ */
    $("img.card-img-top").click(function(e){
        $('img.card-img-top').attr("style", "background:#FFF");
        $(this).attr("style", "background:#f44336 !important");
        $('#post_cover_id').val($(this).attr('srcfull'));
        $('#post_cover_image').val($(this).attr('src'));
        $('#image_full').val($(this).parent().find('img').attr('imgfull'));
    });
    $(document).on('click', '.card2-img-top', function(e) {
        $('.card2-img-top').parent().parent().parent().parent().attr("style", "background:#FFF;color:#856404");
        $(this).parent().parent().parent().parent().attr("style", "background:#ffeeba;");
        $('#post_cover_id').val($(this).parent().find('img').attr('srcfull'));
        $('#post_cover_image').val($(this).parent().find('img').attr('src'));
        $('#image_full').val($(this).parent().find('img').attr('imgfull'));
    });
    /* ------------------------------------------------------------ */
    $('#upload').on('click', function() {
        var file_data = $('#sortpicture').prop('files')[0];  
        var full_url = "<?= Router::url('/',true) . $upload_path ;?>";
        var form_data = new FormData();
        if ($('#sortpicture').get(0).files.length === 0) {
            alert("No files selected.");
            return false;
        }                  
        form_data.append('file', file_data);
        $("#upload").html('<?= __d('Admin', 'در حال ارسال')?> ...');
        $("#upload").attr("disabled", "disabled");
        $.ajax({
            url: "<?= Router::url(['controller' => 'Medias', 'action' => 'AjaxAdd'],false) ?>",
            dataType: 'html',cache: false,contentType: false,processData: false,
            data: form_data,                         
            type: 'POST',
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success : function(data){
                var thumbnail;
                $("#upload").removeAttr("disabled");
                retdata = (JSON.parse(data));
                if(typeof retdata['thumbnail'] === 'undefined'){
                    thumbnail = retdata;
                }
                else{
                    thumbnail = retdata['thumbnail']['fulladdr'];
                }
                if( data == '0'){
                    $("#upload").html('<?= __d('Admin', 'شروع آپلود')?>');
                    $(".upload_status").html('<?=__d('Admin', 'متاسفانه اپلود انجام نشد')?>');
                }
                else{
                    $("#upload").html('<?=__d('Admin', 'شروع آپلود')?>');
                    if(typeof retdata['thumbnail'] === 'undefined') {
                        $(".ajax_upload_box").html(''+
                        '<div class="alert alert-warning col-sm-12" style="padding: 4px;">'+
                                '<img class="rounded" imgfull="'+retdata['filename_fulladdr']+'" style="background:#FFF;width:30px;height:30px;" '+
                                ' srcfull="'+retdata['media_id']+'" '+
                                'src="'+retdata['fulladdr']+'" > '+ retdata['filename_fulladdr']+
                            ' <a href="#" class="card2-img-top pull-left" style="padding: 5px;">[<?=__d('Admin', 'انتخاب تصویر')?>]</a>'+
                        '</div>'+$(".ajax_upload_box").html());
                    }
                    else {
                        $(".ajax_upload_box").html(''+
                        '<div class="alert alert-warning col-sm-12" style="padding: 4px;">'+
                                '<img class="rounded" imgfull="'+retdata['filename_fulladdr']+'" style="background:#FFF;width:30px;height:30px;" '+
                                ' srcfull="'+retdata['media_id']+'" '+
                                'src="' + retdata['thumbnail']['fulladdr'] + '" > '+ retdata['filename_fulladdr']+
                            ' <a href="#" class="card2-img-top pull-left" style="padding: 5px;">[<?=__d('Admin', 'انتخاب تصویر')?>]</a>'+
                        '</div>'+$(".ajax_upload_box").html());
                    }
                    $("#sortpicture").val("");
                }

            },
            error:function (XMLHttpRequest, textStatus, errorThrown) {
                $("#upload").removeAttr("disabled");
                $(".upload_status").html('<div class="alert alert-danger"><?=__d('Admin', 'متاسفانه اپلود انجام نشد')?></div>');
            }
        });
    
    });

    function createFormData(files) {
        for (var i = 0; i < files.length; i++) {
            var allowedExtensions = ['.jpg', '.jpeg', '.png', '.pdf', '.svg','.gif', '.zip', '.rar', '.docx','.doc', '.xlsx','.xls','.mp4','.mp3'];
            var fileExtension = files[i].name.substring(files[i].name.lastIndexOf('.')).toLowerCase();
            if (allowedExtensions.includes(fileExtension)) {
                uploadFile(files[i]);
            } else {
                alert('Invalid file type: ' + fileExtension);
            }
        }
    }

    function uploadFile(file) {
        var token;
        token = Math.floor((Math.random() * 100000000) + 1);
        var formData = new FormData();
        formData.append('file', file);
        formData.append('token', token);
        var progressBarContainer = document.createElement('div'); // Container for progress bar and file name
        progressBarContainer.className = 'progress-container';
        progressBarContainer.setAttribute("id", "upload_"+ token);
        var fileName = document.createElement('div'); // Display file name
        fileName.className = 'file-name';
        fileName.setAttribute("id", "up_"+ token);
        fileName.setAttribute("width", "200");
        fileName.textContent = file.name;
        var progressBar = document.createElement('div'); // Create a new progress bar element
        progressBar.className = 'progress-bar';
        progressBar.id = 'progressBar_' + file.name;
        progressBarContainer.appendChild(progressBar);
        var progressBarsContainer = document.getElementById('progressBarsContainer');
        var newRow = document.createElement('tr'); // Create a new table row
        var newCell = document.createElement('td'); // Create a new table cell
        var newCell2 = document.createElement('td'); // Create a new table cell
        newCell.appendChild(fileName);
        newCell2.appendChild(progressBarContainer);
        newRow.appendChild(newCell);
        newRow.appendChild(newCell2);
        progressBarsContainer.appendChild(newRow);
        var xhr = new XMLHttpRequest();
        xhr.upload.addEventListener('progress', function(event) {
            // Reset the input field of type "file"
            document.getElementById('fileUpload').value = '';
            if (event.lengthComputable) {
                var percent = Math.round((event.loaded / event.total) * 100);
                progressBar.style.width = percent + '%';
                progressBar.innerHTML = percent + '%';
                if(percent == 100){
                    progressBar.innerHTML = "در حال پردازش اطلاعات";
                }
            }
        });
        xhr.addEventListener("loadstart", function(event) {/* console.log(event); */});
        xhr.addEventListener("loadend", function(event) {
            result = JSON.parse(event.target.responseText);
            if( typeof result['token'] === 'undefined' ){
                progressBar.innerHTML = "متاسفانه عملیات با شکست انجام شد";
            }
            else{

                /* 
                if(typeof result['thumbnail'] === 'undefined') {
                    $(".ajax_upload_box").html(''+
                    '<div class="alert alert-warning col-sm-12" style="padding: 4px;">'+
                            '<img class="rounded" imgfull="'+result['filename_fulladdr']+'" style="background:#FFF;width:30px;height:30px;" '+
                            ' srcfull="'+result['media_id']+'" '+
                            'src="'+result['fulladdr']+'" > '+ result['filename_fulladdr']+
                        ' <a href="#" class="card2-img-top pull-left" style="padding: 5px;">[<?=__d('Admin', 'انتخاب تصویر')?>]</a>'+
                    '</div>'+$(".ajax_upload_box").html());
                }
                else {
                    $(".ajax_upload_box").html(''+
                    '<div class="alert alert-warning col-sm-12" style="padding: 4px;">'+
                            '<img class="rounded" imgfull="'+result['filename_fulladdr']+'" style="background:#FFF;width:30px;height:30px;" '+
                            ' srcfull="'+result['media_id']+'" '+
                            'src="' + result['thumbnail']['fulladdr'] + '" > '+ result['filename_fulladdr']+
                        ' <a href="#" class="card2-img-top pull-left" style="padding: 5px;">[<?=__d('Admin', 'انتخاب تصویر')?>]</a>'+
                    '</div>'+$(".ajax_upload_box").html());
                } */
                
                progressBar.innerHTML = "عملیات انجام شد";
                progressBar.className = 'progress-bar d-none';
                if(typeof result['token'] != 'undefined') {
                    var uploadStatus = document.getElementById( "upload_" + result['token']);
                    uploadStatus.innerHTML += '<div class="alert"><a target="_blank" href="<?=  Cake\Routing\Router::url('/'.$upload_path, true);?>' + result['filename']+'"><?=  Cake\Routing\Router::url('/'.$upload_path, true);?>' + result['filename']+"</div>";
                }
                if(typeof result['thumbnail']['fulladdr'] != 'undefined') {
                    var up_image = document.getElementById( "up_" + result['token']);
                    up_image.innerHTML = 
                        '<div style="padding: 4px;line-break: anywhere;">'+
                                '<img class="rounded" imgfull="'+result['filename_fulladdr']+'" style="background:#FFF;width:30px;height:30px;" '+
                                ' srcfull="'+result['media_id']+'" '+
                                'src="' + result['thumbnail']['fulladdr'] + '" >'+'<a class="card2-img-top" style="padding: 5px;">[<?=__d('Admin', 'انتخاب تصویر')?>]</a><br>'+
                                result['filename_real']+
                        '</div>';
                        //'<img src="'+result['thumbnail']['fulladdr']+'">' + ;
                }
            }
        });
        xhr.addEventListener('load', function(event) {});
        xhr.addEventListener("error", function(event) {/* console.log(event); */});
        xhr.open('POST', "<?=  Cake\Routing\Router::url('/admin/medias/add', true);?>", true);
        /* xhr.timeout = 10000; // Set timeout to 4 seconds (4000 milliseconds)
        xhr.setRequestHeader("Content-Type", "multipart/form-data");
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded'); */
        xhr.getResponseHeader('Content-Type');
        xhr.withCredentials = true;
        xhr.onreadystatechange = function(){
            if(xhr.readyState == 4){
                /* console.log(this.responseText); */
            }
        }
        xhr.send(formData);
    }

    $(document).ready(function() {
        $("#drop-area").on('dragenter', function (e){
            e.preventDefault();
            $(this).css('background', '#7367f021');
        });

        $("#drop-area").on('dragover', function (e){
            e.preventDefault();
        });

        $("#drop-area").on('drop', function (e){
            $(this).css('background', '#FFFFFF');
            e.preventDefault();
            var image = e.originalEvent.dataTransfer.files;
            createFormData(image);
        });
    });

</script>
<style>
.dropzone .dz-message:before {
    position: initial;
}
.dropzone{
    min-height:inherit;
}
div.dataTables_wrapper div.dataTables_filter input {
    margin-left: .5em;
    display: inline-block;
    width: auto;
}
.dataTables_wrapper .form-control-sm {
    height: calc(1.648438rem + 2px);
    padding: .25rem .5rem;
    font-size: .765625rem;
    line-height: 1.5;
    border-radius: .2rem;
}
.dataTables_wrapper .form-control {
    height: 28px;
    color: #5c6873;
    border: 1px solid #c2cfd6;
    border-radius: 0;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    margin-left: 14px !important;
}
.dataTables_wrapper [type=search] {
    outline-offset: -2px;
    -webkit-appearance: none;
}
#home1 .img-thumbnail{
    width: 100%;
    min-width: 103px;
    height: 95px;
    min-height: 103px;
    background: #f8f8f8 !important;
    /* border-radius: 5px; */
}

#home1 .img-thumbnail:before {
    content: ' ';
    display: block;
    position: absolute;
    height: 95px;
    width: 95px;
    background: url("<?=Router::url('/admin/img/no_picture_available.png')?>") center;
    /* border-radius: 5px; */
    background-size: cover;
}
</style>
<style>
.progress-container{
    line-break: anywhere;
}
.progress-container .alert{
    direction: ltr;
    text-align: left;
    margin-top: 5px;
}
.dropzone .dz-message:before {
    position: initial;
}

#drop-area {
    /* border-style: dotted;
    min-height: 200px;
    padding: 10px;
    border-color: #999;
    border-radius: 15px;
    stroke-width: 1px;
    margin-bottom: 15px; */
}

h3.drop-text {
    color: #999;
    text-align: center;
    font-size: 2em;
}

#loader-icon {
    display: none;
}
/* .ath_container {
    width: 740px;
    margin: 20px auto;
    padding: 0px 20px 0px 20px;
} */

/* .ath_container {
    width: 820px;
    border: #d7d7d7 1px solid;
    border-radius: 5px;
    padding: 10px 20px 10px 20px;
    box-shadow: 0 0 5px rgba(0, 0, 0, .3);
} */

#uploadStatus {
    color: #00e200;
}

.ath_container a {
    text-decoration: none;
    color: #2f20d1;
}

.ath_container a:hover {
    text-decoration: underline;
}

.ath_container img {
    height: auto;
    max-width: 100%;
    vertical-align: middle;
    max-width: 60px;
    max-height: 60px;
    border: 1px solid #CCC;
    border-radius: 5px;
    padding: 1px;
    margin-left: 10px;
}


.ath_container .label {
    color: #565656;
    margin-bottom: 2px;
}
.ath_container .message {
    padding: 6px 20px;
    font-size: 1em;
    color: rgb(40, 40, 40);
    box-sizing: border-box;
    margin: 0px;
    border-radius: 3px;
    width: 100%;
    overflow: auto;
}
.ath_container .error {
    padding: 6px 20px;
    border-radius: 3px;
    background-color: #ffe7e7;
    border: 1px solid #e46b66;
    color: #dc0d24;
}
.ath_container .success {
    background-color: #48e0a4;
    border: #40cc94 1px solid;
    border-radius: 3px;
    color: #105b3d;
}
.ath_container .validation-message {
    color: #e20900;
}
.ath_container .font-bold {
    font-weight: bold;
}

.ath_container .display-none {
    display: none;
}
.ath_container .inline-block {
    display: inline-block;
}

.ath_container .float-right {
    float: right;
}

.ath_container .float-left {
    float: left;
}

.ath_container .text-center {
    text-align: center;
}

.ath_container .text-left {
    text-align: left;
}

.ath_container .text-right {
    text-align: right;
}

.ath_container .full-width {
    width: 100%;
}

.ath_container .cursor-pointer {
    cursor: pointer;
}

.ath_container .mr-20 {
    margin-right: 20px;
}
.ath_container .m-20 {
    margin: 20px;
}
.ath_container table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
    border: 1px solid #ddd;
    margin-top: 20px;
}
.ath_container table th,
.ath_container table td {
    padding: 5px;
    border: 1px solid #ededed;
    width: 20%;
}

tr:nth-child(even) {
    background-color: #f2f2f2
}

.ath_container .progress {
    margin: 20px 0 0 0;
    width: 300px;
    border: 1px solid #ddd;
    padding: 5px;
    border-radius: 5px;
}

.progress-bar {
    width: 0%;
    height: 20px;
    background-color: #4CAF50;
    margin-top: 5px;
    border-radius: 20px;
    text-align: center;
    color: #fff;

}

@media all and (max-width: 780px) {
    .ath_container {
        width: auto;
    }
}


.ath_container input,
.ath_container textarea,
.ath_container select {
    box-sizing: border-box;
    width: 300px;
    height: initial;
    padding: 8px 5px;
    border: 1px solid #9a9a9a;
    border-radius: 4px;
    margin-left: 10px;
}

.ath_container input[type="checkbox"] {
    width: auto;
    vertical-align: text-bottom;
}

.ath_container textarea {
    width: 300px;
}

.ath_container select {
    display: initial;
    height: 30px;
    padding: 2px 5px;
}

/* .ath_container button,
.ath_container input[type=submit],
.ath_container input[type=button] {
    padding: 8px 30px;
    font-size: 1em;
    cursor: pointer;
    border-radius: 25px;
    color: #ffffff;
    background-color: #6213d3;
    border-color: #9554f1 #9172bd #4907a9;
} */

.ath_container input[type=submit]:hover {
    background-color: #f7c027;
}

::placeholder {
    color: #bdbfc4;
}

.ath_container label {
    display: block;
    color: #565656;
}

@media all and (max-width: 400px) {
    .ath_container {
        padding: 0px 20px;
    }
    .ath_container {
        width: auto;
    }
    .ath_container input,
    .ath_container textarea,
    .ath_container select {
        width: 100%;
    }
}
</style>