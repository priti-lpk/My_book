<?php

//e63afc8cacaedb84d5ca5b3669d4522980e8c8de16bd38f935aca9e6d62edb64
require_once './SendNotification.php';
require_once './config/session_info.php';
require_once './config/DBAdapter.php';
require_once './config.php';
$dba = new DBAdapter();
require_once './config/Controls.php';
$cont = new Controls();
if (isset($_POST['action'])) {
    if ($_POST['action'] == 'add') {
        unset($_POST['action']);
        unset($_POST['option']);
        if ($_FILES["language1_pdf"]["name"]) {
            $uploads_dir = './Book_pdf';
            $tmp_name = $_FILES["language1_pdf"]["tmp_name"];
            $name = $_FILES["language1_pdf"]["name"];
            $lastID = $dba->getLastID("id", "post_list", "1");
            $ID = $lastID + 1;
            move_uploaded_file($tmp_name, "$uploads_dir/$ID$name");
            $_POST['language1_pdf'] = $ID . $_FILES["language1_pdf"]["name"];
        }
        if ($_FILES["language2_pdf"]["name"]) {
            $uploads_dir = './Book_pdf';
            $tmp_name = $_FILES["language2_pdf"]["tmp_name"];
            $name = $_FILES["language2_pdf"]["name"];
            $lastID = $dba->getLastID("id", "post_list", "1");
            $ID = $lastID + 1;
            move_uploaded_file($tmp_name, "$uploads_dir/$ID$name");
            $_POST['language2_pdf'] = $ID . $_FILES["language2_pdf"]["name"];
        }
        if ($dba->setData("add_book", $_POST)) {
            $notification_status = $dba->getRowAssoc("notification", array("status"), "1");
            $status = $notification_status[0]['status'];
            if ($status == 'true') {
                $data = $dba->getRow("firebase_token_list", array("device_token"), "1");
                if (!empty($data)) {
                    $serverObject = new SendNotification();

                    $notification = [
                        'title' => 'My Book',
                        'body' => 'New Book Add',
                    ];
                    $data = array_column($data, 0);
                    $jsonString = $serverObject->sendPushNotificationToGCMSever($data, json_encode($notification), "New Book", $_POST['language1_title']);

                    $jsonObject = json_decode($jsonString);
                    $jsonObject = json_decode(json_encode($jsonObject), TRUE);
                    $fcmResult = array("fcm_multicast_id" => $jsonObject['multicast_id'],
                        "fcm_success" => $jsonObject['success'],
                        "fcm_failure" => $jsonObject['failure'],
                        "fcm_error" => json_encode(array_column($jsonObject['results'], 'error')),
                        "fcm_type" => "My Book",
                    );
                    $msg = '<script>swal("Success!","Apps Notification Results Success: ' . $jsonObject['success'] . ' Failure: ' . $jsonObject['failure'] . '", "success")</script>';

                    $dba->setData("firebase_result", $fcmResult);
                }
            } else {
                
            }
            $msg = "Book created successfully!";
            header('location:add_book.php');
        } else {
            $msg = "Category create fail! " . mysqli_error($con);
        }
    } else if ($_POST['action'] == 'edit') {
        $id = $_POST['id'];
//        echo $id;
        if ($_POST['action'] == 'edit' && $_FILES['language1_pdf']['name'] == '' && $_FILES["language2_pdf"]["name"] == '') {
            unset($_POST['action']);
            unset($_POST['option']);
            unset($_POST['id']);
            echo $_FILES["language1_pdf"]["name"];
            if ($_FILES["language1_pdf"]["name"]) {
                $uploads_dir = './Book_pdf';
                $tmp_name = $_FILES["language1_pdf"]["tmp_name"];
                $name = $_FILES["language1_pdf"]["name"];
                move_uploaded_file($tmp_name, "$uploads_dir/$id$name");
                $_POST['language1_pdf'] = $id . $_FILES["language1_pdf"]["name"];
            }
            if ($_FILES["language2_pdf"]["name"]) {
                $uploads_dir = './Book_pdf';
                $tmp_name = $_FILES["language2_pdf"]["tmp_name"];
                $name = $_FILES["language2_pdf"]["name"];
                move_uploaded_file($tmp_name, "$uploads_dir/$id$name");
                $_POST['language2_pdf'] = $id . $_FILES["language2_pdf"]["name"];
            }
            if ($dba->updateRow("add_book", $_POST, "id=" . $id)) {
                $msg = "updated successfully!";
//                header('location:add_book.php');
            } else {
                $msg = "update fail!";
            }
        } else {
            if ($dba->updateRow("add_book", $_POST, "id=" . $id)) {
                $msg = "updated successfully!";
                header('location:add_book.php');
            } else {
                $msg = "update fail!";
            }
        }
    }
}
?>
<?php

if (!function_exists("array_column")) {

    function array_column(array $input, $columnKey, $indexKey = null) {
        $array = array();
        foreach ($input as $value) {
            if (!isset($value[$columnKey])) {
                trigger_error("Key \"$columnKey\" does not exist in array");
                return false;
            }
            if (is_null($indexKey)) {
                $array[] = $value[$columnKey];
            } else {
                if (!isset($value[$indexKey])) {
                    trigger_error("Key \"$indexKey\" does not exist in array");
                    return false;
                }
                if (!is_scalar($value[$indexKey])) {
                    trigger_error("Key \"$indexKey\" does not contain scalar value");
                    return false;
                }
                $array[$value[$indexKey]] = $value[$columnKey];
            }
        }
        return $array;
    }

}
?>