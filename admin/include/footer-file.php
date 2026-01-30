		<footer class="footer">
		  <span class="pull-right">
		    <?php echo $developerName; ?>
		  </span>
		    <?php echo $year; ?>
		</footer>
		</div>
		<!-- Vendor scripts -->
		<script src="vendor/jquery/dist/jquery.min.js"></script>
		<script src="vendor/jquery-ui/jquery-ui.min.js"></script>
		<script src="vendor/slimScroll/jquery.slimscroll.min.js"></script>
		<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
		<script src="vendor/metisMenu/dist/metisMenu.min.js"></script>
		<script src="vendor/iCheck/icheck.min.js"></script>
		<script src="vendor/sparkline/index.js"></script>
		<script src="vendor/toastr/build/toastr.min.js"></script>
		<script src="vendor/jquery-validation/jquery.validate.min.js"></script>
		<script src="vendor/bootstrap-datepicker-master/dist/js/bootstrap-datepicker.js"></script>
		<script src="vendor/clockpicker/dist/bootstrap-clockpicker.min.js"></script>
		<script src="vendor/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>

		<!-- date picker-->


		<!-- App scripts -->
		<script src="scripts/homer.js"></script>
		<script src="js/custum.js"></script>
		<!-- Vendor scripts -->

		<style>
		  .dropdown-toggle {
		    background: #e8e5e5;
		    padding: 2px 10px;
		    border: 1px solid #ccc;
		  }
		</style>
		<style>
		  <?php
      if ($_SESSION['edit_status'] == 0 && $_SESSION['delete_status'] == 0) {
        echo ".dropdown-toggle{display:none;}";
      }
      if ($_SESSION['add_status'] == 0) {
        echo ".hbreadcrumb li:nth-child(1){display: none;}";
      }
      if ($_SESSION['edit_status'] == 0) {
        echo ".dropdown-menu li:nth-child(1){display: none;}.edit{display:none;}";
      }
      if ($_SESSION['delete_status'] == 0) {
        echo ".dropdown-menu li:nth-child(2){display: none;}.demo3{display:none;}";
      }
      ?>#menu {
		    width: 220px;
		  }

		  #logo {
		    float: left;
		    width: 220px;
		  }

		  #side-menu li:first-child {
		    border-top: 0;
		  }

		  #side-menu li {
		    border-bottom: 0;
		    width: 220px;
		  }

		  #side-menu {
		    background: #fff;
		  }

		  #logo.light-version {
		    background-color: #fff;
		  }

		  #side-menu li a i {
		    /* color: #087be1 !important; */
		    font-size: 15px;
		    padding-right: 5px;
		  }

		  #header {
		    background-color: #fff;
		    display: block;
		    height: 56px;
		  }
		</style>