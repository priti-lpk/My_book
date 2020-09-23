<?php

include_once 'config/DBAdapter.php';
include 'config.php';
$dba = new DBAdapter();
//Authorization
$token = '';
$Authorization = Authorization;
$request_auth = getallheaders();
if (!empty($request_auth['Authorization'])) {
    $request_auth = $request_auth['Authorization'];
    echo $request_auth;
    if (!isset($_POST['name'])) {
        $response['status'] = false;
        $response['message'] = "Unknown requested name..";
        echo json_encode($response);
        die();
    }
    $tmp = Auth($_POST['name']);
//    echo $tmp;
    if (!$tmp) {
        $response['status'] = false;
        $response['message'] = "Unauthorised request";
        echo json_encode($response);
        die();
    }
    if ($_POST['name'] == 'category') {

        $data = $dba->getRowAssoc("category_master", array("*"), "1");
        $category = array();
        if (!empty($data)) {
            foreach ($data as $subData) {
                $category[] = $subData;
            }
        }
        if (!empty($category)) {
            echo json_encode(array("status" => TRUE, "data" => $category, "msg" => "data get successfully"));
        } else {
            echo json_encode(array("status" => FALSE, "data" => $category, "msg" => "No Data available"));
        }
        die();
    } elseif ($_POST['name'] == 'book') {
        if (isset($_POST['category_id'])) {

            $data = $dba->getRowAssoc("add_book", array("*"), "category_id=" . $_POST['category_id']);
            $book = array();
            if (!empty($data)) {
                foreach ($data as $subData) {
                    $book[] = $subData;
                }
            }
            if (!empty($book)) {
                echo json_encode(array("status" => TRUE, "data" => $book, "url"=>"http://book.lpktechnosoft.com/Book_pdf","msg" => "data get successfully"));
            } else {
                echo json_encode(array("status" => FALSE, "data" => $book, "msg" => "No Data available"));
            }
        }
        die();
    } elseif ($_POST['name'] == 'all_book') {

        $data = $dba->getRowAssoc("add_book", array("*"), "1");
        $book = array();
        if (!empty($data)) {
            foreach ($data as $subData) {
                $book[] = $subData;
            }
        }
        if (!empty($book)) {
            echo json_encode(array("status" => TRUE, "data" => $book,"url"=>"http://book.lpktechnosoft.com/Book_pdf", "msg" => "data get successfully"));
        } else {
            echo json_encode(array("status" => FALSE, "data" => $book, "msg" => "No Data available"));
        }
        die();
    } elseif ($_POST['name'] == 'language') {

        $data = $dba->getRowAssoc("setting", array("*"), "1");
        $lag = array();
        if (!empty($data)) {
            foreach ($data as $subData) {
                $lag[] = $subData;
            }
        }
        if (!empty($lag)) {
            echo json_encode(array("status" => TRUE, "data" => $lag, "msg" => "data get successfully"));
        } else {
            echo json_encode(array("status" => FALSE, "data" => $lag, "msg" => "No Data available"));
        }
        die();
    }
    // Firebase Tokrn List
    if ($_POST['name'] == 'firebase_token_list') {
        unset($_POST['name']);
        $data = $dba->getRow("firebase_token_list", array("device_id"), "device_id='" . $_POST['device_id'] . "'");

        if (empty($data)) {
            if ($dba->setData("firebase_token_list", $_POST)) {

                echo json_encode(array("status" => TRUE, "data" => "Data Insert Successfully"));
            } else {

                echo json_encode(array("status" => FALSE, "msg" => "error"));
            }
        } else {

            if ($dba->updateRow("firebase_token_list", $_POST, "device_id='" . $_POST['device_id'] . "'")) {
                echo json_encode(array("status" => TRUE, "msg" => "Data Update Successfully"));
            } else {
                echo json_encode(array("status" => FALSE, "msg" => "error"));
            }
        }
        die();
    }
} else {
    $response['status'] = false;
    $response['message'] = "Unknown request";
    echo json_encode($response);
    die();
}

function Auth($apiname) {
    $request_auth = getallheaders();
    $request_auth = $request_auth['Authorization'];
    $Id = '260898';
    if ($request_auth == $Id) {
        return TRUE;
    } else {
        return FALSE;
    }
}
?>

