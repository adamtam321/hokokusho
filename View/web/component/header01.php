<?php
require_once('Model/DBconnect.php');
ob_start();
if (!isset($_SESSION)) {
    session_start();
}
$student = (isset($_SESSION['student'])) ? $_SESSION['student'] : [];
$studentId = (isset($_SESSION['student'])) ? $student['id'] : [];
$student_code = (isset($_SESSION['student'])) ? $student['student_code'] : [];
if (isset($_SESSION['student'])) {
    $nameStudent = "SELECT `student_name` FROM `student` WHERE id = $studentId";
    $query = mysqli_query($conn, $nameStudent);
    $data = mysqli_fetch_assoc($query);

    $shartReport = "SELECT `shiken_kekka` FROM `shiken` WHERE student_code = '$student_code'";
    $queryNaitei = mysqli_query($conn, $shartReport);
    $dataNaitei = mysqli_fetch_assoc($queryNaitei);
}
?>

<!-- Navigation-->
<!-- <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand" href="index.php"><img src="https://ueno.daiichi-koudai.ac.jp/wp-content/themes/daiichi_koudai_ueno/img/index/header_logo.svg" alt="..." /></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars ms-1"></i>
                </button>
                 
                <div class="navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                                              
                        <li class="nav-item">
                        
                        <?php if (isset($student['name'])) { ?>
                            <div class="profile-createform">
                                <?php
                                if (!empty($dataNaitei)) {  ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="javascript:0" onclick="errorReport()">報告書新規登録</a>
                                    </li>
                                    <div class="dropdown">
                                        <p class="dropbtn">
                                            <?php echo $data['name'] ?></p>

                                        <div class="dropdown-content">
                                            <a href="?view=profile_user">情報変更</a>
                                            <a href="?view=logout">ログアウト</a>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="?view=create_form">報告書新規登録</a>
                                    </li>
                                    <div class="dropdown">
                                        <p class="dropbtn">
                                            <?php echo $data['student_name'] ?></p>

                                        <div class="dropdown-content">
                                            <a href="?view=profile_user">情報変更</a>
                                            <a href="?view=logout">ログアウト</a>
                                        </div>
                                    </div>
                                <?php } ?>


                            </div>
                        <?php } else { ?>
                            <div class="register-login">
                                <li class="nav-item">
                                    <a class="nav-link" style="cursor: pointer;" href="?view=login">ログイン</a>
                                </li>

                            </div>
                        <?php } ?>
                    </li>
                   
                    
                    </ul>
                </div>
            </div>
        </nav> -->

<script>

</script>

<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
    <div class="container">
        <!-- <a class="navbar-brand" href="http://localhost/hokokusho2021/"><img src="./public/assets/web/image/icon-book.png" alt="..." /></a> -->
        <a class="navbar-brand" href="index.php"><img src="https://ueno.daiichi-koudai.ac.jp/wp-content/themes/daiichi_koudai_ueno/img/index/header_logo.svg" alt="..." /></a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <!-- Sửa aria-expanded từ "true" thành "false" -->
            Menu
            <i class="fas fa-bars ms-1"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarResponsive">
            <!-- Đảm bảo thêm lớp "collapse" để thanh navbar có thể thu gọn/mở rộng -->
            <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">

                <li class="nav-item">

                    <?php if (isset($student['student_name'])) { ?>
                        <div class="profile-createform">
                            <?php
                            if (!empty($dataNaitei)) {  ?>
                <li class="nav-item">
                    <a class="nav-link" href="javascript:0" onclick="errorReport()">報告書新規登録</a>
                </li>
                <div class="dropdown">
                    <p class="dropbtn">
                        <?php echo $data['student_name'] ?></p>

                    <div class="dropdown-content">
                        <a href="?view=profile_user">情報変更</a>
                        <a href="?view=logout">ログアウト</a>
                    </div>
                </div>
            <?php } else { ?>
                <li class="nav-item">
                    <a class="nav-link" href="?view=create_form">報告書新規登録</a>
                </li>
                <div class="dropdown">
                    <p class="dropbtn">
                        <?php echo $data['student_name'] ?></p>

                    <div class="dropdown-content">
                        <a href="?view=profile_user">情報変更</a>
                        <a href="?view=logout">ログアウト</a>
                    </div>
                </div>
            <?php } ?>


        </div>
    <?php } else { ?>
        <div class="register-login">
            <li class="nav-item">
                <a class="nav-link" style="cursor: pointer;" href="?view=login">ログイン</a>
            </li>
            <!-- <li class="nav-item">
                                    <a class="nav-link" href="?view=register">新規登録</a>
                                </li> -->
        </div>
    <?php } ?>
    </li>


    </ul>
    </div>
    </div>
</nav>

<script>
    $(document).ready(function () {
        // Đảm bảo thanh navbar đóng khi tải trang lần đầu tiên
        $('#navbarResponsive').removeClass('show');
        
        // Đảm bảo thanh navbar không tự động mở lại sau lần đầu tiên ấn vào
        $('.navbar-toggler').on('click', function () {
            if ($('#navbarResponsive').hasClass('show')) {
                $('#navbarResponsive').collapse('hide');
            }
        });
    });
</script>
