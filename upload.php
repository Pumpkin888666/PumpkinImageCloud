<?php
include './includes/common.php';
// 允许上传的图片后缀
$filename = $_FILES["file"]["name"];
$filename = trim($filename); //清除字符串两边的空格
$filename = preg_replace("/\t/","",  $filename); //使用正则表达式替换内容，如：空格，换行，并将替换为空。
$filename = preg_replace("/\r\n/","",$filename); 
$filename = preg_replace("/\r/","",  $filename); 
$filename = preg_replace("/\n/","",  $filename); 
$filename = preg_replace("/ /","",   $filename);
$filename = preg_replace("/  /","",  $filename);
$allowedExts = array("gif", "jpeg", "jpg", "png","GIF","JPEG","JPG","PNG");
$temp = explode(".", $filename);
$extension = end($temp);     // 获取文件后缀名
if (in_array($extension, $allowedExts)){
    if ($_FILES["file"]["error"] > 0){
        echo json_encode(array("code" => -1, "message" => $_FILES["file"]["error"]));
    }
    else{
        if (file_exists("uploads/" . $filename))
        {
            echo json_encode(array("code" => -1, "message"=>"文件已存在，请换个名字"));
        }
        else
        {
            // 如果 upload 目录不存在该文件则将文件上传到 upload 目录下
            move_uploaded_file($_FILES["file"]["tmp_name"], "uploads/" . $filename);
            $time = date('Y/m/d');
            $sql = 'INSERT INTO file(filename,uploadtime) VALUES("'.$filename.'","'.$time.'");';
            if($conn->query($sql)){
                echo json_encode(array('code' => 0, 'message' => '文件上传成功点击确定跳转详情页','filename'=>$filename));
            }else{
                echo json_encode(array('code' => -1, 'message' => '文件上传成功但是数据库记录失败'.$time));
            }
        }
    }

}else{
    echo json_encode(array("code" => -1, "message" => "文件被拒绝上传"));
}
?>
