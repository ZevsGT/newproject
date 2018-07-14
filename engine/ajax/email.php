<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/head.php';

if (filter_var($_POST['contacts'], FILTER_VALIDATE_EMAIL) || preg_match("/^[0-9]{11,11}+$/", $_POST['contacts'])) {
  
    $user = $db->loadInterview($_SESSION[question_data]['interview_id']);
    $user = $db->loadUser($user->users_id);

    $to = $user->login;
    $from = "info@mail.com";
    $subject = "Результаты опроса";
    $message = "ФИО: ".$_POST['name']."\nДанные: ".$_POST['contacts']."\nРезультаты: \n".$_SESSION[user_data_result];
    $boundary = md5(date('r', time()));
    $headers = "From: $from\r\nContent-type:text/plain; Charset=utf-8\r\n";
  
    mail($to, $subject, $message, $headers);
    echo $_POST['name'].', Ваши результаты отправлены, спасибо!';
}else {
  echo 'E-mail или номер телефона заполненн не верно';
}
?>