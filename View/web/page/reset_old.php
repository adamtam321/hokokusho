<?php
require_once('Model/DBconnect.php');

$error = [];

if (isset($_POST['email']) && isset($_POST['token'])) {
    $email = $_POST['email'];
    $token = $_POST['token'];
    $password = $_POST['password'];
    $re_password = $_POST['re_password'];

    // Check if the email and token combination is valid
    $query = "SELECT * FROM student WHERE email = '$email' AND password = '$token'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $tokenCreationTime = strtotime($row['modified']);
        $currentTime = time();

        // Debugging: Log the values
        error_log("Token Creation Time: " . $tokenCreationTime);
        error_log("Current Time: " . $currentTime);

        // Check if the token is still valid (e.g., less than 5 minutes old)
        $tokenExpirationTime = $tokenCreationTime + 300; // 300 seconds = 5 minutes
        if ($currentTime <= $tokenExpirationTime) {
            if (empty($password)) {
                $error['password'] = "新しいパスワードを入力してください。";
            } elseif ($password != $re_password) {
                $error['re_password'] = "パスワードを合わせていませんでした。";
            } elseif (!preg_match("/\A(?=.*?[a-z])(?=.*?\d)(?=.*?[!-\/:-@[-`{-~])[!-~]{8,100}+\z/i", $password)) {
                $error['password'] = "パスワードは8桁数字、文字、記号を合わせてください。";
            }
            if (empty($error)) {
                $password = password_hash($password, PASSWORD_DEFAULT);
                $updateQuery = "UPDATE student SET password = '$password' WHERE email = '$email'";
                mysqli_query($conn, $updateQuery);
                // Clear the user token after the password change
                $clearTokenQuery = "UPDATE student SET user_token = NULL WHERE email = '$email'";
                mysqli_query($conn, $clearTokenQuery);

                header('Location: ?View=login');
                exit;
            }
        } else {
            // Token has expired, inform the user and handle accordingly
            $error['token'] = "トークンが無効です。"; // Provide the desired error message
        }
    } else {
        $error['token'] = "トークンが無効です。"; // Provide the desired error message
    }
}
?>
<section>
    <div class="register-page">
        <div class="content-register-page" style="margin-top: 100px;">
            <p>パスワード変更</p>
            <form action="" method="POST">
                メールアドレス：
                <input id="email" name="email" type="email" placeholder="メールアドレス">
                <div class="error-validate">
                    <span><?php echo (isset($error['email'])) ? $error['email'] : '' ?></span>
                </div>
                リセットパスワード:
                <input id="token" name="token" type="text" placeholder="リセットパスワード">
                <div class="error-validate">
                    <span><?php echo (isset($error['token'])) ? $error['token'] : '' ?></span>
                </div>
                新しいパスワード: パスワードは8桁数字、文字、記号を合わせてください。
                <input id="password" type="password" name="password" placeholder="新しいパスワード">
                <div class="error-validate">
                    <span><?php echo (isset($error['password'])) ? $error['password'] : '' ?></span>
                </div>
                新しいパスワード確認：
                <input id="re_password" type="password" name="re_password" placeholder="新しいパスワード確認">
                <div class="error-validate">
                    <span><?php echo (isset($error['re_password'])) ? $error['re_password'] : '' ?></span>
                </div>
                <button type="submit">変更</button>
            </form>
            <div class="login-page-register">
                <p> ユーザーが有れば、ここに <a href="?View=login">ログイン</a>してください</p>
            </div>
        </div>
    </div>
</section>