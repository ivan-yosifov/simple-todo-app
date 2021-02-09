<?php
session_start();
$title = 'Todo App';

// TODO: add logic that prevents logged users from accessing page

require_once './db.php';

if(isset($_SESSION['user_id'])){
  $user_id = $_SESSION['user_id'];

  $sql = "SELECT * FROM tasks WHERE user_id = :user_id";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([':user_id' => $user_id]);
  $tasks = $stmt->fetchAll(PDO::FETCH_OBJ);
  $num_tasks = $stmt->rowCount();
  $tasks_count = 1;
}
?>

<?php require('./header.php'); ?>
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
                  <form action="<?php echo htmlspecialchars('./update.php'); ?>" class="d-inline" method="post">
                    <input type="hidden" name="task_id" value="<?php echo $task->task_id; ?>">
                    <input type="submit" value="Update" name="update" class="btn btn-warning btn-sm">
                  </form>
                  <form action="<?php echo htmlspecialchars('./delete.php'); ?>" class="d-inline" method="post">
                    <input type="hidden" name="task_id" value="<?php echo $task->task_id; ?>">
                    <input type="submit" value="Delete" name="delete" class="btn btn-danger btn-sm">
                  </form>
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
   

<?php require('./footer.php'); ?>