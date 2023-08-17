<?php
include './includes/common.php';
$filename = $_GET['filename'];
if(empty($filename) || !file_exists("uploads/$filename")){ //如果没有这个参数或者文件不存在直接跳转主页
    include './index.php';
    exit();
}
$filetype = array('image'=>array('png','jpg','jepg','gif','PNG','JPG','JEPG','GIF'),'video'=>array('mp4','MP4'),'compress'=>array('zip','7z','rar','ZIP','7Z','RAR'));
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>南瓜图床-文件详情</title>
    <link rel="stylesheet" href="./assets/bootstrap/bootstrap.min.css">
    <style>
        .card{
            width: 100%;
            box-shadow: 2px 2px 12px 2px #ccc;
            border-radius: 7px;
        }
        
        .view{
            width: 100%;
            min-height: 300px;
            max-height: 450px;
        }
        
        .svg{
            width: 30%;
            margin: 20px 30%;
        }
        
    </style>
</head>
<body>
    <!-- 导航栏 -->
    <nav class="navbar navbar-light bg-light fixed-top">
        <a class="navbar-brand" href="index.php">南瓜图床</a>
        <form class="form-inline" method="GET" action="index.php">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">搜索</button>
            &nbsp
            <a href="upload.html" class="btn btn-outline-primary"><img src="/assets/svg/upload.svg"> 上传</a>
        </form>
    </nav>
    <!-- 文件详情 -->
    <div class="container" style="margin-top: 80px;">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">文件查看器 - <?php echo $filename ?></h5>
                        <?php 
                        $extension = pathinfo("/uploads/$filename", PATHINFO_EXTENSION);
                        if(in_array($extension,$filetype['image'])){
                            ?>

                        <p class="card-text">图片查看器</p>
                        <div>
                            <a href="/uploads/<?php echo $filename ?>" title="点击查看原图">
                                <img src="/uploads/<?php echo $filename ?>" alt="玩命加载中..." class="view">
                            </a>
                        </div>

                        <?php
                        }else if(in_array($extension, $filetype['video'])){ ?>

                        <p class="card-text">视频查看器</p>
                        <div>
                            <a href="/uploads/<?php echo $filename ?>" title="点击查看原视频">
                                <video class="view" controls>
                                    <source src="/uploads/<?php echo $filename ?>" type="video/mp4">
                                </video>
                            </a>
                        </div>

                        <?php
                        }else if(in_array($extension, $filetype['compress'])){ ?>
                        
                        <p class="card-text">压缩包示例的查看器</p>
                        <div>
                            <img src="/assets/svg/file-earmark-zip.svg" alt="玩命加载中..." class="svg">
                        </div>
                        
                        <?php }else{?>

                        <p class="card-text">其他文件的查看器</p>
                        <div>
                            <img src="/assets/svg/file-earmark.svg" alt="玩命加载中..." class="svg">
                        </div>

                        <?php } ?>
                        <a class="btn btn-outline-primary" href="down.php?filename=<?php echo $filename ?>" style="margin-top:10px;">下载文件</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" style="width: 70%;">
                    <div class="card-body">
                        <h5 class="card-title">手机扫码即可下载文件</h5>
                        <img alt="二维码" src="//api.qrserver.com/v1/create-qr-code/?size=180x180&amp;margin=10&amp;data=<?php 
                        $http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
                        $domain = $http_type . $_SERVER['HTTP_HOST'];
                        echo $domain . '/down.php?filename=' . $filename;
                        ?>" style="margin: 0 auto;">
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>