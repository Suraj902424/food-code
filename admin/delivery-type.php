<?php include 'loginQuery/session_start.php';
include 'dbc.php';
$pageTitle = "Add New Delivery Type";
$pageName    = "Delivery Type";
$linkName    = "Show All Delivery Type";
$editMode    =   "editData";
$addMode    =   "addData";
$tableName   = $tblDeliveryType;
$listPageUrl = $urlDeliveryTypeList;
$imageUrl = $mainPath;
$user_id = $_SESSION['userid']
?>
<?php
if (isset($_GET['id'])) {
    $serviceSql = mysqli_query($conn, "SELECT * FROM $tableName WHERE id = $_GET[id]");
    $serviceData = mysqli_fetch_assoc($serviceSql);
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
                                <!--image section end-->
                                <div class="form-group row" style="display: none;">
                                    <div class="col-xs-12 col-sm-12">
                                        <input type="text" id="" name="table_name" class="form-control" value="<?php echo $tableName ?>">
                                        <input type="text" id="" name="return_url" class="form-control" value="<?php echo $listPageUrl ?>">
                                        <input type="text" id="" name="page_name" class="form-control" value="Record">
                                        <select name="simple_data[]" id="" multiple>
                                            <!-- <option value="state_id" selected>state_id</option> -->
                                            <option value="name" selected >name</option>
                                            <!-- <option value="url" selected >url</option> -->
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