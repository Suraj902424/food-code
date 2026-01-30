<?php include 'loginQuery/session_start.php';
include 'dbc.php';
$pageTitle = "List of Delivery Boy Report ";
$pageName = " Delivery Boy Report";
$tableName = $tblOrder;
$addPageUrl = $urlCity;
$deleteMode = "deleteData";
$returnurl = $urlCityList;
$imageUrl = $mainPath;
$imagepath = $productPath;
$totalImage = 1;
$user_id = $_SESSION['userid'];
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <!-- Page title -->
    <title>
        <?php echo $pageTitle; ?>
    </title>
    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->
    <!-- Vendor styles -->
    <?php include 'include/header-file.php'; ?>
    <!--select feild css-->
    <link rel="stylesheet" href="vendor/select2-3.5.2/select2.css" />
    <link rel="stylesheet" href="vendor/select2-bootstrap/select2-bootstrap.css" />
    <link rel="stylesheet" href="vendor/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css" />
    <link rel="stylesheet" href="vendor/datatables.net-bs/css/dataTables.bootstrap.min.css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <?php include 'message.php'; ?>


    </meta>
    </meta>
    </meta>
    <style>
        .small-header .panel-body h2 {
            margin-top: 3px;
        }

        .hbreadcrumb {
            margin-top: 0;
        }
    </style>
</head>

<body>
    <!-- Simple splash screen-->

    <!--[if lt IE 7]>
<p class="alert alert-danger">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
    <!-- Header -->
    <?php include 'include/header.php'; ?>
    <!-- Header End-->

    <!-- Navigation -->
    <?php include 'include/side-menu.php'; ?>
    <!-- Navigation -->

    <!-- Main Wrapper -->
    <div id="wrapper">
        <!----------------start top normal header--------------------->
        <div class="small-header">
            <div class="hpanel">
                <div class="panel-body">
                    <!-- <div id="hbreadcrumb" class="pull-right">
                        <ol class="hbreadcrumb ">
                            <li><a class="btn btn-danger" href="<?php echo $addPageUrl ?>"><strong>Add New</strong></a>
                            </li>
                        </ol>
                    </div> -->
                    <h2 class="font-light m-b-xs">
                        <?php echo $pageName; ?>

                    </h2>
                    <small>
                        <?php echo $pageTitle; ?>
                    </small>
                </div>
            </div>
        </div>
        <!----------------end top normal header--------------------->

        <!--model window-->

        <!--model window-->

        <style>
            .profile-image {
                width: 50px;
                height: 50px;
            }

            .order-actions {
                display: flex;
                /* Ensure flex display */
                align-items: center;
                /* Center items vertically */
                gap: 10px;
                /* Space between buttons */
            }

            .order-actions .btn {
                margin: 0;
                /* Reset any default margins */
            }

            .btn {
                display: inline-flex;
                /* Ensure buttons remain inline */
            }
        </style>
        <?php
        // Initialize variables for the filter criteria
        $delivery_boy_id = isset($_GET['delivery_boy_id']) ? $_GET['delivery_boy_id'] : '';
        $startdate = isset($_GET['startdate']) ? $_GET['startdate'] : '';
        $enddate = isset($_GET['enddate']) ? $_GET['enddate'] : '';

        // Initialize query variable
        $query = "SELECT * FROM $tableName WHERE 1=1"; // Start with a default true condition

        // Check if at least one filter is selected
        $filterSelected = false;

        // Add condition for delivery_boy_id if selected
        if (!empty($delivery_boy_id)) {
            $query .= " AND delivery_boy_id = '$delivery_boy_id'";
            $filterSelected = true;
        }

        // Add condition for date range if both dates are provided
        if (!empty($startdate) && !empty($enddate)) {
            $query .= " AND order_date BETWEEN '$startdate' AND '$enddate'";
            $filterSelected = true;
        }

        // If no filter is selected, don't execute the query
        if ($filterSelected) {
            // Execute query
            $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
        } else {
            // If no filter is selected, set result as null
            $result = null;
        }
        ?>
        <div class="content">
            <div class="row">
                <div class="">
                    <div class="hpanel">
                        <div class="panel-body">
                            <div class="row">
                                <form method="get">
                                    <div class="col-xs-12 col-sm-5">
                                        <select name="delivery_boy_id" class="form-control js-source-states">
                                            <option value="" selected>Select Delivery Boy</option>
                                            <?php
                                            $del_sql = mysqli_query($conn, "SELECT * FROM tbl_delivery_boy") or die(mysqli_error($conn));
                                            while ($del_row = mysqli_fetch_assoc($del_sql)) {
                                                $selected = ($del_row['id'] == $delivery_boy_id) ? 'selected' : '';
                                                echo "<option value='{$del_row['id']}' $selected>{$del_row['name']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-xs-12 col-sm-5">
                                        <div class="input-daterange input-group form-group" id="datepicker">
                                            <input type="text" class="input-sm form-control" name="startdate" placeholder="Start Date" style="height:34px;" value="<?php echo $startdate; ?>" />
                                            <span class="input-group-addon">to</span>
                                            <input type="text" class="input-sm form-control" name="enddate" placeholder="End Date" style="height:34px;" value="<?php echo $enddate; ?>" />
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-2">
                                        <input type="submit" class="btn btn-success" value="Go">
                                    </div>
                                </form>
                            </div>
                        </div>
                        <br>
                        <div class="panel-body" id="">
                            <div class="clearfix"></div>
                            <div id="showrecord">
                                <?php
                                // Check if any filter criteria are selected
                                if (!$filterSelected) {
                                    echo '<p>Please select filter criteria to view records.</p>';
                                } else {
                                    // Display the table if there are any results
                                    if (mysqli_num_rows($result) > 0) {
                                        $grand_total = 0;
                                ?>
                                        <table id="" class="table table-striped table-bordered table-hover" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Order Date</th>
                                                    <th>Customer Name</th>
                                                    <th>Product</th>
                                                    <th>Size</th>
                                                    <th>Price</th>
                                                    <th>Total Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody id="">
                                                <?php
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    // Add the current row's total_amount to the grand total
                                                    $grand_total += $row['total_amount'];
                                                ?>
                                                    <tr>
                                                        <td><?php echo date('Y-m-d', strtotime($row['order_date'])); ?></td>
                                                        <td><?php echo $row['customer_name']; ?></td>
                                                        <td><?php echo $row['product_name']; ?></td>
                                                        <td><?php echo $row['size_name']; ?></td>
                                                        <td><?php echo $row['product_price']; ?></td>
                                                        <td><?php echo $row['total_amount']; ?></td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                            <thead>
                                                <tr>
                                                    <th colspan="5">Grand Total</th>
                                                    <th><?php echo number_format($grand_total, 2); ?></th> <!-- Display grand total with 2 decimal places -->
                                                </tr>
                                            </thead>
                                        </table>
                                <?php
                                    } else {
                                        echo '<tr><td colspan="5">No records found for the selected criteria.</td></tr>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Footer-->
        <?php include 'include/footer-file.php'; ?>

        <!--select feild css-->
        <script src="vendor/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"></script>
        <script src="vendor/select2-3.5.2/select2.min.js"></script>

        <!-- App scripts -->
</body>

</html>
<link rel="stylesheet" href="vendor/sweetalert/lib/sweet-alert.css" />
<script src="vendor/sweetalert/lib/sweet-alert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    $(document).on('click', '.demo3', function() {
        var path = $(this).attr('path');

        swal({
                title: "Are you sure?",
                text: "Your will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!"
            },
            function() {
                window.location.href = path
            });
    });
</script>



<!--<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.0.3.js"></script>-->




<script>
    $(function() {



        $("#form_2").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 3
                },
                username: {
                    required: true,
                    minlength: 5
                },
                url: {
                    required: true,
                    url: true
                },
                number: {
                    required: true,
                    number: true
                },
                last_name: {
                    required: true,
                    minlength: 6
                }
            },
            messages: {
                number: {
                    required: "(Please enter your phone number)",
                    number: "(Please enter valid phone number)"
                },
                last_name: {
                    required: "This is custom message for required",
                    minlength: "This is custom message for min length"
                }
            },
            submitHandler: function(form) {
                form.submit();
            },
            errorPlacement: function(error, element) {
                $(element)
                    .closest("form")
                    .find("label[for='" + element.attr("id") + "']")
                    .append(error);
            },
            errorElement: "span",
        });


    });
</script>
<!-- DataTables -->
<script src="vendor/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="vendor/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- DataTables buttons scripts -->
<script src="vendor/pdfmake/build/pdfmake.min.js"></script>
<script src="vendor/pdfmake/build/vfs_fonts.js"></script>
<script src="vendor/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="vendor/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="vendor/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="vendor/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>

<script>
    $(function() {

        // Initialize Example 1
        $('#example1').dataTable({
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            buttons: [{
                    extend: 'copy',
                    className: 'btn-sm'
                },
                {
                    extend: 'csv',
                    title: 'ExampleFile',
                    className: 'btn-sm'
                },
                {
                    extend: 'pdf',
                    title: 'ExampleFile',
                    className: 'btn-sm'
                },
                {
                    extend: 'print',
                    className: 'btn-sm'
                }
            ]
        });

        // Initialize Example 2
        $('#example2').dataTable();

    });
</script>
<!-- ================== -->
<script>
    $(function() {

        $('#datepicker').datepicker();
        $("#datepicker").on("changeDate", function(event) {
            $("#my_hidden_input").val(
                $("#datepicker").datepicker('getFormattedDate')
            )
        });

        $('#datapicker2').datepicker();
        $('.input-group.date').datepicker({});
        $('.input-daterange').datepicker({});

        $("#demo1").TouchSpin({
            min: 0,
            max: 100,
            step: 0.1,
            decimals: 2,
            boostat: 5,
            maxboostedstep: 10,
        });

        $("#demo2").TouchSpin({
            verticalbuttons: true
        });

        $("#demo3").TouchSpin({
            postfix: '%'
        });

        $("#demo4").TouchSpin({
            postfix: "a button",
            postfix_extraclass: "btn btn-default"
        });

        $(".js-source-states").select2();
        $(".js-source-states-2").select2();

        //turn to inline mode
        $.fn.editable.defaults.mode = 'inline';

        //defaults
        $.fn.editable.defaults.url = '#';

        //editables
        $('#username').editable({
            url: '#',
            type: 'text',
            pk: 1,
            name: 'username',
            title: 'Enter username'
        });

        $('#firstname').editable({
            validate: function(value) {
                if ($.trim(value) == '') return 'This field is required';
            }
        });

        $('#sex').editable({
            prepend: "not selected",
            source: [{
                    value: 1,
                    text: 'Male'
                },
                {
                    value: 2,
                    text: 'Female'
                }
            ],
            display: function(value, sourceData) {
                var colors = {
                        "": "gray",
                        1: "green",
                        2: "blue"
                    },
                    elem = $.grep(sourceData, function(o) {
                        return o.value == value;
                    });

                if (elem.length) {
                    $(this).text(elem[0].text).css("color", colors[value]);
                } else {
                    $(this).empty();
                }
            }
        });

        $('#dob').editable();

        $('#event').editable({
            placement: 'right',
            combodate: {
                firstItem: 'name'
            }
        });

        $('#comments').editable({
            showbuttons: 'bottom'
        });

        $('#fruits').editable({
            pk: 1,
            limit: 3,
            source: [{
                    value: 1,
                    text: 'banana'
                },
                {
                    value: 2,
                    text: 'peach'
                },
                {
                    value: 3,
                    text: 'apple'
                },
                {
                    value: 4,
                    text: 'watermelon'
                },
                {
                    value: 5,
                    text: 'orange'
                }
            ]
        });

        $('#user .editable').on('hidden', function(e, reason) {
            if (reason === 'save' || reason === 'nochange') {
                var $next = $(this).closest('tr').next().find('.editable');
                if ($('#autoopen').is(':checked')) {
                    setTimeout(function() {
                        $next.editable('show');
                    }, 300);
                } else {
                    $next.focus();
                }
            }
        });

        // ClockPicker
        $('.clockpicker').clockpicker({
            autoclose: true
        });

        // DateTimePicker
        $('#datetimepicker1').datetimepicker();

    });
</script>