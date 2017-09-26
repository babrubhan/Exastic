<?php
 ob_start();
 session_start();
 if( isset($_SESSION['user'])!="" ){
  header("Location: contest_registration.php");
 }
 include_once 'dbconfig.php';

 $error = false;

 if ( isset($_POST['btn-signup']) ) {
  
  // clean user inputs to prevent sql injections
  $uname = trim($_POST['uname']);
  $uname = strip_tags($uname);
  $uname = htmlspecialchars($uname);
  
  $uemail = trim($_POST['uemail']);
  $uemail = strip_tags($uemail);
  $uemail = htmlspecialchars($uemail);
  
  $upass = trim($_POST['upass']);
  $upass = strip_tags($upass);
  $upass = htmlspecialchars($upass);
  
  $cpass = trim($_POST['cpass']);
  $cpass = strip_tags($cpass);
  $cpass = htmlspecialchars($cpass);
  
  $uinst = trim($_POST['uinst']);
  $uinst = strip_tags($uinst);
  $uinst = htmlspecialchars($uinst);
  
  $ucity = trim($_POST['ucity']);
  $ucity = strip_tags($ucity);
  $ucity = htmlspecialchars($ucity);
  
  // basic name validation
  if (empty($uname)) {
   $error = true;
   $nameError = "Error!...Please enter your full name.";
   echo $nameError;
  } else if (strlen($uname) < 3) {
   $error = true;
   $nameError = "Error!...Name must have atleat 3 characters.";
   echo $nameError;
  } else if (!preg_match("/^[a-zA-Z ]+$/",$uname)) {
   $error = true;
   $nameError = "Error!...Name must contain alphabets and space.";
   echo $nameError;
  }
  
 //basic email validation
  if ( !filter_var($uemail,FILTER_VALIDATE_EMAIL) ) {
   $error = true;
   $emailError = "Error!...Please enter valid email address.";
   echo $emailError;
   
  } else {
   // check email exist or not
 @  $query = mysqli_query($DBcon, "SELECT userEmail FROM register WHERE userEmail='".$uemail."'");
@   $count = mysqli_num_rows($query);
if($count > 0){
    $error = true;
    $emailError = "Error!...Provided Email is already in use.";
	
	}
  }
  
  // password validation
  if (empty($upass) || $upass != $cpass){
   $error = true;
   $passError = "Error!...Please enter password.";
   echo $passError;
  } else if(strlen($upass) < 6) {
   $error = true;
   $passError = "Error!...Password must have atleast 6 characters.";
   echo $passError;
  }
  
  // password encrypt using SHA256();
  $password = hash('sha256', $upass);
  $cpassword = hash('sha256', $cpass);
  if($password != $cpassword)
  {
	  echo("Error... Passwords do not match!");
	  exit;
  }
  
  // if there's no error, continue to signup
  
  if( !$error ) {
   
 @  $query = "INSERT INTO register(userName,userEmail,userPass,userInstitute,userCity) VALUES('$uname','$uemail','$password','$uinst','$ucity')";
    $res = $link->query($query);
    
   if ($res) {
    $errTyp = "success";
    $errMSG = "Successfully registered! Please check your email.";
	echo $errMSG;

	ini_set("SMTP", "smtpout.secureserver.net");//confirm smtp
	$to = "$uemail";
	$subject = "Ragistration confirmed!";
	$message = "     
      Hello $uname,
     
      Welcome in Exastic!
      Congratulations!!! Your registration for Online Contest has been confirmed.
      All further info about test will be uploaded on our official Facebook page.
	  
      See you then,and feel free to reply to your confirmation email if you have any questions!
	  
      Thanks.

      Best Regards,
      Team Exastic ";
	  
	$from = "contact@exastic.com";
	$headers = "From: $from";
@	mail($to,$subject,$message,$headers);

    unset($uname);
    unset($uemail);
    unset($upass);
   } else {
    $errTyp = "danger";
    $errMSG = "Something went wrong, try again later...";
   echo $errMSG;
   } 
    
  }
  
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel='shortcut icon' href='images/favicon.png' type='image/x-icon'/ >
<title>Free Online Contest Registration</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>

<div style="background-color:rgb(4, 19, 102); color:white; border:1px solid black; width:700px; height:600px;  margin:30px auto; padding:10px;">
<center><h1>Welome To Exastic Online Portal</h1><hr/><p style="font-size:14px; text-align:justify;">- This free online testing quiz will help you for self assessment and prepare for other certification exams as well as interviews.
  <br/><br/>
 - This is just the first of many more contests to come. We will be covering similar online tests to enhance your basic and advanced knowledge about IT sector. 
<br/><br>
- Test details including the date and time of the Online Test will be uploaded on our official <a href="http://www.fb.com/exastic"><span style="color:yellow">FACEBOOK</span></a> page.
<br/><br/>
<span style="font-size:18px;">- Finally, We will give you prize and celebrate the top score by putting your result on <a href="http://www.exastic.com"><span style="color:yellow">EXASTIC</span></a> and social media sites as well like <a href="http://www.fb.com/exastic"><span style="color:yellow">FACEBOOK</span></a> and <a href="http://www.twitter.com/exastic_us"><span style="color:yellow">TWITTER</span></a>.
<br/><br/>
Note:<br>
- Be sure to register to take part in the test. Prizes await You!!<br>
- For any queries please contact us at <a href="http://www.exastic.com"><span style="color:yellow">contact@exastic.com</span></a>. You can also visit our website <a href="http://www.exastic.com"><span style="color:yellow">EXASTIC</span></a>. Call us on <span style="color:yellow">+919813759214</span>.
</span>
</p></center>

<center><button style="position:relative; top:50px; "  type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-log-in"></span> &nbsp; Register to Apply For Contest</span></button></center>
</div>

<div class="container">
  <!-- Trigger the modal with a button -->

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
	  
        
        <div class="modal-body">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		
		<div class="signin-form">
		
		<h2 style="text-align:center">Register for Free Online Contest<br><span style="font-size:14px;">Powered By</span> <span style="color:rgb(4, 19, 102)">EXASTIC</span></h2>
		
          <form class="form-signin" method="post" id="register-form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
       		
		
		
            <?php
   if ( isset($errMSG) ) {
    ?>
	
    <div class="form-group">
             <div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
    <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
             </div>
                <?php
   }
   ?>

                <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
             <input type="text" name="uname" class="form-control" placeholder="Name" maxlength="50" required />
                </div>
                
            </div>
            
            <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
             <input type="email" name="uemail" class="form-control" placeholder="Email" maxlength="40" required />
                </div>
                
            </div>
            
            <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
             <input type="password" name="upass" class="form-control" placeholder="Password" maxlength="15" required />
                </div>
				
				</div>
				
			<div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
             <input type="password" name="cpass" class="form-control" placeholder="Confirm Password" maxlength="15" required />
                </div>
				
				</div>
				
				<div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-education"></span></span>
             <input type="text" name="uinst" class="form-control" placeholder="Institute" maxlength="40" required />
                </div>
				
				</div>
				
			<div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-home"></span></span>
             <input type="text" name="ucity" class="form-control" placeholder="City" maxlength="40" required />
                </div>
				              
            </div>
            
            
  		         <div class="form-group">
                   <center><button type="submit" class="btn btn-default" name="btn-signup">
                    <span class="glyphicon glyphicon-log-in"></span> &nbsp; Register
                   </button></center>
				   
            </div>
			</div>
			
        </form>
		</div>
        </div>
         
      </div>
      
    </div>
  </div>
  
</div>

</body>
</html>
<?php ob_end_flush(); ?>