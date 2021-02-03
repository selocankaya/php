
<?php
session_start();
$con = mysqli_connect("localhost","root","","social");
if(mysqli_connect_errno()){
    echo "failed to connect ;" . mysqli_connect_errno() ;
}
//declaring variables to prevent errors
$fname =""; //first name 
$lname =""; // Last name
$em ="";    //email
$em2 ="";   //email2
$password="";   
$password2 ="";
$date ="";  //sign up date
$error_array =array();   // holds error message

if(isset($_POST['register_button'])){
    //registiration post values

    //First name
    $fname =strip_tags($_POST['reg_fname']);  // remove html tags
    $fname =str_replace(' ','',$fname);     //remove spaces
    $fname = ucfirst(strtolower($fname));   //UpperCase first
    $_SESSION['reg_fname']= $fname; //stores first name into session variables


    //Last name
    $lname =strip_tags($_POST['reg_lname']);  // remove html tags
    $lname =str_replace(' ','',$lname);     //remove spaces
    $lname = ucfirst(strtolower($lname));   //UpperCase first
    $_SESSION['reg_lname']= $lname; //stores last name into session variables


    //Email1
    $em =strip_tags($_POST['reg_email']);  // remove html tags
    $em =str_replace(' ','',$em );     //remove spaces
    $em = ucfirst(strtolower($em ));   //UpperCase first
    $_SESSION['reg_email']= $em; //stores email into session variables

   
    //Email 2
    $em2 =strip_tags($_POST['reg_email2']);  // remove html tags
    $em2 =str_replace(' ','',$em2 );     //remove spaces
    $em2 = ucfirst(strtolower($em2 ));   //UpperCase first
    $_SESSION['reg_email2']= $em2; //stores email2 into session variables

    //passwords
    $password =strip_tags($_POST['reg_password']);  // remove html tags
    $password2 =strip_tags($_POST['reg_password2']);  // remove html tags

    $data =date("Y-m-d"); // Current date
    
    if ($em== $em2) {
        // Check if email is in valid format
        if (filter_var($em, FILTER_VALIDATE_EMAIL)) {
            $em =filter_var($em, FILTER_VALIDATE_EMAIL);

            //check if email already exists
            $e_check = mysqli_query($con,"select email from users where email='$em'");

            $num_rows = mysqli_num_rows($e_check);
            if ($num_rows>0) {
                echo "Email already in use..";
            }
        }
        else {
            echo " Invalid format";
        }
            
    }
    else{
         echo "Emails don't match.";
    }

    if(strlen($fname)>25 || strlen($fname) < 2 ){
        echo " Your first name must be between 2 and 25 characters.";
    }
    if(strlen($lname)>25 || strlen($lname) < 2 ){
        echo " Your last name must be between 2 and 25 characters.";
    }

    if ($password != $password2) {
      echo" Your passwords do not match.";
    }
    else {
        if (preg_match('/[^A-Za-z0-9]/',$password)) {
            echo "Your password can only contain english characters or numbers.";
        }
    }
    if(strlen($password) > 30 || strlen($password) < 5) {
        echo " Your first name must be between 5 and 30 characters.";
    }

  
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome To Swirlfeed</title> 
</head>
<body>
    <form action="register.php" method="POST">
    <input type="text" name="reg_fname" placeholder="First Name" value="<?php 
    if (isset($_SESSION['$reg_fname'])) {
        echo $_SESSION['$reg_fname'];
    }
    ?>" required>
    <br>
    <input type="text" name="reg_lname" placeholder="Last Name" value="<?php 
    if (isset($_SESSION['$reg_lname'])) {
        echo $_SESSION['$reg_lname'];
    } 
     ?>" required>
    <br>
    <input type="email" name="reg_email" placeholder="Email" value="<?php 
    if (isset($_SESSION['$reg_email'])) {
        echo $_SESSION['$reg_email'];
    }
    ?>" required>
    <br>
    <input type="email" name="reg_email2" placeholder="Confirm Email" value="<?php 
    if (isset($_SESSION['$reg_email2'])) {
        echo $_SESSION['$reg_email2'];
    }
    ?>" required>
    <br>
    <input type="password" name="reg_password"  placeholder="Password" required>
    <br>
    <input type="password" name="reg_password2" placeholder="Confirm Password" required>
    <br>
    <input type="submit" name="register_button" value="Register">
    
    </form>
</body>
</html>