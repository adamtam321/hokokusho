<!-- Login -->
<?php
require_once('Model/DBconnect.php');
if (!isset($_SESSION)) {
    session_start();
}
$error = [];

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (empty($email)) {
        $error['email'] = "メールアドレスを入力してください。";
    }
    if (empty($password)) {
        $error['password'] = "パスワードを入力してください。";
    }

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
            $_SESSION['student'] = $data;
            $_SESSION['login_success'] = "ログイン完了しました。";
            header('Location: index.php');
        } else {
            $errorPassword = "パスワードを間違います。";
        }
    } else {
        $errorMail = "メールアドレスをまだ登録しませんでした。";
    }
}
?>



<style>
    .required:after {
        content: " ※必須";
        /* content:"";  */
        color: red;
    }
</style>



<section class="bg-gray-50 dark:bg-gray-900 pt-20">
    <!-- 21te412 グエン　ヴァン　クイ　2024/07/09　アカウントを登録完了しましたの通知を追加とパスワード変更されたら、通知追加　 -->
    <div id="notificationContainer"></div>
        <script>
            // Hàm để hiển thị thông báo
            function showNotification(message) {
                var notificationContainer = document.getElementById('notificationContainer');
                var alert = document.createElement('div');
                alert.className = 'alert';
                alert.innerHTML = message + '<span class="closebtn" onclick="closeAlert(this)">&times;</span>';
                notificationContainer.appendChild(alert);

                // Tự động ẩn thông báo sau 5 giây
                setTimeout(function() {
                    if (alert) {
                        alert.style.display = 'none';
                    }
                }, 5000);
            }

            // Hàm để đóng thông báo khi người dùng nhấp vào nút đóng
            function closeAlert(element) {
                var alert = element.parentElement;
                if (alert) {
                    alert.style.display = 'none';
                }
            }

            // Kiểm tra nếu có thông báo từ PHP, hiển thị nó
            <?php if (!empty($_SESSION['register_success'])): ?>
                showNotification('<?php echo addslashes($_SESSION['register_success']); ?>');
                <?php unset($_SESSION['register_success']); // Xóa thông báo sau khi hiển thị ?>
            <?php endif; ?>
            <?php if (!empty($_SESSION['resetpassword_success'])): ?>
                showNotification('<?php echo addslashes($_SESSION['resetpassword_success']); ?>');
                <?php unset($_SESSION['resetpassword_success']); // Xóa thông báo sau khi hiển thị ?>
            <?php endif; ?>
        </script>
         <!-- 21te412 グエン　ヴァン　クイ　2024/07/09 アカウントを登録完了しましたの通知を追加 -->
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        <p class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">

            就職支援システム
        </p>
        <div class="w-full bg-gray rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    ログイン
                </h1>
                <form class="space-y-4 md:space-y-6" action="" method="POST">

                    <!-- mail -->
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white required">メールアドレス&nbsp;</label>
                        <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="例）20TE000@ditu.jp" required="">
                        <div class="error-validate">
                            <span><?php echo (isset($error['email'])) ? $error['email'] : '' ?></span>
                        </div>
                        <div class="error-validate">
                            <span><?php echo (isset($errorMail)) ? $errorMail : '' ?></span>
                        </div>
                    </div>

                    <!-- password -->
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white required">パスワード&nbsp;</label>
                        <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                        <div class="error-validate">
                            <span><?php echo (isset($error['password'])) ? $error['password'] : '' ?></span>
                        </div>
                        <div class="error-validate">
                            <span><?php echo (isset($error['db_query'])) ? $error['db_query'] : '' ?></span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input aria-describedby="remember" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="remember" class="text-gray-500 dark:text-gray-300">ログインしたままにする</label>
                            </div>
                        </div>

                        <a href="?View=reset2" class="mb-2 text-sm text-gray-500 dark:text-gray-300 font-medium text-primary-600 hover:underline">パスワードを忘れた場合</a>


                    </div>



                    <button type="submit" style="background-color:#ff4b2b" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">ログイン</button>
                    <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                        アカウントを持っていますか?&nbsp; <a href="?View=register" style="color:#ff4b2b" class="font-medium text-primary-600 hover:underline dark:text-primary-500">新規登録</a>
                    </p>
                    <div class="error-validate">
                            <span><?php echo (isset($errorPassword)) ? $errorPassword : '' ?></span>
                            <span><?php echo (isset($errorMail)) ? $errorMail : '' ?></span>
                        </div>
                </form>
            </div>
        </div>
    </div>
</section>