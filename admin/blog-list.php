<?php
// Session aur database connection include karein
// Ensure these paths are correct relative to your file structure
include __DIR__ . '/loginQuery/session_start.php';
include __DIR__ . '/dbc.php'; // Yeh file database connection ($conn) aur path variables define karegi

// Page specific variables setup
$pageTitle = "List of Blogs";
$pageName = "Blog";
// Make sure these variables are defined in your dbc.php
// Example: $tblBlog = "blogs"; $urlBlog = "blog.php"; $urlblogList = "blog-list.php";
$tableName = $tblBlog ?? 'tbl_blog'; // Use a default if not defined in dbc.php
$addPageUrl = $urlBlog ?? 'blog.php'; // Use a default if not defined in dbc.php
$returnurl = $urlblogList ?? 'blog-list.php'; // Use a default if not defined in dbc.php

// Image paths setup from dbc.php (assuming mainPath and productPath are defined there)
// Example in dbc.php:
// $mainPath = "http://localhost/your_project/uploads/"; // Web-accessible URL to your uploads folder
// $productPath = __DIR__ . "/uploads/products/"; // Server-side path to your products uploads folder
$imageUrl = $mainPath ?? '';   // Web-accessible URL (e.g., http://localhost/your_project/uploads/)
$imagepath = $productPath ?? ''; // Server-side file path (e.g., /var/www/html/your_project/uploads/products/)

// Safely get user_id from session
$user_id = $_SESSION['userid'] ?? null;

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>

    <?php
    // Header files ko include karein (e.g., Bootstrap, custom CSS, etc.)
    include __DIR__ . '/include/header-file.php';
    ?>

    <!-- External CSS Libraries -->
    <link rel="stylesheet" href="vendor/select2-3.5.2/select2.css" />
    <link rel="stylesheet" href="vendor/select2-bootstrap/select2-bootstrap.css" />
    <link rel="stylesheet" href="vendor/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css" />
    <link rel="stylesheet" href="vendor/datatables.net-bs/css/dataTables.bootstrap.min.css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="vendor/sweetalert/lib/sweet-alert.css" />

    <?php
    // Message display system include karein
    include __DIR__ . '/message.php';
    ?>

    <style>
        /* Custom CSS styles for better UI */
        .small-header .panel-body h2 {
            margin-top: 3px;
        }
        .hbreadcrumb {
            margin-top: 0;
        }
        .profile-image {
            width: 50px;
            height: 50px;
            object-fit: cover; /* Aspect ratio maintain karein */
            border-radius: 5px; /* Thode gol corners */
        }
        .order-actions {
            display: flex;
            align-items: center; /* Items ko vertically center karein */
            gap: 10px; /* Buttons ke beech space */
        }
        .order-actions .btn {
            margin: 0; /* Default margins ko reset karein */
        }
        .btn {
            display: inline-flex; /* Buttons ko inline rakhein */
            align-items: center; /* Icon aur text ko center karein */
            justify-content: center; /* Icon aur text ko horizontally center karein */
        }
        .btn i {
            margin-right: 3px; /* Icon aur text ke beech space */
        }
    </style>
</head>
<body>
    <?php
    // Header aur side menu include karein
    include __DIR__ . '/include/header.php';
    include __DIR__ . '/include/side-menu.php';
    ?>

    <div id="wrapper">
        <div class="small-header">
            <div class="hpanel">
                <div class="panel-body">
                    <div id="hbreadcrumb" class="pull-right">
                        <ol class="hbreadcrumb">
                            <li><a class="btn btn-danger" href="<?php echo htmlspecialchars($addPageUrl); ?>"><strong>Add New</strong></a></li>
                        </ol>
                    </div>
                    <h2 class="font-light m-b-xs"><?php echo htmlspecialchars($pageName); ?></h2>
                    <small><?php echo htmlspecialchars($pageTitle); ?></small>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="hpanel">
                        <div class="panel-body">
                            <div class="clearfix"></div>

                            <div id="showrecord">
                                <table id="example1" class="table table-striped table-bordered table-hover" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="30">ID</th>
                                            <th>Image</th>
                                            <th>Date</th>
                                            <th>Heading</th>
                                            <th>Short Description</th>
                                            <th width="120">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Database connection check
                                        if (!$conn) {
                                            echo '<tr><td colspan="6" class="text-center text-danger">Database connection error.</td></tr>';
                                        } else {
                                            // Blogs data fetch karein
                                            $query = "SELECT * FROM {$tableName} ORDER BY id DESC";
                                            $result = mysqli_query($conn, $query);

                                            if (!$result) {
                                                echo '<tr><td colspan="6" class="text-center text-danger">Error fetching data: ' . htmlspecialchars(mysqli_error($conn)) . '</td></tr>';
                                            } elseif (mysqli_num_rows($result) === 0) {
                                                echo '<tr><td colspan="6" class="text-center">No blogs found.</td></tr>';
                                            } else {
                                                $counter = 1;
                                                while ($row = mysqli_fetch_assoc($result)) {
                                        ?>
                                        <tr>
                                            <td><?php echo $counter++; ?></td>
                                            <td>
                                                <?php
                                                // Check agar image exist karti hai
                                                if (!empty($row['image1'])) {
                                                    $imageFullPath = htmlspecialchars($imageUrl . $row['image1']);
                                                    // Ensure $imagepath is correctly defined as a server-side path (e.g., in dbc.php)
                                                    $imageFilePath = htmlspecialchars($imagepath . $row['image1']); // Server-side path for deletion
                                                ?>
                                                    <img src="<?= $imageFullPath ?>" alt="Blog Image" class="profile-image">
                                                <?php
                                                } else {
                                                    echo '<span class="text-muted">No Image</span>';
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo htmlspecialchars($row['date'] ?? ''); ?></td>
                                            <td><?php echo htmlspecialchars($row['heading'] ?? ''); ?></td>
                                            <td width="200"><?php echo htmlspecialchars($row['short_description'] ?? ''); ?></td>
                                            <td>
                                                <div class="order-actions">
                                                    <!-- Edit Button -->
                                                    <a href="blog.php?id=<?= htmlspecialchars($row['id']) ?>" class="btn btn-success" title="Edit"><i class="bx bxs-edit"></i></a>
                                                    <!-- Delete Button -->
                                                    <button type="button" class="btn btn-danger delete-btn"
                                                        data-id="<?= htmlspecialchars($row['id']) ?>"
                                                        data-table-name="<?= htmlspecialchars($tableName) ?>"
                                                        data-image1="<?= htmlspecialchars($imageFilePath) ?>" title="Delete">
                                                        <i class="bx bxs-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
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
            </div>
        </div>
        <?php
        // Footer files include karein
        include __DIR__ . '/include/footer-file.php';
        ?>
    </div>

    <!-- External JavaScript Libraries -->
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