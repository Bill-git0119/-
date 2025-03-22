<?php
session_start();
?>

<h1>Login result</h1>

<?php
$defaultName1="nuk";
$defaultPwd1="123456";
$defaultName2="ad";
$defaultPwd2="00000";
$userName=$_POST["userName"];
$userPwd=$_POST["userPwd"];

if($defaultName1==$userName && $defaultPwd1==$userPwd){
    echo "<font size=4>Login success</font>";
    $_SESSION["check"]=1;
    $cookieDate=strtotime("+5 second",time());
    setcookie("userName",$defaultName1,$cookieDate);
    header("Location:form.php");
}
else if($defaultName2==$userName && $defaultPwd2==$userPwd){
    echo "<font size=4>Login success</font>";
    $_SESSION["check"]=1;
    $cookieDate=strtotime("+5 second",time());
    setcookie("userName",$defaultName2,$cookieDate);
    header("Location:form.php");
}
else{
    echo "Login failed, will send you back to login again";
    header("Refresh:3;url='login.php'");
}

?>