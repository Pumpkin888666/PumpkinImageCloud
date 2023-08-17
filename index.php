<?php
include './includes/common.php';
?> 

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>南瓜图床-首页</title>
    <link rel="stylesheet" href="./assets/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/layui/css/layui.css">
    <style>
        .seemcard{
            box-shadow: 2px 2px 12px 2px #ccc;
            border-radius: 7px;
            border: 1px black;
            padding: 10px;
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
    <!-- 文件列表 -->
    <?php 
    if(!$_GET['Search']){
    ?>
    <div class="container seemcard" style="margin-top: 80px;">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>文件名</th>
                    <th>文件大小</th>
                    <th>文件操作</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = 'SELECT * FROM file';
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '  <tr>
                                    <td>'.$row['id'].'</td>
                                    <td>' . $row['filename'] . '</td>
                                    <td>' . filesize("./uploads/".$row['filename']) . 'kb</td>
                                    <td>
                                    <a href="detail.php?filename=' . $row['filename'] . '" class="btn btn-sm btn-outline-primary"><img src="/assets/svg/folder.svg"> 文件详情</a>
                                    <button class="btn btn-sm btn-outline-danger" onclick="DeleteFile(' . $row['id'] .',\''. $row['filename'].'\')"><img src="/assets/svg/trash.svg"> 删除文件</button>
                                    </td>
                                </tr>';
                    }
                }
                ?>
                
            </tbody>
        </table>
        <p style="text-align:center;">我也是有底线滴~</p>
    </div>
    <?php
    }else{
        $filename = $_GET['Search'];
    ?>
    <div class="container seemcard" style="margin-top: 80px;">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>文件名</th>
                    <th>文件大小</th>
                    <th>文件操作</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM file WHERE filename LIKE '%$filename%';";//模糊查询
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '  <tr>
                                    <td>'.$row['id'].'</td>
                                    <td>' . $row['filename'] . '</td>
                                    <td>' . filesize("./uploads/".$row['filename']) . 'kb</td>
                                    <td>
                                    <a href="detail.php?filename=' . $row['filename'] . '" class="btn btn-sm btn-outline-primary"><img src="/assets/svg/folder.svg"> 文件详情</a>
                                    <button class="btn btn-sm btn-outline-danger" onclick="DeleteFile(' . $row['id'] . ',\'' . $row['filename'] . '\')"><img src="/assets/svg/trash.svg"> 删除文件</button>
                                    </td>
                                </tr>';
                    }
                }
                ?>
                
            </tbody>
        </table>
        <p style="text-align:center;">我也是有底线滴~</p>
    </div>
    <?php
    }
    ?>
    <script src="/assets/bootstrap/jquery-3.7.0.min.js"></script>
    <script src="/assets/layui/layui.js"></script>
    <script>
        function DeleteFile(id,filename){
            var index = layer.confirm('确定删除id为 '+id+' 的文件吗？', function(){
                layer.close(index);
                var load = layer.load(1);
                $.post('deleteFile.php',
                {    // data数据，要参考并符合api格式给定
                    id: id,
                    filename:filename,
                },
                function (data) {    // 回调函数
                    var json = $.parseJSON(data);
                        if(json.code == -1){
                            layer.close(load);
                            layer.msg('删除失败!',{icon: 2})
                        }else if(json.code == 0){
                            layer.close(load);
                            layer.msg('删除成功!',{icon: 1})
                            setTimeout("window.location.href='index.php'", 2000)
                        }
                    }
                )
             }, function(){
                 layer.close(index);
             });
        }
    </script>
</body>
</html>