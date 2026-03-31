<?php
require_once('../../Model/DBconnect.php');

$student_id = $_GET['student_code'];
$sql = "SELECT * FROM student where student_code='$student_code'";
$query = mysqli_query($conn, $sql);

$user = mysqli_fetch_array($query);
if (isset($_POST['status'])) {
    $status = $_POST['status'];
    $sql = "UPDATE student SET status='$status' WHERE student_code='$student_code'";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        echo " <script>alert('編集を完了しました。')
    </script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $conn->close();

}

?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">ホーム</a></li>
                        <li class="breadcrumb-item active">閲覧と未閲覧</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>


    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">設定</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="POST" action="">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">設定</label>
                                    <select class="form-control" name="status">
                                        <option value="1">閲覧</option>
                                        <option value="0">未閲覧</option>
                                    </select>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">登録</button>
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