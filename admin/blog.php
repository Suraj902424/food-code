<?php
include 'loginQuery/session_start.php';
include 'dbc.php'; // Make sure this file correctly defines $conn, $tblBlog, $mainPath, $productPath, $urlblogList

$pageTitle = "Add a new Blog";
$pageName  = "Blogs";
$linkName  = "Show All Blogs";
$tableName = $tblBlog; // Defined in dbc.php
$listPageUrl = $urlblogList; // Defined in dbc.php
$imageUrl = $mainPath; // Defined in dbc.php (This is your web-accessible image path)
$user_id = $_SESSION['userid'] ?? null; // Safely get user_id, it might not always be set

// Initialize $serviceData to an empty array to avoid errors when adding new blog
$serviceData = [];
$image1 = ''; // Initialize image1 variable

// Check if an ID is provided in the URL for editing
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $blogId = mysqli_real_escape_string($conn, $_GET['id']); // Sanitize input
    $blogSql = mysqli_query($conn, "SELECT * FROM {$tableName} WHERE id = {$blogId}");

    if ($blogSql && mysqli_num_rows($blogSql) > 0) {
        $serviceData = mysqli_fetch_assoc($blogSql);
        $image1 = $serviceData['image1'] ?? ''; // Fetch image1 from the database, safely
        $pageTitle = "Edit Blog"; // Change page title for edit mode
    } else {
        // If ID is provided but no data found, alert the user
        echo "<script>alert('No blog found with this ID. Showing new blog form.');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <title><?php echo $pageName; ?></title>

    <?php include 'include/header-file.php'; ?>

    <link rel="stylesheet" href="vendor/select2-3.5.2/select2.css" />
    <link rel="stylesheet" href="vendor/select2-bootstrap/select2-bootstrap.css" />
    <link rel="stylesheet" href="vendor/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css" />
    <link rel="stylesheet" href="vendor/summernote/dist/summernote.css" />
    <link rel="stylesheet" href="vendor/summernote/dist/summernote-bs3.css" />

    <script type="text/javascript" src="js/tinymce/tinymce.min.js"></script>
    <script type="text/javascript">
        tinymce.init({
            selector: ".editor",
            plugins: [
                "codesample",
                "advlist autolink lists link image charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | codesample"
        });
    </script>
    <style>
        .small-header .panel-body h2 {
            margin-top: 3px;
        }
        .hbreadcrumb {
            margin-top: 0;
        }
        /* Added for image preview consistency */
        .img-content-size-1 img {
            max-width: 100%;
            height: auto;
            display: block; /* Removes extra space below image */
        }
    </style>
</head>
<body>
    <?php include 'include/header.php'; ?>
    <?php include 'include/side-menu.php'; ?>
    <div id="wrapper">
        <div class="small-header">
            <div class="hpanel">
                <div class="panel-body">
                    <div id="hbreadcrumb" class="pull-right">
                        <ol class="hbreadcrumb breadcrumb">
                            <li>
                                <a href="<?php echo $listPageUrl; ?>" class="btn btn-warning">
                                    <strong><?php echo $linkName; ?></strong>
                                </a>
                            </li>
                        </ol>
                    </div>
                    <h2 class="font-light m-b-xs"><?php echo $pageName; ?></h2>
                    <small><?php echo $pageTitle; ?></small>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="hpanel">
                        <div class="panel-body">
                            <form id="InsertUpdateForm" role="form" action="product_api.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="case" value="InsertUpdate">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($serviceData['id'] ?? ''); ?>">

                                <div class="form-group row">
                                    <div class="col-xs-12 col-sm-6">
                                        <label>Heading </label>
                                        <input type="text" id="applicationname" name="heading" class="form-control" value="<?php echo htmlspecialchars($serviceData['heading'] ?? ''); ?>">
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <label>Date</label>
                                        <input type="date" id="setpageName" name="date" class="form-control" value="<?php echo htmlspecialchars($serviceData['date'] ?? ''); ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-xs-12 col-sm-12">
                                        <label for="name">Short Description</label>
                                        <textarea name="short_description" class="form-control"><?php echo htmlspecialchars($serviceData['short_description'] ?? ''); ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-xs-12 col-sm-12">
                                        <label for="name">Description</label>
                                        <textarea name="description" class="editor"><?php echo htmlspecialchars($serviceData['description'] ?? ''); ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-xs-12 col-sm-12">
                                        <label for="name">Meta Title</label>
                                        <textarea name="meta_title" class="form-control"><?php echo htmlspecialchars($serviceData['meta_title'] ?? ''); ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-xs-12 col-sm-12">
                                        <label for="name">Meta Keyword</label>
                                        <textarea name="meta_keyword" class="form-control"><?php echo htmlspecialchars($serviceData['meta_keyword'] ?? ''); ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-xs-12 col-sm-12">
                                        <label for="name">Meta Description</label>
                                        <textarea name="meta_description" class="form-control editor"><?php echo htmlspecialchars($serviceData['meta_description'] ?? ''); ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-xs-3 control-label" for="name" style="width:19%">
                                        <label>Uploaded Image</label>
                                        <div id="brandimageprv1" class="img-content-size-1 common-fram">
                                            <?php
                                            // --- DEBUGGING IMAGE PATHS START ---
                                            echo "";
                                            echo "";
                                            echo "";
                                            $fullImageUrl = $imageUrl . $image1;
                                            echo "";

                                            // To check if the file exists on the server (requires $productPath from dbc.php)
                                            // Make sure $productPath is defined as the server-side path, e.g., $_SERVER['DOCUMENT_ROOT'] . '/artbots/uploads/products/'
                                            if (isset($productPath)) {
                                                echo "";
                                            } else {
                                                echo "";
                                            }
                                            // --- DEBUGGING IMAGE PATHS END ---

                                            if (!empty($image1)): ?>
                                                <img src="<?php echo htmlspecialchars($fullImageUrl); ?>" alt="Blog Image" width="100%">
                                            <?php endif; ?>
                                        </div>
                                        <input class="textbox brand-img1" type="file" name="image1fleimage">
                                    </div>
                                    <div class="col-xs-4" style="width:49%">
                                        <p class="text-left"><strong>Image Guidelines</strong></p>
                                        <ul>
                                            <li>Recommended image size 500 x 400 px</li>
                                            <li>Image format must be jpg or jpeg</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="form-group row" style="display: none;">
                                    <div class="col-xs-12 col-sm-12">
                                        <input type="text" name="table_name" class="form-control" value="<?php echo htmlspecialchars($tableName); ?>">
                                        <input type="text" name="return_url" class="form-control" value="<?php echo htmlspecialchars($listPageUrl); ?>">
                                        <input type="text" name="page_name" class="form-control" value="Record">
                                        <select name="simple_data[]" multiple>
                                            <option value="heading" selected>heading</option>
                                            <option value="date" selected>date</option>
                                            <option value="short_description" selected>short_description</option>
                                            <option value="description" selected>description</option>
                                            <option value="meta_title" selected>meta_title</option>
                                            <option value="meta_keyword" selected>meta_keyword</option>
                                            <option value="meta_description" selected>meta_description</option>
                                        </select>
                                        <select name="image_data[]" multiple>
                                            <option value="image1" selected>image1</option>
                                        </select>
                                    </div>
                                </div>
                                <hr>
                                <div>
                                    <button class="btn btn-sm btn-primary m-t-n-xs" type="submit"><strong>Submit</strong></button>
                                </div>
                            </form>
                        </div></div></div></div>
        </div>
        <?php include 'include/footer-file.php'; ?>
    </div>
    <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="vendor/summernote/dist/summernote.min.js"></script>
    <script>
        $(function() {
            // Initialize summernote plugin
            $('.summernote').summernote();
            $('.summernote1').summernote({
                toolbar: [
                    ['headline', ['style']],
                    ['style', ['bold', 'italic', 'underline', 'superscript', 'subscript', 'strikethrough', 'clear']],
                    ['textsize', ['fontsize']],
                    ['alignment', ['ul', 'ol', 'paragraph', 'lineheight']],
                ]
            });
            $('.summernote2').summernote({
                airMode: true,
            });
        });
    </script>

    <script src="vendor/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"></script>
    <script src="vendor/select2-3.5.2/select2.min.js"></script>
    <?php include 'message.php'; ?>

    <script>
        $(document).ready(function() {
            // Initialize TouchSpin
            $("#demo1").TouchSpin({
                min: 0, max: 100, step: 0.1, decimals: 2, boostat: 5, maxboostedstep: 10,
            });
            $("#demo2").TouchSpin({ verticalbuttons: true });
            $("#demo3").TouchSpin({ postfix: '%' });
            $("#demo4").TouchSpin({ postfix: "a button", postfix_extraclass: "btn btn-default" });

            // Initialize Select2
            $(".js-source-states").select2();
            $(".js-source-states-2").select2();

            // Initialize ClockPicker
            $('.clockpicker').clockpicker({ autoclose: true });

            // Initialize DateTimePicker
            $('#datetimepicker1').datetimepicker();

            // Datepicker initialization (assuming datepicker.js is included from header-file.php or elsewhere)
            $('#datepicker').datepicker();
            $("#datepicker").on("changeDate", function(event) {
                $("#my_hidden_input").val($("#datepicker").datepicker('getFormattedDate'))
            });
            $('#datapicker2').datepicker();
            $('.input-group.date').datepicker({});
            $('.input-daterange').datepicker({});
        });
    </script>
</body>
</html>