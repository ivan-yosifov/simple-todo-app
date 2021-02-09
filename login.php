<?php
session_start();
$title = 'Login';

// TODO: add logic that prevents logged users from accessing page
if(isset($_SESSION['user_id'])){
	header('Location: index.php');
	exit();
}

require_once './db.php';

if(isset($_POST['login'])){
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);

  $_SESSION['msg'] = array();

  // validate username
  if(strlen($username) < 3){
    array_push($_SESSION['msg'], [
      'class' => 'danger',
      'text' => 'Username must be at least 3 characters long'
    ]);
  }

  // validate password
  if(strlen($password) < 5){
    array_push($_SESSION['msg'], [
      'class' => 'danger',
      'text' => 'Password must be at least 5 characters long'
    ]);
  }

  if(empty($_SESSION['msg'])){
    // check if user exists
    $sql = "SELECT * FROM users WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':username' => $username]);

    if($stmt->rowCount() == 0){
    	array_push($_SESSION['msg'], [
        'class' => 'warning',
        'text' => 'Wrong username and/or password'
      ]);
    }else{
    	// check if password matches
    	$result = $stmt->fetch(PDO::FETCH_OBJ);
    	$hash_password = $result->password;

    	if(!password_verify($password, $hash_password)){
    		array_push($_SESSION['msg'], [
	        'class' => 'warning',
	        'text' => 'Wrong username and/or password'
	      ]);
    	}else{
    		// Log in user
    		unset($_SESSION['msg']);
    		$_SESSION['user_id'] = $result->id;
    		$_SESSION['username'] = $result->username;
        header('Location: index.php');
        exit();
    	}
    }
  }  
}
?>

<?php require('./header.php'); ?>
    <div class="center-form">
       <main class="form-signin">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
          <h1 class="h3 mb-3 fw-normal text-center">Please Login</h1>
          <?php if(isset($_SESSION['msg'])): ?>
          <?php foreach($_SESSION['msg'] as $msg): ?>
          <p class="alert alert-<?php echo $msg['class']; ?> py-2"><?php echo $msg['text']; ?></p>
          <?php endforeach; ?>
          <?php endif; ?>
          <label for="username" class="visually-hidden">Username</label>
          <input type="text" id="username" class="form-control" name="username" placeholder="Username" value="<?php if(isset($username)) echo $username; ?>" required autofocus>
          <label for="inputPassword" class="visually-hidden">Password</label>
          <input type="password" id="inputPassword" class="form-control" name="password" placeholder="Password" value="<?php if(isset($password)) echo $password; ?>" required>

          <button class="w-100 btn btn-lg btn-success" type="submit" name="login">Login</button>
        </form>
      </main>
    </div>
   

<?php require('./footer.php'); ?>
