
<?php
if (!isset($_SESSION)) {
    session_start();
}

if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == 1){
    header('location: ./index.php');
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- custom stylesheet -->
    <link rel="stylesheet" href="./assets/css/login.css">

    <title>Intern-Connect | Login as Employer</title>
</head>

<body class="text-center">


    <form class="form-signin" method="post" action="action/authentication.php">
        <?php if (isset($_SESSION['login_status']) && $_SESSION['login_status'] == 0) {
            echo '<div class="row">
            <div class="col-md-12 my-2">
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">Login Error!</h4>
                    <p>username or password is incorrect</p>
                    <hr>
                    <p class="mb-0">you want login as student? <a href="student-auth.php"> Login</a></p>
                </div>
            </div>
        </div>';
            unset($_SESSION['login_status']);
        } ?>
        <a href="index.php" class="brand-logo">
            <h4>Intern-Connect</h4>
            <!-- <img src="./assets/images/logo.svg" alt="Intern-Connect" style="height: 80px;"> -->
        </a>
        <div class="container shadow p-3 mb-5 bg-white rounded">
        <p class="text-muted">Employer Login</p>
        <h1 class="h3 mb-3 font-weight-normal">Login to Your Account</h1>
        <div class="form-group">
            <label for="email" class="sr-only">Email address</label>
            <input type="email" id="email" name="email_id" class="form-control" placeholder="Email address" required autofocus>
        </div>
        <div class="form-group">
            <label for="password" class="sr-only">Password</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <button class="btn btn-lg btn-primary btn-block mb-3" type="submit" name="employer_login">Sign in</button>
        <span>OR</span>
        <a href="employer-registration.php" class="btn btn-lg btn-dark btn-block mt-3">Register</a>
            
        </div>
       
    </form>
    </div>
    <!-- Container -->

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>