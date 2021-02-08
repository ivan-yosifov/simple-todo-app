<?php
session_start();

// TODO: add logic that prevents logged users from accessing page

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
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
          <ul class="navbar-nav me-auto mb-2 mb-md-0">
            <li class="nav-item active">
              <a class="nav-link" aria-current="page" href="./index.php">Todo</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Link</a>
            </li>
          </ul>
          <ul class="navbar-nav">
            <li class="nav-item">
              <a href="./register.php" class="btn btn-outline-primary me-2">Register</a>
            </li>
            <li class="nav-item">
              <a href="./login.php" class="btn btn-outline-success">Login</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
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
   

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
  </body>
</html>
<?php
if(isset($_SESSION['msg'])){
  unset($_SESSION['msg']);
}
?>
