<?php
require_once('../../Model/DBconnect.php');
$data = "SELECT *  FROM shiken INNER JOIN student ON student.student_code = shiken.student_code
INNER JOIN naitei ON naitei.student_code = shiken.student_code
INNER JOIN recruit ON recruit.student_code = shiken.student_code";

$result = mysqli_query($conn, $data);


$student = (isset($_SESSION['student'])) ? $_SESSION['student'] : [];


// Get status message
if(!empty($_GET['status'])){
    switch($_GET['status']){
        case 'succ':
            $statusType = 'alert-success';
            $statusMsg = 'Members data has been imported successfully.';
            break;
        case 'err':
            $statusType = 'alert-danger';
            $statusMsg = 'Some problem occurred, please try again.';
            break;
        case 'invalid_file':
            $statusType = 'alert-danger';
            $statusMsg = 'Please upload a valid CSV file.';
            break;
        default:
            $statusType = '';
            $statusMsg = '';
    }
}
?>

<!-- Display status message -->
<?php if(!empty($statusMsg)){ ?>
<div class="col-xs-12">
    <div class="alert <?php echo $statusType; ?>"><?php echo $statusMsg; ?></div>
</div>
<?php } ?>

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
                            <li class="breadcrumb-item active">報告書</li>
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
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">報告書</h3><br>
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-xs-12">
                                    <i class="fas fa-search"></i>
                                    <input type="text" id="search" placeholder="会社名">

                                    </div>
                                </div>

                            </div>

                            <!-- /.card-header -->
                            <div class="card-body">
                                <p class="add-form-user"><a href="#">報告書</a></p>
                                <table id="example2" class="table table-bordered table-hover table-responsive-xl">
                                    <thead class="thead-dark">
                                        <tr class="text-center">
                                            <th>名前</th>
                                            <th>学生番号</th>
                                            <th>会社名</th>
                                            <th>試験日</th>
                                            <th>住所</th>
                                            <th>内定日  </th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody class="share_experience_table_down" id="output">
                                      
                                        <?php foreach ($result   as $key => $students) : ?>
                                            <tr>
                                                <td><?php echo $students['student_name']; ?></td>
                                                <td><?php echo $students['student_code'] ?></td>
                                                <td><?php echo $students['company_name']; ?></td>
                                                <td><?php echo $students['shiken_date']; ?></td>
                                                <td><?php echo $students['company_address']; ?></td>
                                                <td><?php echo $students['naitei_date'] ?></td>
                                                <td class="function-student">
                                                    <a class="btn btn-primary"  href="index.php?view=update-share-experience&student_code=<?php echo $students['student_code'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                                    <a href="#" class="btn btn-danger" onclick="deleteStudent('<?php echo $students['student_code'] ?>')"><i class="fa-solid fa-trash-can"></i></a>
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
        .function-student a {
            padding: 5px 10px;
        }

        .add-form-user a {
            padding: 5px 10px;
            background: #00A000;
            color: #fff;
        }
    </style>
    <script type="text/javascript">
        function deleteStudent(student_code) {

            option = confirm('削除したいですか？')
            if (!option) {
                return;
            }

            $.post('delete-share-experience.php', {
                'student_code': student_code
            }, function(data) {
                alert(data)
                location.reload()
            })
        }
        ChangeBackGround1();
    </script>

</section>