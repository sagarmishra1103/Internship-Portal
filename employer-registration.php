<?php
include('./partials/session-manager.php');
include('./config/db.php');
include('./action/core.php');

// Create Instance of core class
$obj = new dataOperaion;

?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Selec2 Plugin -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />

    <!-- custom stylesheet -->
    <link rel="stylesheet" href="./assets/css/style.css">

    <title>Intern-Connect | Internships that matter</title>
</head>

<body>
    <!-- Include Nav -->
    <?php include('./partials/nav.php'); ?>
    <div class="container">
        <?php if (isset($_SESSION['employer_registration']) && $_SESSION['employer_registration'] == 1) {
            echo '<div class="row">
            <div class="col-md-12 my-4">
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading">Registration Succesful!</h4>
                    <p>You successfully registered with us.</p>
                    <hr>
                    <p class="mb-0">You can now move to login and post internships ! <a href="employer-auth.php"> Login</a></p>
                </div>
            </div>
        </div>';
            unset($_SESSION['employer_registration']);
        } 
        // IF there is any error
        if (isset($_SESSION['duplicate_mobile']) || isset($_SESSION['duplicate_email'])) {
            echo '<div class="row">
            <div class="col-md-12 my-4">
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">Oops!</h4>
                    <p>There are one or more errors in your request</p>
                    <hr>
                    <p class="mb-0">Please cross check your email and mobile</p>
                </div>
            </div>
        </div>';
        } ?>

        <div class="row">
            <div class="col-md-12">
                <h3 class="pt-3 text-center text-muted">Register with us as Employer</h3>
            </div>
        </div>
        <div class="row py-3">
            <div class="col-md-10 m-auto">
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="action/action.php">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="first_name">First Name</label>
                                        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" requiredminlength="1" maxlength="50" pattern="[a-zA-Z]{1,50}" 
                                         oninvalid="this.setCustomValidity('First Name should contain only alphabets')" 
                                         oninput="this.setCustomValidity('')">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="last_name">Last Name</label>
                                        <input type="type" class="form-control" id="last_name" name="last_name" placeholder="Last Name" required maxlength="50" pattern="[a-zA-Z]{1,50}" 
                                         oninvalid="this.setCustomValidity('Last Name should contain only alphabets')" 
                                         oninput="this.setCustomValidity('')">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email_id" placeholder="Email ID" required maxlength="100">
                                        <?php if (isset($_SESSION['duplicate_email']) && $_SESSION['duplicate_email'] == 1) { ?>
                                            <small class="text-danger">Email ID is already registered!</small>
                                        <?php unset($_SESSION['duplicate_email']);
                                        } ?>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="password">Password</label>                                       
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required maxlength="20" minlength="6" pattern="[(?=.*\d)] [(?=.*[a-z])][(?=.*[A-Z])] {6,20}"}" 
                                         oninvalid="this.setCustomValidity('Password should contain atleast 6 characters')" 
                                         oninput="this.setCustomValidity('')">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mobile">Mobile</label>
                                        <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile" required maxlength="10" pattern="[0-9]{10}" 
                                         oninvalid="this.setCustomValidity('Enter the  10 digits Mobile Number')" 
                                         oninput="this.setCustomValidity('')">
                                        <?php if (isset($_SESSION['duplicate_mobile']) && $_SESSION['duplicate_mobile'] == 1) {  ?>
                                            <small class="text-danger">Mobile Number is already registered!</small>
                                        <?php unset($_SESSION['duplicate_mobile']);
                                        } ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="company_name">Company Name</label>
                                        <input type="text" name="company_name" id="company_name" class="form-control" placeholder="Name of Company" required maxlength="100">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="company_url">Company Url</label>
                                        <input type="text" name="company_url" id="company_url" class="form-control" placeholder="http://your-awesome-company.com" required maxlength="250">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="about_company">About Company</label>
                                        <textarea name="about" id="about_company" class="form-control" rows="7" placeholder="Write a bit about your company" required ></textarea>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" name="add_employer" class="btn btn-primary my-3 float-right">Save Details</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container -->
    <?php include('./partials/footer.php'); ?>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!-- Select2 Plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
    <!-- Jquery Validation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/additional-methods.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
            $('.select2-selection--single').css({
                "padding-top": "3px",
                "height": "38px"
            })
        });
    </script>
</body>

</html>