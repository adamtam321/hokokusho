<?php
require_once('../../Model/DBconnect.php');


$student_code = $_GET['student_code'];
$sql = "SELECT student.*, recruit.*,naitei.*,shiken.* FROM student, recruit , naitei, shiken  WHERE student.student_code='$student_code'";
$query = mysqli_query($conn, $sql);
$data = mysqli_fetch_array($query);
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
                        <li class="breadcrumb-item active">学生の情報</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
        <section>
            <div class="container">
                <div class="row">
                   
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12">
                                    <div class="show-report">
                                        <div class="show-report-student">
                                            <p class="name-student"><?php echo $data["name"] ?> </p>
                                            <p>
                                                <span>提出日:&nbsp;</span> <?php echo $data["registration_date"] ?>
                                            </p>

                                            <p>
                                                <span>性別:&nbsp;</span> <?php echo $data["gender"] ?>
                                            </p>
                                            <p>
                                                <span>会社名:&nbsp;</span> <?php echo $data["company_name"] ?>
                                            </p>
                                            <p>
                                                <span>会社の住所:&nbsp;</span> <?php echo $data["address"] ?>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-md-3">
                                    <div class="show-report">
                                        <div class="thumb-avatar">
                                            <img src="<?php echo $data["thumb"] ?>" alt="<?php echo $data["name"] ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="show-report">
                                        <table style="width: 100%;">
                                            <tr>
                                                <th width="20%">データベース</th>
                                                <th width="80%">内容</th>
                                            </tr>
                                            <tr>
                                                <th>内定</th>
                                                <th>
                                                    <div class="show-report">

                                                        <p>
                                                            <span>試験の結果:&nbsp;</span><?php echo $data["shiken_kekka"] ?>
                                                        </p>
                                                        <p>
                                                            <span>内定を得た:&nbsp;</span><?php echo $data["naitei"] ?>
                                                        </p>
                                                        <p>
                                                            <span>内定日:&nbsp;</span><?php echo $data["naiteibi"] ?>
                                                        </p>
                                                        <p>
                                                            <span>内定日および方法:&nbsp;</span><?php echo $data["method"] ?>
                                                        </p>
                                                        <p><span>アドバイス:&nbsp;</span><?php echo $data["advice"] ?>
                                                        </p>
                                                    </div>
                                                </th>

                                            </tr>

                                        </table>
                                    </div>

                                    <div class="show-report">
                                        <table style="width: 100%;">
                                            <tr>
                                                <th style="width: 20%">応募</th>
                                                <th style="width: 80%">
                                                    <div class="show-report">

                                                        <p>
                                                            <span>応募方法:&nbsp;</span><?php echo $data["recruitment_method"] ?>
                                                        </p>
                                                        <p>
                                                            <span>訪問内容:&nbsp;</span><?php echo $data["interview_content"] ?>
                                                        </p>
                                                        <p>
                                                            <span>職種: &nbsp;</span><?php echo $data["career_field"] ?>
                                                        </p>
                                                    </div>
                                                </th>

                                            </tr>

                                        </table>
                                    </div>

                                    <div class="show-report">
                                        <table style="width: 100%;">
                                            <tr>
                                                <th style="width: 20%">試験</th>
                                                <th style="width: 80%">
                                                    <div class="show-report">

                                                        <div class="show-report-shiken">
                                                            <div class="skiken-left">
                                                                <p>
                                                                    <span>試験日:&nbsp;</span><?php echo $data["date_time_interview"] ?>
                                                                </p>
                                                                <p>
                                                                    <span>時間:&nbsp;</span><?php echo $data["jikan"] ?>
                                                                </p>
                                                                <p>
                                                                    <span>会場: &nbsp;</span><?php echo $data["kaiyou"] ?>
                                                                </p>
                                                                <p>
                                                                    <span>行動概要: &nbsp;</span><?php echo $data["action"] ?>
                                                                </p>
                                                                <p>
                                                                    <span>一般常識: &nbsp;</span><?php echo $data["general_job"] ?>
                                                                </p>
                                                                <p>
                                                                    <span>時間: &nbsp;</span><?php echo $data["jikan_general_job"] ?>
                                                                </p>
                                                                <p>
                                                                    <span>論文: &nbsp;</span><?php echo $data["ronbun"] ?>
                                                                </p>
                                                                <p>
                                                                    <span>時間: &nbsp;</span><?php echo $data["jikan_ronbun"] ?>
                                                                </p>
                                                                <p>
                                                                    <span>専門: &nbsp;</span><?php echo $data["senmon"] ?>
                                                                </p>
                                                                <p>
                                                                    <span>時間: &nbsp;</span><?php echo $data["jikan_senmon"] ?>
                                                                </p>

                                                            </div>
                                                            <div class="skiken-right">
                                                                <p>
                                                                    <span>語学: &nbsp;</span><?php echo $data["gengo"] ?>
                                                                </p>
                                                                <p>
                                                                    <span>時間: &nbsp;</span><?php echo $data["jikan_gengo"] ?>
                                                                </p>
                                                                <p>
                                                                    <span>適正: &nbsp;</span><?php echo $data["tekisei"] ?>
                                                                </p>
                                                                <p>
                                                                    <span>時間: &nbsp;</span><?php echo $data["jikan_tekisei"] ?>
                                                                </p>
                                                                <p>
                                                                    <span>一次面接: &nbsp;</span><?php echo $data["ichimensetsu"] ?>
                                                                </p>
                                                                <p>
                                                                    <span>時間 : &nbsp;</span><?php echo $data["jikan_ichimensetsu"] ?>
                                                                </p>
                                                                <p>
                                                                    <span>形式: &nbsp;</span><?php echo $data["keishiki_ichimensetsu"] ?>
                                                                </p>
                                                                <p>
                                                                    <span>二次面接: &nbsp;</span><?php echo $data["nijimensetsu"] ?>
                                                                </p>
                                                                <p>
                                                                    <span>時間 : &nbsp;</span><?php echo $data["nijikan_nijikanmensetsu"] ?>
                                                                </p>
                                                                <p>
                                                                    <span>形式: &nbsp;</span><?php echo $data["keishiki_ni"] ?>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </th>

                                            </tr>

                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </section>
        <style>
            .thumb-avatar img {
                width: 100%;
            }

            .show-report table th {
                padding: 5px 5px;
                border: 1px solid #000000;
            }
            .show-report {
                margin-top: 20px;
            }
        </style>
    </section>