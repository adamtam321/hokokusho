<?php
//require_once('../../Model/DBconnect.php');
$server_username = "root";
$server_password = "";
$server_host = "localhost";
$database = 'hokokusho2021';

$conn = mysqli_connect($server_host, $server_username, $server_password, $database) or die("データベースを連携できません！");
mysqli_query($conn, "SET NAMES 'UTF8'");

$sql = "SELECT *  FROM shiken INNER JOIN student ON student.student_code = shiken.student_code
        INNER JOIN naitei ON naitei.student_code = shiken.student_code
        INNER JOIN recruit ON recruit.student_code = shiken.student_code 
       WHERE `company_name` like '%" . $_POST['name'] . "%'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    foreach ($result as $key => $students) :
        echo "
              <tr>
                   <td>" . $students['name'] . "</td>
                 <td>" . $students['student_code'] . "</td>
                 <td>" . $students['gender'] . "</td>
                 <td>" . $students['company_name'] . "</td>
                 <td>" . $students['date_time_interview'] . "</td>
                 <td>" . $students['address'] . "</td>
                <td class='function-student'>
                <a class='btn-primary' style='border-radius: 5px; height: 50px;padding: 11px 15px;padding-top: 5px;' href='index.php?view=update-share-experience&student_code=" . $students['student_code'] . "'>編集</a>
                <a href='javascript:0' onclick='deleteStudent(`". $students['student_code'] ."`)'   class='btn btn-danger'>削除</a>
                </td>
                </tr>
               ";
    endforeach;
} else {
    echo "<tr><th>報告書の情報がありません！</th></tr>";
}

?>
