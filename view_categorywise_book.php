<!DOCTYPE html>
<?php
require_once './config/session_info.php';
require_once './config/DBAdapter.php';
include_once 'config.php';
$dba = new DBAdapter();
?>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>View Catgeory Wise Book</title>

        <!-- Custom fonts for this template-->
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

        <!-- Page level plugin CSS-->
        <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
        <link href="vendor/datatables/buttons.bootstrap4.min.css" rel="stylesheet">
        <!-- Custom styles for this template-->
        <link href="css/sb-admin.css" rel="stylesheet">
        <link href="css/bootstrap3-wysihtml5.min.css" rel="stylesheet">
        <link href="js/select2/css/select2.min.css" rel="stylesheet">

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
                            <a href="">View Category Wise Book</a>
                        </li>

                    </ol>
                    <div class="row">
                        <div class="col-xl-10">
                            <form action="" method="get" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Select Category</label>
                                    <div class="col-sm-4">
                                        <select type="text" class="form-control select2" id = "cat" name = "category_id" required=""/>
                                        <option>Select Category</option>       
                                        <?php
                                        $dba = new DBAdapter();
                                        $data1 = $dba->getRow("category_master", array("id", "language1", "language2"), "1");
                                        foreach ($data1 as $subData) {
                                            echo "<option value=" . $subData[0] . ">" . $subData[1] . " / " . $subData[2] . "</option>";
                                        }
                                        ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-1">
                                        <button  type="submit" id='submit-button' class="btn btn-primary btn-block w-md waves-effect waves-light"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                    <hr>
                    <!-- Icon Cards-->
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="fas fa-table"></i>&nbsp;View Book</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>

                                            <th>#</th>
                                            <?php
                                            $dba = new DBAdapter();
                                            $data1 = $dba->getRow("setting", array("id", "language1", "language2"), "1");
                                            foreach ($data1 as $subData) {
                                                echo'<th>' . $subData[1] . ' Title</th>
                                                     <th>' . $subData[2] . ' Title</th>
                                                     <th>' . $subData[1] . ' Details</th>
                                                     <th>' . $subData[2] . ' Details</th>
                                                     <th>' . $subData[1] . ' PDF</th>
                                                     <th>' . $subData[2] . ' PDF</th>';
                                            }
                                            ?>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_GET['category_id'])) {
                                            include_once './config/DBAdapter.php';
                                            $dba = new DBAdapter();
                                            $data = $dba->getRowAssoc("`add_book` INNER JOIN category_master ON add_book.category_id=category_master.id", array("add_book.*"), "category_id=" . $_GET['category_id']);
                                            $i = 1;
                                            if (!empty($data)) {
                                                foreach ($data as $row) {
                                                    echo "<tr>";
                                                    echo "<td>" . $i . "</td>";
                                                    echo "<td>" . $row['language1_title'] . "</td>";
                                                    echo "<td>" . $row['language2_title'] . "</td>";
                                                    echo "<td>" . $row['language1_details'] . "</td>";
                                                    echo "<td>" . $row['language2_details'] . "</td>";
                                                    echo "<td><a href=Book_pdf/" . $row['language1_pdf'] . " target='_blank'>" . $row['language1_pdf'] . "</a></td>";
                                                    echo "<td><a href=Book_pdf/" . $row['language2_pdf'] . " target='_blank'>" . $row['language2_pdf'] . "</a></td>";
                                                    echo "<td><a href='add_book.php?id=" . $row['id'] . "' class='btn btn-primary waves-effect waves-light'>Edit</a>&nbsp<a href='delete.php?bid=" . $row['id'] . "' class='btn btn-primary waves-effect waves-light'>Delete</a></td>";
                                                    echo "</tr>";
                                                    $i++;
                                                }
                                            }
                                        }
                                        ?>   
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>


                </div>
                <!-- /.container-fluid -->

                <!-- Sticky Footer -->
                <?php require_once './footer.php'; ?>

            </div>
            <!-- /.content-wrapper -->

        </div>
        <!-- /#wrapper -->

        <script>
            $(function () {
                $("select2").select2();
            });
        </script>
        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
        <!-- Required datatable js -->
        <script src="vendor/datatables/jquery.dataTables.js"></script>
        <script src="vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
        <!-- Buttons examples -->
        <script src="vendor/datatables/dataTables.buttons.min.js"></script>
        <script src="vendor/datatables/buttons.bootstrap4.min.js"></script>
        <script src="vendor/datatables/jszip.min.js"></script>
        <script src="vendor/datatables/pdfmake.min.js"></script>
        <script src="vendor/datatables/vfs_fonts.js"></script>
        <script src="vendor/datatables/buttons.html5.min.js"></script>
        <script src="vendor/datatables/buttons.print.min.js"></script>
        <script src="vendor/datatables/buttons.colVis.min.js"></script>
        <!-- Responsive examples -->
        <script src="vendor/datatables/dataTables.responsive.min.js"></script>
        <script src="vendor/datatables/responsive.bootstrap4.min.js"></script>
        <script src="js/datatables.init.js"></script>
        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin.min.js"></script>
        <!-- Demo scripts for this page-->
        <script src="js/demo/datatables-demo.js"></script>
        <script src="js/select2/select2.min.js"></script>

    </body>

</html>
