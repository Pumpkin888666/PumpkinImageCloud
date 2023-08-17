function getFile() {
    $('#file').click();
}

$('#file').change(function () {
    $('.progress').slideDown();
    $('#btn').slideUp(function () {
        $('#btn').attr('onclick', 'upload(0)').removeClass('btn-outline-primary').addClass('btn-outline-success').text('开始上传').slideDown();
    });
})
function stopUpload() {
    upload.abort();
}
function upload(file) {
    if (file == 0) {
        var formData = new FormData(document.getElementById("uploadForm"));
    } else {
        var formData = new FormData(file);
    }
    $('#btn').slideUp(function () {
        $('#btn').removeClass('btn-outline-success').addClass('btn-outline-danger').attr('onclick', 'stopUpload()').text('停止上传').slideDown();
    })
    upload = $.ajax({
        url: 'upload.php',
        type: 'post',
        contentType: false,
        processData: false,
        data: formData,
        timeout: 300000,
        xhr: function () {
            var myXhr = $.ajaxSettings.xhr();
            if (myXhr.upload) { //检查上传的文件是否存在
                myXhr.upload.addEventListener('progress', function (e) {
                    var loaded = e.loaded; //已经上传大小情况 
                    var total = e.total; //附件总大小 
                    var percent = Math.floor(100 * loaded / total) + "%"; //已经上传的百分比  
                    //显示进度条
                    $('#uploadProgress').css('width', percent).text(percent);
                }, false);
            }
            return myXhr;
        },
        success: function (data) {
            var json = $.parseJSON(data);
            if (json.code == -1) {
                alert(json.message);
                window.location.href = 'upload.html';
            } else if (json.code == 0) {
                alert(json.message)
                window.location.href = 'detail.php?filename=' + json.filename;;
            }
            $('#btn').slideUp(function () {
                $('#btn').attr('onclick', 'getFile()').removeClass('btn-outline-success').removeClass('btn-outline-danger').addClass('btn-outline-primary').text('选择文件').slideDown();
                $('#progress').slideUp(function () {
                    $('#uploadProgress').css('width', '0%').text('0%');
                })
            });
        },
        error: function () {
            alert("上传终止");
            window.location.href = 'upload.html';
        }
    })
};