<?php
require_once('Model/DBconnect.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// require '/home/baolab/web/baolab.ditu.site/public_html/PHPMailer/PHPMailer/src/Exception.php';
// require '/home/baolab/web/baolab.ditu.site/public_html/PHPMailer/PHPMailer/src/PHPMailer.php';
// require '/home/baolab/web/baolab.ditu.site/public_html/PHPMailer/PHPMailer/src/SMTP.php';
require 'C:\xampp\htdocs\hokokusho2024\PHPMailer\PHPMailer\src\Exception.php';
require 'C:\xampp\htdocs\hokokusho2024\PHPMailer\PHPMailer\src\PHPMailer.php';
require 'C:\xampp\htdocs\hokokusho2024\PHPMailer\PHPMailer\src\SMTP.php';

$error = [];

if (isset($_POST['email'])) {
    $email = $_POST['email'];

    // Check if the email exists in the student database
    $query = "SELECT * FROM student WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if (mysqli_num_rows($result) == 1) {
        // Generate a token
        $token = bin2hex(random_bytes(4)); 
        // You can adjust the length of the token as needed
        // token 暗証化する。21TE412グエンヴァン　クイ　2024/07/31
        $encrypted_token = password_hash($token , PASSWORD_DEFAULT);
        // Store the token in the student database

        $updateQuery = "UPDATE student SET reset_token = '$encrypted_token', token_expire = ADDDATE(NOW(), INTERVAL 5 MINUTE) WHERE email = '$email'";
        mysqli_query($conn, $updateQuery);

        // Send a confirmation email with the token
        $mail = new PHPMailer();

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'bao.lab2023@gmail.com';
            $mail->Password = 'oagq novd rogp ozuu';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('bao.lab2023@gmail.com', 'BaoLab');
            $mail->addAddress($email); // Send the email to the user's email

            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Confirmation';
            $mail->Body    = 'こんにちは ' . $row['student_name'] . ' さん、<br><br>'
            . 'パスワードリセットのリクエストを受け付けました。次のトークンを使用してパスワードをリセットしてください：<br><br>'
            . 'パスワードリセットトークン: <strong>' . $token . '</strong><br><br>'
            . 'このトークンは'. $row['token_expire'] . 'まで有効です。<br><br>'
            . '<br>第一工科大学<br>'
            .  '伊藤先生ゼミ<br>';
            if ($mail->send()) {
                echo 'Confirmation email sent successfully.';

                // Redirect to the reset page
                header('Location: ?View=reset');
                exit;
            } else {
                $error['email_not_sent'] = 'Confirmation email delivery failed. Error: ' . $mail->ErrorInfo;
            }
        } catch (Exception $e) {
            $error['email_not_sent'] = 'Confirmation email delivery failed. Error: ' . $mail->ErrorInfo;
        }
    } else {
        $error['email_not_found'] = "This email address is not registered.";
    }
}
?>

<script>
    function redirectToResetPage() {
        document.getElementById("confirmation-form").action = "?View=reset"; // Set the form's action to the reset page URL
        document.getElementById("confirmation-form").submit(); // Submit the form
    }
</script>

<section>
    <div class="register-page">
        <div class="content-register-page" style="margin-top: 100px;">
            <p>パスワード変更</p>
            <form action="" method="POST" id="confirmation-form">
                メールアドレス：
                <input id="email" name="email" type="email" placeholder="メールアドレス">
                <div class="error-validate">
                    <span><?php echo (isset($error['email_not_found'])) ? $error['email_not_found'] : '' ?></span> <!-- Use the correct key here -->
                </div>
                <button type="submit" style="padding: 15px 20px; font-size: 15px; margin-top: 10px;">Send Confirmation</button>
            </form>
            <div class="login-page-register">
                <p> ユーザーが有れば、ここに <a href="?View=login" style="color:#ff4b2b">ログイン</a>してください</p>
                <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                    アカウントを持っていますか?&nbsp; <a href="?View=register" style="color:#ff4b2b;" class="font-medium text-primary-600 hover:underline dark:text-primary-500">新規登録</a>
                </p>
            </div>
        </div>
    </div>
</section>