<?php
require_once('../../Model/DBconnect.php');


if (isset($_POST['student_code'])) {
    $student_code = $_POST['student_code'];
    $sql = "DELETE FROM student WHERE student_code = '$student_code'";
    $sql1 = "DELETE  FROM shiken WHERE student_code = '$student_code'";
    $sql2 = "DELETE recruit , naitei  FROM recruit  INNER JOIN naitei  
     WHERE recruit.student_code= naitei.student_code and recruit.student_code = '$student_code'";
    $query = mysqli_query($conn, $sql);
    $query1 = mysqli_query($conn, $sql1);
    $query2 = mysqli_query($conn, $sql2);
    if (isset($query)) {
        echo "削除を完了しました。";
    }
}
?>

