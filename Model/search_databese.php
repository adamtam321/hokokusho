<?php
$data = "SELECT *  FROM shiken INNER JOIN student ON student.student_code = shiken.student_code
INNER JOIN naitei ON naitei.student_code = shiken.student_code
INNER JOIN recruit ON recruit.student_code = shiken.student_code
WHERE student.status = 0|| 1;";
//phuong thuc khoi tao sesstion de tao phien lam viec tren browser//
if (!isset($_SESSION)) {
    session_start();
}
//chuc nang seacher lay name trong html dung toan tu 3 ngoi//
$key = (isset($_GET['keyword'])) ? $_GET['keyword'] : [];


//* session của login dùng toan tử 3 ngồi để xét giá trị nếu isset (kiểm tra sesion user (name trong html) thì chyaj session đó không thì in ra rỗng)
$student = (isset($_SESSION['student'])) ? $_SESSION['student'] : [];

//lay giá trị trên trinh duyệt để xét nếu có thì sẽ lấy giá trị trong DB để in ra//
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';


//hàm check không rỗng
    if (!empty($keyword)) {
        $search = "SELECT *  FROM shiken INNER JOIN student ON student.student_code = shiken.student_code
        INNER JOIN naitei ON naitei.student_code = shiken.student_code
        INNER JOIN recruit ON recruit.student_code = shiken.student_code;
WHERE `company_name` like '%" . $key . "%'";
//kết nối với DB nếu có thí sẽ lấy DB và lưu
        $result = mysqli_query($conn, $search);
        var_dump($result);
        die($result);
    } else {
        $result = mysqli_query($conn, $data);
    }
?>