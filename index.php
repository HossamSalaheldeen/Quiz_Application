<?php
require_once "autoload.php";

if (!(isset($_POST["prev"])) && (!isset($_POST["next"]))){
    $_SESSION["currentpage"] = 1;
    $_SESSION["trueanswers"] = 0;
}   

if(isset($_POST["next"])) {

    $_SESSION["currentpage"]++;

}

if(isset($_POST["prev"])) {

    $_SESSION["currentpage"]--;
    

} 

    $answer = isset($_POST["choose"]) ? $_POST["choose"] : "";

    try {
        
        $exam = new Exam();
        
        $current_page = $exam->getPage();
        
        if($current_page >= 2) {
            
            if (trim($exam->get_Qustion_answer($current_page)) == trim($answer))
            {
                $_SESSION["trueanswers"]++;
            }
        }
        
        
        if ($current_page == ($exam->getQuestion_number()+1)) {
            include_once("views/End.php");
            exit();
        } else {
                $current_question = $exam->load_exam_page($current_page);
               
        }
        
    } catch (Exception $ex) {
        if (mode === "production") {
            include("views/error.php");
            exit();
        } else {
            echo $ex->getMessage();
            echo $ex->getTraceAsString();
            exit();
        }
    }

?>

<html>
    <?php include "views/header.php"; ?>
    <body>
        <?php include "views/questions.php"; ?>
    </body>
</html>