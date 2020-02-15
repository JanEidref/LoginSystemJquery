<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <link   rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" 
            integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="card card-signin my-5">
                    <div class="card-body">

                        <h5 class="card-title text-center">Sign In</h5>
                        <?php
                            if(isset($_SESSION['Error'])){
                                echo '<div class="row">';
                                echo '  <div id="alert" class="col-sm-12 mt-2">';
                                echo '      <div class="alert alert-danger">';
                                echo '          <strong>Error:</strong> '.$_SESSION['Error'];
                                echo '      </div>';
                                echo '  </div>';                    
                                echo '</div>';                    
                            }
                        ?>
                        <form action="modules/login/login.php" id="inputForm" class="form-signin" method="POST"> 
                            <div class="form-label-group">
                                <input type="text" id="userName" class="form-control" name="userName" placeholder="User Name" autocomplete="off" required autofocus>
                                <label for="userName">User Name</label>
                            </div>

                            <div class="form-label-group">
                                <input type="password" id="inputPassword" class="form-control" name="password" placeholder="Password" required>
                                <label for="inputPassword">Password</label>
                            </div>
                            <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Sign in</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</body>
</html>
<?php
    session_destroy();
?>