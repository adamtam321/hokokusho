<!-- 19te500 ギュウテイハイ -->
<?php
require_once('Model/DBconnect.php');

$data = "SELECT s.*, n.*, r.*, sh.*
    FROM student s 
    LEFT JOIN naitei n ON s.student_code = n.student_code 
    LEFT JOIN recruit r ON n.naitei_id = r.recruit_id 
    LEFT JOIN shiken sh ON r.recruit_id = sh.shiken_id 
    GROUP BY n.naitei_id, r.recruit_id, sh.shiken_id
    ORDER BY s.reporting_date DESC";

if (!isset($_SESSION)) {
    session_start();
}
$advice = mysqli_query($conn, $data);
// $result = mysqli_query($conn, $data);
$itemsPerPage = 9; // Number of items to display per page

// Calculate the total number of advice entries
$totalItemsQuery = "SELECT COUNT(*) FROM naitei WHERE advice_content IS NOT NULL";  // Add the same condition as in your SQL query
$totalItemsResult = mysqli_query($conn, $totalItemsQuery);
$totalItemsRow = mysqli_fetch_row($totalItemsResult);
$totalItems = $totalItemsRow[0];

// Calculate the total number of pages
$totalPages = ceil($totalItems / $itemsPerPage);

if (!isset($_GET['advice_page'])) {
    $advicePage = 1;
} else {
    $advicePage = (int)$_GET['advice_page'];
}

// Ensure the current page is within a valid range
$advicePage = max(1, min($advicePage, $totalPages));

// Calculate the starting point for the current page
$start2 = ($advicePage - 1) * $itemsPerPage;

// Modify your SQL query to include the LIMIT clause for pagination
$paginationQuery2 = "SELECT s.*, n.*, r.*, sh.*
FROM student s 
LEFT JOIN naitei n ON s.student_code = n.student_code 
LEFT JOIN recruit r ON n.naitei_id = r.recruit_id 
LEFT JOIN shiken sh ON r.recruit_id = sh.shiken_id
WHERE n.advice_content IS NOT NULL  -- Add this condition to filter records with advice_content
ORDER BY s.reporting_date DESC
LIMIT $start2, $itemsPerPage";
$advice = mysqli_query($conn, $paginationQuery2);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>



<body>

    <style>
        /* CSS to center the 10th item */
        .center-item {
            margin-left: auto;
            margin-right: auto;
        }

        @media (max-width: 1020px) {
            .col-lg-4 {
                flex-basis: 50%;
                /* Display 2 items in 1 row */
                max-width: 50%;
            }
        }

        @media (max-width: 640px) {
            .col-lg-4 {
                flex-basis: 100%;
                /* Display 1 item in 1 row */
                max-width: 100%;
            }
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="scroll.js"></script>
    <script>
        function scrollToTop() {
            $('html, body').animate({
                scrollTop: $('.pt-5').offset().top - 300
            }, 100, '');
        }

        $(document).ready(function() {
            $('#scrollTop').click(function() {
                scrollToTop();
            });
        });
    </script>

    <!-- Portfolio Grid-->
    <section class="page-section bg-light opacity-95 homelist" id="portfolio">
        <div class="container">
            <div class="text-center pt-5">
                <h2 class="section-heading text-uppercase">先輩からのアドバイス</h2>
                <h3 class="section-subheading text-muted">内定・内々定が確定された学生達のアドバイス</h3>
            </div>

            <div class="row">
                <?php foreach ($advice as $a) : ?>

                    <div class="col-lg-4 col-sm-6 mb-4 center-item">
                        <!-- Portfolio item 1-->
                        <div class="portfolio-item rounded shadow mb-5 bg-body">
                            <a class="portfolio-link border border-secondary-5 rounded" data-bs-toggle="modal" href="#portfolioModal1">
                                <div class="portfolio-hover ">
                                    <?php if (isset($_SESSION["student"])) { ?>
                                        <button type="button" class="detail infor_button" data-toggle="modal" data-target="#<?php echo $a["naitei_id"] ?>">
                                            <div class="portfolio-hover-content"><i class="fas fa-plus fa-3x"></i></div>
                                        </button>
                                    <?php } else { ?>
                                        <button type="button" onclick="login()" class="detail infor_button">
                                            <div class="portfolio-hover-content"><i class="fas fa-plus fa-3x"></i></div>
                                        </button>

                                    <?php } ?>
                                    <!-- <div class="portfolio-hover-content"><i class="fas fa-plus fa-3x"></i><?php echo $f["student_name"] ?></div> -->
                                </div>
                                <div style="width:100%; max-width:400px; height:350px; z-index:-1; display:flex; justify-content:center; align-items:center;">
                                    <h1 class="display-5"><?php echo $a["advice_content"] ?></h1>
                                    <!-- <h1 style="position:absolute;  font-size:32px; margin:0 -72px;"><?php echo $f["student_name"] ?></h1> -->
                                </div>

                                <!-- <img style="width:350px; height:262.5px" src="public/assets/web/image/assets/img/portfolio/1.jpg" alt="<?php echo $f["student_name"] ?>" /> -->


                            </a>
                            <!-- 21TE412 グエンヴァン　クイ portfolio-caption　CSSを 追加した!-->
                            <div class="portfolio-caption rounded-bottom" style="height: 150px;display: flex;flex-direction: column;justify-content: center;padding: 10px;box-sizing: border-box;">
                                <div class=" portfolio-caption-heading"><small>会社名：</small><br><?php echo $a["company_name"] ?></div>
                                <div class="portfolio-caption-subheading text-muted">名前：<?php echo $a["student_name"] ?></div>
                                <div class="portfolio-caption-subheading text-muted">内定日：<?php echo $a["naitei_date"] ?></div>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>
            </div>
            <div class="pagination">
                <?php if ($totalPages > 1) : ?>
                    <?php if ($advicePage > 1) : ?>
                        <a class="btn btn-secondary text-uppercase" style="margin-right: 5px;" href="?View=advice&advice_page=1#advice_page-1">&#171;</a>
                        <a class="btn btn-secondary text-uppercase" style="margin-right: 5px;" href="?View=advice&advice_page=<?php echo $advicePage - 1; ?>#advice_page-<?php echo $advicePage - 1; ?>">&#60;</a>
                    <?php endif; ?>

                    <?php
                    $numPagesToShow = 5; // Change this value to control how many page buttons you want to display
                    $halfNumPages = floor($numPagesToShow / 2);

                    // Calculate the starting and ending page numbers
                    $startPage = max(1, $advicePage - $halfNumPages);
                    $endPage = min($totalPages, $advicePage + $halfNumPages);

                    // Display an ellipsis if necessary
                    if ($startPage > 1) {
                        echo '<span style="margin-right: 5px;">...</span>';
                    }

                    // Display page buttons with spacing
                    for ($i = $startPage; $i <= $endPage; $i++) {
                        $isActive = $i == $advicePage ? 'active' : '';
                        echo '<a class="btn btn-secondary text-uppercase ' . $isActive . '" href="?View=advice&advice_page=' . $i . '#advice_page-' . $i . '" style="margin-right: 5px;">' . $i . '</a>';
                    }

                    // Display an ellipsis if necessary
                    if ($endPage < $totalPages) {
                        echo '<span style="margin-right: 5px;">...</span>';
                    }
                    ?>

                    <?php if ($advicePage < $totalPages) : ?>
                        <a class="btn btn-secondary text-uppercase" style="margin-right: 5px;" href="?View=advice&advice_page=<?php echo $advicePage + 1; ?>#advice_page-<?php echo $advicePage + 1; ?>">&#62</a>
                        <a class="btn btn-secondary text-uppercase" style="margin-right: 5px;" href="?View=advice&advice_page=<?php echo $totalPages; ?>#advice_page-<?php echo $totalPages; ?>">&#187;</a>
                    <?php endif; ?>
                    <a class="btn btn-outline-secondary" style="margin-left: auto;" id="scrollTop">Top</a>
                <?php endif; ?>
            </div>
        </div>

    </section>


    <section>
        <!-- Detail Info -->

        <?php foreach ($advice as $key => $a) : ?>
            <div class="modal fade" id="<?php echo $a["naitei_id"] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                    <span>提出日:&nbsp;</span> <?php echo $a["reporting_date"] ?>
                                                </p>

                                                <p>
                                                    <span>性別:&nbsp;</span> <?php echo $a["gender"] ?>
                                                </p>
                                                <p>
                                                    <span>会社名:&nbsp;</span> <?php echo $a["company_name"] ?>
                                                </p>
                                                <p>
                                                    <span>郵便番号:&nbsp;</span> <?php echo $a["company_postcode"] ?>
                                                </p>
                                                <p>
                                                    <span>会社の住所:&nbsp;</span> <?php echo $a["company_address"] ?>
                                                </p>
                                                <p>
                                                    <span>会社の電話番号:&nbsp;</span> <?php echo $a["company_tel"] ?>
                                                </p>
                                                <p>
                                                    <span>会社評価値:&nbsp;</span> <?php echo $a["rating"] ?>
                                                </p>
                                                <p>
                                                    <span>会社タッグ情報:&nbsp;</span> <?php echo $a["tag"] ?>
                                                </p>
                                            </div>
                                            <!-- <div class="show-report-student"> -->

                                            <!-- </div> -->
                                        </div>

                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6">
                                        <div class="show-report_text">
                                            <div class="show_student_code">
                                                <p class="student_code_show"><?php echo $a["student_code"] ?></p>
                                            </div>
                                            <div class="show-report_name">
                                                <p class="name-student"><?php echo $a["student_name"] ?> </p>
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
                                                                <span>試験の結果:&nbsp;</span><?php echo $a["shiken_kekka"] ?>
                                                            </p>
                                                            <p>
                                                                <span>内定:&nbsp;</span><?php echo $a["naitei_flag"] ?>
                                                            </p>
                                                            <p>
                                                                <span>内定日:&nbsp;</span><?php echo $a["naitei_date"] ?>
                                                            </p>
                                                            <p>
                                                                <span>内定方法:&nbsp;</span><?php echo $a["naitei_method"] ?>
                                                            </p>
                                                            <p>
                                                                <span>後輩へのアドバイス:&nbsp;</span><?php echo $a["advice_content"] ?>
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
                                                                <span>応募方法:&nbsp;</span><?php echo $a["apply_process"] ?>
                                                            </p>
                                                            <p>
                                                                <span>業種:&nbsp;</span><?php echo $a["industry_type"] ?>
                                                            </p>
                                                            <p>
                                                                <span>職種： &nbsp;</span><?php echo $a["job_name"] ?>
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
                                                                        <span>試験日:&nbsp;</span><?php echo $a["shiken_date"] ?>
                                                                    </p>
                                                                    <p>
                                                                        <span>試験内容:&nbsp;</span><?php echo $a["shiken_naiyou"] ?>
                                                                    </p>
                                                                    <p>
                                                                        <span>面接質問事項:&nbsp;</span><?php echo $a["interview_items"] ?>
                                                                    </p>
                                                                    <p>
                                                                        <span>面接回数:&nbsp;</span><?php echo $a["interview_times"] ?>
                                                                    </p>
                                                                    <p>
                                                                        <span>一次面接日:&nbsp;</span><?php echo $a["first_interview_date"] ?>
                                                                    </p>
                                                                    <p>
                                                                        <span>二次面接日:&nbsp;</span><?php echo $a["second_interview_date"] ?>
                                                                    </p>
                                                                    <p>
                                                                        <span>三次面接日:&nbsp;</span><?php echo $a["third_interview_date"] ?>
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
                        <div class="modal-footer">
                            <?php
                            $student_code = $a["student_code"];
                            $naitei_id = $a["naitei_id"];
                            $student_user_code = isset($student['student_code']) ? $student['student_code'] : '';
                            $naitei_num = isset($naitei['naitei_id']) ? $naitei['naitei_id'] : '';
                            ?>
                            <?php
                            if ($student_code === $student_user_code) { ?>
                                <a class="btn btn-primary" href="?View=edit_form&student_code=<?php echo $a['student_code'] ?>&naitei_id=<?php echo $a['naitei_id'] ?>">編集</a>
                                <a class="btn btn-danger" onclick="return confirm('削除したいですか？')" href="?View=delete-share-experience&naitei_id=<?php echo $a['naitei_id'] ?>">削除</a>
                            <?php } ?>
                            <button type="button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" data-dismiss="modal">閉じる</button>





                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>


        </div>
        </div>
        </div>


    </section>
</body>

</html>