<?php include 'loginQuery/session_start.php';
include 'dbc.php';
$pageTitle = "Add New Team";
$pageName    = "Team";
$linkName    = "Show All Teams";
$editMode    =   "editData";
$addMode    =   "addData";
$tableName   = $tblTeam;
$listPageUrl = $urlTeamList;
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
                                        <label>Post </label>
                                        <input type="text" id="" name="post" class="form-control" value="<?php echo (isset($_GET['id'])) ? $serviceData['post'] : "" ?>">
                                    </div>
                                </div>

                                 <div class="form-group row">
                                    <div class="col-xs-12 col-sm-12">
                                        <label>Facebook</label>
                                        <input type="text" id="" name="link" class="form-control" value="<?php echo (isset($_GET['id'])) ? $serviceData['link'] : "" ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-xs-12 col-sm-12">
                                        <label>instagram</label>
                                        <input type="text" id="" name="link1" class="form-control" value="<?php echo (isset($_GET['id'])) ? $serviceData['link1'] : "" ?>">
                                    </div>
                                </div>

                                 <div class="form-group row">
                                    <div class="col-xs-12 col-sm-12">
                                        <label>twitter</label>
                                        <input type="text" id="" name="link2" class="form-control" value="<?php echo (isset($_GET['id'])) ? $serviceData['link2'] : "" ?>">
                                    </div>
                                </div>
                                 <div class="form-group row">
                                    <div class="col-xs-12 col-sm-12">
                                        <label>Youtube</label>
                                        <input type="text" id="" name="link3" class="form-control" value="<?php echo (isset($_GET['id'])) ? $serviceData['link3'] : "" ?>">
                                    </div>
                                </div>

                                      <div class="form-group row">
                                    <div class="col-xs-12 col-sm-12">
                                        <label for="overview">overview</label>
                                        <textarea name="overview" class="editor"><?php echo htmlspecialchars($serviceData['overview'] ?? ''); ?></textarea>
                                    </div>
                                </div>
                                
                                 <div class="form-group row">
                              <div class="col-xs-12 col-sm-12">
                                <label>Skills</label>
                                 <textarea name="skills" class="form-control" rows="4" placeholder="Enter skills"><?php echo isset($serviceData['skills']) ? $serviceData['skills'] : ''; ?></textarea>
                              </div>
                           </div>


                                   <div class="form-group row">
                                    <div class="col-xs-12 col-sm-12">
                                        <label>	awards</label>
                                        <input type="text" id="" name="awards" class="form-control" value="<?php echo (isset($_GET['awards'])) ? $serviceData['post'] : "" ?>">
                                    </div>
                                </div>

                                  <div class="form-group row">
                                    <div class="col-xs-12 col-sm-12">
                                        <label>education</label>
                                        <input type="text" id="" name="education" class="form-control" value="<?php echo (isset($_GET['education'])) ? $serviceData['post'] : "" ?>">
                                    </div>
                                </div>


                                 <div class="form-group row">
                                    <div class="col-xs-12 col-sm-12">
                                        <label>experience</label>
                                        <input type="text" id="" name="experience" class="form-control" value="<?php echo (isset($_GET['experience'])) ? $serviceData['post'] : "" ?>">
                                    </div>
                                </div>

                                   <div class="form-group row">
                                    <div class="col-xs-12 col-sm-12">
                                        <label>total_prize</label>
                                        <input type="text" id="" name="total_prize" class="form-control" value="<?php echo (isset($_GET['total_prize'])) ? $serviceData['post'] : "" ?>">
                                    </div>
                                </div>

                                 <div class="form-group row">
                                    <div class="col-xs-12 col-sm-12">
                                        <label>phone</label>
                                        <input type="text" id="" name="phone" class="form-control" value="<?php echo (isset($_GET['phone'])) ? $serviceData['post'] : "" ?>">
                                    </div>
                                </div>

                                   <div class="form-group row">
                                    <div class="col-xs-12 col-sm-12">
                                        <label>email</label>
                                        <input type="text" id="" name="email" class="form-control" value="<?php echo (isset($_GET['email'])) ? $serviceData['post'] : "" ?>">
                                    </div>
                                </div>


                                  <div class="form-group row">
                                    <div class="col-xs-12 col-sm-12">
                                        <label>website_link</label>
                                        <input type="text" id="" name="website_link" class="form-control" value="<?php echo (isset($_GET['website_link'])) ? $serviceData['post'] : "" ?>">
                                    </div>
                                </div>

<div class="form-group row">
    <div class="col-xs-12 col-sm-12">
        <label>Address</label>
        <input type="text" name="address" class="form-control" 
               value="<?php echo isset($serviceData['address']) ? $serviceData['address'] : ''; ?>">
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
                                <div class="form-group row" style="display: none;">
                                    <div class="col-xs-12 col-sm-12">
                                        <input type="text" id="" name="table_name" class="form-control" value="<?php echo $tableName ?>">
                                        <input type="text" id="" name="return_url" class="form-control" value="<?php echo $listPageUrl ?>">
                                        <input type="text" id="" name="page_name" class="form-control" value="Record">
                                        <select name="simple_data[]" id="" multiple>
                                            <option value="name" selected>name</option>
                                            <option value="post" selected>post</option>
                                            <option value="link" selected>link</option>
                                            <option value="link1" selected>link1</option>
                                            <option value="link2" selected>link2</option>
                                            <option value="link3" selected>link3</option>
                                            <option value="overview" selected>overview</option>
                                            <option value="skills" selected>skills</option>
                                            <option value="awards" selected>awards</option>
                                            <option value="education" selected>education</option>
                                            <option value="experience" selected>experience</option>
                                            <option value="total_prize" selected>total_prize</option>
                                            <option value="phone" selected>phone</option>
                                            <option value="email" selected>email</option>
                                            <option value="website_link" selected>website_link</option>
                                             <option value="address" selected>address</option>
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