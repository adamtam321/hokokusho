<?php
require_once('../../Model/DBconnect.php');
if (!isset($_SESSION)) {
    session_start();
}

$error = [];

$id = $_GET['id'];
$sql = "SELECT * FROM student where id='$id'";
$query = mysqli_query($conn, $sql);
$student = mysqli_fetch_array($query);

if (isset($_POST['name'])) {
    $name = $_POST['name'];
    $password = $_POST['password'];
    $re_password = $_POST['re_password'];
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    if (empty($name)) {
        $error['name'] = "名前を入力してください。";
    }

    if (empty($password)) {
        $error['password'] = "パスワードを入力してください。";
    }
    if ($password != $re_password) {
        $error['re_password'] = "パスワードを合わせていませんでした。";
    }
    if (empty($error)) {
        $sql = "UPDATE student SET name='$name' ,password = '$password_hash' WHERE id='$id'";

        $query = mysqli_query($conn, $sql);
        if (isset($query)) {
            $_SESSION['edit-student-success'] = "Sửa Học sinh thành công";
            header('Location: http://localhost/hokokusho2021/view/admin/index.php?view=student');
        }
        $conn->close();
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
                        <li class="breadcrumb-item active">編集</li>
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
                            <h3 class="card-title">編集</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="POST" action="" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">名前</label>
                                    <input type="text" class="form-control" name="name"
                                           value="<?php echo $student['name']; ?>">
                                </div>
                                <div class="error-validate">
                                    <span><?php echo (isset($error['name'])) ? $error['name'] : '' ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">メールアドレス</label>
                                    <input type="email" class="form-control" name="email" readonly="readonly"
                                           value="<?php echo $student['email']; ?>">
                                </div>
                                <div class="error-validate">
                                    <span><?php echo (isset($error['email'])) ? $error['email'] : '' ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">学生番号</label>
                                    <input type="text" class="form-control" name="student_code" readonly="readonly"
                                           value="<?php echo $student['student_code']; ?>">
                                </div>
                                <div class="error-validate">
                                    <span><?php echo (isset($error['student_code'])) ? $error['student_code'] : '' ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Giới tính</label>
                                    <input type="text" class="form-control" name="gender" readonly="readonly"
                                           value="<?php echo $student['gender']; ?>">
                                </div>
                                <div class="error-validate">
                                    <span><?php echo (isset($error['gender'])) ? $error['gender'] : '' ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">パスワード</label>
                                    <input type="password" class="form-control" name="password">
                                </div>
                                <div class="error-validate">
                                    <span><?php echo (isset($error['password'])) ? $error['password'] : '' ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">パスワードを再入力</label>
                                    <input type="password" class="form-control" name="re_password">
                                </div>
                                <div class="error-validate">
                                    <span><?php echo (isset($error['re_password'])) ? $error['re_password'] : '' ?></span>
                                </div>

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
</div>
<style>
    .error-validate span {
        color: red;
    }
</style>

</section>
<!-- /.content -->
