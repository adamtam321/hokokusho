<?php 
class HomeController {
    public function index(){
        $s = "select * from student";
        var_dump($s);    
    
        include_once "../../view/web/page/home.php";
    }
}
?>