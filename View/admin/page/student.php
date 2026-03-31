<?php
require_once('../../Model/DBconnect.php');

$data = "SELECT *  FROM student INNER JOIN naitei ON student.student_code = naitei.student_code ORDER BY student.reporting_date DESC";


if (!isset($_SESSION)) {
    session_start();
}
$key = (isset($_GET['keyword'])) ? $_GET['keyword'] : [];
$student = (isset($_SESSION['student'])) ? $_SESSION['student'] : [];
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
if (!empty($keyword)) {
    $search = "SELECT *  FROM student INNER JOIN naitei ON student.student_code = naitei.student_code;
       WHERE `company_name` like '%" . $key . "%'";
    $result = mysqli_query($conn, $search);

} else {
    $result = mysqli_query($conn, $data);
}

?>
<section>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>利用者</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">ホーム</a></li>
                            <li class="breadcrumb-item active">ユーザーテーブル</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <?php if (isset($_SESSION['edit-student-success'])) { ?>
                            <div class="alert alert-primary" role="alert">
                               情報を編集完了しました!
                            </div>
                            <?php
                            unset($_SESSION['edit-student-success']);
                        } ?>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">利用者情報</h3>
                            </div>

                            <!-- /.card-header -->
                            <div class="card-body">
                                <p class="add-form-user"><a href="#">新利用者</a></p>
                                <table id="example2" class="table table-bordered table-hover table-responsive-xl">
                                    <thead class="thead-dark">
                                    <tr class="text-center">
                                        <th>名前</th>
                                        <th>学生番号</th>
                                        <th>メールアドレス</th>
                                        <th>会社名</th>
                                        <th>性別</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody class="user_table_down">
                                    <?php
                                    $listUser = 'select * from student where status = 0';
                                    $student = mysqli_query($conn, $listUser);
                                    ?>
                                    <?php foreach ($result as $key => $student ): ?>
                                        <tr>
                                            <td><?php echo $student['student_name']; ?></td>
                                            <td><?php echo $student['student_code']; ?></td>
                                            <td><?php echo $student['email']; ?></td>
                                            <td><?php echo $student['company_name'];?></td>
                                            <td><?php echo $student['gender']; ?></td>
                                            <td class="function-user">
                                                    <a class="btn btn-primary"
                                                        href="index.php?view=edit-student&id=<?php echo $student['id'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                                    <a class="btn btn-danger m-6"
                                                   onclick="deleteUser('<?php echo $student['student_code'] ?>')"><i class="fa-solid fa-trash-can"></i></a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <style>
        .function-user a {
            padding: 5px 10px;
        }

        .add-form-user a {
            padding: 5px 10px;
            background: #00A000;
            color: #fff;
        }
        
    </style>
    <script type="text/javascript">
        function deleteUser(student_code) {
            option = confirm('削除したいですか？')
            if (!option) {
                return;
            }
            $.post('delete-student.php', {
                'student_code': student_code
            }, function (data) {
                alert(data)
                location.reload()
            })
        }
        ChangeBackGround();
    </script>

</section>