<html>
<head>  
    <meta charset="utf-8">
</head>

<?php
echo "檔案名稱:".$_FILES["file"]["name"]."<br/>";
echo "暫存檔名:".$_FILES["file"]["tmp_name"]."<br/>";
echo "檔案尺寸:".$_FILES["file"]["size"]."<br/>";
echo "檔案種類:".$_FILES["file"]["type"]."<hr/>";

$time=time();
$FileName="pic\\".$time.".png";

if ( copy($_FILES["file"]["tmp_name"],$FileName)) {
    echo "檔案上傳成功<br/>";
    unlink($_FILES["file"]["tmp_name"]);
}
else
    echo "檔案上傳失敗<br/>"
?>
</html>

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require 'PHPMailer.php';
require 'SMTP.php';
require 'Exception.php';

$mail = new PHPMailer(true);
$email=$_POST["email"];
$name=$_POST["name"];

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = '01bill19@gmail.com';                     //SMTP username
    $mail->Password   = 'rceo isqi ltfm miyp';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;   
    $mail->CharSet = "utf-8";                                 //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('01bill19@gmail.com', 'Mailer');
    $mail->addAddress($email, 'Joe User');     //Add a recipient
    $mail->addAddress($email);               //Name is optional
    $mail->addReplyTo('01bill19@gmail.com', 'Information');
    $mail->addCC('01bill19@gmail.com');
    $mail->addBCC('01bill19@gmail.com');

    //Attachments
    //mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';


    $isSuccess = ($email !== 'admin@example.com');

    if($isSuccess){
        $mail->Subject='註冊成功通知';
        $mail->Body="您好{$name}:<br><br>已成功註冊，歡迎";
        echo "註冊成功，通知信已寄送";
    }else{
        $retryURL='"http://localhost/upload.php"';
        $mail->Subject='註冊失敗通知';
        $mail->Body="您好{$name}:<br><br>抱歉，尚未註冊成功。<br>"."點擊以下連結回到註冊頁面:<br><a href='{$retryURL}'>返回註冊頁面</a>";
        echo "註冊失敗通知信已寄出";
    }

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>