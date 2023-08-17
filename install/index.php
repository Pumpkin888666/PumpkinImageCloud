<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>安装</title>
    <link rel="stylesheet" href="../assets/bootstrap/bootstrap.min.css">
    <style>
        .card{
            margin: 10vh auto;
            box-shadow: 2px 2px 12px 2px #ccc;
            border-radius: 7px;
        }
    </style>
</head>
<body>
    <?php

    $ConfigFile = '../config/config.php';
    ini_set("display_errors", "Off"); //关闭错误提示

    if(file_exists('install.lock')){ //检测是否安装过
        echo '
        <div class="container">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">您已安装！</h5>
                    <p class="card-text">检测到install目录下的install.lock文件,请不要重复安装！如果你要重新安装，请手动删除后再安装！</p>
                    <a href="#" class="btn btn-danger">我知道了！</a>
                </div>
            </div>
        </div>
        ';
        exit();
    };

    $step=isset($_GET['step'])?$_GET['step']:1;
    if($step == 1){ //简介页

        echo '
        <div class="container">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">安装系统</h5>
                    <p class="card-text">欢迎使用南瓜图床系统，接下来是极为简单的安装过程。</p>
                    <a href="index.php?step=2" class="btn btn-success">GO！</a>
                </div>
            </div>
        </div>
        ';

    }else if($step == 2){ //环境检测页

        $install = True;
        if(PHP_VERSION >= 7.4){
            $phpversion = "<span style='color:green;'>支持</span>";
        }else{
            $phpversion = "<span style='color:red;'>不支持</span>";
            $install = False;
        }
        if(is_writable($ConfigFile)){
            $writeable = "<span style='color:green;'>支持</span>";
        }else{
            $writeable = "<span style='color:red;'>不支持</span>";
        }
        if($install){ //这里是判断是否可以继续安装的地方，如果增加了其他需要支持的组件，在这里加就行。防君子不防小人，依然可以通过改step继续。
            $url = "index.php?step=3";
            $bclass = "btn btn-success";
            $text = 'Next';
        }else{
            $url = '#';
            $bclass = 'btn btn-danger';
            $text = '无法继续';
        }
        echo '
        <div class="container">
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">环境检测</h5>
                <div class="container">
                <ul style="list-style: none;">
                    <li>PHP>=7.4 '.$phpversion.'</li>
                    <li>根目录读取权限 '.$writeable.'</li>
                </ul>
                </div>
                <a href="'.$url.'" class="'.$bclass.'">'.$text.'</a>
                
            </div>
        </div>
        </div>
        ';
    
    }else if($step == 3){ //数据配置页

        echo '
        <div class="container">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">安装程序</h5>
                    <form action="index.php?step=4&jump=0" method="post">
                        <div class="form-group">
                            <label>数据库地址:</label>
                            <input type="text" class="form-control" value="localhost" name="host">
                        </div>
                        <div class="form-group">
                            <label>数据库用户名:</label>
                            <input type="text" class="form-control" name="user">
                        </div>
                        <div class="form-group">
                            <label>数据库密码:</label>
                            <input type="password" class="form-control" name="password">
                        </div>
                        <div class="form-group">
                            <label>数据库名:</label>
                            <input type="text" class="form-control" name="dbname">
                        </div>
                        <a href="index.php?step=2" class="btn btn-danger">上一步</a>
                        <button type="submit" class="btn btn-success">提交</button>
                    </form>
                    <a href="index.php?step=4&jump=1" class="btn btn-primary">已填写config.php点我跳过</a>
                </div>
            </div>
        </div>
        ';

    }else if($step == 4){//config设置阶段

       if ($_GET['jump'] == 0){ //没有写config，从前台提交。
            $host = $_POST['host'];
            $user = $_POST['user'];
            $password = $_POST['password'];
            $dbname = $_POST['dbname'];
            if(empty($host) ||empty($user) ||empty($password) ||empty($dbname)){//检查前台提交是否有空的
                echo '
                <div class="container">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h3>错误</h3>
                            <p>请你填写完整表单再提交！</p>
                            <a href="index.php?step=3" class="btn btn-danger">上一步</a>
                        </div>
                    </div>
                </div>
                ';
            }else{ //保存config阶段
                $config = "
<?php
/*数据库配置*/
\$dbconfig=array(
	'host' => '$host', //数据库服务器
	'port' => 3306, //数据库端口 只能3306
	'user' => '$user', //数据库用户名
	'password' => '$password', //数据库密码
	'dbname' => '$dbname', //数据库名
);
";
                if(file_put_contents($ConfigFile,$config)){ //检测是否成功保存
                    echo '
                    <div class="container">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h3>成功！</h3>
                            <p>数据保存成功！</p>
                            <a href="index.php?step=5" class="btn btn-success">下一步</a>
                        </div>
                    </div>
                    </div>
                    ';
                }else{
                    echo '
                    <div class="container">
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                                <h3>错误</h3>
                                <p>无法保存数据文件，请你手动填写config.php或者给该文件权限！</p>
                                <a href="index.php?step=3" class="btn btn-danger">上一步</a>
                            </div>
                        </div>
                    </div>
                    ';
                }

            }

        }else{ //填写过config的

            include '../config/config.php';
            $host = $dbconfig['host'];
            $user = $dbconfig['user'];
            $password = $dbconfig['password'];
            $dbname = $dbconfig['dbname'];
            if (empty($host) || empty($user) || empty($password) || empty($dbname)) { //检查前台提交是否有空的
                echo '
                <div class="container">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h3>错误</h3>
                            <p>请你填写完整config再提交！</p>
                            <a href="index.php?step=3" class="btn btn-danger">上一步</a>
                        </div>
                    </div>
                </div>
                ';
            }else{
                echo '
                    <div class="container">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h3>成功！</h3>
                            <p>数据读取成功！</p>
                            <a href="index.php?step=5" class="btn btn-success">下一步</a>
                        </div>
                    </div>
                </div>
                ';
            }

        }
    }else if($step==5){ //连接数据库
        //注意：每次按钮都是新页面，固然会使变量消失
        include '../config/config.php';
        $host = $dbconfig['host'];
        $user = $dbconfig['user'];
        $password = $dbconfig['password'];
        $dbname = $dbconfig['dbname'];
        $conn = new mysqli($host,$user, $password, $dbname);
        if ($conn->connect_error) {
            die('
            <div class="container">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h3>错误</h3>
                            <p>数据库连接失败！请你检查数据库配置是否正确！错误信息->'.mysqli_connect_error().'</p>
                            <a href="index.php?step=3" class="btn btn-danger">上一步</a>
                        </div>
                    </div>
                </div>
            ');
        }else{
            echo '<div class="container">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h3>成功</h3>
                        <p>数据库连接成功！</p>
                        <a href="index.php?step=6" class="btn btn-success">安装</a>
                    </div>
                </div>
            </div>';
        }
        $conn->close();
    }else if($step == 6){ // 安装数据库
        include '../config/config.php';
        $host = $dbconfig['host'];
        $user = $dbconfig['user'];
        $password = $dbconfig['password'];
        $dbname = $dbconfig['dbname'];
        $conn = new mysqli($host, $user, $password, $dbname);
        $_sql = file_get_contents('sql.sql'); //写自己的.sql文件
        $_arr = explode(';', $_sql);
        //执行sql语句
        $conn->query('set names utf8;'); //设置编码方式
        $oksql = 0;
        foreach ($_arr as $_value) {
            $conn->query($_value.';');
            $oksql++;
        }
        echo '<div class="container">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h3>成功</h3>
                        <p>语句执行成功 '.$oksql.' 条,共'.count($_arr,1).'条</p>
                        <a href="#" class="btn btn-success">完成</a>
                    </div>
                </div>
            </div>';
        if(file_put_contents('./install.lock','安装锁')){
            echo '<div class="container">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h3>成功</h3>
                        <p>成功创建安装锁</p>
                    </div>
                </div>
            </div>';
        }else{
            echo '<div class="container">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h3 style="color:red;">失败</h3>
                        <p>无法创建安装锁，这对您的网站有巨大危害，请手动在install目录下创建install.lock文件</p>
                    </div>
                </div>
            </div>';
        }
    }
    ?>
</body>
</html>