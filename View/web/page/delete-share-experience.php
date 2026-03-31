<?php

require_once('Model/DBconnect.php');

if (isset($_GET['naitei_id'])){
    // $student_code = $_GET['student_code'];
    $naitei_id = $_GET['naitei_id'];
    $sql = "DELETE  FROM shiken WHERE shiken_id ='$naitei_id'";
    $sql1 = "DELETE recruit , naitei  FROM recruit  INNER JOIN naitei  
     WHERE recruit.recruit_id= naitei.naitei_id and recruit.recruit_id = '$naitei_id'";
    $query = mysqli_query($conn,$sql);
    $query1 = mysqli_query($conn,$sql1);

    if (isset($query)){
        echo "削除を完了しました。";
        header('Location: ?index.php');
    } else {
        echo "削除を完了しませんでした。";
    }
}
?>