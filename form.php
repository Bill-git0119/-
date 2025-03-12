<html>
<head></head>

<body bgcolor="#E8FFF5">

<form  action="info.php" method="post">

<font size="4">
please input your name:<input type="text" name="uName" required><br>
please input your password:<input type="password" name="uPwd" required><br>
please input your email:<input type="email" name="uemail" required><br>
please select your gender:<input type="radio" name="ugender" value="male">male<input type="radio" name="gender" value="female">female<br>
please select your age:<input type="number" name="uage" min="18" max="60"><br>
please select your birthday:<input type="date" name="ubirth"><br>
please select how you like this webpage:<input type="range" name="ulike"><br>
<input type="hidden" name="usecret" value="only i can see">

please select your interest:
<input type="checkbox" name="uinterest[]" value="study">study
<input type="checkbox" name="uinterest[]" value="sleep">sleep
<input type="checkbox" name="uinterest[]" value="game">game<br>

please input your comments:
<br>
<textarea cols="30" rows="30" name="ucomment"></textarea>
</font>
<br>
<br>
<br>



<br><input type="submit"><input type="reset">
</form>




</body>











</html>