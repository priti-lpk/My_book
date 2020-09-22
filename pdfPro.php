<?php

//e63afc8cacaedb84d5ca5b3669d4522980e8c8de16bd38f935aca9e6d62edb64
//require_once './SendNotification.php';
require_once './config/session_info.php';
require_once './config/DBAdapter.php';
require_once './config.php';   
include('class.pdf2text.php');
$dba = new DBAdapter();

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'add') {
        unset($_POST['action']);
        $var = new PDF2Text();
        $var->setFilename($_FILES['note']['name']);
        $var->decodePDF();
        $_POST['note'] = $var->output();
        $var = $_FILES['note']['tmp_name'];
        if ($dba->setData("pdf", $_POST)) {
            $msg = "PDF created successfully!";
//            header('location:pdf.php');
        } else {
            $msg = "Category create fail! " . mysqli_error($con);
        }
    }
}
?>
