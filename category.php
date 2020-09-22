<?php

require_once './config/session_info.php';
require_once './config/DBAdapter.php';
include_once 'config.php';
$dba = new DBAdapter();
if (isset($_POST['action'])) {
    if ($_POST['action'] == 'add') {
        unset($_POST['action']);
        if ($dba->setData("category_master", $_POST)) {
            $msg = "Category created successfully!";
            header('location:add_category.php');
        } else {
            $msg = "Category create fail! " . mysqli_error($con);
        }
    } else if ($_POST['action'] == 'edit') {
        $id = $_POST['id'];
        unset($_POST['action']);
        unset($_POST['id']);
        if ($dba->updateRow("category_master", $_POST, "id=" . $id)) {
            $msg = "updated successfully!";
            header('location:add_category.php');
        } else {
            $msg = "update fail!";
        }
    }
}
?>