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
<?php
// Check if group_id is set in the URL query parameters
if (isset($_GET['group_id']) && !empty($_GET['group_id'])) {
    $group_id = $_GET['group_id'];

    $cus_group_sql = "SELECT cg.* , c.name AS cus_name, c.phone
    FROM tbl_customer_group cg
    LEFT JOIN tbl_customer c ON cg.customer_id = c.id
    WHERE group_id = '$group_id'";
    $cus_group_res = mysqli_query($conn, $cus_group_sql);
}
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
                                            <option value="" disabled selected>Select Group</option>
                                            <?php
                                            $group_que = "SELECT * FROM tbl_group";
                                            $group_res = mysqli_query($conn, $group_que);
                                            while ($group_row = mysqli_fetch_array($group_res)) {
                                                $selected = isset($serviceData['group_id']) && $serviceData['group_id'] == $group_row['id'] ? 'selected' : '';
                                                echo "<option value='" . $group_row['id'] . "' $selected>" . $group_row['name'] . "</option>";
                                            }
                                            ?>
                                        </select>
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

        <!-- Table to display customer details -->
        <div class="content" style="display:none" id="customerTable">
            <div class="row">
                <div class="">
                    <div class="hpanel">
                        <div class="panel-body">
                            <div class="clearfix"></div>
                            <form action="report.php" method="POST" id="productForm">
                                <?php
                                while ($cus_goup_row = mysqli_fetch_array($cus_group_res)) {
                                    $customer_id = $cus_goup_row['customer_id'];
                                    $customer_name = $cus_goup_row['cus_name'];
                                    $contact_no = $cus_goup_row['phone'];
                                ?>
                                    <div id="showrecord" class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover table-responsive" style="margin-top: 40px;" width="100%">
                                            <thead>
                                                <tr>
                                                    <th colspan="2">Customer Name</th>
                                                    <th colspan="2">Contact No.</th>
                                                </tr>
                                            </thead>
                                            <tbody id="customerData">
                                                <tr>
                                                    <td colspan="2"><?= $customer_name ?></td>
                                                    <td colspan="2"><?= $contact_no ?></td>
                                                </tr>
                                            </tbody>
                                            <thead>
                                                <th>Products</th>
                                                <th>Size</th>
                                                <th>Price</th>
                                                <th>Total</th>
                                            </thead>
                                            <tbody id="productData">
                                                <?php
                                                $sql = mysqli_query($conn, "SELECT cp.*, p.name AS product_name, s.name AS size_name, s.unit AS unit_name
                                                        FROM tbl_customer_product cp
                                                        LEFT JOIN tbl_product p ON p.id = cp.product_id
                                                        LEFT JOIN tbl_size s ON s.id = cp.size_id
                                                        WHERE cp.customer_id = $customer_id AND delivery = 1");

                                                if (mysqli_num_rows($sql) > 0) {
                                                    while ($product_row = mysqli_fetch_assoc($sql)) {
                                                        $total_amount = $product_row['unit_name'] * $product_row['price'];
                                                ?>
                                                        <tr class="productRow" data-product-id="<?= $product_row['product_id'] ?>" data-size-id="<?= $product_row['size_id'] ?>">
                                                            <td><?= $product_row['product_name']; ?></td>

                                                            <!-- Size dropdown (editable) -->
                                                            <td>
                                                                <select class="size-dropdown" name="size[<?= $product_row['product_id'] ?>]" data-product-id="<?= $product_row['product_id'] ?>" data-price="<?= $product_row['price'] ?>">
                                                                    <?php
                                                                    $sizes_sql = mysqli_query($conn, "SELECT * FROM tbl_size");
                                                                    while ($size_row = mysqli_fetch_assoc($sizes_sql)) {
                                                                        $selected = ($size_row['id'] == $product_row['size_id']) ? 'selected' : '';
                                                                        echo "<option value='{$size_row['unit']}' $selected data-id='{$size_row['id']}'>{$size_row['name']}</option>";
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </td>

                                                            <td class="price"><?= $product_row['price']; ?></td>
                                                            <td class="total-amount"><?= $total_amount; ?></td>
                                                        </tr>
                                                <?php
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='4'>No products found</td></tr>";
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
        <!-- Footer-->
        <?php include 'include/footer-file.php'; ?>

        <!--select feild css-->
        <script src="vendor/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"></script>
        <script src="vendor/select2-3.5.2/select2.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Function to calculate total amount based on selected size
                function updateTotal(productRow) {
                    var sizeDropdown = productRow.querySelector('.size-dropdown');
                    var priceElement = productRow.querySelector('.price');
                    var totalAmountElement = productRow.querySelector('.total-amount');

                    var selectedSize = sizeDropdown.value;
                    var price = parseFloat(priceElement.textContent);
                    var totalAmount = parseFloat(selectedSize) * price;

                    totalAmountElement.textContent = totalAmount.toFixed(2);

                    // Log the selected size and total for debugging
                    console.log("Selected Size: " + selectedSize);
                    console.log("Calculated Total: " + totalAmount.toFixed(2));
                }

                // Add event listener for size dropdown change
                document.querySelectorAll('.size-dropdown').forEach(function(dropdown) {
                    dropdown.addEventListener('change', function() {
                        var productRow = this.closest('.productRow');
                        updateTotal(productRow);
                    });
                });

                // Submit the form with the updated data
                document.getElementById('productForm').addEventListener('submit', function(e) {
                    e.preventDefault(); // This will stop the page from reloading

                    // Loop through each product row and update hidden inputs
                    var productRows = document.querySelectorAll('.productRow');
                    var form = this; // Reference to the form

                    // Loop through each product row to gather the necessary data
                    productRows.forEach(function(row) {
                        var sizeDropdown = row.querySelector('.size-dropdown');
                        var selectedSize = sizeDropdown.value;
                        var productId = row.getAttribute('data-product-id');
                        var price = row.querySelector('.price').textContent;
                        var totalAmount = row.querySelector('.total-amount').textContent;

                        // Log the data for each product before appending to the form
                        console.log("Product ID: " + productId);
                        console.log("Selected Size: " + selectedSize);
                        console.log("Price: " + price);
                        console.log("Total Amount: " + totalAmount);

                        // Create hidden inputs for each product's selected size and total amount
                        var sizeInput = document.createElement('input');
                        sizeInput.type = 'hidden';
                        sizeInput.name = 'size[' + productId + ']'; // Name the input to match the server-side key
                        sizeInput.value = selectedSize;
                        form.appendChild(sizeInput);

                        var totalInput = document.createElement('input');
                        totalInput.type = 'hidden';
                        totalInput.name = 'total[' + productId + ']'; // Same as above
                        totalInput.value = totalAmount;
                        form.appendChild(totalInput);
                    });

                    // Optionally submit the form manually after logging data
                    this.submit(); // Uncomment this line to submit the form after collecting the data
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