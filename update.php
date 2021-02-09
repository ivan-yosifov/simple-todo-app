<?php
session_start();
$title = "Update Task";

// TODO: add logic that prevents logged users from accessing page
if(!isset($_SESSION['user_id'])){
  header('Location: index.php');
  exit();
}


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

<?php require ('./header.php'); ?>
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
   

<?php require('./footer.php'); ?>