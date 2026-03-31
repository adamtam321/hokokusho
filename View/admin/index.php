<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>管理者</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../public/assets/admin/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
          href="../../public/assets/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../../public/assets/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="../../public/assets/admin/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../public/assets/admin/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="../../public/assets/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="../../public/assets/admin/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="../../public/assets/admin/plugins/summernote/summernote-bs4.min.css">
    <!-- style css -->
    <link rel="stylesheet" href="../../public/assets/admin/css/home_admin.css">
    <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />

</head>
<body class="hold-transition sidebar-mini layout-fixed">

<?php
if (!isset($_SESSION)) {
    session_start();
} 

if(isset($_SESSION['user-admin'])){
    $user_admin = (isset($_SESSION['user-admin'])) ? $_SESSION['user-admin'] : [];
} else {
    header("Location: View/admin/login.php"); /* Redirect browser */
}
?>

    <div id="navbar">
        <?php include("component/navbar.php") ?>
    </div>
<div class="wrapper">
    <?php
    if (isset($_GET["view"])) {
        $view = $_GET["view"];
        include("page/" . $view . ".php");
    } else {
        include("page/home.php");
    }
    
    ?>


</div>

<div id="navbar">

    <?php include("component/footer.php") ?>
</div>

<?php  ?>
<script>
        $(document).ready(function () {
            // Đảm bảo thanh navbar đóng khi tải trang lần đầu tiên
            $('#navbarResponsive').removeClass('show');
            
            // Đảm bảo thanh navbar không tự động mở lại sau lần đầu tiên ấn vào
            $('.navbar-toggler').on('click', function () {
                if ($('#navbarResponsive').hasClass('show')) {
                    $('#navbarResponsive').collapse('hide');
                }
            });
        });
    </script>

<!-- jQuery -->
<script src="../../public/assets/admin/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../../public/assets/admin/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="../../public/assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="../../public/assets/admin/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="../../public/assets/admin/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="../../public/assets/admin/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="../../public/assets/admin/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="../../public/assets/admin/plugins/moment/moment.min.js"></script>
<script src="../../public/assets/admin/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../../public/assets/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="../../public/assets/admin/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="../../public/assets/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="../../public/assets/admin/dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../public/assets/admin/dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../../public/assets/admin/dist/js/pages/dashboard.js"></script>

<script>
    //quan trong la phan nay anh nhe day la cach goi jquery, ajax
    $(document).ready(function (){
        $("#search").keypress(function (){
           $.ajax({
               type: 'POST',
               url: 'page/search-share-ex.php',
               data:{
                   name:$("#search").val(),
               },
               success:function (data){
                   $("#output").html(data);
               }
           })

        })
    })
</script>

</body>
</html>
