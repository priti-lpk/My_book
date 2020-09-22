<?php

include_once './config/DBAdapter.php';
$dba = new DBAdapter();
if (isset($_GET['cid'])) {
    $delete = $dba->delRow("category_master", $_GET['cid']);
    if ($delete) {
        echo "<script>alert('successfully Detail deleted!');top.location='add_category.php';</script>";
    } else
        echo "<script>alert('Oops, Could not delete the Image\nTry Again!');</script>";
}
else if (isset($_GET['bid'])) {
    $delete = $dba->delRow("add_book", $_GET['bid']);
    if ($delete) {
        echo "<script>alert('successfully Book Detail deleted!');top.location='view_book.php';</script>";
    } else
        echo "<script>alert('Oops, Could not delete the Image\nTry Again!');</script>";
}

?>