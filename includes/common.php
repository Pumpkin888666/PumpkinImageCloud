<?php
define('SYSTEM_ROOT', dirname(__FILE__) . '/'); //定义当前项目的根目录
define('ROOT', dirname(SYSTEM_ROOT) . '/'); //定义当前文件目录
date_default_timezone_set('Asia/Shanghai'); //设置时区
ini_set("display_errors", "On");
if (!PHP_VERSION >= 7.4) {
    echo '你的网站PHP版本低于7.4！极度建议你使用PHP7.4以上版本,在此之前我们不会工作。';
    exit();
}
if (!file_exists(ROOT . 'install/install.lock')) {
    echo '<p>你的网站没有安装！如果你安装了仍然出现此警告说明在install目录下创建install.lock锁失败，请你手动创建在使用！在此之前我们不会工作。</p><a href="/install">前往安装</a>';
    exit();
}

require SYSTEM_ROOT.'./conn.php';


?>