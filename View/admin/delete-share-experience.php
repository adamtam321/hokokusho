<?php
require_once('../../Model/DBconnect.php');


if (isset($_POST['student_code'])){
    $student_code = $_POST['student_code'];

    $sql = "DELETE  FROM shiken WHERE student_code = '$student_code'";
    $sql1 = "DELETE recruit , naitei  FROM recruit  INNER JOIN naitei  
     WHERE recruit.student_code= naitei.student_code and recruit.student_code = '$student_code'";
    $query = mysqli_query($conn,$sql);
    $query1 = mysqli_query($conn,$sql1);

    if (isset($query)){
        echo "削除を完了しました。";
    } else {
        echo "削除を完了しませんでした。";
    }
}
?>

