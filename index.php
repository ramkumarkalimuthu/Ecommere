<?php
include "config.php";
include "header.php";

?>
   <body class="bg-dark">
      <div class="sufee-login d-flex align-content-center flex-wrap">
         <div class="container">
            <div class="login-content">
               <div class="login-form mt-150">
                  <form method="post" id="signin" name="signin">
                     <div class="form-group">
                        <label>Email address</label>
                        <input type="email" id="email" class="form-control" placeholder="Email">
                     </div>
                     <div class="form-group">
                        <label>Password</label>
                        <input type="password" id= "password" class="form-control" placeholder="Password">
                     </div>
                     <input type="submit" name="submit" class="btn btn-success btn-flat m-b-30 m-t-30">
					
                     <div class="form-group">
<p id="error-msg-au" class="error-msg-au"></p>
</div>
               
                  </form>


               </div>
            </div>
         </div>
      </div>


      <script>
$( document ).ready(function() {
	$("#signin").submit(function(e){
		debugger;
		e.preventDefault();
		var email = $('#email').val();
		var pwd = $('#password').val();
		var url = "<?php echo $api_root_url;?>login.php?email=" + email + "&pwd=" + pwd;
	   $.ajax({
		url: url,
		async: false,
		type: "GET",
		dataType: "json",
		success: function (result) {
			debugger;
		  if(result[0].result=='success'){
				window.location='dashboard.php';
			}else{
				$('#error-msg-au').css('color','red');
				$('#error-msg-au').html('Invalid user or password');
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr);
		}
	  });  
   });
   function loginPart()	{
		$(".login").css("display","block");
		$(".regi-foot").css("display","none");
		$(".forget-block").css("display","none");
		$(".btn-groups").css("display","block");
		$(".register").css("display","none");
	}
   $('#error-msg').on('click','#login-b', function() {
	loginPart();
});
  });

  </script>
<style>
.error-msg{
	width: 250px !important;
    font-size: 13px;
	 border: none !important;
}
#error-msg{
    margin:20px 0;
    font-size:15px;
    font-weight:bold;
}
</style>

      <?php
      include "footer.php";
           
      ?>