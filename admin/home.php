<?php 
include'loginQuery/session_start.php';
include'dbc.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
            <meta content="width=device-width, initial-scale=1.0" name="viewport">
                <meta content="IE=edge" http-equiv="X-UA-Compatible">
                    <!-- Page title -->
                    <title>
                        <?php echo $companyName;?> - Dashboard
                    </title>
                    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
                    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->
                    <!-- Vendor styles -->
                    <?php include'include/header-file.php';?>


                </meta>
            </meta>
        </meta>
    </head>
    
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
<!--<div class="small-header">
    <div class="hpanel">
        <div class="panel-body">
            <div id="hbreadcrumb" class="pull-right">
                <ol class="hbreadcrumb breadcrumb">
                    <li><a href="index.html">Dashboard</a></li>
                    <li>
                        <span>Forms</span>
                    </li>
                    <li class="active">
                        <span>Forms elements </span>
                    </li>
                </ol>
            </div>
            <h2 class="font-light m-b-xs">
                Forms elements
            </h2>
            <small>Examples of various form controls.</small>
        </div>
    </div>
</div>     -->
<!--small header end-->   
            <div class="content ">
                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-10">
                        <div class="hpanel" style=" padding:20px;">
                            
                            <div class="row">
                            	
                                <div class="col-xs-12 ">
                                	<!------------------->
                                    <div class="row">
                                    <div class="col-xs-12">
                                        <div class="hpanel" style="">
                                            <div class="panel-body" style="padding:0">
                                                <div class="h-200" >
                                                	<a href="#">
                                                    <div class="row">
                                                    	
                                                        <div class="col-xs-12 text-center">
                                                        <!------------->
                                                        
                                                            <img src="images/dashboard1.jpg" style="width: 100%;height: auto;">
                                                            <h3>Welcome to the <?= $companyName ?></h3>
                                                        <!-------------->
                                                        </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <!--------------------->
                                    <?php /*
						        	<!------------------->
									<div class="row">
                                    <a  href="service-list.php">
                                    <div class="col-sm-3 col-xs-12">
                                        <div class="hpanel" style="">
                                            <div class="panel-body" style="padding:0">
                                                <div  style="height:173px;">
                                                <!------------->
                                                <div class="text-center">
                                                    <div class="m" style="margin-top:40px;">
													<i style="font-size: 4.5em" class="fa fa-bed" aria-hidden="true"></i>                                                      
                                                    </div>
                                                    <h2 class="m-b-xs" style="font-size:24px;">Service </h2>
                                                </div>
                                                <!------------->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									</a>
                                    <!--------------------->
                                    <a  href="gallery-list.php">
                                    <div class="col-sm-3 col-xs-12">
                                        <div class="hpanel" style="">
                                            <div class="panel-body" style="padding:0">
                                                <div  style="height:173px;">
                                                <!------------->
                                                <div class="text-center">
                                                    <div class="m" style="margin-top:40px;">
                                                        <i style="font-size: 4.5em"  class="fa fa-picture-o" aria-hidden="true"></i>
                                                    </div>
                                                    <h2 class="m-b-xs" style="font-size:24px;">Gallery</h2>
                                                </div>
                                                <!------------->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </a>
                                    <!--            -->
                                    <a  href="enquiry-list.php?id=1">
                                    <div class="col-sm-3 col-xs-12">
                                        <div class="hpanel" style="">
                                            <div class="panel-body" style="padding:0">
                                                <div  style="height:173px;">
                                                <!------------->
                                                <div class="text-center">
                                                    <div class="m" style="margin-top:40px;">
                                                        <i style="font-size: 4.5em" class="fa fa-envelope" aria-hidden="true"></i>
                                                    </div>
                                                    <h2 class="m-b-xs" style="font-size:24px;">Enquiry</h2>
                                                </div>
                                                <!------------->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </a>
                                    <!------------------->
                                    <a href="menu-category-list.php">
                                    <div class="col-sm-3 col-xs-12">
                                        <div class="hpanel" style="">
                                            <div class="panel-body" style="padding:0">
                                                <div style="height:173px;">
                                                <!------------->
                                                <div class="text-center">
                                                    <div class="m" style="margin-top:40px;">
													<i style="font-size: 4.5em" class="fa fa-picture-o" aria-hidden="true"></i>                                                     
                                                    </div>
                                                    <h2 class="m-b-xs" style="font-size:24px;">Menu</h2>
                                                </div>
                                                <!------------->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </a>
									</div>
                                    <!--------------------->
                                    */?>
                                </div>
                                
                            </div>
                            
                            
                        </div><!--hpanel end-->
                    </div><!--col-10 end-->
                    <div class="col-lg-1"></div>
                </div>
            </div>
            <!-- Footer-->
            <?php include'include/footer-file.php';?>

<!-- App scripts -->

<script>

    $(function(){

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