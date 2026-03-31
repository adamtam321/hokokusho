<?php

require_once('Model/DBconnect.php');


$error = [];
// <!--19TE500 ｷﾞｭｳﾃｲﾊｲ　20221204-->
if (isset($_POST['student_name'])) {
    $student_name = $_POST['student_name'];
    $student_code = $_POST['student_code'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $re_password = $_POST['re_password'];
	// statusのデフォルト値は必ず0に設定 bao 修正 2022/12/10
	$status = 0;
	 // reporting_dateのデフォルト値は必ず"2022-01-01"に設定 bao 修正 2022/12/10
	$reporting_date = "2022-01-01";
    //$query初期値設定 bao 修正 2022/12/10
	$query = 0;
	
    if (empty($student_name)) {
        $error['student_name'] = "名前を入力してください。";
    }
    if (empty($student_code)) {
        $error['student_code'] = "学生番号を入力してください。";
    }
    if (empty($gender)) {
        $error['gender'] = "性別を入力してください。";
    }
    if (empty($email)) {
        $error['email'] = "メールアドレスを入力してください。";
    }
    if (empty($password)) {
        $error['password'] = "パスワードを入力してください。";
    }
    if ($password != $re_password) {
        $error['re_password'] = "パスワードを合わせていませんでした。";
    }
	
    if (empty($error)) {
        // <!--19TE500 ｷﾞｭｳﾃｲﾊｲ　20221204-->
        $password = password_hash($password, PASSWORD_DEFAULT);
		// <!--bao修正　20221210-->
        $sql = "INSERT INTO student (student_code, student_name, gender, reporting_date, email, password, status)
                VALUES ('$student_code', '$student_name', '$gender', '$reporting_date', '$email', '$password', '$status')";
        //check email
        $checkEmail = "SELECT * FROM student WHERE email = '$email'";
        $queryEmail = mysqli_query($conn, $checkEmail);
        $checkEmail = mysqli_num_rows($queryEmail);
        //check student_code 
        $checkStudentNumber = "SELECT * FROM student WHERE student_code = '$student_code'";
        $queryStudentNumber = mysqli_query($conn, $checkStudentNumber);
        $checkStudentNumber = mysqli_num_rows($queryStudentNumber);
        if ($checkEmail > 0) {
            $errorMail = "メールアドレスが存在している！";
        } elseif ($checkStudentNumber > 0) {
            $errorStudent = "学生番号が存在しています！";
        } else {
            $query = mysqli_query($conn, $sql);
			if (!$query) {
				 $error['db_query'] = mysqli_error($conn);
			}
        }
    }
    // check query
    if ($query) {
        $_SESSION['register_success'] = "登録完了しました。";
        header('Location: ?View=login');
        exit;
    }
}
?>
<style>
    .required:after {
    content:" ※必須";
    /* content:"";  */
    color: red;
  }
</style>


<section class="bg-gray-50 dark:bg-gray-900 pt-20">
  <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
      <p  class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
          
          就職支援システム  
</p>
      <div class="w-full bg-gray rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
          <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
              <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                  新規登録
              </h1>
              <form class="space-y-4 md:space-y-6" action="" method="POST">
    <!-- name -->
  <div>
    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white required">名前&nbsp;</label>
    <input class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="student_name" id="student_name" type="text" placeholder="例）山本太郎" required="">
    <div class="error-validate">
            <span><?php echo (isset($error['student_name'])) ? $error['student_name'] : '' ?></span>
    </div>
    <!-- student code and sex -->
<div class="d-flex justify-content-between mt-8">
  <div class="col-md-6 ml-n3">
    <label class="flex text-sm font-medium text-gray-900 dark:text-white required">学籍番号&nbsp;</label>
    <input name="student_code" id="student_coder" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="例）20TE000" required="">
    <div class="error-validate">
                        <span><?php echo (isset($error['student_code'])) ? $error['student_code'] : '' ?></span>
                    </div>
                    <div class="error-validate">
                        <span><?php echo (isset($errorStudent)) ? $errorStudent : '' ?></span>
                    </div>
                    <div class="error-validate">
                        <span><?php echo (isset($error['checkstudent'])) ? $error['checkstudent'] : '' ?></span>
                    </div>
  </div>
  <div class="col-md-6 ml-8">
    <label for="inputPassword4" class="flex text-sm font-medium text-gray-900 dark:text-white required">性別&nbsp;</label>
    <select class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="gender" id="gender" required="">
      <option selected value="男性">男性</option>
      <option value="女性">女性</option>
      <option value="指定しない">指定しない</option>
    </select>
    <div class="error-validate">
                        <span><?php echo (isset($error['gender'])) ? $error['gender'] : '' ?></span>
    </div>
  </div> 
</div>
  </div>
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
                      <input type="password" name="password" id="password" placeholder="半角英数字記号8～16文字" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                      <div class="error-validate">
      <span><?php echo (isset($error['password'])) ? $error['password'] : '' ?></span>
    </div>
    <div class="error-validate">
                    <span><?php echo (isset($error['db_query'])) ? $error['db_query']: '' ?></span>
    </div>
                  </div>

                  <!-- password confirm -->
                  <div>
                      <label for="re_password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white required">パスワード確認&nbsp;</label>
                      <input type="password" name="re_password" id="re_password" placeholder="半角英数字記号8～16文字" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                      <div class="error-validate">
      <span><?php echo (isset($error['re_password'])) ? $error['re_password'] : '' ?></span>
    </div>
    <div class="error-validate">
                    <span><?php echo (isset($error['db_query'])) ? $error['db_query']: '' ?></span>
    </div>
                  </div>

                  <button type="submit" style="background-color:#ff4b2b" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">登録</button>
                  <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                      すでにアカウントをお持ちですか?&nbsp; <a href="?View=login" style="color:#ff4b2b" class="font-medium text-primary-600 hover:underline dark:text-primary-500">&nbsp; サインイン</a>
                  </p>
              </form>
          </div>
      </div>
  </div>
</section>
