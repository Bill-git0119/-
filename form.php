<?php
session_start();
?>

<html>
<head></head>
<body bgcolor="#E8FFF5">
<?php
if (isset($_SESSION["check"])){
    echo "welcome!";
    echo "<a href='logout.php'>Logout</a>";
    echo "<form action='info.php' method='post'>";
    echo "<font size='4'>";
    echo "please input your name:<input type='text' name='uName'><br>";
    echo "please input your password:<input type='password' name='uPwd'><br>";
    echo "please input your email:<input type='email' name='uemail'><br>";
    echo "please select your gender:<input type='radio' name='ugender' value='male'>male<input type='radio' name='gender' value='female'>female<br>";
    echo "please select your age:<input type='number' name='uage' min='18' max='60'><br>";
    echo "please select your birthday:<input type'date' name='ubirth'><br>";
    echo "please select how you like this webpage:<input type='range' name='ulike'><br>";
    echo "<input type='hidden' name='usecret' value='only i can see'>";

    echo "please select your interest:";
    echo "<input type='checkbox' name='uinterest[]' value='study'>study";
    echo "<input type='checkbox' name='uinterest[]' value='sleep'>sleep";
    echo "<input type='checkbox' name='uinterest[]' value='game'>game<br>";

    echo "please input your comments:";
    echo "<br>";
    echo "<textarea cols='30' rows='30' name='ucomment'></textarea>";
    echo "</font>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br><input type='submit'>";
    echo "<input type='reset'>";
    echo "</form>";
}else{
    echo "illegal user!";
    header("Refresh:2;url='login.php'");
}

    
?>
</body>
</html>