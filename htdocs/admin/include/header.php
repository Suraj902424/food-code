 <div id="header">
            <div class="color-line">
            </div>
            <div class="light-version" id="logo">
                <span>
                    <a href="home.php"><?php echo $companyName;?></a>
                </span>
            </div>
            <nav role="navigation">
                <div class="header-link hide-menu">
                    <i class="fa fa-bars">
                    </i>
                </div>
                <div class="small-logo">
                    <span class="text-primary">
                        APP NAME
                    </span>
                </div>
                <!--<form action="#" class="navbar-form-custom" method="post" role="search">
                    <div class="form-group">
                        <input class="form-control" name="search" placeholder="Search something special" type="text">
                        </input>
                    </div>
                </form>-->
                <div class="mobile-menu">
                    <button class="navbar-toggle mobile-menu-toggle" data-target="#mobile-collapse" data-toggle="collapse" type="button">
                        <i class="fa fa-chevron-down">
                        </i>
                    </button>
                    <div class="collapse mobile-navbar" id="mobile-collapse">
                        <ul class="nav navbar-nav">
                            <li><a class="" href="#">Link</a></li>
                            <li><a class="" href="#">Link</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="navbar-right">
                    <ul class="nav navbar-nav no-borders">
                        <li><a href="close-list.php" ><i class="fa fa-bell-o"></i> 
                            <span class="text-danger">
                                <?php 
                                /*$date = date('Y-m-d');
                                $csql = mysqli_query($conn,"select * from $tblClose 
                                    where date = '$date' and status=0 and seen_status=0");
                                    echo mysqli_num_rows($csql);*/ ?>
                            </span>
                        </a></li>
                        <li><a href="loginQuery/logout.php"><i class="pe-7s-upload pe-rotate-90"></i></a></li>
                    </ul>
                </div>
            </nav>
        </div>
        
        
<style>
.nav li{
border-bottom:1px solid #eaeaea;
}        
</style>
        <!-- Right sidebar -->
    <div id="right-sidebar" class="animated fadeInRight">

        <div class="p-m">
            <button id="sidebar-close" class="right-sidebar-toggle sidebar-button btn btn-default m-b-md"><i class="pe pe-7s-close"></i>
            </button>
            <ul class="nav" >
                	<li class="active"><a href="change-password.php"><span class="nav-label">Change Password</span></a></li>
                    <!-- <li class="active"><a href="homepage.php"><span class="nav-label">HomePage Meta</span></a></li> -->
            </ul>        
        </div>
        
    </div>
