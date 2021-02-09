<?php
session_start();
$title = 'Add Task';

// TODO: add logic that prevents logged users from accessing page
if(!isset($_SESSION['user_id'])){
  header('Location: index.php');
  exit();
}

require_once './db.php';

if(isset($_POST['add'])){
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
    $sql = "INSERT INTO tasks (user_id, name, `date`) VALUES (:user_id, :name, :date)";
    $stmt = $pdo->prepare($sql);

    $stmt->execute([
      ':user_id' => $_SESSION['user_id'],
      ':name' => $name,
      ':date' => $date
    ]);

    array_push($_SESSION['msg'], [
      'class' => 'success',
      'text' => 'Task has been successfully added.'
    ]);
    header('Location: add.php');
    exit();
  }

}
?>

<?php require ('./header.php'); ?>
    <div class="container" style="margin-top:60px;">
      <?php print_r($_SESSION); ?>
      <h1 class="pt-5 text-center">Add A Task</h1>
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
              <input type="text" class="form-control" id="task" name="name" aria-describedby="task" placeholder="Enter task name" value="<?php if(isset($name)) echo $name; ?>">
            </div>
          </div>
          <div class="col-md-2">
            <div class="mb-3">
              <label for="date" class="form-label">Due Date</label>
              <input type="date" class="form-control" id="date" name="date" aria-describedby="date" placeholder="Due date">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 offset-md-3 d-grid gap-2">
            <button type="submit" class="btn btn-primary" name="add">Add</button>
          </div>
        </div>       
      </form>

      <div class="d-flex justify-content-center mt-5">
        <a href="./index.php" class="btn btn-dark" >View My Tasks</a>        
      </div>
    </div>
   
<?php require('./footer.php'); ?>