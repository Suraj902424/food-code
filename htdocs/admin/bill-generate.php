<?php include 'loginQuery/session_start.php';
include 'dbc.php';
$pageTitle = "List of Bill Generate ";
$pageName = " Bill Generate";
$tableName = $tblProduct;
$addPageUrl = $urlProduct;
$deleteMode = "deleteData";
$returnurl = $urlProductList;
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
        <div class="content">
            <div class="row">
                <div class="col-lg-1"></div>
                <div class="col-lg-12">
                    <div class="hpanel">
                        <div class="panel-body">
                            <!-- Page Form-->
                            <form id="groupForm" role="form" action="" method="get" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <div class="col-xs-12 col-sm-4">
                                        <label>Group</label>
                                        <select name="group_id" id="group_id" class="form-control js-source-states">
                                            <option value="" disabled>Select Group</option>
                                            <?php
                                            $group_id = isset($_GET['group_id']) ? $_GET['group_id'] : ''; // Retrieve selected group_id if set
                                            $group_que = "SELECT * FROM tbl_group";
                                            $group_res = mysqli_query($conn, $group_que);
                                            while ($group_row = mysqli_fetch_array($group_res)) {
                                                // Check if the current group matches the selected group
                                                $selected = ($group_row['id'] == $group_id) ? 'selected' : '';
                                                echo "<option value='" . $group_row['id'] . "' $selected>" . $group_row['name'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-xs-12 col-sm-4">
                                        <label>Order Date</label>
                                        <input type="date" name="order_date" class="form-control"
                                            value="<?php echo isset($_GET['order_date']) ? $_GET['order_date'] : ''; ?>">
                                    </div>
                                    <div class="col-xs-12 col-sm-4">
                                        <div style="margin-top: 28px;">
                                            <button class="btn btn-sm btn-primary m-t-n-xs" type="submit" id="submitButton"><strong>Generate</strong></button>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </form>

                        </div>
                    </div>
                </div>
                <div class="col-lg-1"></div>
            </div>
        </div>
        <?php
        // Check if group_id is set in the URL query parameters
        if (isset($_GET['group_id']) && !empty($_GET['group_id']) && isset($_GET['order_date']) && !empty($_GET['order_date'])) {
            $group_id = $_GET['group_id'];
            $order_id = date('Ymds') . rand(1000000, 9999999);
            // $order_date = date('Ymd');
            $order_date = $_GET['order_date'];
            $cart_status = 0;
            $cus_group_sql = "SELECT 
                cg.*, 
                c.name AS cus_name, 
                c.id AS cus_id, 
                dt.name AS delivery_type_name,
                p.name AS product_name, 
                p.id AS product_id, 
                cp.price AS product_price, 
                s.id AS size_id, 
                s.name AS size_name, 
                s.unit,
                db.name AS delivery_boy_name,   -- Adding delivery boy's name
                db.id AS delivery_boy_id        -- Adding delivery boy's ID
            FROM 
                tbl_customer_group cg
            LEFT JOIN 
                tbl_customer c ON cg.customer_id = c.id
            LEFT JOIN 
                tbl_customer_product cp ON cp.customer_id = c.id
            LEFT JOIN 
                tbl_product p ON p.id = cp.product_id
            LEFT JOIN 
                tbl_size s ON s.id = cp.size_id
            LEFT JOIN 
                tbl_delivery_type dt ON dt.id = c.delivery_type_id
            LEFT JOIN 
                tbl_delivery_boy db ON FIND_IN_SET(cg.group_id, db.group_id) > 0
            WHERE 
                cg.group_id = '$group_id'";

            $cus_group_res = mysqli_query($conn, $cus_group_sql);

            $check_sql = "SELECT * FROM tbl_temp_order WHERE group_id = '$group_id' AND order_date = '$order_date'";
            $check_result = mysqli_query($conn, $check_sql);

            if (mysqli_num_rows($check_result) > 0) {
                $check_row = mysqli_fetch_array($check_result);
                // Generate JavaScript code to show alert
                // echo "<script>alert('Order Already Generated');</script>";

            } else {
                if (mysqli_num_rows($cus_group_res) > 0) {
                    // Array to hold the values for the INSERT query
                    $values = [];

                    // Loop through the results and prepare values for insertion
                    while ($row = mysqli_fetch_assoc($cus_group_res)) {
                        // Before inserting, check if this customer has an off day for the product on the current date
                        $customer_id = $row['cus_id'];
                        $product_id = $row['product_id'];

                        // Check if there's an entry in tblk_off_days for the same customer_id, product_id, and order_date
                        $check_off_day_sql = "SELECT * FROM tbl_off_days WHERE customer_id = '$customer_id' 
                                      AND product_id = '$product_id' AND date = '$order_date'";

                        $check_off_day_result = mysqli_query($conn, $check_off_day_sql);

                        if (mysqli_num_rows($check_off_day_result) > 0) {
                            // Skip this insertion since the customer has an off day for the product
                            echo "<p>Customer ID: $customer_id has an off day for Product ID: $product_id on $order_date. Skipping this order.</p>";
                            continue; // Skip this iteration and move to the next customer
                        }

                        // Calculate total amount as price * unit
                        $total_amount = $row['product_price'] * $row['unit'];

                        // Prepare the values for this row
                        $values[] = "(
                    '$order_id', 
                    '$order_date', 
                    '$group_id', 
                    '{$row['cus_id']}', 
                    '{$row['cus_name']}', 
                    '{$row['delivery_type_name']}', 
                    '{$row['product_id']}', 
                    '{$row['product_name']}', 
                    '{$row['product_price']}', 
                    '{$row['size_id']}', 
                    '{$row['size_name']}', 
                    '{$row['unit']}',
                    '$total_amount',
                    '$cart_status',
                    '{$row['delivery_boy_id']}',
                    '{$row['delivery_boy_name']}'
                )";
                    }

                    // Insert all values at once if there are any
                    if (count($values) > 0) {
                        $insert_sql = "INSERT INTO tbl_temp_order 
                    (order_id, order_date, group_id, customer_id, customer_name, delivery_type, product_id, product_name, 
                     product_price, size_id, size_name, size_value, total_amount, cart_status, delivery_boy_id, delivery_boy_name)
                    VALUES " . implode(", ", $values);

                        // Execute the insert query
                        if (mysqli_query($conn, $insert_sql)) {
                            echo "<p>Order has been successfully created and inserted.</p>";
                        } else {
                            echo "<p>Error: " . mysqli_error($conn) . "</p>";
                        }
                    }
                } else {
                    echo '<p>No customers found for this group.</p>';
                }
            }
        }
        ?>

        <div class="content" style="display:none" id="customerTable">
            <div class="row">
                <div class="">
                    <div class="hpanel">
                        <div class="panel-body">
                            <div class="clearfix"></div>
                            <form action="report.php" method="POST" id="productForm">
                                <input type="hidden" name="order_id" value="<?= $check_row['order_id'] ?>">
                                <input type="hidden" name="order_date" value="<?= $order_date ?>">
                                <?php
                                $sql = mysqli_query($conn, "SELECT cg.*, c.name AS customer_name, c.phone, c.id = customer_id
                                FROM tbl_customer_group cg 
                               LEFT JOIN tbl_customer c ON cg.customer_id = c.id
                                WHERE cg.group_id = '$group_id'");
                                // Loop through each customer in the order
                                while ($fetch_row = mysqli_fetch_array($sql)) {
                                ?>
                                    <div id="showrecord" class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover table-responsive" style="margin-top: 40px;" width="100%">
                                            <thead>
                                                <tr>
                                                    <th colspan="2">Customer Name</th>
                                                    <th colspan="2">Contact No.</th>
                                                    <th colspan="1">Add</th>
                                                </tr>
                                            </thead>
                                            <tbody id="customerData">
                                                <!-- Display customer name and contact number only once -->
                                                <tr>
                                                    <td colspan="2"><?= $fetch_row['customer_name'] ?></td>
                                                    <td colspan="2"><?= isset($fetch_row['phone']) ? $fetch_row['phone'] : 'N/A' ?></td>
                                                    <td colspan="1">
                                                        <a data-toggle="modal" data-target="#myModal5" class="btn btn-warning add-button" style="padding: 1px 4px;"
                                                            data-customer-id="<?= $fetch_row['customer_id'] ?>"
                                                            data-group-id="<?= $group_id ?>"
                                                            data-order-id="<?= $check_row['order_id'] ?>">
                                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                                            Add
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tbody>

                                            <!-- Product details -->
                                            <thead>
                                                <tr>
                                                    <th>Products</th>
                                                    <th>Size</th>
                                                    <th>Price</th>
                                                    <th>Total</th>
                                                    <th>Update</th>
                                                </tr>
                                            </thead>
                                            <tbody id="productData">
                                                <?php
                                                $sql1 = mysqli_query($conn, "SELECT * FROM tbl_temp_order WHERE customer_id = '{$fetch_row['customer_id']}' AND order_date = '$order_date'");

                                                while ($product_row = mysqli_fetch_array($sql1)) {
                                                    if ($product_row) {
                                                ?>
                                                        <tr class="productRow" data-product-id="<?= $product_row['product_id'] ?>" data-size-id="<?= $product_row['size_id'] ?>" data-product-row-id="<?= $product_row['id'] ?>">
                                                            <td><?= $product_row['product_name']; ?></td>

                                                            <!-- Size dropdown (editable) -->
                                                            <td>
                                                                <select class="size-dropdown" name="size[<?= $product_row['product_id'] ?>]" data-product-id="<?= $product_row['product_id'] ?>" data-price="<?= $product_row['product_price'] ?>">
                                                                    <?php
                                                                    $sizes_sql = mysqli_query($conn, "SELECT * FROM tbl_size");
                                                                    while ($size_row = mysqli_fetch_assoc($sizes_sql)) {
                                                                        $selected = ($size_row['id'] == $product_row['size_id']) ? 'selected' : '';
                                                                        echo "<option value='{$size_row['id']}' $selected data-id='{$size_row['id']}'>{$size_row['name']}</option>";
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </td>

                                                            <td class="price"><?= $product_row['product_price']; ?></td>
                                                            <td class="total-amount"><?= $product_row['total_amount']; ?></td>
                                                            <td><button class="update-btn btn btn-success" style="padding: 1px 4px;" type="">Update</button></td>
                                                        </tr>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php
                                }
                                ?>
                                <div style="margin: auto;">
                                    <button class="btn btn-sm btn-primary m-t-n-xs" type="submit"><strong>Submit</strong></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal HTML Structure -->
        <div class="modal fade hmodal-info" id="myModal5" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form id="formAddproduct" action="" method="post">
                    <div class="modal-content">
                        <div class="color-line"></div>
                        <div class="modal-header text-center" style="padding:8px 30px;">
                            <h4 class="modal-title">Add product</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <!-- Hidden Fields for customer_id and order_id -->
                                <input type="hidden" name="customer_id" id="modal_customer_id">
                                <input type="hidden" name="order_id" id="modal_order_id">
                                <input type="text" name="group_id" id="modal_group_id">
                                <input type="hidden" name="case" value="AddProduct">

                                <div class="col-xs-12 col-sm-4">
                                    <label>Product</label>
                                    <select name="product_id" class="form-control js-source-states-2">
                                        <option value="">Select</option>
                                        <?php
                                        $product_query = mysqli_query($conn, "SELECT * FROM tbl_product");
                                        while ($products_row = mysqli_fetch_assoc($product_query)) {
                                        ?>
                                            <option value="<?= $products_row['id'] ?>"><?= $products_row['name'] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <label>Size</label>
                                    <select name="size_id" class="form-control js-source-states-2">
                                        <option value="">Select</option>
                                        <?php
                                        $sizes_sql = mysqli_query($conn, "SELECT * FROM tbl_size");
                                        while ($sizes_row = mysqli_fetch_assoc($sizes_sql)) {
                                        ?>
                                            <option value="<?= $sizes_row['id'] ?>"><?= $sizes_row['name'] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Footer-->
        <?php include 'include/footer-file.php'; ?>

        <!--select feild css-->
        <script src="vendor/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"></script>
        <script src="vendor/select2-3.5.2/select2.min.js"></script>



        <!-- JavaScript to show the modal -->
        <script>
            $(document).ready(function() {
                // Add event listener to the "ADD" button
                $('.add-button').on('click', function() {
                    // Get customer_id and order_id from the clicked button's data attributes
                    var customerId = $(this).data('customer-id');
                    var orderId = $(this).data('order-id');
                    var groupId = $(this).data('group-id');


                    // Set these values in the modal's hidden input fields
                    $('#modal_customer_id').val(customerId);
                    $('#modal_order_id').val(orderId);
                    $('#modal_group_id').val(groupId);


                    // Optionally, you can also do something else with these values, like filling in select options dynamically.
                });
            });
        </script>

        <script>
            // Add event listener for the Update button
            document.querySelectorAll('.update-btn').forEach(function(updateBtn) {
                updateBtn.addEventListener('click', function(event) {
                    // Prevent default form submission or button action
                    event.preventDefault();

                    var productRow = this.closest('.productRow');
                    var productId = productRow.getAttribute('data-product-id');
                    var productRowId = productRow.getAttribute('data-product-row-id');
                    var sizeDropdown = productRow.querySelector('.size-dropdown');
                    var selectedSize = sizeDropdown.value;
                    var price = productRow.querySelector('.price').textContent; // Get the price from the table

                    // Prepare data for AJAX request
                    var data = {
                        product_id: productId,
                        product_row_id: productRowId,
                        size: selectedSize,
                        price: price, // Include price in the data
                        case: 'InsertUpdateProduct' // Include the case to specify the action
                    };

                    // Log the data to the console
                    console.log('Sending data:', data);

                    // Perform AJAX request
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'dataQuery/process.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            var response = JSON.parse(xhr.responseText);
                            if (response.status === 'success') {
                                alert('Product updated successfully!');
                                //location.reload(); // Reload the page to reflect the updates
                            } else {
                                alert('Error updating product: ' + response.message);
                            }
                        }
                    };

                    // Send the data via POST
                    xhr.send('product_id=' + data.product_id + '&size=' + data.size + '&product_row_id=' + data.product_row_id + '&price=' + data.price + '&case=' + data.case);
                });
            });
        </script>

        <script>
            // jQuery code to show the customer table after data is inserted
            $(document).ready(function() {
                // Check if there are any rows in the customerData table
                if ($('#customerData tr').length > 0) {
                    // Show the customer table
                    $('#customerTable').show();
                }
            });
        </script>

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