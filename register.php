<?php
// Start the session
session_start();

// Check if the user is already logged in, redirect to home page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: home.php");
    exit;
}

// Include the database connection file
// require_once "dbconnect.php";
include('includes/config.php');
if ( isset($_POST["Submit"])) {


$username=htmlentities($_POST["username"]);
$password=htmlentities($_POST["password"]);
  $password2=htmlentities($_POST["confirm_password"]);
   if (isset($_POST["username"])&& isset($_POST["password"])) {
 $passwordmd5 = md5($password);
$sql="INSERT INTO admin(username,password)Values('$username','$passwordmd5')";

if ($dbh->query($sql)==true) {
    echo "<div class='alert alert-success'>Registration successful<br> Username:" .strtoupper($username)."<br>Password :" .$password."</div><br>" ;
    header('Refresh:3;index.php');
}
  else {
    echo "<div class='alert alert-danger'> no record inserted</div>";
}
   }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin Login</title>
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen" >
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen" >
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen" >
        <link rel="stylesheet" href="css/prism/prism.css" media="screen" > <!-- USED FOR DEMO HELP - YOU CAN REMOVE IT -->
        <link rel="stylesheet" href="css/main.css" media="screen" >
        <script src="js/modernizr/modernizr.min.js"></script>
    </head>
    <body class="">
        <div class="main-wrapper">

            
 <h1 align="center">Student Result Management System</h1>
                    <div class="col-lg-6 visible-lg-block">
                        <section class="section">
                            <div class="row ">
                                <div class="col-md-10 col-md-offset-1">
                                    <div class="row">
                                        <div class="col-lg-11">
                                            <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group ">
                <label>Username</label>
                <input type="text" name="username" class="form-control" >
                <span class="help-block"></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" >
                <span class="help-block"></span>
            </div>
            <div class="form-group ">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" >
                <span class="help-block"></span>
            </div>
            <div class="form-group">
                <input type="submit" name="Submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Already have an account? <a href="index.php">Login here</a>.</p>
        </form>
                                            <!-- /.panel -->
                                           <p class="text-muted text-center"><small>Copyright © Meyor</small></p>
                                        </div>
                                        <!-- /.col-md-11 -->
                                    </div>
                                    <!-- /.row -->
                                </div>
                                <!-- /.col-md-12 -->
                            </div>
                            <!-- /.row -->
                        </section>

                    </div>
        
       
</body>
</html>
