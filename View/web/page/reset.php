<?php
require_once('Model/DBconnect.php');

$error = [];

if (isset($_POST['email']) && isset($_POST['token'])) {
    $email = $_POST['email'];
    $token = $_POST['token'];
    $password = $_POST['password'];
    $re_password = $_POST['re_password'];   
    // Check if the email and token combination is valid
    // パスワードを再発行する形を変わる。TOKENとして認証して、正しいければ、パスワードを再発行可能　21TE412グエンヴァン　クイ　2024/07/31
    $query = "SELECT * FROM student WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $stored_token = $row['reset_token'];
        $token_expire = $row['token_expire'];
        // $tokenCreationTime = strtotime($row['modified']);
        $current_Time = time();

        // Debugging: Log the values
        // error_log("Token Creation Time: " . $tokenCreationTime);
        error_log("Current Time: " . $current_Time);

        // Check if the token is still valid (e.g., less than 5 minutes old)
        // $tokenExpirationTime = $tokenCreationTime + 300; // 300 seconds = 5 minutes
        if (isset($token_expire) && $current_Time <= $token_expire && password_verify($token, $stored_token)) {
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
                // Clear the user token　and token_expire after the password change
                $clearTokenQuery = "UPDATE student SET reset_token = NULL , token_expire = NULL WHERE email = '$email'";
                mysqli_query($conn, $clearTokenQuery);
                $_SESSION['resetpassword_success'] ="パスワード変更を完了しました。";

                header('Location: ?View=login');
                exit;
            }
        } else {
            // Token has expired, inform the user and handle accordingly
            $error['token'] = "トークンが無効か、または、トークンが間違っています。"; // Provide the desired error message
        }
    } else {
        $error['token'] = "メールアドレスを間違いかを確認してください。";
    }// パスワードを再発行する形を変わる。TOKENとして認証して、正しいければ、パスワードを再発行可能　21TE412グエンヴァン　クイ　2024/07/31
}
?>
<section>
    <div class="register-page">
        <div class="content-register-page" style="margin-top: 100px;">
            <p>パスワード変更</p>
            <form action="" method="POST">
                メールアドレス
                <input id="email" name="email" type="email" placeholder="メールアドレスを入力してください。">
                <div class="error-validate">
                    <span><?php echo (isset($error['email'])) ? $error['email'] : '' ?></span>
                </div>
                パスワードリセットトークン
                <input id="token" name="token" type="text" placeholder="パスワードリセットトークンを入力してください。
">
                <div class="error-validate">
                    <span><?php echo (isset($error['token'])) ? $error['token'] : '' ?></span>
                </div>
                新しいパスワード: パスワードは8桁数字、文字、記号を合わせてください。
                <input id="password" type="password" name="password" placeholder="新しいパスワードを入力してください。">
                <div class="error-validate">
                    <span><?php echo (isset($error['password'])) ? $error['password'] : '' ?></span>
                </div>
                新しいパスワード確認
                <input id="re_password" type="password" name="re_password" placeholder="新しいパスワード確認を入力してください。">
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