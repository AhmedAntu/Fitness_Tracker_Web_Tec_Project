<?php
if (isset($_GET['error'])) {
  $error = $_GET['error'];
  if ($error == "invalid_user") {
    $errMsg = "Please type a valid username/password!";
  } elseif ($error == "badrequest") {
    $errMsg = "Please login first!";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Login - Fitness Tracker</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f2f2f2;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .box {
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      text-align: center;
      width: 280px;
    }

    h1 {
      margin-bottom: 20px;
      font-size: 20px;
      color: #333;
    }

    input[type="text"],
    input[type="password"] {
      width: calc(100% - 20px);
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    input[type="submit"] {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      border: none;
      border-radius: 5px;
      background: #4CAF50;
      color: white;
      cursor: pointer;
    }

    input[type="submit"]:hover {
      background: #45a049;
    }

    .error {
      color: red;
      margin-top: 15px;
    }
  </style>
</head>

<body>
  <div class="box">
    <h1>Fitness Tracker Login</h1>
    <form method="post" action="loginCheck.php">
      Username: <input type="text" name="username" value="" /> <br>
      Password: <input type="password" name="password" value="" /> <br>
      <input type="submit" name="submit" value="Login" />
    </form>
    <?php if (isset($errMsg)): ?>
      <p class="error"><?php echo $errMsg; ?></p>
    <?php endif; ?>
  </div>
</body>

</html>
