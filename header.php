<?php

$logged_in = false;
if(isset($_SESSION['user_id'])){
  $logged_in = true;
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $title; ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <link rel="stylesheet" href="style.css">

  </head>
  <body>

    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
      <div class="container-fluid">
        <a class="navbar-brand" href="./index.php">Todo</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">          
          <ul class="navbar-nav me-auto mb-2 mb-md-0">
            <?php if($logged_in): ?>
            <li class="nav-item active">
              <a class="nav-link" aria-current="page" href="./add.php">Add task</a>
            </li>
            <?php endif; ?>
          </ul>          
          <ul class="navbar-nav align-items-center">
            <?php if($logged_in): ?>
            <li class="nav-item me-4 text-white"><?php echo $_SESSION['username']; ?></li>
            <li class="nav-item">
              <a href="./logout.php" class="btn btn-outline-secondary">Logout</a>
            </li>
            <?php else: ?>
            <li class="nav-item">
              <a href="./register.php" class="btn btn-outline-primary me-2">Register</a>
            </li>
            <li class="nav-item">
              <a href="./login.php" class="btn btn-outline-success">Login</a>
            </li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </nav>
    