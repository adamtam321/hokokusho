<?php
require_once('Model/DBconnect.php');
if (!isset($_SESSION)) {
    session_start();
}

$error = [];

if (isset($_SESSION['student'])) {
    $student = (isset($_SESSION['student'])) ? $_SESSION['student'] : [];
} else {
    header("?View=login"); /* Redirect browser */
}
$studentId = $student['id'];

if (isset($_POST['student_name'])) {
    // student_name
    $student_name = $_POST['student_name'];
    $student_name = str_replace(" ", "", $student_name);
    // $student_name = mb_convert_kana($student_name, "KVC");
    // student code
    $student_code = $_POST['student_code'];
    // $student_code = str_replace(" ", "", $student_code);
    // $student_code = mb_convert_kana($student_code, "a");

    $reporting_date = $_POST['reporting_date'];
    $gender = $_POST['gender'];
    // company name
    $company_name = $_POST['company_name'];
    // $company_name = str_replace(" ", "", $company_name);
    // $company_name = mb_convert_kana($company_name, "K");

    // post code
    $company_postcode = $_POST['company_postcode'];

    // company_address
    $company_address = $_POST['company_address'];
    // $company_address = str_replace(" ", "", $company_address);
    // $company_address = mb_convert_kana($company_address, "K");

    // tel number
    $company_tel = $_POST['company_tel'];

    // rating
    $rating = $_POST['rating'];

    // tag
    $tag = $_POST['tag'];

    if (empty($student_name)) {
        $error['student_name'] = "名前を入力してください。";
    }
    if (empty($reporting_date)) {
        $error['reporting_date'] = "提出日を入力してください。";
    }
    if (empty($student_code)) {
        $error['student_code'] = "学生番号を入力してください。";
    }
    if (empty($gender)) {
        $error['gender'] = "性別を入力してください。";
    }
    if (empty($company_name)) {
        $error['company_name'] = "会社名を入力してください。";
    }
    if (empty($company_address)) {
        $error['company_address'] = "会社住所を入力してください。";
    }
    if (empty($company_tel)) {
        $error['company_tel'] = "会社電話番号を入力してください。";
    }
    if (empty($rating)) {
        $error['rating'] = "会社評価を入力してください。";
    }
    if (empty($tag)) {
        $error['tag'] = "会社タッグ情報を入力してください。";
    }
    if (empty($company_postcode)) {
        $error['company_postcode'] = "郵便番号を入力してください。";
    }

    //recruit
    $apply_process = $_POST['apply_process'];
    $industry_type = $_POST['industry_type'];
    $job_name = $_POST['job_name'];


    //naitei
    $shiken_kekka = isset($_POST['shiken_kekka']) ? $_POST['shiken_kekka'] : '';

    // $shiken_kekka = $_POST['shiken_kekka'];
    // $naitei = $_POST['naitei'];

    $naitei_flag = isset($_POST['naitei_flag']) ? $_POST['naitei_flag'] : '';

    $naitei_date = $_POST['naitei_date'];

    // $naitei_method = $_POST['naitei_method'];

    $naitei_method = isset($_POST['naitei_method']) ? $_POST['naitei_method'] : '';

    // advice_content
    $advice_content = $_POST['advice_content'];
    // $advice_content = str_replace(" ", "", $advice_content);
    // $advice_content = mb_convert_kana($advice_content, "KVa");


    if (empty($shiken_kekka)) {
        $error['shiken_kekka'] = "試験結果を選択してください。";
    }
    if (empty($naitei_flag)) {
        $error['naitei_flag'] = "内定後の流れを選択してください。";
    }
    if (empty($naitei_date)) {
        $error['naitei_date'] = "内定日を選択してください。";
    }
    if (empty($naitei_method)) {
        $error['naitei_method'] = "内定通知書の連絡方法を入力してください。";
    }
    if (empty($industry_type)) {
        $error['industry_type'] = "業種を入力してください。";
    }
    if (empty($job_name)) {
        $error['job_name'] = "職種を入力してください。";
    }
    if (empty($advice_content)) {
        $error['advice_content'] = "後輩へのアドバイスを入力してください。";
    }

    //    shiken
    $shiken_date = $_POST['shiken_date'];
    // shiken_naiyou
    $shiken_naiyou = $_POST['shiken_naiyou'];

    // interview_items
    $interview_items = $_POST['interview_items'];

    // interview times
    $interview_times = $_POST['interview_times'];

    // interview dates
    $first_interview_date = $_POST['first_interview_date'];
    $second_interview_date = $_POST['second_interview_date'];
    $third_interview_date = $_POST['third_interview_date'];


    if (empty($shiken_date)) {
        $error['shiken_date'] = "試験日を入力してください。";
    }
    if (empty($shiken_naiyou)) {
        $error['shiken_naiyou'] = "試験内容を入力してください。";
    }
    if (empty($interview_items)) {
        $error['interview_items'] = "面接質問事項を入力してください。";
    }
    if (empty($interview_times)) {
        $error['interview_times'] = "面接回数を入力してください。";
    }
    if (empty($first_interview_date)) {
        $error['first_interview_date'] = "一次面接日を入力してください。";
    }

    if (empty($second_interview_date)) {
        $error['second_interview_date'] = "二次面接日を入力してください。";
    }

    if (empty($third_interview_date)) {
        $error['third_interview_date'] = "三次面接日を入力してください。";
    }


    $query = 0;
    // <!-- 19te500 ギュウテイハイ 20221204-->
    if (empty($error)) {

        $sql = "UPDATE student SET `student_code`='$student_code', `reporting_date`='$reporting_date' ,`student_name`='$student_name' WHERE id='$studentId';
        INSERT INTO naitei (student_code, company_name, company_postcode, company_address, company_tel, rating, tag, naitei_date, naitei_method, industry_type, job_name, naitei_flag, advice_content) 
        VALUES ('$student_code', '$company_name', '$company_postcode', '$company_address', '$company_tel', '$rating', '$tag', '$naitei_date', '$naitei_method', '$industry_type', '$job_name', '$naitei_flag', '$advice_content'); 
        INSERT INTO recruit (student_code,apply_process)
        VALUES ('$student_code','$apply_process');
        INSERT INTO shiken (student_code,shiken_date,shiken_naiyou,interview_items,interview_times,first_interview_date,second_interview_date,third_interview_date,shiken_kekka)  
        VALUES ('$student_code','$shiken_date','$shiken_naiyou','$interview_items','$interview_times','$first_interview_date','$second_interview_date','$third_interview_date','$shiken_kekka');";
        $query = $conn->multi_query($sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error($conn), E_USER_ERROR);
        // $_SESSION['create_report_success'] = "Tạo Báo cáo thành công";
        header('Location: ?index.php');
    } else {
        $query = isset($array['query']) ? $array['query'] : '';
        if (!$query) {
            $error['db_query'] = mysqli_error($conn);
        }
    }
}
?>

<style>
    .max-h-64 {
        max-height: 16rem;
    }

    /*Quick overrides of the form input as using the CDN version*/
    .form-input,
    .form-textarea,
    .form-select,
    .form-multiselect {
        background-color: #edf2f7;
    }

    .required:after {
        content: "  ※必須";
        /* content:"";  */
        color: red;
    }

    .required:hover:after {
        font-size: 15px;
        /* Adjust the font size as needed */
    }

    .explanation {
        color: red;
    }
</style>



<div class="bg-gray-100 text-gray-900 tracking-wider leading-normal">
    <nav id="header">
        <div id="userMenu">
        </div>
    </nav>
    <!--Container-->
    <div class="container w-full flex flex-wrap mx-auto px-2 pt-8 lg:pt-16 mt-16">

        <!-- 1 -->
        <div class="w-full lg:w-1/5 px-6 mt-20 ml-n4 text-xl text-gray-800 leading-normal">
            <p class="text-base font-bold py-2 lg:pb-6 text-gray-700">目次</p>
            <div class="block lg:hidden sticky inset-0">
                <button id="menu-toggle" class="flex w-full justify-end px-3 py-3 bg-white lg:bg-transparent border rounded border-gray-600 hover:border-yellow-600 appearance-none focus:outline-none">
                    <svg class="fill-current h-3 float-right" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                    </svg>
                </button>
            </div>
            <div style="top: 6em" id="menu-content" class="w-full sticky inset-0 hidden max-h-64 lg:h-auto overflow-x-hidden overflow-y-auto lg:overflow-y-hidden lg:block mt-0 my-2 lg:my-0 border border-gray-400 lg:border-transparent bg-white shadow lg:shadow-none lg:bg-transparent z-20" style="top:6em;" id="menu-content">
                <ul class="list-reset py-2 md:py-0">
                    <li class="py-1 md:my-2 hover:bg-yellow-100 lg:hover:bg-transparent border-l-4 border-transparent font-bold border-yellow-600">
                        <a href='#section1' class="block pl-4 align-middle text-gray-700 no-underline hover:text-yellow-600">
                            <span class="pb-1 md:pb-0 text-sm">内定情報</span>
                        </a>
                    </li>
                    <li class="py-1 md:my-2 hover:bg-yellow-100 lg:hover:bg-transparent border-l-4 border-transparent">
                        <a href='#section2' class="block pl-4 align-middle text-gray-700 no-underline hover:text-yellow-600">
                            <span class="pb-1 md:pb-0 text-sm">試験情報</span>
                        </a>
                    </li>
                    <li class="py-1 md:my-2 hover:bg-yellow-100 lg:hover:bg-transparent border-l-4 border-transparent">
                        <a href='#section3' class="block pl-4 align-middle text-gray-700 no-underline hover:text-yellow-600">
                            <span class="pb-1 md:pb-0 text-sm">面接内容</span>
                        </a>
                    </li>
                    <li class="py-1 md:my-2 hover:bg-yellow-100 lg:hover:bg-transparent border-l-4 border-transparent">
                        <a href='#section4' class="block pl-4 align-middle text-gray-700 no-underline hover:text-yellow-600">
                            <span class="pb-1 md:pb-0 text-sm">その他</span>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
        <!-- 1e -->

        <!--Section container-->
        <section class="w-full lg:w-4/5">

            <!--Title-->
            <h1 class="flex justify-center items-center font-sans font-bold break-normal text-gray-700 px-2 text-xl mt-12 lg:mt-0 md:text-5xl">
                報告書
            </h1>

            <!--divider-->
            <hr class="bg-gray-300 my-12">


            <!--Form begin-->
            <form action="" id="form" method="POST" name="createForm">
                <!-- 2 -->
                <div class="bg-gray-100 flex items-center justify-center">
                    <!-- 内定情報 -->
                    <div class="container max-w-screen-lg mx-auto">
                        <div>
                            <h2 id='section1' class="font-semibold text-xl text-gray-600">内定情報</h2>
                            <p class="text-gray-500 mb-6"></p>

                            <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
                                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                                    <div class="text-gray-600">
                                        <p class="font-medium text-lg">内定情報</p>
                                        <p>すべてのフィールドに入力してください。</p>
                                    </div>

                                    <div class="lg:col-span-2">
                                        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                                            <div class="md:col-span-5">
                                                <label class="required">提出日</label>
                                                <input class="h-10 border mt-1 rounded px-2 w-full bg-gray-50" name="reporting_date" type="date" value=" <?php echo $student['reporting_date'] ?>" />
                                                <div class="error-validate">
                                                    <span><?php echo (isset($error['reporting_date'])) ? $error['reporting_date'] : '' ?></span>
                                                </div>
                                            </div>
                                            <!-- student code - fullname - sex -->
                                            <div class="md:col-span-2">
                                                <label class="required">学生番号</label>
                                                <div class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1">
                                                    <input class="px-2 appearance-none outline-none text-gray-800 w-full bg-transparent" name="student_code" type="text" value="<?php echo $student['student_code'] ?>" />
                                                    <div class="error-validate">
                                                        <span><?php echo (isset($error['student_code'])) ? $error['student_code'] : '' ?></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="md:col-span-2">
                                                <label class="required">名前</label>
                                                <div class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1">
                                                    <input class="px-2 appearance-none outline-none text-gray-800 w-full bg-transparent" name="student_name" type="text" id="student_name" value="<?php echo $student['student_name'] ?>">
                                                    <div class="error-validate">
                                                        <span><?php echo (isset($error['student_name'])) ? $error['student_name'] : '' ?></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="md:col-span-1">
                                                <label class="required">性別</label>
                                                <div class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1">
                                                    <select class="form-select" name="gender" id="gender">
                                                        <?php
                                                        $gender = $student["gender"];

                                                        ?>
                                                        <?php if ($gender === "男性") { ?>
                                                            <option value="男性">男性</option>
                                                            <option value="女性">女性</option>
                                                            <option value="指定しない">指定しない</option>
                                                        <?php } elseif ($gender === "女性") { ?>
                                                            <option value="女性">女性</option>
                                                            <option value="男性">男性</option>
                                                            <option value="指定しない">指定しない</option>
                                                        <?php } else { ?>
                                                            <option value="指定しない">指定しない</option>
                                                            <option value="男性">男性</option>
                                                            <option value="女性">女性</option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="md:col-span-5">
                                                <label class="required">会社名</label>
                                                <input class="h-10 border mt-1 rounded px-2 w-full bg-gray-50" type="text" name="company_name" id="company_name" placeholder="例）ソニー株式会社" />
                                                <div class="error-validate">
                                                    <span><?php echo (isset($error['company_name'])) ? $error['company_name'] : '' ?></span>
                                                </div>
                                            </div>

                                            <div class="md:col-span-2">
                                                <label class="required">郵便番号</label>
                                                <input type="text" class="h-10 border mt-1 rounded px-2 w-full bg-gray-50" name="company_postcode" placeholder="例）131-0000" />
                                                <div class="error-validate">
                                                    <span><?php echo (isset($error['company_postcode'])) ? $error['company_postcode'] : '' ?></span>
                                                </div>
                                            </div>

                                            <div class="md:col-span-3">
                                                <label class="required">会社住所</label>
                                                <input type="text" class="h-10 border mt-1 rounded px-2 w-full bg-gray-50" name="company_address" placeholder="例）〇〇県庁・〇〇区・丁目" />
                                                <div class="error-validate">
                                                    <span><?php echo (isset($error['company_address'])) ? $error['company_address'] : '' ?></span>
                                                </div>
                                            </div>

                                            <div class="md:col-span-5">
                                                <label class="required">会社電話番号</label>
                                                <input type="text" class="h-10 border mt-1 rounded px-2 w-full bg-gray-50" name="company_tel" placeholder="例）03-1111-2222" />
                                                <div class="error-validate">
                                                    <span><?php echo (isset($error['company_tel'])) ? $error['company_tel'] : '' ?></span>
                                                </div>
                                            </div>

                                            <div class="md:col-span-3">
                                                <label class="required">会社評価</label>
                                                <input type="number" value="0.0" step="0.1" min="0" max="5" class="h-10 border mt-1 rounded px-2 w-full bg-gray-50" name="rating" id="rating" placeholder="Enter a rating (0-5)" title="Click here to enter a rating between 0 and 5" onfocus="showExplanation('ratingExplanation')" onblur="hideExplanation('ratingExplanation')" />
                                                <div class="error-validate">
                                                    <span><?php echo (isset($error['rating'])) ? $error['rating'] : '' ?></span>
                                                    <p class="small-text">
                                                        会社評価は<a href="https://jp.indeed.com/companies" target="_blank" style="color: red; text-decoration: underline;">インディード</a>
                                                    </p>
                                                </div>
                                                <div id="ratingExplanation" class="explanation">5点満点、インディード企業クチコミで検索してね！</div>
                                            </div>

                                            <div class="md:col-span-2">
                                                <label class="required">会社タッグ情報</label>
                                                <input type="text" pattern="\d{4}" title="Please type a 4-digit number" class="h-10 border mt-1 rounded px-2 w-full bg-gray-50" name="tag" placeholder="Enter a 4-digit tag (e.g., 1432)" title="Click here to enter a 4-digit tag" onfocus="showExplanation('tagExplanation')" onblur="hideExplanation('tagExplanation')" />
                                                <div class="error-validate">
                                                    <span><?php echo (isset($error['tag'])) ? $error['tag'] : '' ?></span>
                                                    <p class="small-text">
                                                        タッグ検索は<a href="https://shikiho.toyokeizai.net/" target="_blank" style="color: red; text-decoration: underline;">会社四季報ONLINE</a>
                                                    </p>
                                                </div>
                                                <div id="tagExplanation" class="explanation">会社四季報ONLINEで会社名を検索し、４桁の数字を入力してね！、タッグがない場合は、0000と入力してください。</div>
                                            </div>

                                            <script>
                                                function showExplanation(elementId) {
                                                    var explanation = document.getElementById(elementId);
                                                    explanation.style.display = "block";
                                                }

                                                function hideExplanation(elementId) {
                                                    var explanation = document.getElementById(elementId);
                                                    explanation.style.display = "none";
                                                }

                                                // Hide explanations initially
                                                document.addEventListener("DOMContentLoaded", function() {
                                                    hideExplanation("ratingExplanation");
                                                    hideExplanation("tagExplanation");
                                                });
                                            </script>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- 2e -->
                <!--divider-->
                <hr class="bg-gray-300 my-12">

                <!--内定情報の終わり-->


                <!--試験情報-->
                <!-- 3 -->
                <div class="bg-gray-100 flex items-center justify-center">
                    <div class="container max-w-screen-lg mx-auto">
                        <div>
                            <h2 id='section2' class="font-semibold text-xl text-gray-600">試験情報</h2>
                            <p class="text-gray-500 mb-6"></p>


                            <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
                                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                                    <div class="text-gray-600">
                                        <p class="font-medium text-lg">試験情報</p>
                                        <p>すべてのフィールドに入力してください。</p>
                                    </div>

                                    <div class="lg:col-span-2">
                                        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
                                            <div class="md:col-span-2">
                                                <label class="required">応募方法</label>
                                                <div class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1">
                                                    <select class="form-select" name="apply_process">
                                                        <option value="学科紹介">学科紹介</option>
                                                        <option value="就職課紹介">就職課紹介</option>
                                                        <option value="自由応募">自由応募</option>
                                                        <option value="縁故">縁故</option>
                                                        <option value="その他">その他</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="md:col-span-2">
                                                <label class="required">業種</label>
                                                <div class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1">
                                                    <select class="form-select" name="industry_type">
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
                                            </div>

                                            <div class="md:col-span-2">
                                                <label class="required">職種</label>
                                                <div class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1">
                                                    <select class="form-select" name="job_name">
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

                                            <div class="md:col-span-6">
                                                <label class="required">試験の結果</label>
                                                <div class="md:w-2/3">
                                                    <div class="mt-2">
                                                        <label class="inline-flex items-center col-span-2" for="内定">
                                                            <input type="radio" class="form-radio text-indigo-600" id="naitei" name="shiken_kekka" value="内定">
                                                            <span class="ml-2">内定</span>
                                                        </label>
                                                        <label class="inline-flex items-center ml-6 col-span-2" for="不採用">
                                                            <input type="radio" class="form-radio" id="truot" name="shiken_kekka" value="不採用">
                                                            <span class="ml-2">不採用</span>
                                                        </label>
                                                        <label class="inline-flex items-center ml-6 col-span-2" for="結果待ち">
                                                            <input type="radio" class="form-radio" id="doi_ket_qua" name="shiken_kekka" value="結果待ち">
                                                            <span class="ml-2">結果待ち</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="error-validate">
                                                    <span><?php echo (isset($error['shiken_kekka'])) ? $error['shiken_kekka'] : '' ?></span>
                                                </div>
                                            </div>

                                            <div class="md:col-span-6">
                                                <label class="required">内定後の流れ</label>
                                                <div class="md:w-2/3">
                                                    <div class="mt-2">
                                                        <label class="inline-flex items-center col-span-2" for="1">
                                                            <input type="radio" class="form-radio text-indigo-600" id="di_lam" name="naitei_flag" value="1">
                                                            <span class="ml-2">入社する</span>
                                                        </label>
                                                        <label class="inline-flex items-center ml-6 col-span-2" for="0">
                                                            <input type="radio" class="form-radio" id="khong_di_lam" name="naitei_flag" value="0">
                                                            <span class="ml-2">入社しない</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="error-validate">
                                                    <span><?php echo (isset($error['naitei_flag'])) ? $error['naitei_flag'] : '' ?></span>
                                                </div>
                                            </div>

                                            <div class="md:col-span-6">
                                                <label for="email" class="required">内定日</label>
                                                <input name="naitei_date" type="date" class="h-10 border mt-1 rounded px-2 w-full bg-gray-50" />
                                            </div>

                                            <div class="md:col-span-6">
                                                <label class="required">内定方法</label>
                                                <div class="md:w-2/3">
                                                    <div class="mt-2">
                                                        <label class="inline-flex items-center col-span-2" for="文書">
                                                            <input type="radio" class="form-radio" id="thu_moi" name="naitei_method" value="文書">
                                                            <span class="ml-2">メール</span>
                                                        </label>
                                                        <label class="inline-flex items-center ml-6 col-span-2" for="文書">
                                                            <input type="radio" class="form-radio" id="truyen_mieng" name="naitei_method" value="口答">
                                                            <span class="ml-2">口答</span>
                                                        </label>
                                                        <label class="inline-flex items-center ml-6 col-span-2" for="電話連絡">
                                                            <input type="radio" class="form-radio" id="dien_thoai" name="naitei_method" value="電話連絡">
                                                            <span class="ml-2">電話連絡</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="error-validate">
                                                    <span><?php echo (isset($error['naitei_method'])) ? $error['naitei_method'] : '' ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- 3e -->
                <!--試験情報の終わり-->

                <!--divider-->
                <hr class="bg-gray-300 my-12">


                <!--面接内容-->
                <div class="bg-gray-100 flex items-center justify-center">
                    <div class="container max-w-screen-lg mx-auto">
                        <div>
                            <h2 id='section3' class="font-semibold text-xl text-gray-600">面接内容</h2>
                            <p class="text-gray-500 mb-6"></p>

                            <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
                                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                                    <div class="text-gray-600">
                                        <p class="font-medium text-lg">面接内容</p>
                                        <p>すべてのフィールドに入力してください。.</p>
                                    </div>

                                    <div class="lg:col-span-2">
                                        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                                            <div class="md:col-span-2">
                                                <label class="required">試験日</label>
                                                <input type="date" name="shiken_date" class="h-10 border mt-1 rounded px-2 w-full bg-gray-50" />
                                                <div class="error-validate">
                                                    <span><?php echo (isset($error['shiken_date'])) ? $error['shiken_date'] : '' ?></span>
                                                </div>
                                            </div>

                                            <div class="md:col-span-3">
                                                <label class="required">試験内容</label>

                                                <select class="form-select" name="shiken_naiyou" id="shiken_naiyou">
                                                    <option value="一般常識">一般常識</option>
                                                    <option value="論文試験">論文試験</option>
                                                    <option value="専門試験">専門試験</option>
                                                    <option value="語学試験">語学試験</option>
                                                    <option value="適正試験">適正試験</option>
                                                </select>
                                                <div class="error-validate">
                                                    <span><?php echo (isset($error['shiken_naiyou'])) ? $error['shiken_naiyou'] : '' ?></span>
                                                </div>
                                            </div>

                                            <div class="md:col-span-5">
                                                <label class="required">面接質問事項</label>

                                                <textarea name="interview_items" rows="3" class="form-control block p-2.5 w-full text-sm text-gray-900 bg-white bg-clip-padding rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-slate-500 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="例）研究室の内容をよく聞かれたので、念入りに準備しといたほうがいいなど。。。"></textarea>
                                                <div class="error-validate">
                                                    <span><?php echo (isset($error['interview_items'])) ? $error['interview_items'] : '' ?></span>
                                                </div>
                                            </div>

                                            <div class="md:col-span-5">
                                                <label class="required">面接回数</label>
                                                <div class="md:w-2/3">
                                                    <div class="mt-2">
                                                        <label class="inline-flex items-center col-span-2" for="1">
                                                            <input type="radio" class="form-radio text-indigo-600" name="interview_times" value="1">
                                                            <span class="ml-2">1</span>
                                                        </label>
                                                        <label class="inline-flex items-center ml-6 col-span-2" for="2">
                                                            <input type="radio" class="form-radio" name="interview_times" value="2">
                                                            <span class="ml-2">2</span>
                                                        </label>
                                                        <label class="inline-flex items-center ml-6 col-span-2" for="3">
                                                            <input type="radio" class="form-radio" name="interview_times" value="3">
                                                            <span class="ml-2">3</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="error-validate">
                                                    <span><?php echo (isset($error['interview_times'])) ? $error['interview_times'] : '' ?></span>
                                                </div>
                                            </div>

                                            <div class="md:col-span-5">
                                                <label class="required">一次面接日</label>
                                                <input name="first_interview_date" type="date" class="h-10 border mt-1 rounded px-2 w-full bg-gray-50" />
                                                <div class="error-validate">
                                                    <span><?php echo (isset($error['first_interview_date'])) ? $error['first_interview_date'] : '' ?></span>
                                                </div>
                                            </div>

                                            <div class="md:col-span-5">
                                                <label class="required">二次面接日</label>
                                                <input name="second_interview_date" type="date" class="h-10 border mt-1 rounded px-2 w-full bg-gray-50" />
                                                <div class="error-validate">
                                                    <span><?php echo (isset($error['second_interview_date'])) ? $error['second_interview_date'] : '' ?></span>
                                                </div>
                                            </div>

                                            <div class="md:col-span-5">
                                                <label>三次面接日</label>
                                                <input name="third_interview_date" type="date" class="h-10 border mt-1 rounded px-2 w-full bg-gray-50" />
                                                <div class="error-validate">
                                                    <span><?php echo (isset($error['third_interview_date'])) ? $error['third_interview_date'] : '' ?></span>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--面接内容の終わり-->

                <!--divider-->
                <hr class="bg-gray-300 my-12">
                <div class="bg-gray-100 flex items-center justify-center">
                    <!-- アドバイス -->
                    <div class="container max-w-screen-lg mx-auto">
                        <!--Title-->
                        <h2 id='section4' class="font-sans font-bold break-normal text-gray-700 px-2 pb-8 text-xl">その他</h2>


                        <!--Card-->

                        <!-- <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6"> -->
                        <div class="p-4 mt-6 mb-12 lg:mt-0 rounded shadow bg-white">



                            <div class="md:flex mb-6">
                                <div class="md:w-1/4">
                                    <label class="block text-gray-600 font-bold md:text-left mb-3 md:mb-0 pr-4 required">
                                        後輩へのアドバイス
                                    </label>
                                </div>
                                <div class="md:w-3/4">
                                    <textarea name="advice_content" rows="4" class="form-control block p-2.5 w-full text-sm text-gray-900 bg-white bg-clip-padding rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-slate-500 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="例）研究室の内容をよく聞かれたので、念入りに準備しといたほうがいいなど。。。"></textarea>

                                    <div class="error-validate">
                                        <span><?php echo (isset($error['advice_content'])) ? $error['advice_content'] : '' ?></span>
                                    </div>
                                </div>
                            </div>


                            <div class="md:flex my-8">
                                <div class="md:w-1/4">
                                    <label class="block text-gray-600 font-bold md:text-left mb-1px md:mb-0 pr-4" for="agree">
                                        注意事項
                                    </label>
                                </div>
                                <div class="md:w-3/4">
                                    <input type="checkbox" name="agree" class="form-checkbox text-pink-600" required>
                                    <span class="ml-2">第一工科大学に関するプライバシーポリシーは<a style="color:red;" href="View/web/page/privacy.html" target="window_name" onClick="disp('View/web/page/privacy.html')">こちら</a>を確認の上、ご送信ください。</span>
                                </div>
                            </div>
                            <br>



                            <div class="flex justify-center">

                                <?php
                                if (!empty($error)) {  ?>
                                    <li onclick="createForms()" type="submit" class="shadow bg-yellow-700 hover:bg-yellow-500 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" style="list-style:none; cursor:pointer">
                                        作成
                                    </li>
                                <?php } else { ?>
                                    <button type="submit" class="shadow bg-yellow-700 hover:bg-yellow-500 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">
                                        作成
                                    </button>
                                <?php } ?>


                            </div>



                        </div>
                    </div>
                </div>
                <!--その他の終わり-->
            </form>
            <!-- form end -->
    </div>
</div>









<script>
    function disp(url) {

        window.open(url, "window_name", "width=720,height=400,scrollbars=yes");

    }
</script>

<!-- Toggle dropdown list -->
<script>
    /*https://gist.github.com/slavapas/593e8e50cf4cc16ac972afcbad4f70c8*/

    var userMenuDiv = document.getElementById('userMenu')
    var userMenu = document.getElementById('userButton')

    var helpMenuDiv = document.getElementById('menu-content')
    var helpMenu = document.getElementById('menu-toggle')

    document.onclick = check

    function check(e) {
        var target = (e && e.target) || (event && event.srcElement)

        //User Menu
        if (!checkParent(target, userMenuDiv)) {
            // click NOT on the menu
            if (checkParent(target, userMenu)) {
                // click on the link
                if (userMenuDiv.classList.contains('invisible')) {
                    userMenuDiv.classList.remove('invisible')
                } else {
                    userMenuDiv.classList.add('invisible')
                }
            } else {
                // click both outside link and outside menu, hide menu
                userMenuDiv.classList.add('invisible')
            }
        }

        //Help Menu
        if (!checkParent(target, helpMenuDiv)) {
            // click NOT on the menu
            if (checkParent(target, helpMenu)) {
                // click on the link
                if (helpMenuDiv.classList.contains('hidden')) {
                    helpMenuDiv.classList.remove('hidden')
                } else {
                    helpMenuDiv.classList.add('hidden')
                }
            } else {
                // click both outside link and outside menu, hide menu
                helpMenuDiv.classList.add('hidden')
            }
        }
    }

    function checkParent(t, elm) {
        while (t.parentNode) {
            if (t == elm) {
                return true
            }
            t = t.parentNode
        }
        return false
    }
</script>

<!-- jQuery -->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

<!-- Scroll Spy -->
<script>
    /* http://jsfiddle.net/LwLBx/ */

    // Cache selectors
    var lastId,
        topMenu = $('#menu-content'),
        topMenuHeight = topMenu.outerHeight() + 175,
        // All list items
        menuItems = topMenu.find('a'),
        // Anchors corresponding to menu items
        scrollItems = menuItems.map(function() {
            var item = $($(this).attr('href'))
            if (item.length) {
                return item
            }
        })

    // Bind click handler to menu items
    // so we can get a fancy scroll animation
    menuItems.click(function(e) {
        var href = $(this).attr('href'),
            offsetTop =
            href === '#' ?
            0 :
            $(href).offset().top - topMenuHeight + 1
        $('html, body').stop().animate({
                scrollTop: offsetTop,
            },
            300
        )
        if (!helpMenuDiv.classList.contains('hidden')) {
            helpMenuDiv.classList.add('hidden')
        }
        e.preventDefault()
    })

    // Bind to scroll
    $(window).scroll(function() {
        // Get container scroll position
        var fromTop = $(this).scrollTop() + topMenuHeight

        // Get id of current scroll item
        var cur = scrollItems.map(function() {
            if ($(this).offset().top < fromTop) return this
        })
        // Get the id of the current element
        cur = cur[cur.length - 1]
        var id = cur && cur.length ? cur[0].id : ''

        if (lastId !== id) {
            lastId = id
            // Set/remove active class
            menuItems
                .parent()
                .removeClass('font-bold border-yellow-600')
                .end()
                .filter("[href='#" + id + "']")
                .parent()
                .addClass('font-bold border-yellow-600')
        }
    })
</script>