<?php include'loginQuery/session_start.php';
include'dbc.php';?>
<!DOCTYPE html>
<html>
    <head>
    
        <meta charset="utf-8">
            <meta content="width=device-width, initial-scale=1.0" name="viewport">
                <meta content="IE=edge" http-equiv="X-UA-Compatible">
                    <!-- Page title -->
                    <title>
                        CHELSIE
                    </title>
                    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
                    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->
                    <!-- Vendor styles -->
                    <?php include'include/header-file.php';?>
					<!--select feild css-->                    
					<link rel="stylesheet" href="vendor/select2-3.5.2/select2.css" />
                    <link rel="stylesheet" href="vendor/select2-bootstrap/select2-bootstrap.css" />
				    <link rel="stylesheet" href="vendor/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css" />
                </meta>
            </meta>
        </meta>
    </head>
   
<style>
.small-header .panel-body h2 {
margin-top:3px;
}
.hbreadcrumb {
margin-top:0;
}
</style>    
    <body class="hide-sidebar">
        <!-- Simple splash screen-->
    
        <!--[if lt IE 7]>
<p class="alert alert-danger">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
        <!-- Header -->
        <?php include'include/header.php';?>
        <!-- Header End-->

        <!-- Navigation -->
        <?php include'include/side-menu.php';?>
        <!-- Navigation -->
        
        <!-- Main Wrapper -->
        <div id="wrapper">
       <!--small header start-->    
<div class="small-header">
    <div class="hpanel">
        <div class="panel-body">
            <div id="hbreadcrumb" class="pull-right">
                <!--<ol class="hbreadcrumb breadcrumb">
                    <li><a href="product-list.php" class="btn  btn-warning"><strong>Show All Product</strong></a></li>
                </ol>-->
            </div>
            <h2 class="font-light m-b-xs">
               Change Password
            </h2>
            <small>Change Password</small>
        </div>
    </div>
</div>     
<!--small header end-->   
            <div class="content ">
                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-10">
                        <div class="hpanel">
                            
                            <!--<div class="panel-heading">
                                <div class="panel-tools">
                                    <a class="showhide">
                                        <i class="fa fa-chevron-up">
                                        </i>
                                    </a>
                                    <a class="closebox">
                                        <i class="fa fa-times">
                                        </i>
                                    </a>
                                </div>
                                Title
                            </div>-->
                            <div class="panel-body">
                                <div class="row">
                                	<div class="col-xs-4">
                                    </div>
                                    <div class="col-xs-4">
                                    	<!-- Page Form-->
                                <form action="" id="changepasswordForm">
									<div class="form-group">
                                <label class="control-label" for="username">Old Password</label>
                                
                                <input name="txtoldpassword" type="password" placeholder="******"  title="Please enter you Old password" required="" value="" name="oldpassword" id="username" class="form-control">
                                
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="password">New Password</label>
                                <input id="newpassword" name="txtpassword" type="password" title="Please enter your new password" placeholder="******" required="" value="" name="password" id="password" class="form-control">
                                
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="password">Confirm Password</label>
                                <input id="confirmpassword" name="txtpassword" type="password" title="Please enter your new password" placeholder="******" required="" value="" name="password" id="password" class="form-control">
                                
                            </div>
                            
                            <button  style="position:relative; height:34px;" id="loginbtn" type="submit" class="btn btn-success btn-block ">change</button>
                            
                            <!--<a class="btn btn-default btn-block" href="home.php">Back to Home</a>-->
                                </form>
                                    </div>
                                    <div class="col-xs-4">
                                    </div>
                                </div>
                                
                            </div>
                            <!--panel body end-->
                            
                            
                        </div><!--hpanel end-->
                    </div><!--col-10 end-->
                    <div class="col-lg-1"></div>
                </div>
            </div>
            <!-- Footer-->
            <?php include'include/footer-file.php';?>
<!--select feild css-->                    
<script src="vendor/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"></script>
<script src="vendor/select2-3.5.2/select2.min.js"></script>
     <?php include'message.php';?>
<script>

        

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
                $( element )
                        .closest( "form" )
                        .find( "label[for='" + element.attr( "id" ) + "']" )
                        .append( error );
            },
            errorElement: "span",
        });
</script>
 <script>

        $(function(){

            $('#datepicker').datepicker();
            $("#datepicker").on("changeDate", function(event) {
                $("#my_hidden_input").val(
                        $("#datepicker").datepicker('getFormattedDate')
                )
            });

            $('#datapicker2').datepicker();
            $('.input-group.date').datepicker({ });
            $('.input-daterange').datepicker({ });

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
                    if($.trim(value) == '') return 'This field is required';
                }
            });

            $('#sex').editable({
                prepend: "not selected",
                source: [
                    {value: 1, text: 'Male'},
                    {value: 2, text: 'Female'}
                ],
                display: function(value, sourceData) {
                    var colors = {"": "gray", 1: "green", 2: "blue"},
                            elem = $.grep(sourceData, function(o){return o.value == value;});

                    if(elem.length) {
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
                source: [
                    {value: 1, text: 'banana'},
                    {value: 2, text: 'peach'},
                    {value: 3, text: 'apple'},
                    {value: 4, text: 'watermelon'},
                    {value: 5, text: 'orange'}
                ]
            });

            $('#user .editable').on('hidden', function(e, reason){
                if(reason === 'save' || reason === 'nochange') {
                    var $next = $(this).closest('tr').next().find('.editable');
                    if($('#autoopen').is(':checked')) {
                        setTimeout(function() {
                            $next.editable('show');
                        }, 300);
                    } else {
                        $next.focus();
                    }
                }
            });

            // ClockPicker
            $('.clockpicker').clockpicker({autoclose: true});

            // DateTimePicker
            $('#datetimepicker1').datetimepicker();
			
		

        });
		

    </script>
    


    </body>
</html>