    <?php
    require_once('Model/DBconnect.php');
    $data = "SELECT s.*, n.*, r.*, sh.*
        FROM student s 
        LEFT JOIN naitei n ON s.student_code = n.student_code 
        LEFT JOIN recruit r ON n.naitei_id = r.recruit_id 
        LEFT JOIN shiken sh ON r.recruit_id = sh.shiken_id 
        WHERE n.naitei_id IS NOT NULL
        GROUP BY n.naitei_id, r.recruit_id, sh.shiken_id
        ORDER BY s.reporting_date DESC";

    // Function to translate English to Katakana
    function transliterateToKatakana($input)
    {
        $mapping = [
            'a' => 'ア', 'b' => 'ビ', 'c' => 'シ', 'd' => 'デ', 'e' => 'イ',
            'f' => 'エフ', 'g' => 'ジ', 'h' => 'エイチ', 'i' => 'イ', 'j' => 'ジェイ',
            'k' => 'ケイ', 'l' => 'エル', 'm' => 'エム', 'n' => 'エヌ', 'o' => 'オ',
            'p' => 'ピ', 'q' => 'キュー', 'r' => 'アール', 's' => 'エス', 't' => 'ティ',
            'u' => 'ユー', 'v' => 'ブイ', 'w' => 'ダブリュー', 'x' => 'エックス', 'y' => 'ワイ',
            'z' => 'ゼット',
        ];

        $input = strtolower($input);
        $output = '';

        for ($i = 0; $i < strlen($input); $i++) {
            $char = $input[$i];

            if (array_key_exists($char, $mapping)) {
                $output .= $mapping[$char];
            } else {
                // If the character is not in the mapping, keep it as is
                $output .= $char;
            }
        }

        return $output;
    }


    if (!isset($_SESSION)) {
        session_start();
    }
    $key = (isset($_GET['keyword'])) ? $_GET['keyword'] : [];


    $student = (isset($_SESSION['student'])) ? $_SESSION['student'] : [];


    $naitei = (isset($_SESSION['naitei'])) ? $_SESSION['naitei'] : [];

    $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

    // <!--19TE500 ｷﾞｭｳﾃｲﾊｲ　20220802-->

    // Transliterate the keyword
    $transliteratedKeyword = transliterateToKatakana($keyword);


    // <!--19TE500 ｷﾞｭｳﾃｲﾊｲ　20220802-->


    if (!empty($keyword)) {
        // Convert the keyword to both half-width and full-width for a comprehensive search
        $halfWidthKeyword = mb_convert_kana($keyword, "as");
        $fullWidthKeyword = mb_convert_kana($keyword, "ASKV");

        $search_home = "SELECT s.*, n.*, r.*, sh.*
        FROM student s 
        LEFT JOIN naitei n ON s.student_code = n.student_code 
        LEFT JOIN recruit r ON n.naitei_id = r.recruit_id 
        LEFT JOIN shiken sh ON r.recruit_id = sh.shiken_id
        WHERE 
            (s.student_code LIKE '%$transliteratedKeyword%' OR s.student_code LIKE '%$halfWidthKeyword%' OR s.student_code LIKE '%$fullWidthKeyword%') 
            OR (n.company_name LIKE '%$transliteratedKeyword%' OR n.company_name LIKE '%$halfWidthKeyword%' OR n.company_name LIKE '%$fullWidthKeyword%') 
            OR (n.job_name LIKE '%$transliteratedKeyword%' OR n.job_name LIKE '%$halfWidthKeyword%' OR n.job_name LIKE '%$fullWidthKeyword%') 
            OR (n.industry_type LIKE '%$transliteratedKeyword%' OR n.industry_type LIKE '%$halfWidthKeyword%' OR n.industry_type LIKE '%$fullWidthKeyword%')
        GROUP BY n.naitei_id, r.recruit_id, sh.shiken_id
        ORDER BY s.reporting_date DESC
        LIMIT 0,10;";
        $result1 = mysqli_query($conn, $search_home);
        // 21TE412 グエン　ヴァン　クイ追加　検索履歴をデータベースをインストールする 2024/7/4
        $timestamp = date('Y-m-d H:i:s');
        if(isset($_SESSION['student']))
        {
            $sql = "INSERT INTO search_history (student_code, search_item,search_timestamp)
            VALUES ('$student_code','$keyword',NOW();";
            $query = mysqli_query($conn, $sql);
        }
        else{
            $sql = "INSERT INTO search_history (student_code, search_item,search_timestamp)
            VALUES ('CLONE','$keyword',NOW());";
            $query = mysqli_query($conn, $sql);
        }
        // 21TE412
        
    } else {
        $result1 = mysqli_query($conn, $data);
    }
    // gửi dữ liệu tìm kiếm đến database


    // $result = mysqli_query($conn, $data);
    $itemsPerPage = 9; // Number of items to display per page
    $totalItems = mysqli_num_rows($result1); // Total number of items
    $totalPages = ceil($totalItems / $itemsPerPage); // Calculate total pages
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Get the current page

    // Ensure the current page is within a valid range
    $page = max(1, min($page, $totalPages));

    // Calculate the starting point for the current page
    $start = ($page - 1) * $itemsPerPage;

    // Convert the keyword to both half-width and full-width for a comprehensive search
    $halfWidthKeyword = mb_convert_kana($keyword, "as");
    $fullWidthKeyword = mb_convert_kana($keyword, "ASKV");

    // Modify your SQL query to include the LIMIT clause for pagination
    $paginationQuery = "SELECT s.*, n.*, r.*, sh.*
        FROM student s 
        LEFT JOIN naitei n ON s.student_code = n.student_code 
        LEFT JOIN recruit r ON n.naitei_id = r.recruit_id 
        LEFT JOIN shiken sh ON r.recruit_id = sh.shiken_id
        WHERE 
            (s.student_code LIKE '%$transliteratedKeyword%' OR s.student_code LIKE '%$keyword%') 
            OR (n.company_name LIKE '%$transliteratedKeyword%' OR n.company_name LIKE '%$keyword%') 
            OR (n.job_name LIKE '%$transliteratedKeyword%' OR n.job_name LIKE '%$keyword%') 
            OR (n.industry_type LIKE '%$transliteratedKeyword%' OR n.industry_type LIKE '%$keyword%')
        GROUP BY n.naitei_id, r.recruit_id, sh.shiken_id
        ORDER BY s.reporting_date DESC
        LIMIT $start, $itemsPerPage";

    // Execute the modified query for pagination
    $result1 = mysqli_query($conn, $paginationQuery);

    ?>
    <?php
    require_once('Model/DBconnect.php');
    ob_start();
    if (!isset($_SESSION)) {
        session_start();
    }
    $student = (isset($_SESSION['student'])) ? $_SESSION['student'] : [];
    $studentId = (isset($_SESSION['student'])) ? $student['id'] : [];
    $student_code = (isset($_SESSION['student'])) ? $student['student_code'] : [];
    if (isset($_SESSION['student'])) {
        $nameStudent = "SELECT `student_name` FROM `student` WHERE id = $studentId";
        $query = mysqli_query($conn, $nameStudent);
        $data = mysqli_fetch_assoc($query);

        $shartReport = "SELECT `shiken_kekka` FROM `shiken` WHERE student_code = '$student_code'";
        $queryNaitei = mysqli_query($conn, $shartReport);
        $dataNaitei = mysqli_fetch_assoc($queryNaitei);
    }

    ?>


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
    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        function scrollToPortfolio() {
            // Scroll to the h2 element
            var h2Element = document.getElementById('portfolio');

            if (h2Element) {
                h2Element.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        }

        function scrollToMasthead() {
            // Scroll to the top of the masthead element
            var mastheadElement = document.querySelector('.masthead');

            if (mastheadElement) {
                mastheadElement.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        }

        $(document).ready(function() {
            // Handle button click event
            $('#showCompanyList').click(function(e) {
                // Prevent the default form submission behavior
                e.preventDefault();

                // Toggle the visibility of the company list container
                $('#companyListContainer').toggle();

                // Check if the list is visible
                var isVisible = $('#companyListContainer').is(':visible');

                // If visible, make an AJAX request to get the company names
                if (isVisible) {
                    $.ajax({
                        url: 'getCompanyNames.php',
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            // Display the company names in the container
                            displayCompanyNames(data);
                        },
                        error: function(error) {
                            console.error('Error fetching company names:', error);
                        }
                    });
                }
            });

            // Function to display company names in the container
            function displayCompanyNames(companyNames) {
                var companyListContainer = $('#companyListContainer');

                // Clear existing content
                companyListContainer.empty();

                // Set a fixed height for the container and enable vertical scrolling
                // companyListContainer.css({
                //     'max-height': '200px', // Adjust the height as needed
                //     'overflow-y': 'auto'
                // });		
            companyNames.reverse();

                // Create an unordered list and append company names
                var ul = $('<ul>');
                companyNames.forEach(function(company) {
                    // Append each company name as a list item with a click event listener
                    var li = $('<li>').text(company).click(function() {
                        // Set the clicked company name as the search keyword
                        var keyword = $(this).text().trim();

                        // Update the search input value
                        $('.search-form-container input[name="keyword"]').val(keyword);

                        // Trigger the form submission
                        $('.search-form-container form').submit();
                    });

                    ul.append(li);
                });

                // Append the list to the container
                companyListContainer.append(ul);
            }

            // Close the list when clicking anywhere outside the container or button
            $(document).on('click', function(e) {
                var companyListContainer = $('#companyListContainer');
                var showCompanyListButton = $('#showCompanyList');

                // Check if the clicked element is not the container or the button
                if (!companyListContainer.is(e.target) && !showCompanyListButton.is(e.target) && companyListContainer.has(e.target).length === 0) {
                    companyListContainer.hide();
                }
            });
        });
    </script>
    <style>
        #companyListContainer {
            display: none;
            border: 1px solid #ccc;
            margin-top: 5px;
            position: absolute;
            top: 100%;
            left: 0;
            background-color: black;
            /* Set the background color to black */
            color: white;
            /* Set the text color to white or any contrasting color */
            padding: 10px;
            /* Add padding for better visibility */
            border-radius: 4px;
            /* Optional: Add border radius for rounded corners */
            display: none;
            /* Initially hide the container */
        overflow-y: auto;
            max-height: 200px;
        }

        @media only screen and (max-width: 767px) {
            #companyListContainer {
                max-height: 150px;
            }

            .input-group {
                width: 85%;
                /* Set the width to 85% for smaller screens */
                /* Center the form horizontally if needed */
            }
        }
    </style>


    <!-- Home Header -->

    <header class="masthead">
        <!-- 21te412 グエン　ヴァン　クイ　2024/07/09 ログイン完了追加 -->
        <div id="notificationContainer"></div>
        <script>
            // Hàm để hiển thị thông báo
            function showNotification(message) {
                var notificationContainer = document.getElementById('notificationContainer');
                var alert = document.createElement('div');
                alert.className = 'alert';
                alert.innerHTML = message + '<span class="closebtn" onclick="closeAlert(this)">&times;</span>';
                notificationContainer.appendChild(alert);

                // Tự động ẩn thông báo sau 4 giây
                setTimeout(function() {
                    if (alert) {
                        alert.style.display = 'none';
                    }
                }, 4000);
            }

            // Hàm để đóng thông báo khi người dùng nhấp vào nút đóng
            function closeAlert(element) {
                var alert = element.parentElement;
                if (alert) {
                    alert.style.display = 'none';
                }
            }

            // Kiểm tra nếu có thông báo từ PHP, hiển thị nó
            <?php if (!empty($_SESSION['login_success'])): ?>
                showNotification('<?php echo addslashes($_SESSION['login_success']); ?>');
                <?php unset($_SESSION['login_success']); // Xóa thông báo sau khi hiển thị ?>
            <?php endif; ?>
        </script>
         <!-- 21te412 グエン　ヴァン　クイ　2024/07/09 ログイン完了追加 -->
        <div class="container d-flex flex-column align-items-center">
            <div class="masthead-subheading">第一工科大学上野キャンパス</div>
            <div class="masthead-heading text-uppercase">ようこそ就職支援システム</div>
            <div class="d-flex flex-column align-items-start mw-100" style="width: 350px;">
                <!-- Container for the search form -->
                 <!-- 21te412 グエン　ヴァン　クイ2024/07/18 -->
                <div class="search-form-container">
                    <form action="index.php" method="GET" class="input-group">
                        <input type="search" name="keyword" value="<?php echo (isset($_GET['keyword'])) ? $_GET['keyword'] : ''; ?>" class="form-control rounded" placeholder="会社名・職種・業種・学籍番号" aria-label="Search" aria-describedby="search-addon" />
                        <button type="submit" action="index.php" class="btn btn-primary border text-uppercase" style="background-color:#ff4b2b" id="search-addon">
                            <i class="fas fa-search"></i>
                        </button>
                        <button class="btn btn-dark text-uppercase" id="showCompanyList">会社名一覧</button>
                    </form>

                    <!-- Container to display the company names -->
                    <div id="companyListContainer" style="position: absolute; top: 100%; left: 0;"></div>
                </div>
                <div class="mt-4 h-250">

                    <a class="btn btn-success text-uppercase" href="?View=detailed">詳細検索</a>
                    <a class="btn btn-danger text-uppercase" id="scrollList" onclick="scrollToPortfolio()">リスト表示</a>
                    <a class="btn btn-info  text-uppercase" href="?View=advice">アドバイス閲覧</a>
                </div>

            </div>

        </div>
    </header>

    <!-- Portfolio Grid-->
    <section class="page-section bg-light opacity-95 homelist" id="portfolio">
        <div class="container" id="#page-<?php echo $page; ?>">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">就活状況</h2>
                <h3 class="section-subheading text-muted">内定・内々定が確定された学生達のリスト</h3>
            </div>

            <div class="row">
                <?php foreach ($result1 as $key => $v) : ?>
                    <div class="col-lg-4 col-sm-6 mb-4 center-item">
                        <!-- Portfolio item 1-->
                        <div class="portfolio-item rounded shadow mb-5 bg-body" style="overflow-x: hidden;">
                            <a class="portfolio-link border border-secondary-5 rounded" data-bs-toggle="modal" href="#portfolioModal1">
                                <div class="portfolio-hover ">
                                    <?php if (isset($_SESSION["student"])) { ?>
                                        <button type="button" class="detail infor_button" data-toggle="modal" data-target="#<?php echo $v["naitei_id"] ?>">
                                            <div class="portfolio-hover-content"><i class="fas fa-plus fa-3x"></i></div>
                                        </button>
                                    <?php } else { ?>
                                        <button type="button" onclick="login()" class="detail infor_button">
                                            <div class="portfolio-hover-content"><i class="fas fa-plus fa-3x"></i></div>
                                        </button>

                                    <?php } ?>
                                    <!-- <div class="portfolio-hover-content"><i class="fas fa-plus fa-3x"></i><?php echo $v["student_name"] ?></div> -->
                                </div>
                                <div style="width:100%; max-width:400px; height:350px; z-index:-1; display:flex; justify-content:center; align-items:center;">
                                    <h1 class="display-5"><small>会社名</small><br><strong><?php echo $v["company_name"] ?></strong></h1>
                                    <!-- <h1 style="position:absolute;  font-size:32px; margin:0 -72px;"><?php echo $v["student_name"] ?></h1> -->
                                </div>

                                <!-- <img style="width:350px; height:262.5px" src="public/assets/web/image/assets/img/portfolio/1.jpg" alt="<?php echo $v["student_name"] ?>" /> -->


                            </a>
                            <div class="portfolio-caption rounded-bottom">
                                <div class="portfolio-caption-heading"></div>
                                <div class="portfolio-caption-subheading text-muted">名前：<?php echo $v["student_name"] ?></div>
                                <div class="portfolio-caption-subheading text-muted">内定日：<?php echo $v["naitei_date"] ?></div>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>
            </div>
            <div class="pagination">
                <?php if ($totalPages > 1) : ?>
                    <?php if ($page > 1) : ?>
                        <!-- First link -->
                        <?php $linkFirst = isset($_GET['keyword']) ? "?page=1&keyword=" . urlencode($_GET['keyword']) : "?page=1"; ?>
                        <a class="btn btn-secondary text-uppercase" style="margin-right: 5px;" href="<?php echo $linkFirst; ?>#page-1">&#171;</a>

                        <!-- Previous link -->
                        <?php $linkPrev = isset($_GET['keyword']) ? "?page=" . ($page - 1) . "&keyword=" . urlencode($_GET['keyword']) : "?page=" . ($page - 1); ?>
                        <a class="btn btn-secondary text-uppercase" style="margin-right: 5px;" href="<?php echo $linkPrev; ?>#page-<?php echo $page - 1; ?>">&#60;</a>
                    <?php endif; ?>

                    <?php
                    $numPagesToShow = 5; // Change this value to control how many page buttons you want to display
                    $halfNumPages = floor($numPagesToShow / 2);

                    // Calculate the starting and ending page numbers
                    $startPage = max(1, $page - $halfNumPages);
                    $endPage = min($totalPages, $page + $halfNumPages);

                    // Display an ellipsis if necessary
                    if ($startPage > 1) {
                        echo '<span style="margin-right: 5px;">...</span>';
                    }

                    // Display page buttons with spacing
                    for ($i = $startPage; $i <= $endPage; $i++) {
                        $isActive = $i == $page ? 'active' : '';
                        // Check if the keyword is set and include it in the pagination links
                        $link = isset($_GET['keyword']) ? "?page=$i&keyword=" . urlencode($_GET['keyword']) : "?page=$i";
                        echo '<a class="btn btn-secondary text-uppercase ' . $isActive . '" style="margin-right: 5px;" href="' . $link . '#page-' . $i . '">' . $i . '</a>';
                    }

                    // Display an ellipsis if necessary
                    if ($endPage < $totalPages) {
                        echo '<span style="margin-right: 5px;">...</span>';
                    }
                    ?>

                    <?php if ($page < $totalPages) : ?>
                        <!-- Next link -->
                        <?php $linkNext = isset($_GET['keyword']) ? "?page=" . ($page + 1) . "&keyword=" . urlencode($_GET['keyword']) : "?page=" . ($page + 1); ?>
                        <a class="btn btn-secondary text-uppercase" style="margin-right: 5px;" href="<?php echo $linkNext; ?>#page-<?php echo $page + 1; ?>">&#62</a>

                        <!-- Last link -->
                        <?php $linkLast = isset($_GET['keyword']) ? "?page=" . $totalPages . "&keyword=" . urlencode($_GET['keyword']) : "?page=" . $totalPages; ?>
                        <a class="btn btn-secondary text-uppercase" style="margin-right: 5px;" href="<?php echo $linkLast; ?>#page-<?php echo $totalPages; ?>">&#187;</a>
                    <?php endif; ?>

                    <a class="btn btn-outline-secondary" style="margin-left: auto;" id="scrollTop" onclick="scrollToMasthead()">Top</a>
                <?php endif; ?>
            </div>
        </div>

    </section>


    <section>



        <!-- Detail Info -->

        <?php foreach ($result1 as $key => $v) : ?>
            <div class=" modal fade" id="<?php echo $v["naitei_id"] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            $naitei_id = $v["naitei_id"];
                            $student_user_code = isset($student['student_code']) ? $student['student_code'] : '';
                            $naitei_num = isset($naitei['naitei_id']) ? $naitei['naitei_id'] : '';
                            ?>
                            <?php
                            if ($student_code === $student_user_code) { ?>
                                <a class="btn btn-primary" href="?View=edit_form&student_code=<?php echo $v['student_code'] ?>&naitei_id=<?php echo $v['naitei_id'] ?>">編集</a>
                                <a class="btn btn-danger" onclick="return confirm('削除したいですか？')" href="?View=delete-share-experience&naitei_id=<?php echo $v['naitei_id'] ?>">削除</a>
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