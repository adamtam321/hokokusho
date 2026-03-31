<?php
require_once('../../Model/DBconnect.php');

$error = [];


$student_code = $_GET['student_code'];
$sql = "SELECT recruit.*,naitei.*,shiken.* FROM  recruit , naitei, shiken  WHERE  (shiken.student_code='$student_code' && naitei.student_code='$student_code' && recruit.student_code='$student_code')";
$sql1 = "SELECT student.* FROM student  WHERE  student.student_code='$student_code'";
$query = mysqli_query($conn, $sql);
$query1 = mysqli_query($conn, $sql1);
$data = mysqli_fetch_array($query);
$data1 = mysqli_fetch_array($query1);

if (isset($_POST['name'])) {
    $name = $_POST['name'];
    $registration_date = $_POST['registration_date'];
    $gender = $_POST['gender'];
    $company_name = $_POST['company_name'];
    $address = $_POST['address'];


    //recruit
    $recruitment_method = $_POST['recruitment_method'];
    $interview_content = $_POST['interview_content'];
    $career_field = $_POST['career_field'];

    //naitei
    $shiken_kekka = $_POST['shiken_kekka'];
    $naitei = $_POST['naitei'];
    $naiteibi = $_POST['naiteibi'];
    $method = $_POST['method'];
    $advice = $_POST['advice'];

    //    shiken
    $date_time_interview = $_POST['date_time_interview'];
    $jikan = $_POST['jikan'];
    $kaiyou = $_POST['kaiyou'];
    $action = $_POST['action'];
    $general_job = $_POST['general_job'];
    $jikan_general_job = $_POST['jikan_general_job'];
    $ronbun = $_POST['ronbun'];
    $jikan_ronbun = $_POST['jikan_ronbun'];
    $senmon = $_POST['senmon'];
    $jikan_senmon = $_POST['jikan_senmon'];
    $gengo = $_POST['gengo'];
    $jikan_gengo = $_POST['jikan_gengo'];
    $tekisei = $_POST['tekisei'];
    $jikan_tekisei = $_POST['jikan_tekisei'];
    $ichimensetsu = $_POST['ichimensetsu'];
    $jikan_ichimensetsu = $_POST['jikan_ichimensetsu'];
    $keishiki_ichimensetsu = $_POST['keishiki_ichimensetsu'];
    $nijimensetsu = $_POST['nijimensetsu'];
    $jikan_nijikanmensetsu = $_POST['jikan_nijikanmensetsu'];
    $keishiki_ni = $_POST['keishiki_ni'];

    $sql = "UPDATE `student` SET `registration_date`= '$registration_date',
    `name`='$name',`gender`='$gender',`company_name`='$company_name', `address`='$address'
     WHERE student_code = '$student_code';
     UPDATE `recruit` SET `recruitment_method`= '$recruitment_method',
    `interview_content`='$interview_content',`career_field`='$career_field'
     WHERE student_code = '$student_code';
     UPDATE `naitei` SET `shiken_kekka`='$shiken_kekka',`naitei`='$naitei',`naiteibi`='$naiteibi',
     `method`='$method',`advice`='$advice' WHERE student_code = '$student_code';
     UPDATE `shiken` SET`date_time_interview`='$date_time_interview',`jikan`='$jikan',`kaiyou`='$kaiyou'
     ,`action`='$action',`general_job`='$general_job',`jikan_general_job`='$jikan_general_job',
     `ronbun`='$ronbun',`jikan_ronbun`='$jikan_ronbun',`senmon`='$senmon',
     `jikan_senmon`='$jikan_senmon',`gengo`='$gengo',`jikan_gengo`='$jikan_gengo',
     `tekisei`='$tekisei',`jikan_tekisei`='$jikan_tekisei',`ichimensetsu`='$ichimensetsu',
     `jikan_ichimensetsu`='$jikan_ichimensetsu',`keishiki_ichimensetsu`='$keishiki_ichimensetsu',
     `nijimensetsu`='$nijimensetsu',`jikan_nijikanmensetsu`='$jikan_nijikanmensetsu',`keishiki_ni`='$keishiki_ni'
     WHERE student_code = '$student_code';";
    
   
    $update = $conn->multi_query($sql);
    if ($update) {
        echo "<script>alert('編集を完了しました。')</script>";
        header('Location:  http://localhost/hokokusho2021/view/admin/index.php?view=share-experience');
    } else {
        echo "<script>alert('編集を完了しませんでした。')</script>";
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
                        <li class="breadcrumb-item active">報告書の編集</li>
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
                            <h3 class="card-title">学生</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="POST" action="" enctype="multipart/form-data">
                            <div class="card-body">
                           
                                <div class="form-group">
                                    <label>提出日</label>
                                    <input type="date" class="form-control" name="registration_date" value="<?php echo $data1['registration_date']; ?>">
                                </div>
                                <div class="form-group">
                                    <label>名前</label>
                                    <input type="text" class="form-control" name="name" value="<?php echo $data1['name']; ?>">
                                </div>
                                <div class="form-group">
                                    <label>性別</label>
                                    <input type="text" class="form-control" name="gender" value="<?php echo $data1['gender']; ?>">
                                </div>
                                <div class="form-group">
                                    <label>会社名</label>
                                    <input type="text" class="form-control" name="company_name" value="<?php echo $data1['company_name']; ?>">
                                </div>
                                <div class="form-group">
                                    <label>住所</label>
                                    <input type="text" class="form-control" name="address" value="<?php echo $data1['address']; ?>">
                                </div>

                            </div>
                            <!-- /.card -->


                    </div>
                    <!--/.col (left) -->

                </div>
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">内定</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->

                        <div class="card-body">
                            <div class="form-group">
                                <label>試験の結果</label>
                                <input type="text" class="form-control" name="shiken_kekka" value="<?php echo $data['shiken_kekka']; ?>">
                            </div>
                            <div class="form-group">
                                <label>内定を得た</label>
                                <input type="text" class="form-control" name="naitei" value="<?php echo $data['naitei']; ?>">
                            </div>
                            <div class="form-group">
                                <label>内定日</label>
                                <input type="text" class="form-control" name="naiteibi" value="<?php echo $data['naiteibi']; ?>">
                            </div>
                            <div class="form-group">
                                <label>内定および方法</label>
                                <input type="text" class="form-control" name="method" value="<?php echo $data['method']; ?>">
                            </div>
                            <div class="form-group">
                                <label>アドバイス</label>
                                <textarea name="advice"><?php echo $data['advice']; ?></textarea>

                            </div>

                        </div>
                        <!-- /.card -->


                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <div class="row update-share_kn">

                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">応募</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->

                        <div class="card-body">
                            <div class="form-group">
                                <label>応募方法</label>
                                <input type="text" class="form-control" name="recruitment_method" value="<?php echo $data['recruitment_method']; ?>">
                            </div>
                            <div class="form-group">
                                <label>訪問内容</label>
                                <input type="text" class="form-control" name="interview_content" value="<?php echo $data['interview_content']; ?>">
                            </div>
                            <div class="form-group">
                                <label>職種</label>
                                <input type="text" class="form-control" name="career_field" value="<?php echo $data['career_field']; ?>">
                            </div>


                        </div>
                        <!-- /.card -->


                    </div>
                </div>
                <div class="col-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">試験</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->

                        <div class="card-body">
                            <div class="form-group">
                                <label>試験日</label>

                                <input type="date" class="form-control" name="date_time_interview" value="<?php echo $data['date_time_interview']; ?>">
                            </div>
                            <div class="form-group">
                                <label>時間</label>
                                <input type="text" class="form-control" name="jikan" value="<?php echo $data['jikan']; ?>">
                            </div>

                            <div class="form-group">
                                <label>会場</label>
                                <input type="text" class="form-control" name="kaiyou" value="<?php echo $data['kaiyou']; ?>">
                            </div>
                            <div class="form-group">
                                <label>行動概要</label>
                                <input type="text" class="form-control" name="action" value="<?php echo $data['action']; ?>">
                            </div>
                            <div class="form-group">
                                <label>一般常識</label>
                                <input type="text" class="form-control" name="general_job" value="<?php echo $data['general_job']; ?>">
                            </div>
                            <div class="form-group">
                                <label>時間</label>
                                <input type="text" class="form-control" name="jikan_general_job" value="<?php echo $data['jikan_general_job']; ?>">
                            </div>
                            <div class="form-group">
                                <label>論文</label>
                                <input type="text" class="form-control" name="ronbun" value="<?php echo $data['ronbun']; ?>">
                            </div>
                            <div class="form-group">
                                <label>時間</label>
                                <input type="text" class="form-control" name="jikan_ronbun" value="<?php echo $data['jikan_ronbun']; ?>">
                            </div>
                            <div class="form-group">
                                <label>専門</label>
                                <input type="text" class="form-control" name="senmon" value="<?php echo $data['senmon']; ?>">
                            </div>
                            <div class="form-group">
                                <label>時間</label>
                                <input type="text" class="form-control" name="jikan_senmon" value="<?php echo $data['jikan_senmon']; ?>">
                            </div>

                            <div class="form-group">
                                <label>語学</label>
                                <input type="text" class="form-control" name="gengo" value="<?php echo $data['gengo']; ?>">
                            </div>
                            <div class="form-group">
                                <label>時間</label>
                                <input type="text" class="form-control" name="jikan_gengo" value="<?php echo $data['jikan_gengo']; ?>">
                            </div>

                            <div class="form-group">
                                <label>適正</label>
                                <input type="text" class="form-control" name="tekisei" value="<?php echo $data['tekisei']; ?>">
                            </div>
                            <div class="form-group">
                                <label>時間</label>
                                <input type="text" class="form-control" name="jikan_tekisei" value="<?php echo $data['jikan_tekisei']; ?>">
                            </div>
                            <div class="form-group">
                                <label>一次面接</label>
                                <input type="text" class="form-control" name="ichimensetsu" value="<?php echo $data['ichimensetsu']; ?>">
                            </div>
                            <div class="form-group">
                                <label>時間</label>
                                <input type="text" class="form-control" name="jikan_ichimensetsu" value="<?php echo $data['jikan_ichimensetsu']; ?>">
                            </div>
                            <div class="form-group">
                                <label>形式</label>
                                <input type="text" class="form-control" name="keishiki_ichimensetsu" value="<?php echo $data['keishiki_ichimensetsu']; ?>">
                            </div>

                            <div class="form-group">
                                <label>二次面接</label>
                                <input type="text" class="form-control" name="nijimensetsu" value="<?php echo $data['nijimensetsu']; ?>">
                            </div>
                            <div class="form-group">
                                <label>時間</label>
                                <input type="text" class="form-control" name="jikan_nijikanmensetsu" value="<?php echo $data['jikan_nijikanmensetsu']; ?>">
                            </div>
                            <div class="form-group">
                                <label>形式</label>
                                <input type="text" class="form-control" name="keishiki_ni" value="<?php echo $data['keishiki_ni']; ?>">
                            </div>


                        </div>
                    </div>
                </div>
                <div class="card-footer update-share_kn_btn">
                    <button type="submit" class="btn btn-primary">登録</button>
                </div>
            </div>
        </div>
                </form>
                <style>
                    .error-validate span {
                        color: red;
                    }
                </style>

    </section>
    <!-- /.content -->