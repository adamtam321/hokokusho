<!DOCTYPE html>
<html lang="en">
<head>
    <title>管理のログイン</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="../../public/assets/admin/login/images/icons/favicon.ico"/>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css"
          href="../../public/assets/admin/login/vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css"
          href="../../public/assets/admin/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css"
          href="../../public/assets/admin/login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../../public/assets/admin/login/vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css"
          href="../../public/assets/admin/login/vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../../public/assets/admin/login/vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../../public/assets/admin/login/css/util.css">
    <link rel="stylesheet" type="text/css" href="../../public/assets/admin/login/css/main.css">
    <!--===============================================================================================-->
</head>
<body>


<?php

include '../../Model/DBconnect.php';
$error = [];
if (isset($_POST['email'])) {
    if (empty($email)) {
        $error['email'] = "メールアドレスを入力してください。";
    }
    if (empty($password)) {
        $error['password'] = "パスワードを入力してください。";
    }
}

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM student WHERE email = '$email'";
    $query = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($query);
    $checkEmail = mysqli_num_rows($query);
    if (!isset($_SESSION)) {
        session_start();
    }
    if ($checkEmail == 1) {
        $checkPass = password_verify($password, $data['password']);
        if ($checkPass) {
            $status = $data['status'];
            if ($status == 1) {
                $_SESSION['user-admin'] = $data;
                header('Location: View/admin/index.php');
            } else {
                $errorAdmin =  "こちらのユーザーは管理者の役割がありません。";
            }

        } else {
            $errorPassword =  "パスワードを間違います。";
        }
    }
}
?>

<div class="limiter">

    <div class="container-login100" style="background-image: url('../../public/assets/admin/login/images/img-01.jpg');">
        <div class="wrap-login100 p-t-190 p-b-30">
            <form class="login100-form validate-form" method="POST" action="">
                <div class="login100-form-avatar">
                    <img src="../../public/assets/admin/login/images/admin.jpeg" alt="AVATAR">
                </div>

                <span class="login100-form-title p-t-20 p-b-45">
						管理者
					</span>

                <form method="POST">
                    <div class="wrap-input100 validate-input m-b-10" data-validate="Username is required">
                        <input class="input100" type="email" name="email" placeholder="メールアドレスを記入して下さい">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
							<i class="fa fa-user"></i>
						</span>
                    </div>

                    <div class="wrap-input100 validate-input m-b-10" data-validate="Password is required">
                        <input class="input100" type="password" name="password" placeholder="パスワードを記入して下さい。">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
							<i class="fa fa-lock"></i>
						</span>
                    </div>
                    <div class="error-validate" style="color: red">
                        <span><?php echo (isset($errorAdmin)) ? $errorAdmin : '' ?></span>
                        <!-- 21te412 グエン　ヴァン　クイ　パスワードを間違っているメッセージを追加  2024/07/09 -->
                        <span><?php echo (isset($errorPassword)) ? $errorPassword : '' ?></span>
                        <!-- 21te412 グエン　ヴァン　クイ　パスワードを間違っているメッセージを追加  2024/07/09 -->
                    </div>
                    <div class="container-login100-form-btn p-t-10">
                        <button type="submit" class="login100-form-btn">
                            ログイン
                        </button>
                    </div>
                </form>

                <div class="text-center w-full p-t-25 p-b-230">

                </div>

                <div class="text-center w-full">
                    <a class="txt1" href="#">
                        ユーザー新登録
                        <i class="fa fa-long-arrow-right"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>


<!--===============================================================================================-->
<script src="../../public/assets/admin/login/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
<script src="../../public/assets/admin/login/vendor/bootstrap/js/popper.js"></script>
<script src="../../public/assets/admin/login/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
<script src="../../public/assets/admin/login/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
<script src="../../public/assets/admin/login/js/main.js"></script>

</body>
</html>