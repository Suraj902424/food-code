<?php include 'loginQuery/session_start.php';
include 'dbc.php';
$pageTitle = "Add a new Service and other attributes";
$pageName    = "Dance";
$linkName    = "Show All Dance";
$editMode    =   "editData";
$addMode    =   "addData";
$tableName   = $tblDance;
$listPageUrl = $urlDanceList;
$imageUrl = $mainPath;
$user_id = $_SESSION['userid']
?>
<?php
if (isset($_GET['id'])) {
    $serviceSql = mysqli_query($conn, "SELECT * FROM $tableName WHERE id = $_GET[id]");
    $serviceData = mysqli_fetch_assoc($serviceSql);

    // Assuming you are fetching $serviceData from the database
    $image1 = $serviceData['image1'];  // Fetch image1 from the database
    $image2 = $serviceData['image2'];  // Fetch image2 from the database
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
                                    <div class="col-xs-12 col-sm-5">
                                        <label>Name </label>
                                        <input type="text" id="applicationname" name="name" class="form-control" value="<?php echo (isset($_GET['id'])) ? $serviceData['name'] : "" ?>">
                                    </div>
                                    <div class="col-xs-12 col-sm-5">
                                        <label>Url</label>
                                        <input type="text" id="setpageName" name="url" class="form-control" value="<?php echo (isset($_GET['id'])) ? $serviceData['url'] : "" ?>">
                                    </div>
                                    <div class="col-xs-12 col-sm-2">
                                        <label>Icon</label>
                                        <input type="text" name="icon" class="form-control" value="<?php echo (isset($_GET['id'])) ? $serviceData['icon'] : "" ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-xs-12 col-sm-12">
                                        <label for="name">Short Description</label>
                                        <textarea name="short_description" class="form-control"><?php echo (isset($_GET['id'])) ? $serviceData['short_description'] : "" ?></textarea>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-xs-12 col-sm-12">
                                        <label for="name">Description</label>
                                        <textarea name="full_description" class="editor"><?php echo (isset($_GET['id'])) ? $serviceData['full_description'] : "" ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-xs-12 col-sm-12">
                                        <label for="name">Meta Title</label>
                                        <textarea name="meta_title" class="form-control"><?php echo (isset($_GET['id'])) ? $serviceData['meta_title'] : "" ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-xs-12 col-sm-12">
                                        <label for="name">Meta Keyword</label>
                                        <textarea name="meta_keyword" class="form-control"><?php echo (isset($_GET['id'])) ? $serviceData['meta_keyword'] : "" ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-xs-12 col-sm-12">
                                        <label for="name">Meta Description</label>
                                        <textarea name="meta_description" class="form-control editor"><?php echo (isset($_GET['id'])) ? $serviceData['meta_description'] : "" ?></textarea>
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

                                <div class="form-group row">
                                    <div class="col-xs-3 control-label" for="name" style="width:19%">
                                        <label>Uploaded Banner Image</label>
                                        <div id="brandimageprv2" class="img-content-size-1 common-fram">
                                            <!-- Display the image if it exists -->
                                            <?php if (!empty($image2)): ?>
                                                <img src="<?php echo $imageUrl . $image2; ?>" alt="Image 2" width="100%">
                                            <?php endif; ?>
                                        </div>
                                        <input class="textbox brand-img2" type="file" name="image2fleimage">
                                    </div>
                                    <div class="col-xs-4" style="width:49%">
                                        <p class="text-left"><strong>Image Guidelines</strong></p>
                                        <ul>
                                            <li>Recommended image size 800 x 500 px</li>
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
                                            <option value="url" selected >url</option>
                                            <option value="short_description" selected >short_description</option>
                                            <option value="full_description" selected >full_description</option>
                                            <option value="meta_title" selected >meta_title</option>
                                            <option value="meta_keyword" selected >meta_keyword</option>
                                            <option value="meta_description" selected >meta_description</option>
                                        </select>
                                        <select name="image_data[]" id="" multiple>
                                            <option value="image1" selected>image1</option>
                                            <option value="image2" selected>image2</option>
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
            $("#serviceForm").validate({
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
        </script>
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



</body>

</html>