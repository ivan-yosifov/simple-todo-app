<?php
session_start();

// TODO: add logic that prevents logged users from accessing page

require_once './db.php';

if(!$_POST){
  header('Location: index.php');
  exit();
}

if(isset($_POST['update'])){
  $sql = "SELECT * FROM tasks WHERE task_id = :task_id LIMIT 1";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([':task_id' => $_POST['task_id']]);

  $task = $stmt->fetch(PDO::FETCH_OBJ);
  $date = $task->date;
}

if(isset($_POST['update_task'])){
  $name = trim($_POST['name']);
  $date = trim($_POST['date']);

  $_SESSION['msg'] = array();

  // validate task name
  if(strlen($name) < 3){
    array_push($_SESSION['msg'], [
      'class' => 'danger',
      'text' => 'Task name must be at least 3 characters long'
    ]);
  }

  // validate date
  if(strlen($date) < 10){
    array_push($_SESSION['msg'], [
      'class' => 'danger',
      'text' => 'Due date must be provided'
    ]);
  }

  if(empty($_SESSION['msg'])){
    $sql = "UPDATE tasks SET name = :name, `date` = :date WHERE task_id = :task_id";
    $stmt = $pdo->prepare($sql);

    $stmt->execute([
      ':task_id' => $_POST['task_id'],
      ':name' => $name,
      ':date' => $date
    ]);
    
    header('Location: index.php');
    exit();
  }

}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Update Task</title>

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
      <h1 class="pt-5 text-center">Update A Task</h1>
      <form class="mt-5" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <?php if(isset($_SESSION['msg'])): ?>
          <div class="row">
        <?php foreach($_SESSION['msg'] as $msg): ?>
         <div class="col-md-6 offset-md-3">
        <p class="alert alert-<?php echo $msg['class']; ?> py-2"><?php echo $msg['text']; ?></p>
          </div>
        <?php endforeach; ?>
      </div>
        <?php endif; ?>
        <div class="row">
          <div class="col-md-4 offset-md-3">
            <div class="mb-3">
              <label for="task" class="form-label">Task</label>
              <input type="text" class="form-control" id="task" name="name" aria-describedby="task" placeholder="Enter task name" value="<?php echo $task->name; ?>">
              <input type="hidden" name="task_id" value="<?php echo $task->task_id; ?>">
            </div>
          </div>
          <div class="col-md-2">
            <div class="mb-3">
              <label for="date" class="form-label">Due Date</label>
              <input type="date" class="form-control" id="date" name="date" aria-describedby="date">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 offset-md-3 d-grid gap-2">
            <button type="submit" class="btn btn-warning" name="update_task">Update</button>
          </div>
        </div>       
      </form>

      <div class="d-flex justify-content-center mt-5">
        <a href="./index.php" class="btn btn-dark" >View My Tasks</a>        
      </div>
    </div>
   

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

    <script>
      <?php if(isset($date)): ?>
      var d = document.getElementById('date');
      d.value = '<?php echo $date; ?>';     
      <?php endif; ?>
    </script>
  </body>

</html>
<?php
if(isset($_SESSION['msg'])){
  unset($_SESSION['msg']);
}
?>