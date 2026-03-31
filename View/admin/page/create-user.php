<?php
require_once('../../Model/DBconnect.php');
$error = [];

if (isset($_POST['name'])) {
    $name = $_POST['name'];
    $student_code = $_POST['student_code'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $re_password = $_POST['re_password'];

    if (empty($name)) {
        $error['name'] = "名前を入力してください。";
    }
    if (empty($student_code)) {
        $error['student_code'] = "学生番号を入力してください";
    }
    if (empty($gender)) {
        $error['gender'] = "性別を選択してください。";
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
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO student (name, gender,email,student_number,password)
VALUES ('$name', '$gender', '$email','$student_number','$password')";

        $checkEmail = "SELECT * FROM student WHERE email = '$email'";
        $queryEmail = mysqli_query($conn, $checkEmail);
        $checkEmail = mysqli_num_rows($queryEmail);

        $checkStudentNumber = "SELECT * FROM student WHERE student_code= '$student_code'";
        $queryStudentNumber = mysqli_query($conn, $checkStudentNumber);
        $checkStudentNumber = mysqli_num_rows($queryStudentNumber);

        if ($checkEmail == 1) {
            echo "メールアドレスが存在しました。";
        } elseif ($checkStudentNumber == 1) {
            echo "学生番号が存在しました。";
        } else {
            $query = mysqli_query($conn, $sql);
        }

    }


    if (isset($query)) {
        echo " <script>
alert('作成を完了しました。');
    </script>";
    header('Location: http://localhost/hokokusho2021/view/admin/index.php?view=user');

    }
}

?>

<!-- Content Header (Page header) -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">ホーム</a></li>
                        <li class="breadcrumb-item active">ユーザー作成</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">新登録</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="POST" action="" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">名前</label>
                                    <input type="text" class="form-control" name="name"
                                           placeholder="お名前">
                                </div>
                                <div class="error-validate">
                                    <span><?php echo (isset($error['name'])) ? $error['name'] : '' ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">メールアドレス</label>
                                    <input type="email" class="form-control" name="email"
                                           placeholder="メールアドレス">
                                </div>
                                <div class="error-validate">
                                    <span><?php echo (isset($error['email'])) ? $error['email'] : '' ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">学生番号</label>
                                    <input type="text" class="form-control" name="student_number"
                                           placeholder="学生番号を入力してください。">
                                </div>
                                <div class="error-validate">
                                    <span><?php echo (isset($error['student_number'])) ? $error['student_number'] : '' ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">性別</label>
                                    <select class="form-control" name="gender">
                                        <option value="男性">男性</option>
                                        <option value="女性">女性</option>
                                    </select>
                                </div>
                                <div class="error-validate">
                                    <span><?php echo (isset($error['gender'])) ? $error['gender'] : '' ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">パスワード</label>
                                    <input type="password" class="form-control" name="password"
                                           placeholder="パスワード">
                                </div>
                                <div class="error-validate">
                                    <span><?php echo (isset($error['password'])) ? $error['password'] : '' ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">パスワードを再入力</label>
                                    <input type="password" class="form-control" name="re_password"
                                           placeholder="パスワードを再入力してください。">
                                </div>
                                <div class="error-validate">
                                    <span><?php echo (isset($error['re_password'])) ? $error['re_password'] : '' ?></span>
                                </div>                              
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">保存</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->


                </div>
                <!--/.col (left) -->

            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
</div>
<style>
    .error-validate span {
        color: red;
    }
</style>


<!-- /.content -->
