<?php
use Cake\Routing\Router;

$path = $this->request->getAttribute("webroot") . $upload_path;
function getMaximumFileUploadSize(){
    return min((ini_get('post_max_size')), (ini_get('upload_max_filesize')));  
}?> 
<div class="content-header row">
    <div class="content-header-right col-md-8 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title1 float-right mb-0">
                    <?= (isset($comment['id'])?__d('Admin', 'ویرایش رسانه'):__d('Admin', 'آپلود رسانه'))?>
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                        <?= $this->Auths->link(
                            __d('Admin', 'آپلود دستی'),
                            ['action'=>'Add2'],
                            ['class'=>'btn btn-sm btn-primary mr-1']);?>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header-left col-md-4 col-12 mb-2">
        <?= $this->Form->create(null, ['type' => 'get','validate'=>false]); ?>
        <div class="row" style="justify-content: flex-end;margin-left: 5px;">
            <?= $this->Form->control('parent_id', ['id'=>'parent_id',
                'options' => $parentCategory,
                'empty'=>'--  '.__d('Admin', 'دسته بندی').' --',
                'label'=>false,
                'default'=>$this->request->getQuery('parent_id'),
                'class' => 'form-control form-control-sm',]);?>

            <?= $this->Form->button(
                __d('Admin', 'آپلود در این دسته'),
                ['class'=>'btn btn-sm btn-success']);?>
        </div>
        <?= $this->Form->end(); ?>

        <script nonce="<?=get_nonce?>" type="text/javascript">
        $(document).ready(function() {
            $('#parent_id').on('change', function() {
                this.form.submit();
            });
        });
        </script>

    </div>
    
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body ath_container">
                <div class="dropzone dropzone-area dz-clickable" id="drop-area">
                    <br>
                    <div class="dz-message" style="flex-direction: column;;position: inherit;font-size:20px;"> <br>
                        <?= __d('Admin', 'پرونده (فایل) ها را کشیده و در صفحه رها کنید<br> 
                         و یا از فرم زیر بصورت تکی یا چندتایی انتخاب کرده و سپس  کلید شروع آپلود را بزنید')?>
                    
                        <div id="success-message-info" class="message success display-none"></div>
                        <br><br><br>
                    </div>
                    <meta name="csrfToken" content="<?= $this->request->getAttribute('csrfToken') ?>">
                    <div class=" tile-container text-center" style="display: flex;justify-content: center;">
                            <div id="uploadStatus"></div>
                            <input type="file" id="fileUpload" required multiple placeholder="choose file or browse" /><br>
                            <button class="btn btn-success" onclick="uploadFiles()">شروع آپلود</button>
                    </div>
                </div>

                <div class="show_result"><Br>
                    <div>
                        <table id="progressBarsContainer"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
#progressBarsContainer{
    width: 100%;
    margin-top: 10px !important;
}
#progressBarsContainer tr td:first-child{
    width: 35%;
}
</style>

<div class="row">
    <div class="col-sm-7 alert alert-warning" style="margin-right:15px;font-size:15px;color:#000 !Important">
        پسوند های مجاز :svg zip  rar  jpg  jpeg  png  gif  pdf  docx  doc  xls  xlsx  mp4  mp3
    </div>
    <div class="col-sm-4 alert alert-warning" style="margin-right:15px;font-size:15px;color:#000 !Important">
        حداکثر قابل اپلود: <span style="font-family: tahoma;"><?=getMaximumFileUploadSize();?></span>
    </div>

</div>


<script nonce="<?=get_nonce?>" type="text/javascript">
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

function uploadFile(file) {
    var token;
    token = Math.floor((Math.random() * 100000000) + 1);
    var formData = new FormData();
    formData.append('file', file);
    var csrfToken = document.querySelector('meta[name="csrfToken"]').getAttribute('content');
    formData.append('_csrfToken', csrfToken);
    formData.append('token', token);
    var progressBarContainer = document.createElement('div'); // Container for progress bar and file name
    progressBarContainer.className = 'progress-container';
    progressBarContainer.setAttribute("id", "upload_"+ token);
    var fileName = document.createElement('div'); // Display file name
    fileName.className = 'file-name';
    fileName.setAttribute("id", "up_"+ token);
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
                progressBar.innerHTML = "در حال پردازش اطلاعات ...";
            }
        }
    });
    xhr.addEventListener("loadstart", function(event) {console.log(event);});
    xhr.addEventListener("loadend", function(event) {
        result = JSON.parse(event.target.responseText);
        if( typeof result['token'] === 'undefined' ){
            progressBar.innerHTML = "متاسفانه عملیات با شکست انجام شد";
        }
        else{
            progressBar.innerHTML = "عملیات انجام شد";
            progressBar.className = 'progress-bar d-none';
            if(typeof result['token'] != 'undefined') {
                var uploadStatus = document.getElementById( "upload_" + result['token']);
                uploadStatus.innerHTML += '<div class="alert"><a target="_blank" href="<?=  Cake\Routing\Router::url('/'.$upload_path, true);?>' + result['filename']+'"><?=  Cake\Routing\Router::url('/'.$upload_path, true);?>' + result['filename']+"</div>";
            }
            if(typeof result['thumbnail']['fulladdr'] != 'undefined') {
                var up_image = document.getElementById( "up_" + result['token']);
                up_image.innerHTML = '<img src="'+result['thumbnail']['fulladdr']+'">' + result['filename'];
            }
        }
    });
    xhr.addEventListener('load', function(event) {});
    xhr.addEventListener("error", function(event) {console.log(event);});
    xhr.open('POST', "<?=  Cake\Routing\Router::url(null, true);?>", true);
    /* xhr.timeout = 10000; // Set timeout to 4 seconds (4000 milliseconds)
    xhr.setRequestHeader("Content-Type", "multipart/form-data");
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded'); */

    console.log(csrfToken);
    if (!csrfToken) {
        console.error('CSRF token not found');
        return;
    }
    xhr.setRequestHeader('X-CSRF-Token', csrfToken);

    xhr.getResponseHeader('Content-Type');
    xhr.withCredentials = true;
    xhr.onreadystatechange = function(){
        if(xhr.readyState == 4){
            console.log(this.responseText);
        }
    }
    xhr.send(formData);
}
$(function() {
    $('#FilUploader').change(function() {
        var fileExtension = ['webp','svg','zip','rar','jpg','jpeg','png','gif','pdf','docx','doc','xls','xlsx','mp4','mp3'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            alert("فایل آپلودی دارای پسوند غیرمجاز می باشد و آپلود نخواهد شد");
        }
    });
})
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
    border: 1px solid 
#ddd;
    margin-top: 20px;
}
.ath_container table th,
.ath_container table td {
    padding: 5px;
    border: 1px solid #ededed;
    width: 50%;
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