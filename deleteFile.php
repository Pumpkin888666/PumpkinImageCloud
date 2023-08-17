<?php
include './includes/common.php';
$id = $_POST['id'];
$filename = $_POST['filename'];
if(empty($id) || empty($filename)){
    echo json_encode(array('code' => -1));
    exit();
}else{
    $stmt = $conn->prepare("DELETE FROM file WHERE id = ?;");
    $stmt->bind_param("s", $id);
    if($stmt->execute() && file_exists(ROOT . "/uploads/$filename")){
        if(unlink(ROOT . "/uploads/$filename")){
            echo json_encode(array('code' => 0));
            exit();
        }else{
            echo json_encode(array('code' => -1));
            exit();
        }
    }else{
        echo json_encode(array('code' => -1));
        exit();
    }
}