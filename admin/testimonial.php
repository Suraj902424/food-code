<?php include 'loginQuery/session_start.php';
include 'dbc.php';
$pageTitle = "Add New Testimonial";
$pageName    = "Testimonial";
$linkName    = "Show All Testimonials";
$editMode    =   "editData";
$addMode    =   "addData";
$tableName   = $tblTestimonial;
$listPageUrl = $urlTestimonialList;
$imageUrl = $mainPath;
$user_id = $_SESSION['userid']
?>
<?php
if (isset($_GET['id'])) {
    $serviceSql = mysqli_query($conn, "SELECT * FROM $tableName WHERE id = $_GET[id]");
    $serviceData = mysqli_fetch_assoc($serviceSql);

    // Assuming you are fetching $serviceData from the database
    $image1 = $serviceData['image1'];  // Fetch image1 from the database

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
        <?php echo $pageName ?>
    </title>
    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->
    <!-- Vendor styles -->
    <?php include 'include/header-file.php'; ?>
    <!--select feild css-->
    <link rel="stylesheet" href="vendor/select2-3.5.2/select2.css" />
    <link rel="stylesheet" href="vendor/select2-bootstrap/select2-bootstrap.css" />
    <link rel="stylesheet" href="vendor/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css" />
    <link rel="stylesheet" href="vendor/summernote/dist/summernote.css" />
    <link rel="stylesheet" href="vendor/summernote/dist/summernote-bs3.css" />
    </meta>
    </meta>
    </meta>
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
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | codesample "
        });
    </script>
</head>
<style>
    .small-header .panel-body h2 {
        margin-top: 3px;
    }

    .hbreadcrumb {
        margin-top: 0;
    }
</style>

<body>
    <!-- Header -->
    <?php include 'include/header.php'; ?>
    <!-- Header End-->

    <!-- Navigation -->
    <?php include 'include/side-menu.php'; ?>
    <!-- Navigation -->

    <!-- Main Wrapper -->
    <div id="wrapper">
        <!--small header start-->
        <div class="small-header">
            <div class="hpanel">
                <div class="panel-body">
                    <div id="hbreadcrumb" class="pull-right">
                        <ol class="hbreadcrumb breadcrumb">
                            <li><a href="<?php echo $listPageUrl; ?>" class="btn  btn-warning"><strong>
                                        <?php echo $linkName; ?>
                                    </strong></a></li>
                        </ol>
                    </div>
                    <h2 class="font-light m-b-xs">
                        <?php echo $pageName; ?>
                    </h2>
                    <small>
                        <?php echo $pageTitle; ?>
                    </small>
                </div>
            </div>
        </div>

        <!--small header end-->
        <div class="content ">
            <div class="row">
                <div class="col-lg-1"></div>
                <div class="col-lg-12">
                    <div class="hpanel">
                        <div class="panel-body">
                            <!-- Page Form-->
                            <form id="InsertUpdateForm" role="form" action="" method="post"
                                enctype="multipart/form-data">
                                <input type="hidden" name="case" value="InsertUpdate">
                                <input type="hidden" name="id" value="<?php echo (isset($_GET['id'])) ? $serviceData['id'] : "" ?>">

                                <div class="form-group row">
                                    <div class="col-xs-12 col-sm-12">
                                        <label>Name </label>
                                        <input type="text" id="" name="name" class="form-control" value="<?php echo (isset($_GET['id'])) ? $serviceData['name'] : "" ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-xs-12 col-sm-12">
                                        <label>Heading </label>
                                        <input type="text" id="" name="heading" class="form-control" value="<?php echo (isset($_GET['id'])) ? $serviceData['heading'] : "" ?>">
                                    </div>
                                </div>
                                    <div class="form-group row">
                                    <div class="col-xs-12 col-sm-12">
                                        <label for="name">Description</label>
                                        <textarea name="description" class="editor"><?php echo htmlspecialchars($serviceData['description'] ?? ''); ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-xs-3 control-label" for="name" style="width:19%">
                                        <label>Uploaded Image</label>
                                        <div id="brandimageprv1" class="img-content-size-1 common-fram">
                                            <?php if (!empty($image1)): ?>
                                                <img src="<?php echo $imageUrl . $image1; ?>" alt="Image 1" width="100%">
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
                                <!--image section end-->
                                <div class="form-group row" style="display: none;">
                                    <div class="col-xs-12 col-sm-12">
                                        <input type="text" id="" name="table_name" class="form-control" value="<?php echo $tableName ?>">
                                        <input type="text" id="" name="return_url" class="form-control" value="<?php echo $listPageUrl ?>">
                                        <input type="text" id="" name="page_name" class="form-control" value="Record">
                                        <select name="simple_data[]" id="" multiple>
                                            <option value="name" selected>name</option>
                                            <option value="heading" selected >heading</option>
                                            <option value="description" selected >description</option>
                                        </select>
                                        <select name="image_data[]" id="" multiple>
                                            <option value="image1" selected>image1</option>
                                        </select>
                                    </div>
                                </div>
                                <hr>
                                <div>
                                    <button class="btn btn-sm btn-primary m-t-n-xs"
                                        type="submit"><strong>Submit</strong></button>
                                </div>
                            </form>

                        </div><!--panel body end-->


                    </div><!--hpanel end-->
                </div><!--col-10 end-->
                <div class="col-lg-1"></div>
            </div>
        </div>
        <!-- Footer-->
        <?php include 'include/footer-file.php'; ?>
        <!--select feild css-->
<!-- Required JS libraries -->
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
    
    <!-- I have removed the second, conflicting TinyMCE script that was here. -->

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