<?php include 'loginQuery/session_start.php';
include 'dbc.php';
$pageTitle = "Update Setting";
$pageName    = "Setting";
$linkName    = "Show All SEtting";
$editMode    =   "editData";
$addMode    =   "addData";
$tableName   = $tblSetting;
$listPageUrl = $urlSetting;
$imageUrl = $mainPath;
$user_id = $_SESSION['userid']
?>
<?php
if (isset($_GET['id'])) {
    $settingSql = mysqli_query($conn, "SELECT * FROM $tableName WHERE id = $_GET[id]");
    $settingData = mysqli_fetch_assoc($settingSql);
    $image1 = $settingData['image1'];  // Fetch image1 from the database
    $image2 = $settingData['image2'];  // Fetch image1 from the database
    // $image3 = $settingData['image3'];  // Fetch image1 from the database
    // $image4 = $settingData['image4'];  // Fetch image1 from the database
    // $image5 = $settingData['image5'];  // Fetch image1 from the database

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
                        <!-- <ol class="hbreadcrumb breadcrumb">
                            <li><a href="<?php echo $listPageUrl; ?>" class="btn  btn-warning"><strong>
                                        <?php echo $linkName; ?>
                                    </strong></a></li>
                        </ol> -->
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
                            <!-- Page Form-->
                            <form id="InsertUpdateForm" role="form" action="" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="case" value="InsertUpdate">
                                <input type="hidden" name="id" value="<?php echo (isset($_GET['id'])) ? $settingData['id'] : "" ?>">

                                <!-- About Section -->
                                <fieldset>
                                    <legend><strong>About Us</strong></legend>

                                    <div class="form-group row">
                                        <div class="col-xs-12 col-sm-6">
                                            <label>Heading</label>
                                            <input type="text" name="about_us_heading" class="form-control" value="<?php echo (isset($_GET['id'])) ? $settingData['about_us_heading'] : "" ?>">
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <label>Sub Heading</label>
                                            <input type="text" name="about_us_sub_heading" class="form-control" value="<?php echo (isset($_GET['id'])) ? $settingData['about_us_sub_heading'] : "" ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-xs-12 col-sm-8">
                                            <label>Narration</label>
                                            <input type="text" name="about_us_narration" class="form-control" value="<?php echo isset($settingData['about_us_narration']) ? $settingData['about_us_narration'] : "" ?>">
                                        </div>
                                        <div class="col-xs-12 col-sm-4">
                                            <label>No. Of Experience</label>
                                            <input type="text" name="experience" class="form-control" value="<?php echo isset($settingData['experience']) ? $settingData['experience'] : "" ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-xs-12 col-sm-12">
                                            <label>Short Description</label>
                                            <textarea name="about_short" class="form-control"><?php echo (isset($_GET['id'])) ? $settingData['about_short'] : "" ?></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-xs-12 col-sm-12">
                                            <label>Description</label>
                                            <textarea name="description" class="editor"><?php echo (isset($_GET['id'])) ? $settingData['description'] : "" ?></textarea>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <legend><strong>Vision & Mission</strong></legend>
                                    <div class="form-group row">
                                        <div class="col-xs-12 col-sm-12">
                                            <label>Vission</label>
                                            <textarea name="vission" class="editor"><?php echo (isset($_GET['id'])) ? $settingData['vission'] : "" ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-xs-12 col-sm-12">
                                            <label>Mission</label>
                                            <textarea name="mission" class="editor"><?php echo (isset($_GET['id'])) ? $settingData['mission'] : "" ?></textarea>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset>
                                    <legend><strong>Placement</strong></legend>

                                    <div class="form-group row">
                                        <div class="col-xs-12 col-sm-12">
                                            <label>Careers In Hospitality</label>
                                            <textarea name="career_hospitality" class="editor"><?php echo (isset($_GET['id'])) ? $settingData['career_hospitality'] : "" ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-xs-12 col-sm-12">
                                            <label>International Internship</label>
                                            <textarea name="internation_intenship" class="editor"><?php echo (isset($_GET['id'])) ? $settingData['internation_intenship'] : "" ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-xs-12 col-sm-12">
                                            <label>Alumani</label>
                                            <textarea name="alumani" class="editor"><?php echo (isset($_GET['id'])) ? $settingData['alumani'] : "" ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-xs-3 control-label" for="name" style="width:19%">
                                            <label>Uploaded Image</label>
                                            <div id="brandimageprv2" class="img-content-size-1 common-fram">
                                                <!-- Display the image if it exists -->
                                                <?php if (!empty($image2)): ?>
                                                    <img src="<?php echo $imageUrl . $image2; ?>" alt="Image 2" width="100%">
                                                <?php endif; ?>
                                            </div>
                                            <input class="textbox brand-img2" type="file" name="image2fleimage">
                                        </div>
                                        <div class="col-xs-3" style="width:30%">
                                            <p class="text-left"><strong>Image Guidelines</strong></p>
                                            <ul>
                                                <li>Recommended image size 800 x 500 px</li>
                                                <li>Image format must be jpg or jpeg</li>
                                            </ul>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset>
                                    <legend><strong>Life After IAHM</strong></legend>
                                    <div class="form-group row">
                                        <div class="col-xs-12 col-sm-12">
                                            <label>Life After IAHM</label>
                                            <textarea name="life_after_iahm" class="editor"><?php echo (isset($_GET['id'])) ? $settingData['life_after_iahm'] : "" ?></textarea>
                                        </div>
                                    </div>
                                </fieldset>

                                <!-- Contact Information Section -->
                                <fieldset>
                                    <legend><strong>Contact Info</strong></legend>

                                    <div class="form-group row">
                                        <div class="col-xs-12 col-sm-6">
                                            <label>Conatct Number</label>
                                            <input type="text" name="phone1" class="form-control" value="<?php echo (isset($_GET['id'])) ? $settingData['phone1'] : "" ?>">
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <label>Whatsapp Number</label>
                                            <input type="text" name="phone2" class="form-control" value="<?php echo (isset($_GET['id'])) ? $settingData['phone2'] : "" ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-xs-12 col-sm-6">
                                            <label>Email ID</label>
                                            <input type="text" name="email" class="form-control" value="<?php echo (isset($_GET['id'])) ? $settingData['email'] : "" ?>">
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <label>Opening Timing</label>
                                            <input type="text" name="open_timing" class="form-control" value="<?php echo (isset($_GET['id'])) ? $settingData['open_timing'] : "" ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-xs-12 col-sm-6">
                                            <label>Address</label>
                                            <textarea name="address" class="form-control"><?php echo (isset($_GET['id'])) ? $settingData['address'] : "" ?></textarea>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <label>Office Address</label>
                                            <textarea name="address1" class="form-control"><?php echo (isset($_GET['id'])) ? $settingData['address1'] : "" ?></textarea>
                                        </div>
                                    </div>
                                </fieldset>

                                <!-- Social Links Section -->
                                <fieldset>
                                    <legend><strong>Social Links</strong></legend>

                                    <div class="form-group row">
                                        <div class="col-xs-12 col-sm-6">
                                            <label>Facebook Link</label>
                                            <input type="text" name="link1" class="form-control" value="<?php echo (isset($_GET['id'])) ? $settingData['link1'] : "" ?>">
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <label>Twitter Link</label>
                                            <input type="text" name="link2" class="form-control" value="<?php echo (isset($_GET['id'])) ? $settingData['link2'] : "" ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-xs-12 col-sm-6">
                                            <label>Instagram Link</label>
                                            <input type="text" name="link3" class="form-control" value="<?php echo (isset($_GET['id'])) ? $settingData['link3'] : "" ?>">
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <label>Youtube Link</label>
                                            <input type="text" name="link4" class="form-control" value="<?php echo (isset($_GET['id'])) ? $settingData['link4'] : "" ?>">
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset>
                                    <legend><strong>Map Url</strong></legend>

                                    <div class="form-group row">
                                        <div class="col-xs-12 col-sm-6">
                                            <label>Map link</label>
                                            <input type="text" name="url" class="form-control" value="<?php echo (isset($_GET['id'])) ? $settingData['url'] : "" ?>">
                                        </div>
                      
                                </fieldset>


                                <!-- About Section -->
                                <fieldset>
                                    <legend><strong>Counter Area</strong></legend>

                                    <div class="form-group row">
                                        <div class="col-xs-12 col-sm-6">
                                            <label>Point 1</label>
                                            <input type="text" name="point1" class="form-control" value="<?php echo (isset($_GET['id'])) ? $settingData['point1'] : "" ?>">
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <label>Value 1</label>
                                            <input type="text" name="value1" class="form-control" value="<?php echo (isset($_GET['id'])) ? $settingData['value1'] : "" ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-xs-12 col-sm-6">
                                            <label>Point 2</label>
                                            <input type="text" name="point2" class="form-control" value="<?php echo (isset($_GET['id'])) ? $settingData['point2'] : "" ?>">
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <label>Value 2</label>
                                            <input type="text" name="value2" class="form-control" value="<?php echo (isset($_GET['id'])) ? $settingData['value2'] : "" ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-xs-12 col-sm-6">
                                            <label>Point 3</label>
                                            <input type="text" name="point3" class="form-control" value="<?php echo (isset($_GET['id'])) ? $settingData['point3'] : "" ?>">
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <label>Value 3</label>
                                            <input type="text" name="value3" class="form-control" value="<?php echo (isset($_GET['id'])) ? $settingData['value3'] : "" ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-xs-12 col-sm-6">
                                            <label>Point 4</label>
                                            <input type="text" name="point4" class="form-control" value="<?php echo (isset($_GET['id'])) ? $settingData['point4'] : "" ?>">
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <label>Value 4</label>
                                            <input type="text" name="value4" class="form-control" value="<?php echo (isset($_GET['id'])) ? $settingData['value4'] : "" ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-xs-12 col-sm-6">
                                            <label>Point 5</label>
                                            <input type="text" name="point5" class="form-control" value="<?php echo (isset($_GET['id'])) ? $settingData['point5'] : "" ?>">
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <label>Value 5</label>
                                            <input type="text" name="value5" class="form-control" value="<?php echo (isset($_GET['id'])) ? $settingData['value5'] : "" ?>">
                                        </div>
                                    </div>
                                </fieldset>

                                <!-- Image Section -->
                                <fieldset>
                                    <legend><strong>Logo Image</strong></legend>

                                    <div class="form-group row">
                                        <div class="col-xs-3 control-label" style="width:19%">
                                            <label>Uploaded Image</label>
                                            <div id="brandimageprv1" class="img-content-size-1 common-fram">
                                                <?php if (!empty($image1)): ?>
                                                    <img src="<?php echo $imageUrl . $image1; ?>" alt="Image 1" width="100%">
                                                <?php endif; ?>
                                            </div>
                                            <input class="textbox brand-img1" type="file" name="image1fleimage">
                                        </div>
                                        <div class="col-xs-4" style="width:49%">
                                            <p><strong>Image Guidelines</strong></p>
                                            <ul>
                                                <li>Recommended image size 500 x 400 px</li>
                                                <li>Image format must be jpg or jpeg</li>
                                            </ul>
                                        </div>
                                    </div>
                                </fieldset>

                                <hr>
                                <div class="form-group row" style="display: none;">
                                    <div class="col-xs-12 col-sm-12">
                                        <input type="text" id="" name="table_name" class="form-control" value="<?php echo $tableName ?>">
                                        <input type="text" id="" name="return_url" class="form-control" value="<?php echo $listPageUrl ?>">
                                        <input type="text" id="" name="page_name" class="form-control" value="Setting">
                                        <select name="simple_data[]" id="" multiple>
                                            <option value="about_us_heading" selected>about_us_heading</option>
                                            <option value="about_us_sub_heading" selected>about_us_sub_heading</option>
                                            <option value="about_us_narration" selected>about_us_narration</option>
                                            <option value="experience" selected>experience</option>
                                            <option value="about_short" selected>about_short</option>
                                            <option value="description" selected>description</option>
                                            <option value="vission" selected>vission</option>
                                            <option value="mission" selected>mission</option>
                                            <option value="career_hospitality" selected>career_hospitality</option>
                                            <option value="internation_intenship" selected>internation_intenship</option>
                                            <option value="alumani" selected>alumani</option>
                                            <option value="life_after_iahm" selected>life_after_iahm</option>
                                            <option value="phone1" selected>phone1</option>
                                            <option value="phone2" selected>phone2</option>
                                            <option value="email" selected>email</option>
                                            <option value="open_timing" selected>open_timing</option>
                                            <option value="address" selected>address</option>
                                            <option value="address1" selected>address1</option>
                                            <option value="link1" selected>link1</option>
                                            <option value="link2" selected>link2</option>
                                            <option value="link3" selected>link3</option>
                                            <option value="link4" selected>link4</option>
                                            <option value="url" selected>url</option>
                                            <option value="point1" selected>point1</option>
                                            <option value="value1" selected>value1</option>
                                            <option value="point2" selected>point2</option>
                                            <option value="value2" selected>value2</option>
                                            <option value="point3" selected>point3</option>
                                            <option value="value3" selected>value3</option>
                                            <option value="point4" selected>point4</option>
                                            <option value="value4" selected>value4</option>
                                            <option value="point5" selected>point5</option>
                                            <option value="value5" selected>value5</option>
                                        </select>
                                        <select name="image_data[]" id="" multiple>
                                            <option value="image1" selected>image1</option>
                                            <option value="image2" selected>image2</option>
                                        </select>
                                        <!-- <select name="multiple_data[]" id="" multiple>
                                            <option value="job_type_id" selected>job_type_id</option>
                                        </select> -->
                                    </div>
                                </div>

                                <div>
                                    <button class="btn btn-sm btn-primary m-t-n-xs" type="submit"><strong>Update</strong></button>
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
        <script src="vendor/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"></script>
        <script src="vendor/select2-3.5.2/select2.min.js"></script>
        <?php include 'message.php'; ?>
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