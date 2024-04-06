<?php
include('database_connection.php');
session_start();
if(!isset($_SESSION['id'])){
	header("location:login.php");
}
$data = array(
 ':to_id'  => $_POST['to_id'],
 ':from_id'  => $_SESSION['id'],
 ':chat_message'  => $_POST['chat_message'],
 ':status'   => '1'
);

$query = "INSERT INTO chat_message (to_id, from_id, chat_message, status) VALUES (:to_id, :from_id, :chat_message, :status)";
$statement = $connect->prepare($query);

if($statement->execute($data)){
	echo fetch_user_chat_history($_SESSION['id'], $_POST['to_id'], $connect);
}
?>
