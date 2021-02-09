<?php
session_start();

// TODO: add logic that prevents logged users from accessing page

require_once './db.php';

$logged_in = false;
if(isset($_SESSION['user_id'])){
  $logged_in = true;
  $user_id = $_SESSION['user_id'];

  $sql = "SELECT * FROM tasks WHERE user_id = :user_id";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([':user_id' => $user_id]);
  $tasks = $stmt->fetchAll(PDO::FETCH_OBJ);
  $num_tasks = $stmt->rowCount();
  $tasks_count = 1;
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login</title>

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
            <li class="nav-item active">
              <a class="nav-link" aria-current="page" href="./add.php">Add task</a>
            </li>
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
    <div class="container" style="margin-top:60px;">
      <?php if($logged_in): ?>
      <div class="row">
        <div class="col-md-12">
          <?php if($num_tasks == 0): ?>
          <h2 class="my-4 text-center">You have not tasks. Hurray!</h2>
          <p class="lead text-center mt-5">Wanna get busy? <a href="./add.php" class="btn btn-success">Add a task ✍️</a></p>
          <?php else: ?>
          <h2 class="my-4 text-center">Current tasks</h2>
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col" class="col-md-8">Name</th>
                <th scope="col">Due Date</th>
                <th scope="col" class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($tasks as $task): ?>
              <tr>
                <th scope="row"><?php echo $tasks_count++; ?></th>
                <td><?php echo $task->name; ?></td>
                <td><?php echo date('j M, Y', strtotime($task->date)); ?>


                <?php
                  $d1 = strtotime(date('j M Y', strtotime($task->date)));
                  $d2 = strtotime(date('j M Y'));
                  if($d1 == $d2){
                    echo '<span class="fw-bold text-success fst-italic">due today</span>';
                  }else if($d1 < $d2){
                    echo '<span class="fw-bold text-danger fst-italic">overdue <span class="fst-normal">💣</span></span>';
                  }
                ?></td>
                <td class="text-center">
                  <a href="./update.php?id=<?php echo $task->task_id; ?>" class="btn btn-warning btn-sm">Update</a>
                  <a href="./delete.php?id=<?php echo $task->task_id; ?>" class="btn btn-danger btn-sm">Delete</a>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>  
          <?php endif; ?>
        </div>
      </div>
      <?php endif; ?>
    </div>
   

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
  </body>

</html>