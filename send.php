<?php
// Файлы phpmailer
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

// Переменные, которые отправляет пользователь
$name = $_POST['name'];
$email = $_POST['email'];
$text = $_POST['text'];
$file = $_FILES['myfile'];
$file1 = $_FILES['myfile1'];
$file1 = $_FILES['myfile2'];
$file1 = $_FILES['myfile3'];
$file1 = $_FILES['myfile4'];
$file1 = $_FILES['myfile5'];
$file1 = $_FILES['myfile6'];
$file1 = $_FILES['myfile7'];
$file1 = $_FILES['myfile8'];
$file1 = $_FILES['myfile9'];
$file1 = $_FILES['myfile10'];
$file1 = $_FILES['myfile11'];
$file1 = $_FILES['myfile12'];
$file1 = $_FILES['myfile13'];
$select = $_POST['select'];
// Формирование самого письма
$title = "Заголовок письма";
$body = "
<h2>Новое письмо</h2>
<b>Имя:</b> $name<br>
<b>Почта:</b> $email<br>
<b>Сообщение:</b>$text<br>
<b>Направление</b>$select<br>
";

// Настройки PHPMailer
$mail = new PHPMailer\PHPMailer\PHPMailer();
try {
    $mail->isSMTP();   
    $mail->CharSet = "UTF-8";
    $mail->SMTPAuth   = true;
    
    $mail->SMTPDebug = 2;
    $mail->Debugoutput = function($str, $level) {$GLOBALS['status'][] = $str;};

    // Настройки вашей почты
    $mail->Host       = 'smtp.gmail.com'; // SMTP сервера вашей почты
    $mail->Username   = 'yaroslavas1101@gmail.com'; // Логин на почте
    $mail->Password   = 'zhbr2001yfcnz'; // Пароль на почте
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;
    $mail->setFrom('yaroslavas1101@gmail.com', 'Ярослава'); // Адрес самой почты и имя отправителя

    // Получатель письма
    $mail->addAddress('yaroslavas2001@list.ru');  
    // $mail->addAddress('youremail@gmail.com'); // Ещё один, если нужен

    // Прикрипление файлов к письму
if (!empty($file['name'][0])) {
    for ($ct = 0; $ct < count($file['tmp_name']); $ct++) {
        $uploadfile = tempnam(sys_get_temp_dir(), sha1($file['name'][$ct]));
        $filename = $file['name'][$ct];
        if (move_uploaded_file($file['tmp_name'][$ct], $uploadfile)) {
            $mail->addAttachment($uploadfile, $filename);
            $rfile[] = "Файл $filename прикреплён";
        } else {
            $rfile[] = "Не удалось прикрепить файл $filename";
        }
    }   
}
// Отправка сообщения
$mail->isHTML(true);
$mail->Subject = $title;
$mail->Body = $body;    

// Проверяем отравленность сообщения
if ($mail->send()) {$result = "success";} 
else {$result = "error";}

} catch (Exception $e) {
    $result = "error";
    $status = "Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}";
}

// Отображение результата
echo json_encode(["result" => $result, "resultfile" => $rfile, "status" => $status]);