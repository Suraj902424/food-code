<?php
	// 0- Record has not been saved successfully
	// 1- Record has been saved successfully
	// 2- this image content two dot (.) 
	// 3- Pleas Select Image
	// 4- Record has been updated 
	// 5- Record has not been updated
	// 6- Rrecord has been delteted
	// 7- Record has not been delteted
		$messsageType="";
	
	$m = isset($_GET['m']) ? $_GET['m'] : '9';
		$n = isset($_GET['n']) ? $_GET['n'] : '';
			 if($m==0){$messsageType=0;$message = "Record has not been saved successfully.";}
		else if($m==1){$messsageType=1;$message = "Record has been saved successfully.";}
		else if($m==2){$messsageType=0;$message = $n." image name content two dot (.)";}
		else if($m==3){$messsageType=0;$message = "Pleas Select Image ".$n;}
		else if($m==4){$messsageType=1;$message = "Record has been updated.";}
		else if($m==5){$messsageType=0;$message = "Record has not been updated";}
		else if($m==6){$messsageType=1;$message = "Rrecord has been deleted.";}
		else if($m==7){$messsageType=0;$message = "Record has not been deleted.";}
		else if($m==8){$messsageType=0;$message = "This  name already exists.";}
		else if($m==10){$messsageType=0;$message = "This email id already exists.";}
		else if($m==11){$messsageType=0;$message = "This phone no already exists.";}
		else if($m==12){$messsageType=0;$message = "This category cannot be deleted. It has items associated with it.";}
		else if($m==13){$messsageType=0;$message = "Image width  should be greater then ".$n;}
		else if($m==14){$messsageType=0;$message = "This category already exists ";}
		else if($m==15){$messsageType=0;$message = "This record content other record  ";}
		else if($m==16){$messsageType=0;$message = "Only select jpg, jpeg image";}
		
		 
		else
		{
			$message = "";
		}
	
	if($m!=9)
	{?>
   <!-- <div class="alert alert-success alert-dismissible fade in" role="alert">
                                                <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                
                                            </div>-->
	<?php }		
		
		
?>
<script src="vendor/toastr/build/toastr.min.js"></script>
<script>

    $(function(){

		
/*-----------------------------------------------*/

// Toastr options
        toastr.options = {
            "debug": false,
            "newestOnTop": false,
            "positionClass": "toast-top-center",
            "closeButton": true,
            "toastClass": "animated fadeInDown",
        };

        <?php if($message!=""){
			if($messsageType==1){?>
		toastr.success('<?php echo $message; ?>');	
			<?php }else{
			?>
		 toastr.error('<?php echo $message; ?>');
		 <?php }}?>
        
/*------------------------------------------------*/

    });
</script>