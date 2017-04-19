<?php
  $error = false;
  // Error - GET handler
  if (isset($_GET['error'])) {
    $error = true;
    switch ($_GET['error']) {
      case "1":
        $message = "Please provide your username and password to continue.";
        break;
      case "2":
        $message = "We can't match what you entered with our records. Please double check your credentials and try again.";
        break;
      default:
        $message = "An unknown error occured. Please try again later.";
    }
  }
  // Alexa - Get handler
  if (isset($_GET['state']) && isset($_GET['redirect_uri'])) {
    $alexa = true;
    $state = $_GET['state'];
    $redirect_uri = $_GET['redirect_uri'];
  } else {
    $alexa = false;
    $error = true;
    $message = "There was an issue in the request from Alexa - the account linking may not work. Please close the app and try again later.";
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link type="image/x-icon" href="https://www.allstate.com/favicon.ico" rel="shortcut icon">

    <title>Allstate - Login</title>

    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <link href="assets/css/main.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
      <div class="panel panel-default">
        <div class="panel-body">
          <img class="logo img-responsive center-block" src="img\all_grad_ver_4pro_pos.png" />

          <div class="page-header">
            <h1>Login <small>to Allstate</small></h1>
          </div>

          <?php
            if ($error == true) {
              ?>
              <div class="alert alert-danger">
                <?php echo $message ?>
              </div>
              <?php
            } else {
          ?>

          <form id="login" method="post" enctype="application/x-www-form-urlencoded" action="includes/post.php">
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" class="form-control" id="username" name="username" placeholder="Username">
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            </div>
            <?php if ($alexa == true) { ?>
              <input type="hidden" name="redirect_uri" value="<?php echo $redirect_uri ?>">
              <input type="hidden" name="state" value="<?php echo $state ?>">
            <?php } ?>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>

          <hr />
          <p>Need help logging in? Click <a href="https://myaccountrwd.allstate.com/anon/account/recover">here</a>.</p>

          <?php } ?>
        </div>
      </div>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
  </body>
</html>
