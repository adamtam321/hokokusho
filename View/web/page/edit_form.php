<?php
require_once('Model/DBconnect.php');
$error = [];
$student_code = $_GET['student_code'];
$naitei_id = $_GET['naitei_id'];
$sql = "SELECT recruit.*,naitei.*,shiken.* FROM  recruit , naitei, shiken  WHERE  (shiken.shiken_id='$naitei_id' && naitei.naitei_id='$naitei_id' && recruit.recruit_id='$naitei_id')";
$sql1 = "SELECT student.* FROM student  WHERE  student.student_code='$student_code'";
$query = mysqli_query($conn, $sql);
$query1 = mysqli_query($conn, $sql1);
$data = mysqli_fetch_array($query);
$data1 = mysqli_fetch_array($query1);
// $data = isset($array['query']) ? $array['query'] : '';
if (isset($_POST['student_name'])) {

    $naitei_id = $_GET['naitei_id'];
    $student_name = $_POST['student_name'];
    $student_code = $_POST['student_code'];
    $reporting_date = $_POST['reporting_date'];
    $gender = $_POST['gender'];

    //recruit
    $apply_process = $_POST['apply_process'];


    //naitei
    $company_name = $_POST['company_name'];
    $company_address = $_POST['company_address'];
    $company_postcode = $_POST['company_postcode'];
    $company_tel = $_POST['company_tel'];
    $rating = $_POST['rating'];
    $tag = $_POST['tag'];
    $naitei_flag = isset($_POST['naitei_flag']) ? $_POST['naitei_flag'] : '';
    $naitei_date = $_POST['naitei_date'];
    $naitei_method = isset($_POST['naitei_method']) ? $_POST['naitei_method'] : '';
    $industry_type = $_POST['industry_type'];
    $job_name = $_POST['job_name'];
    $advice_content = $_POST['advice_content'];

    //    shiken
    $shiken_kekka = isset($_POST['shiken_kekka']) ? $_POST['shiken_kekka'] : '';
    $shiken_date = $_POST['shiken_date'];
    $shiken_naiyou = $_POST['shiken_naiyou'];
    $interview_items = $_POST['interview_items'];
    $interview_times = $_POST['interview_times'];
    $first_interview_date = $_POST['first_interview_date'];
    $second_interview_date = $_POST['second_interview_date'];
    $third_interview_date = $_POST['third_interview_date'];


    $sql = "UPDATE `student` SET `reporting_date`= '$reporting_date',`student_name`='$student_name',`gender`='$gender'
            WHERE student_code = '$student_code';
            UPDATE `recruit` SET `apply_process`= '$apply_process'
            WHERE student_code = '$student_code' and recruit_id ='$naitei_id';
            UPDATE `naitei` SET `company_name`='$company_name',`company_postcode`='$company_postcode',`company_tel`='$company_tel',
                `rating`='$rating',`tag`='$tag', `company_address`='$company_address',`naitei_flag`='$naitei_flag', `naitei_date`='$naitei_date', `naitei_method`='$naitei_method'
                , `industry_type`='$industry_type', `job_name`='$job_name', `advice_content`='$advice_content'  WHERE student_code = '$student_code'and naitei_id ='$naitei_id';
            UPDATE `shiken` SET`shiken_kekka`='$shiken_kekka',`shiken_date`='$shiken_date',`shiken_naiyou`='$shiken_naiyou',`interview_items`='$interview_items'
                ,`interview_times`='$interview_times',`first_interview_date`='$first_interview_date',`second_interview_date`='$second_interview_date', `third_interview_date`='$third_interview_date'
            WHERE student_code = '$student_code' and shiken_id ='$naitei_id';
            ";


    $update = $conn->multi_query($sql);

    if ($update) {
        echo "<script>alert('編集完了しました。')</script>";
        header('Location: ?index.php');
    } else {
        echo "<script>alert('編集完了しませんでした。')</script>";
    }
}

?>


<div class="content-wrapper">
    <nav id="header">
        <div id="userMenu">
        </div>
    </nav>
    <br />
    <br />
    <br />
    <br />
    <br />
    <section class="content-header" style="z-index:999;">
        <div class="container-fluid">
            <div class="row mb-2">

                <div class="col-sm-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="?index.php">ホームページ</a></li>
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
                <!-- left column -->
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">利用者</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="POST" action="" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>学生番号</label>
                                    <input type="text" class="form-control" name="student_code" value="<?php echo $data1['student_code']; ?>">
                                </div>

                                <div class="form-group">
                                    <label>登録日</label>
                                    <input type="datetime-local" class="form-control" name="reporting_date" value="<?php echo $data1['reporting_date']; ?>">
                                </div>

                                <div class="form-group">
                                    <label>名前</label>
                                    <input type="text" class="form-control" name="student_name" value="<?php echo $data1['student_name']; ?>">
                                </div>
                                <div class="form-group">
                                    <label>性別</label>
                                    <input type="text" class="form-control" name="gender" value="<?php echo $data1['gender']; ?>">
                                </div>
                                <div class="form-group">
                                    <label>会社名</label>
                                    <input type="text" class="form-control" name="company_name" value="<?php echo $data['company_name']; ?>">
                                </div>
                                <div class="form-group">
                                    <label>会社の住所</label>
                                    <input type="text" class="form-control" name="company_address" value="<?php echo $data['company_address']; ?>">
                                </div>
                                <div class="form-group">
                                    <label>郵便番号</label>
                                    <input type="text" class="form-control" name="company_postcode" value="<?php echo $data['company_postcode']; ?>">
                                </div>
                                <div class="form-group">
                                    <label>会社電話番号</label>
                                    <input type="text" class="form-control" name="company_tel" value="<?php echo $data['company_tel']; ?>">
                                </div>
                                <div class="form-group">
                                    <label>会社評価値</label>
                                    <input type="number" class="form-control" step="0.1" name="rating" value="<?php echo $data['rating']; ?>">
                                </div>
                                <div class="form-group">
                                    <label>会社タッグ情報</label>
                                    <input type="number" class="form-control" name="tag" value="<?php echo $data['tag']; ?>">
                                </div>

                            </div>
                            <!-- /.card -->


                    </div>
                    <!--/.col (left) -->

                </div>
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">面接内容</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->

                        <div class="card-body">
                            <div class="row card-body_group">
                                <div class="col-6 form-group">
                                    <div class="row">
                                        <div class="col-3">
                                            <label>試験日</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="date" class="form-control" name="shiken_date" value="<?php echo $data['shiken_date']; ?>">
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <div>試験内容</div>
                                    <select class="form-group_select" name="shiken_naiyou">
                                        <option value="<?php echo $data['shiken_naiyou']; ?>"><?php echo $data['shiken_naiyou']; ?></option>
                                        <option value="一般常識">一般常識</option>
                                        <option value="論文試験">論文試験</option>
                                        <option value="専門試験">専門試験</option>
                                        <option value="語学試験">語学試験</option>
                                        <option value="適正試験">適正試験</option>
                                    </select>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-6 form-group">
                                    <div class="row">
                                        <div class="col-3">
                                            <label>面接質問事項</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" class="form-control" name="interview_items" value="<?php echo $data['interview_items']; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 form-group">
                                    <div class="row">
                                        <div class="col-3">
                                            <label>面接回数</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" class="form-control" name="interview_times" value="<?php echo $data['interview_times']; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 form-group">
                                    <div class="row">
                                        <div class="col-3">
                                            <label>一次面接日</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="date" class="form-control" name="first_interview_date" value="<?php echo $data['first_interview_date']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 form-group">
                                    <div class="row">
                                        <div class="col-3">
                                            <label>二次面接日</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="date" class="form-control" name="second_interview_date" value="<?php echo $data['second_interview_date']; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 form-group">
                                    <div class="row">
                                        <div class="col-3">
                                            <label>三次面接日</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="date" class="form-control" name="third_interview_date" value="<?php echo $data['third_interview_date']; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
</div>


<div class="col-md-6">
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">内定の情報</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->

        <div class="card-body card-body_oubou">
            <div class="card-body_oubou_item">
                <div class="form-group">
                    <ldiv>応募方法</ldiv>
                    <select class="form-group_select" name="apply_process">
                        <option value="<?php echo $data['apply_process']; ?>"><?php echo $data['apply_process']; ?></option>
                        <option value="学校の紹介">学校の紹介</option>
                        <option value="就職課紹介">就職課紹介</option>
                        <option value="自由応募">自由応募</option>
                        <option value="自己縁故">自己縁故</option>
                        <option value="その他">その他</option>

                    </select>
                </div>
                <div class="form-group">
                    <div>業種</div>
                    <select class="form-group_select" name="industry_type">
                        <option value="<?php echo $data['industry_type']; ?>"><?php echo $data['industry_type']; ?></option>
                        <option value="商社 小売 貿易業界">商社 小売 貿易業界</option>
                        <option value="フード業界">フード業界</option>
                        <option value="IT ｺﾝﾋﾟｭｰﾀ業界">IT ｺﾝﾋﾟｭｰﾀ業界</option>
                        <option value="住宅 不動産 建設業界">住宅 不動産 建設業界</option>
                        <option value="ｻｰﾋﾞｽ業界">ｻｰﾋﾞｽ業界</option>
                        <option value="ﾏｽｺﾐ 通信業界">ﾏｽｺﾐ 通信業界</option>
                        <option value="旅行 ｴﾝﾀﾒ業界">旅行 ｴﾝﾀﾒ業界</option>
                        <option value="ものづくり業界">ものづくり業界</option>
                        <option value="金融 証券業界">金融 証券業界</option>
                        <option value="農林 水産業界">農林 水産業界</option>
                        <option value="教育業界">教育業界</option>
                        <option value="公務員">公務員</option>
                        <option value="その他">その他</option>
                    </select>
                </div>
                <div class="form-group">
                    <div>職種</div>
                    <select class="form-group_select" name="job_name">
                        <option value="<?php echo $data['job_name']; ?>"><?php echo $data['job_name']; ?></option>
                        <option value="建設技術">建設技術</option>
                        <option value="電気技術">電気技術</option>
                        <option value="機械技術">機械技術</option>
                        <option value="製造技術">製造技術</option>
                        <option value="設計">設計</option>
                        <option value="デザイン">デザイン</option>
                        <option value="情纂・測量">情纂・測量</option>
                        <option value="現場指導">現場指導</option>
                        <option value="研究開発">研究開発</option>
                        <option value="品質管理">品質管理</option>
                        <option value="生産管理">生産管理</option>
                        <option value="検査">検査</option>
                        <option value="サービスエンジニア">サービスエンジニア</option>
                        <option value="システムエンジニア">システムエンジニア</option>
                        <option value="プログラマー">プログラマー</option>
                        <option value="企画・調査">企画・調査</option>
                        <option value="セールスエンジニア">セールスエンジニア</option>
                        <option value="福集・取材">福集・取材</option>
                        <option value="営業・販売">営業・販売</option>
                        <option value="プロパー">プロパー</option>
                        <option value="サービス">サービス</option>
                        <option value="事務">事務</option>
                        <option value="教員">教員</option>
                        <option value="公務員">公務員</option>
                        <option value="その他">その他</option>
                    </select>
                </div>
            </div>
        </div>
        <!-- /.card -->
    </div>
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
                <input type="text" class="form-control" name="naitei_flag" value="<?php echo $data['naitei_flag']; ?>">
            </div>
            <div class="form-group">
                <label>内定日</label>
                <input type="data" class="form-control" name="naitei_date" value="<?php echo $data['naitei_date']; ?>">
            </div>
            <div class="form-group">
                <label>内定日および方法</label>
                <input type="text" class="form-control" name="naitei_method" value="<?php echo $data['naitei_method']; ?>">
            </div>
            <div class="form-group">
                <label>アドバイス</label>
                <textarea name="advice_content"><?php echo $data['advice_content']; ?></textarea>

            </div>

        </div>
        <!-- /.card -->


    </div>
    <!-- /.row -->
</div>

<div class="card-footer">
    <button type="submit" class="shadow bg-yellow-700 hover:bg-yellow-500 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">保存</button>
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