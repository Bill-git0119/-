

<?php

$uName = $_POST["uName"];
$uPwd = $_POST["uPwd"];
$uemail = $_POST["uemail"];
$ugender=$_POST["ugender"];
$uage=$_POST["uage"];
$ubirth=$_POST["ubirth"];
$ulike=$_POST["ulike"];
$interest = isset($_POST["uinterest"]) ? $_POST["uinterest"] :[];
$ucomment=$_POST["ucomment"];


echo "your name is:".$uName."<br>";
echo "your password is:".$uPwd."<br>";
echo "your email is:".$uemail."<br>";
echo "your gender is:".$ugender."<br>";
echo "your age is:".$uage."<br>";
echo "your birth is:".$ubirth."<br>";
echo "your satisfication is:".$ulike."<br>";
echo "your interest is: " . (!empty($interest) ? implode(", ", $interest) : "None") . "<br>";


echo "your comment".nl2br(htmlentities($ucomment));

?>