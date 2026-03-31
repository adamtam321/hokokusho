<?php
require_once('Model/DBconnect.php');

$data = "SELECT s.*, n.*, r.*, sh.*
    FROM student s 
    LEFT JOIN naitei n ON s.student_code = n.student_code 
    LEFT JOIN recruit r ON n.naitei_id = r.recruit_id 
    LEFT JOIN shiken sh ON r.recruit_id = sh.shiken_id 
    WHERE n.naitei_id IS NOT NULL
    GROUP BY n.naitei_id, r.recruit_id, sh.shiken_id
    ORDER BY s.reporting_date DESC;"; // <!--19TE500 ｷﾞｭｳﾃｲﾊｲ　20221204-->

if (!isset($_SESSION)) {
    session_start();
}



$company_name = "";
$company_address = "";
$apply_process = "";
$industry_type = "";
$job_name = "";

$demand1 = "1=1";
$demand2 = "1=1";
$demand3 = "1=1";
$demand4 = "1=1";
$demand5 = "1=1";



if (!empty($_POST["company_name"])) {
    $company_name = $_POST['company_name'];
    $demand1 = "company_name like '%{$company_name}%'";
}
if (!empty($_POST["company_address"])) {
    $company_address = $_POST['company_address'];
    $demand2 = "company_address like '%{$company_address}%'";
}

if (!empty($_POST["apply_process"])) {
    $apply_process = $_POST['apply_process'];
    $demand3 = "apply_process = '$apply_process'";
}
if (!empty($_POST["industry_type"])) {
    $industry_type = $_POST['industry_type'];
    $demand4 = "industry_type = '$industry_type'";
}
if (!empty($_POST["job_name"])) {
    $job_name = $_POST['job_name'];
    $demand5 = "job_name = '$job_name'";
}

$search = "SELECT * FROM student s 
    INNER JOIN naitei n ON s.student_code = n.student_code 
    INNER JOIN recruit r ON n.student_code = r.student_code 
    INNER JOIN shiken sh ON r.student_code = sh.student_code 
    WHERE ({$demand1}) OR ({$demand2}) OR ({$demand3}) AND ({$demand4}) AND ({$demand5})
    GROUP BY n.naitei_id
    ORDER BY s.reporting_date DESC
    LIMIT 0, 10;";

if (!empty($company_name) || !empty($company_address) || !empty($apply_process) || !empty($industry_type) || !empty($job_name)) {
    $result = mysqli_query($conn, $search);
    $searchResults = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if (!empty($searchResults)) {
        // Display all search results here
        foreach ($searchResults as $v) {
            // Display each result as you did in your code
        }
    } else {
        echo "No search results found.";
    }
} else {
    $result = mysqli_query($conn, $data);
    $itemsPerPage = 8; // Number of items to display per page
    $totalItems = mysqli_num_rows($result); // Total number of items
    $totalPages = ceil($totalItems / $itemsPerPage); // Calculate total pages
    $detailedPage = isset($_GET['detailed_page']) ? (int)$_GET['detailed_page'] : 1; // Get the current page

    // Ensure the current page is within a valid range
    $detailedPage = max(1, min($detailedPage, $totalPages));

    // Calculate the starting point for the current page
    $start3 = ($detailedPage - 1) * $itemsPerPage;

    // Modify your SQL query to include the LIMIT clause for pagination
    if (!empty($company_name) || !empty($company_address) || !empty($apply_process) || !empty($industry_type) || !empty($job_name)) {
        $paginationQuery3 = "SELECT s.*, n.*, r.*, sh.*
        FROM student s 
        LEFT JOIN naitei n ON s.student_code = n.student_code 
        LEFT JOIN recruit r ON n.naitei_id = r.recruit_id 
        LEFT JOIN shiken sh ON r.recruit_id = sh.shiken_id
        WHERE ({$demand1}) OR ({$demand2}) OR ({$demand3}) AND ({$demand4}) AND ({$demand5})
        GROUP BY n.naitei_id
        ORDER BY s.reporting_date DESC
        LIMIT $start3, $itemsPerPage";
    } else {
        $paginationQuery3 = "SELECT s.*, n.*, r.*, sh.*
        FROM student s 
        LEFT JOIN naitei n ON s.student_code = n.student_code 
        LEFT JOIN recruit r ON n.naitei_id = r.recruit_id 
        LEFT JOIN shiken sh ON r.recruit_id = sh.shiken_id
        WHERE naitei_id IS NOT NULL
        GROUP BY n.naitei_id, r.recruit_id, sh.shiken_id
        ORDER BY s.reporting_date DESC
        LIMIT $start3, $itemsPerPage";
    }


    // Execute the modified query for pagination
    $result = mysqli_query($conn, $paginationQuery3);
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- SEARCH TEMPLATE -->
    <link href="public/assets/web/search/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="public/assets/web/search/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">

    <!-- Vendor CSS-->
    <link href="public/assets/web/search/vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="public/assets/web/search/vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="public/assets/web/search/css/mains.css?<?php echo time(); ?>" rel="stylesheet" media="all">


    <!-- Vendor JS-->
    <script src="public/assets/web/search/vendor/select2/select2.min.js"></script>
    <script src="public/assets/web/search/vendor/jquery-validate/jquery.validate.min.js"></script>
    <script src="public/assets/web/search/vendor/bootstrap-wizard/bootstrap.min.js"></script>
    <script src="public/assets/web/search/vendor/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
    <script src="public/assets/web/search/vendor/datepicker/moment.min.js"></script>
    <script src="public/assets/web/search/vendor/datepicker/daterangepicker.js"></script>

    <!-- Main JS-->
    <script src="public/assets/web/search/js/global.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            font-size: 60px;
        }

        #niuniu {
            display: -webkit-flex;
            display: flex;
            -webkit-justify-content: center;
            justify-content: center;
            margin: auto;
            width: 50%;
            height: auto;
            padding: auto;
        }
    </style>
</head>

<body>
    <div class="page-wrapper bg-color-1 p-t-395 p-b-120">
        <div id="top" style="margin-bottom:60px;">
            <h1>詳細検索</h1>
        </div>

        <div class="wrapper wrapper--w1226">
            <div class="card-7">
                <div class="card-body">
                    <form class="form" action="" method="post">
                        <div class="input-group input--large">
                            <label for="" class="label">会社名</label>
                            <input class="input--style-1" type="text" placeholder="例）アルプス" name="company_name" value="<?php echo $company_name ?>">
                        </div>
                        <div class="input-group input--medium">
                            <label for="" class="label">会社の住所</label>
                            <input class="input--style-1" type="text" name="company_address" placeholder="例）神奈川県" id="input-start" value="<?php echo $company_address ?>">
                        </div>
                        <div class="input-group input--medium">
                            <label for="" class="label">応募方法</label>
                            <select class="input--style-1" style="-webkit-appearance: none;" name="apply_process" id="">
                                <option value="学校の紹介"><-----------選択-----------></option>
                                <option value="学校の紹介">学校の紹介</option>
                                <option value="就職課紹介">就職課紹介</option>
                                <option value="自由応募">自由応募</option>
                                <option value="自己縁故">自己縁故</option>
                                <option value="その他">その他</option>
                            </select>
                        </div>
                        <div class="input-group input--medium">
                            <label for="" class="label">業種</label>
                            <select class="input--style-1" style="-webkit-appearance: none;" name="industry_type" id="">
                                <option value="商社 小売 貿易業界"><-----------選択-----------></option>
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
                        <div class="input-group input--medium">
                            <label for="" class="label">職種</label>
                            <select class="input--style-1" style="-webkit-appearance: none;" name="job_name" id="">
                                <option value="建設技術"><-----------選択-----------></option>
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
                        <button class="btn-submit" type="submit" action="">検索</button>
                    </form>

                </div>
            </div>
        </div>

        <!-- /.card-header -->
        <section>
            <div class="container table-responsive py-5">
                <table border="1" id="example2" class="table table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr class="text-center">
                            <th>学籍番号</th>
                            <th>会社名</th>
                            <th>会社の住所</th>
                            <th>応募方法</th>
                            <th>業種</th>
                            <th>職種</th>
                            <td>&nbsp;</td>
                        </tr>
                    </thead>

                    <tbody class="user_table_down">
                        <?php foreach ($result as $keyword => $v) : ?>
                            <tr>

                                <td><?php echo $v["student_code"]; ?></td>
                                <td><?php echo $v["company_name"]; ?></td>
                                <td><?php echo $v["company_address"]; ?></td>
                                <td><?php echo $v["apply_process"]; ?></td>
                                <td><?php echo $v["industry_type"]; ?></td>
                                <td><?php echo $v["job_name"]; ?></td>
                                <td><?php if (isset($_SESSION["student"])) { ?>
                                        <button type="button" class="detail infor_button" data-toggle="modal" data-target="#<?php echo $v["naitei_id"] ?>">
                                            詳しく
                                        </button>
                                    <?php } else { ?>
                                        <button type="button" onclick="login()" class="detail infor_button">
                                            詳しく
                                        </button>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </section>
        <!-- Detail Info -->
        <section>

            <?php foreach ($result as $keyword => $v) : ?>
                <div class="modal fade" id="<?php echo $v["naitei_id"] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel" style="color:cornsilk">
                                    報告書の詳細</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                            <div class="show-report">
                                                <div class="show-report-student">
                                                    <p>
                                                        <span>提出日:&nbsp;</span> <?php echo $v["reporting_date"] ?>
                                                    </p>

                                                    <p>
                                                        <span>性別:&nbsp;</span> <?php echo $v["gender"] ?>
                                                    </p>
                                                    <p>
                                                        <span>会社名:&nbsp;</span> <?php echo $v["company_name"] ?>
                                                    </p>
                                                    <p>
                                                        <span>郵便番号:&nbsp;</span> <?php echo $v["company_postcode"] ?>
                                                    </p>
                                                    <p>
                                                        <span>会社の住所:&nbsp;</span> <?php echo $v["company_address"] ?>
                                                    </p>
                                                    <p>
                                                        <span>会社の電話番号:&nbsp;</span> <?php echo $v["company_tel"] ?>
                                                    </p>
                                                    <p>
                                                        <span>会社評価値:&nbsp;</span> <?php echo $v["rating"] ?>
                                                    </p>
                                                    <p>
                                                        <span>会社タッグ情報:&nbsp;</span> <?php echo $v["tag"] ?>
                                                    </p>
                                                </div>
                                                <!-- <div class="show-report-student"> -->

                                                <!-- </div> -->
                                            </div>

                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="show-report_text">
                                                <div class="show-report_name">
                                                    <p class="name-student"><?php echo $v["student_name"] ?> </p>
                                                </div>
                                                <div class="show_student_code">
                                                    <p class="student_code_show"><?php echo $v["student_code"] ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="show-report">
                                                <table>
                                                    <tr>
                                                        <th width="20%">データベース</th>
                                                        <th width="80%">内容</th>
                                                    </tr>
                                                    <tr>
                                                        <th>内定</th>
                                                        <th>
                                                            <div class="show-report">

                                                                <p>
                                                                    <span>試験の結果:&nbsp;</span><?php echo $v["shiken_kekka"] ?>
                                                                </p>
                                                                <p>
                                                                    <span>内定:&nbsp;</span><?php echo $v["naitei_flag"] ?>
                                                                </p>
                                                                <p>
                                                                    <span>内定日:&nbsp;</span><?php echo $v["naitei_date"] ?>
                                                                </p>
                                                                <p>
                                                                    <span>内定方法:&nbsp;</span><?php echo $v["naitei_method"] ?>
                                                                </p>
                                                                <p>
                                                                    <span>後輩へのアドバイス:&nbsp;</span><?php echo $v["advice_content"] ?>
                                                                </p>
                                                            </div>
                                                        </th>

                                                    </tr>

                                                </table>
                                            </div>

                                            <div class="show-report">
                                                <table>
                                                    <tr>
                                                        <th style="width: 20% ">応募情報</th>
                                                        <th style="width: 80%">
                                                            <div class="show-report">

                                                                <p>
                                                                    <span>応募方法:&nbsp;</span><?php echo $v["apply_process"] ?>
                                                                </p>
                                                                <p>
                                                                    <span>業種:&nbsp;</span><?php echo $v["industry_type"] ?>
                                                                </p>
                                                                <p>
                                                                    <span>職種： &nbsp;</span><?php echo $v["job_name"] ?>
                                                                </p>
                                                            </div>
                                                        </th>

                                                    </tr>

                                                </table>
                                            </div>

                                            <div class="show-report">
                                                <table>
                                                    <tr>
                                                        <th style="width: 20%">試験の内容</th>
                                                        <th style="width: 80%">
                                                            <div class="show-report">

                                                                <div class="show-report-shiken">
                                                                    <div class="skiken-left">
                                                                        <p>
                                                                            <span>試験日:&nbsp;</span><?php echo $v["shiken_date"] ?>
                                                                        </p>
                                                                        <p>
                                                                            <span>試験内容:&nbsp;</span><?php echo $v["shiken_naiyou"] ?>
                                                                        </p>
                                                                        <p>
                                                                            <span>面接質問事項:&nbsp;</span><?php echo $v["interview_items"] ?>
                                                                        </p>
                                                                        <p>
                                                                            <span>面接回数:&nbsp;</span><?php echo $v["interview_times"] ?>
                                                                        </p>
                                                                        <p>
                                                                            <span>一次面接日:&nbsp;</span><?php echo $v["first_interview_date"] ?>
                                                                        </p>
                                                                        <p>
                                                                            <span>二次面接日:&nbsp;</span><?php echo $v["second_interview_date"] ?>
                                                                        </p>
                                                                        <p>
                                                                            <span>三次面接日:&nbsp;</span><?php echo $v["third_interview_date"] ?>
                                                                        </p>

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
                            <div class="modal-footer">
                                <?php
                                $student_code = $v["student_code"];
                                $student_user_code = isset($student['student_code']) ? $student['student_code'] : '';
                                ?>
                                <?php
                                if ($student_code === $student_user_code) { ?>
                                    <a class="btn btn-primary" href="?View=edit_form&student_code=<?php echo $v['student_code'] ?>">編集</a>
                                    <a class="btn btn-danger" onclick="return confirm('削除したいですか？')" href="?View=delete-share-experience&student_code=<?php echo $v['student_code'] ?>">削除</a>
                                <?php } ?>
                                <button type="button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" data-dismiss="modal">閉じる
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="container" style="text-align:center;">
                <?php if (isset($totalPages) && $totalPages > 1) : ?>
                    <?php if (isset($detailedPage) && $detailedPage > 1) : ?>
                        <a class="btn btn-secondary text-uppercase" style="margin-right: 5px;" href="?View=detailed&detailed_page=1#detailed_page-1">&#171;</a>
                        <a class="btn btn-secondary text-uppercase" style="margin-right: 5px;" href="?View=detailed&detailed_page=<?php echo max(1, $detailedPage - 1); ?>#advice_page-<?php echo max(1, $detailedPage - 1); ?>">&#60;</a>
                    <?php endif; ?>

                    <?php
                    $numPagesToShow = 5; // Change this value to control how many page buttons you want to display
                    $halfNumPages = floor($numPagesToShow / 2);

                    // Calculate the starting and ending page numbers
                    $startPage = isset($detailedPage) ? max(1, $detailedPage - $halfNumPages) : 1;
                    $endPage = isset($totalPages) ? min($totalPages, isset($detailedPage) ? $detailedPage + $halfNumPages : $numPagesToShow) : 1;

                    // Display an ellipsis if necessary
                    if ($startPage > 1) {
                        echo '<span style="margin-right: 5px;">...</span>';
                    }

                    // Display page buttons with spacing
                    for ($i = $startPage; $i <= $endPage; $i++) {
                        $isActive = isset($detailedPage) && $i == $detailedPage ? 'active' : '';
                        echo '<a class="btn btn-secondary text-uppercase ' . $isActive . '" href="?View=detailed&detailed_page=' . $i . '#detailed_page-' . $i . '" style="margin-right: 5px;">' . $i . '</a>';
                    }

                    // Display an ellipsis if necessary
                    if (isset($totalPages) && $endPage < $totalPages) {
                        echo '<span style="margin-right: 5px;">...</span>';
                    }

                    if (isset($detailedPage) && $detailedPage < $totalPages) : ?>
                        <a class="btn btn-secondary text-uppercase" style="margin-right: 5px;" href="?View=detailed&detailed_page=<?php echo min($totalPages, $detailedPage + 1); ?>#detailed_page-<?php echo min($totalPages, $detailedPage + 1); ?>">&#62</a>
                        <a class="btn btn-secondary text-uppercase" style="margin-right: 5px;" href="?View=detailed&detailed_page=<?php echo $totalPages; ?>#detailed_page-<?php echo $totalPages; ?>">&#187;</a>
                    <?php endif; ?>
                <?php else : ?>
                    <!-- Add a clear search button when pagination is not displayed -->
                    <form action="?View=detailed" method="post">
                        <button type="submit" class="btn btn-secondary text-uppercase" style="color: black; border: 1px solid black;">Clear Search</button>
                    </form>
                <?php endif; ?>
            </div>
    </div>
    </div>

    </div>

    </section>



</body>

</html>