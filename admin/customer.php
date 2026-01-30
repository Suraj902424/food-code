<?php include 'loginQuery/session_start.php';
include 'dbc.php';
$pageTitle = "Add a new Customer";
$pageName    = "Customer";
$linkName    = "Show All Customer";
$editMode    =   "editData";
$addMode    =   "addData";
$tableName   = $tblCustomer;
$listPageUrl = $urlCustomerList;
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
                                        <input type="text" id="applicationname" name="name" class="form-control" value="<?php echo (isset($_GET['id'])) ? $serviceData['name'] : "" ?>">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-xs-12 col-sm-6">
                                        <label>Contact No.</label>
                                        <input type="text" id="" name="phone" class="form-control" value="<?php echo (isset($_GET['id'])) ? $serviceData['phone'] : "" ?>">
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <label>Email</label>
                                        <input type="email" id="" name="email" class="form-control" value="<?php echo (isset($_GET['id'])) ? $serviceData['email'] : "" ?>">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-xs-12 col-sm-12">
                                        <label for="name">Address</label>
                                        <textarea name="address" class="form-control"><?php echo (isset($_GET['id'])) ? $serviceData['address'] : "" ?></textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-xs-12 col-sm-6">
                                        <label>Landmark </label>
                                        <input type="text" id="" name="landmark" class="form-control" value="<?php echo (isset($_GET['id'])) ? $serviceData['landmark'] : "" ?>">
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <label>Sequence </label>
                                        <input type="text" id="" name="ordering" class="form-control" value="<?php echo (isset($_GET['id'])) ? $serviceData['ordering'] : "" ?>">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-xs-12 col-sm-12">
                                        <label>Location</label>
                                        <select name="location_id" id="" class="form-control js-source-states">
                                            <option value="" disabled selected>Select Location</option>
                                            <?php
                                            $location_que = "SELECT * FROM tbl_location";
                                            $location_res = mysqli_query($conn, $location_que);
                                            while ($location_row = mysqli_fetch_array($location_res)) {
                                                $selected = isset($serviceData['location_id']) && $serviceData['location_id'] == $location_row['id'] ? 'selected' : '';
                                            ?>
                                                <option value="<?= $location_row['id'] ?>" <?= $selected ?>><?= $location_row['name'] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-xs-12 col-sm-12">
                                        <label>Delivery Type</label>
                                        <select name="delivery_type_id" id="" class="form-control js-source-states">
                                            <option value="" disabled selected>Select Delivery Type</option>
                                            <?php
                                            $delivery_type_que = "SELECT * FROM tbl_delivery_type";
                                            $delivery_type_res = mysqli_query($conn, $delivery_type_que);
                                            while ($delivery_type_row = mysqli_fetch_array($delivery_type_res)) {
                                                $selected = isset($serviceData['delivery_type_id']) && $serviceData['delivery_type_id'] == $delivery_type_row['id'] ? 'selected' : '';
                                            ?>
                                                <option value="<?= $delivery_type_row['id'] ?>" <?= $selected ?>><?= $delivery_type_row['name'] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-xs-12 col-sm-6">
                                        <label>State</label>
                                        <select class="form-control js-source-states" id="state" name="state_id">
                                            <option value="" disabled selected>Select State</option>
                                            <?php
                                            $state_que = "SELECT * FROM tbl_state";
                                            $state_res = mysqli_query($conn, $state_que);
                                            while ($state_row = mysqli_fetch_array($state_res)) {
                                                // Use isset or null coalescing to prevent undefined index notice
                                                $selected = isset($serviceData['state_id']) && $serviceData['state_id'] == $state_row['id'] ? 'selected' : '';
                                            ?>
                                                <option value="<?= $state_row['id'] ?>" <?= $selected ?>><?= $state_row['name'] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-xs-12 col-sm-6">
                                        <label>City</label>
                                        <select class="form-control js-source-states" id="city" name="city_id">
                                            <option value="" disabled selected>Select State First</option>
                                            <?php
                                            if (isset($serviceData['state_id'])) {
                                                $city_que = "SELECT * FROM tbl_city WHERE state_id = '{$serviceData['state_id']}'";
                                                $city_res = mysqli_query($conn, $city_que);
                                                while ($city_row = mysqli_fetch_array($city_res)) {
                                                    // Fix undefined index for city
                                                    $selected = isset($serviceData['city_id']) && $serviceData['city_id'] == $city_row['id'] ? 'selected' : '';
                                            ?>
                                                    <option value="<?= $city_row['id'] ?>" <?= $selected ?>><?= $city_row['name'] ?></option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-xs-12 col-sm-12">
                                        <label for="name">Extra Note</label>
                                        <textarea name="extra_note" class="form-control editor"><?php echo (isset($_GET['id'])) ? $serviceData['extra_note'] : "" ?></textarea>
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
                                            <option value="phone" selected>phone</option>
                                            <option value="email" selected>email</option>
                                            <option value="address" selected>address</option>
                                            <option value="landmark" selected>landmark</option>
                                            <option value="ordering" selected>ordering</option>
                                            <option value="location_id" selected>location_id</option>
                                            <option value="delivery_type_id" selected>delivery_type_id</option>
                                            <option value="state_id" selected>state_id</option>
                                            <option value="city_id" selected>city_id</option>
                                            <option value="extra_note" selected>extra_note</option>
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
            $(document).ready(function() {
                $('#category_id').change(function() {
                    var categoryId = $(this).val();
                    $.ajax({
                        type: 'POST',
                        url: 'fetch_data.php?action=getSubCategory',
                        data: {
                            category_id: categoryId
                        },
                        dataType: 'json',
                        success: function(response) {
                            $('#sub_category_id').empty();
                            $('#sub_category_id').append('<option value="">Select Sub Category</option>');
                            $.each(response, function(index, sub_category) {
                                $('#sub_category_id').append('<option value="' + sub_category.id + '">' + sub_category.name + '</option>');
                            });
                        }
                    });
                });
            });
        </script>
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