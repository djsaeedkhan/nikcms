
<div class="card-body ath_container">
    <div class="dropzone dropzone-area dz-clickable" id="drop-area">
        <br>
        <div class="dz-message" style="flex-direction: column;;position: inherit;font-size:20px;"> <br>
            <?= __d('Admin', 'پرونده (فایل) ها را کشیده و در صفحه رها کنید<br> 
                و یا از فرم زیر بصورت تکی یا چندتایی انتخاب کرده و سپس  کلید شروع آپلود را بزنید')?>
        
            <div id="success-message-info" class="message success display-none"></div>
            <br><br><br>
        </div>

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
                progressBar.innerHTML = "در حال پردازش اطلاعات";
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