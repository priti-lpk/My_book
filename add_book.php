<!DOCTYPE html>
<?php
require_once './config/session_info.php';
require_once './config/DBAdapter.php';
include_once 'config.php';
$dba = new DBAdapter();
//get data for edit
if (isset($_GET['id'])) {
    $data = $dba->getRowAssoc("add_book", array("*"), "id=" . $_GET['id']);
//    echo $data[0]['category_id'];
}
?>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Add Book</title>

        <!-- Custom fonts for this template-->
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

        <!-- Page level plugin CSS-->
        <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

        <!-- Custom styles for this template-->
        <link href="css/sb-admin.css" rel="stylesheet">

    </head>

    <body id="page-top">

        <?php require_once './topbar.php'; ?>

        <div id="wrapper">

            <!-- Sidebar -->
            <?php require_once './sidebar.php'; ?>

            <div id="content-wrapper">

                <div class="container-fluid">

                    <!-- Breadcrumbs-->
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="">Add Book</a>
                        </li>

                    </ol>

                    <!-- Icon Cards-->
                    <div class="row">
                        <div class="col-xl-10">
                            <form action="add_bookPro.php" method="post" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Select Category</label>
                                    <div class="col-sm-10">
                                        <select type="text" class="form-control select2 chosen" id = "cat" name = "category_id" required=""/>
                                        <option>Select Category</option>       
                                        <?php
                                        $dba = new DBAdapter();
                                        $data1 = $dba->getRow("category_master", array("id", "language1", "language2"), "1");
                                        foreach ($data1 as $subData) {
                                            echo "<option " . ($subData[0] == $data[0]['category_id'] ? 'selected' : '') . " value=" . $subData[0] . ">" . $subData[1] . " / " . $subData[2] . "</option>";
                                        }
                                        ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <?php
                                    $dba = new DBAdapter();
                                    $data1 = $dba->getRow("setting", array("id", "language1"), "1");
                                    foreach ($data1 as $subData) {
                                        echo'<label for="example-text-input" class="col-sm-2 col-form-label">' . $subData[1] . ' Title</label>';
                                    }
                                    ?>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control select2" id = "language1_title" name = "language1_title" value="<?= (isset($_GET['id'])) ? $data[0]['language1_title'] : '' ?>" required=""/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <?php
                                    $dba = new DBAdapter();
                                    $data1 = $dba->getRow("setting", array("id", "language2"), "1");
                                    foreach ($data1 as $subData) {
                                        echo'<label for="example-text-input" class="col-sm-2 col-form-label">' . $subData[1] . ' Title</label>';
                                    }
                                    ?>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control select2" id = "language2_title" name = "language2_title" value="<?= (isset($_GET['id'])) ? $data[0]['language2_title'] : '' ?>" required=""/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Select Option</label>
                                    <div class="col-sm-10">
                                        <input type="radio" id="details" name="option" value="male">
                                        <label for="male">Details</label>&nbsp;&nbsp;
                                        <input type="radio" id="pdf" name="option" value="female">
                                        <label for="female">PDF</label><br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <?php
                                    $dba = new DBAdapter();
                                    $data1 = $dba->getRow("setting", array("id", "language1"), "1");
                                    foreach ($data1 as $subData) {
                                        echo'<label for="example-text-input" class="col-sm-2 col-form-label">' . $subData[1] . ' Details</label>';
                                    }
                                    ?>                                    
                                    <div class="col-sm-10">
                                        <?php
                                        if (isset($_GET['id'])) {
                                            if ($data[0]['language1_details'] == '') {
                                                ?>
                                                <textarea class="form-control" name="language1_details" id="language1_details" disabled=""></textarea>
                                                <?php
                                            } else {
                                                ?>
                                                <textarea class="form-control" name="language1_details" id="language1_details"><?= (isset($_GET['id'])) ? $data[0]['language1_details'] : '' ?></textarea>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <textarea class="form-control" name="language1_details" id="language1_details" disabled=""></textarea>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div> 

                                <div class="form-group row">
                                    <?php
                                    $dba = new DBAdapter();
                                    $data1 = $dba->getRow("setting", array("id", "language2"), "1");
                                    foreach ($data1 as $subData) {
                                        echo'<label for="example-text-input" class="col-sm-2 col-form-label">' . $subData[1] . ' Details</label>';
                                    }
                                    ?>
                                    <div class="col-sm-10">
                                        <?php
                                        if (isset($_GET['id'])) {
                                            if ($data[0]['language2_details'] == '') {
                                                ?>
                                                <textarea class="form-control" name="language2_details" id="language2_details" disabled=""></textarea>
                                                <?php
                                            } else {
                                                ?>
                                                <textarea class="form-control" name="language2_details" id="language2_details"><?= (isset($_GET['id'])) ? $data[0]['language2_details'] : '' ?></textarea>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <textarea class="form-control" name="language2_details" id="language2_details" disabled=""></textarea>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div> 
                                <div class="form-group row">
                                    <?php
                                    $dba = new DBAdapter();
                                    $data1 = $dba->getRow("setting", array("id", "language1"), "1");
                                    foreach ($data1 as $subData) {
                                        echo'<label for="example-text-input" class="col-sm-2 col-form-label">' . $subData[1] . ' Details</label>';
                                    }
                                    ?>                                    
                                    <div class="col-sm-4">
                                        <?php
                                        if (isset($_GET['id'])) {
                                            if ($data[0]['language1_pdf'] == '') {
                                                ?>
                                                <input type="file" class="form-control" name="language1_pdf" id="language1_pdf" disabled="" />
                                                <?php
                                            } else {
                                                ?>
                                                <input type="file" class="form-control" name="language1_pdf" id="language1_pdf" value="<?= (isset($_GET['id'])) ? $data[0]['language1_pdf'] : '' ?>"/>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <input type="file" class="form-control" name="language1_pdf" id="language1_pdf" disabled="" />
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <?php
                                    $dba = new DBAdapter();
                                    $data1 = $dba->getRow("setting", array("id", "language2"), "1");
                                    foreach ($data1 as $subData) {
                                        echo'<label for="example-text-input" class="col-sm-2 col-form-label">' . $subData[1] . ' Details</label>';
                                    }
                                    ?>
                                    <div class="col-sm-4">
                                        <?php
                                        if (isset($_GET['id'])) {
                                            if ($data[0]['language2_pdf'] == '') {
                                                ?>
                                                <input type="file" class="form-control" name="language2_pdf" id="language2_pdf" disabled="" />
                                                <?php
                                            } else {
                                                ?>
                                                <input type="file" class="form-control" name="language2_pdf" id="language2_pdf" value="<?= (isset($_GET['id'])) ? $data[0]['language2_pdf'] : '' ?>"/>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <input type="file" class="form-control" name="language2_pdf" id="language2_pdf" disabled="" />
                                            <?php
                                        }
                                        ?>                                    </div>
                                </div>
                                <div class="form-group row">  
                                    <div class="col-sm-2"> </div>
                                    <div class="col-sm-10">
                                        <?= (isset($_GET['id'])) ? '<input type="hidden" name="id" value="' . $_GET['id'] . '">' : '' ?>
                                        <input type="hidden" name="action" id='action' value="<?= (isset($_GET['id'])) ? 'edit' : 'add' ?>">
                                        <button  type="submit" id='submit-button' class="btn btn-primary btn-block w-md waves-effect waves-light" >Submit</button>
                                    </div>
                                </div>

                            </form>
                        </div>

                    </div><hr>


                </div>
                <!-- /.container-fluid -->

                <!-- Sticky Footer -->
                <?php require_once './footer.php'; ?>

            </div>
            <!-- /.content-wrapper -->

        </div>
        <!-- /#wrapper -->


        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Page level plugin JavaScript-->

        <script src="vendor/datatables/jquery.dataTables.js"></script>
        <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin.min.js"></script>
        <script src="vendor/select2/select2.min.js"></script>
        <script src="js/sb-basic.js"></script>
        <script src="js/select.js"></script>
        <!-- Demo scripts for this page-->
        <script src="js/demo/datatables-demo.js"></script>

        <link href="js/summernote/summernote.css" rel="stylesheet">
        <link href="css/main.css" rel="stylesheet">
        <script src="js/summernote/summernote.js"></script>

        <script type="text/javascript">
            $('.summernote').summernote({
                toolbar: [
                    ['style', ['style']],
                    ['fontsize', ['fontsize']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['insert', ['picture', 'hr']],
                    ['table', ['table']],
                    ['insert', ['link', 'image', 'doc', 'video', 'code']],
                    ['view', ['fullscreen', 'codeview', 'help']],
                ],
                height: 400,
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('.chosen').select2();
            });
            $("#details").click(function () {
                $("#language1_details").attr("disabled", false);
                $("#language2_details").attr("disabled", false);
                $("#language1_pdf").attr("disabled", true);
                $("#language2_pdf").attr("disabled", true);
                $("#language1_details").val('');
                $("#language2_details").val('');
                $('#language1_pdf').attr({value: 'null'});
                $('#language2_pdf').attr({value: 'null'});
            });
            $("#pdf").click(function () {
                $("#language1_details").attr("disabled", true);
                $("#language2_details").attr("disabled", true);
                $("#language1_pdf").attr("disabled", false);
                $("#language2_pdf").attr("disabled", false);
                $('#language1_pdf').attr({value: 'null'});
                $('#language2_pdf').attr({value: 'null'});
                $("#language1_details").val('');
                $("#language2_details").val('');
            })
        </script>
    </body>

</html>
