<?php
session_start();

// TODO: add logic that prevents logged users from accessing page
if(!isset($_SESSION['user_id'])){
  header('Location: index.php');
  exit();
}

require_once './db.php';

if(!$_POST || !$_POST['task_id']){
  header('Location: index.php');
  exit();
}

if(isset($_POST['delete'])){
  $sql = "DELETE FROM tasks WHERE task_id = :task_id LIMIT 1";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([':task_id' => $_POST['task_id']]);

  header('Location: index.php');
  exit();
}