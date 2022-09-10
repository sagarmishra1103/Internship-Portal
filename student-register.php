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

    <title>Intern-Connect | Register</title>
</head>

<body>
    <!-- Include Nav -->
    <?php include('./partials/nav.php'); ?>
    <div class="container">
    <?php if (isset($_SESSION['student_registration']) && $_SESSION['student_registration'] == 1) {
            echo '<div class="row">
            <div class="col-md-12 my-4">
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading">Registration Succesful!</h4>
                    <p>You successfully registered with Intern-Connect.</p>
                    <hr>
                    <p class="mb-0">You can now move to login and check out internships that suit you ! <a href="student-auth.php"> Login</a></p>
                </div>
            </div>
        </div>';
            unset($_SESSION['student_registration']);
        } ?>
        <div class="row">
            <div class="col-md-12">
                <h3 class="pt-3 text-center text-muted">Register to apply for internships</h3>
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
                                        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" required minlength="1" maxlength="50" pattern="[a-zA-Z]{1,50}" 
                                         oninvalid="this.setCustomValidity('First Name should contain only alphabets')" 
                                         oninput="this.setCustomValidity('')">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="last_name">Last Name</label>
                                        <input type="type" class="form-control" id="last_name" name="last_name" placeholder="Last Name" maxlength="50" pattern="[a-zA-Z]{1,50}" 
                                         oninvalid="this.setCustomValidity('Last Name should contain only alphabets')" 
                                         oninput="this.setCustomValidity('')">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Email ID" required >
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
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mobile">Mobile</label>
                                        <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile" required maxlength="10" pattern="[0-9]{10}" 
                                         oninvalid="this.setCustomValidity('Enter the  10 digits Mobile Number')" 
                                         oninput="this.setCustomValidity('')">
                                       
                                        <?php  if (isset($_SESSION['duplicate_mobile']) && $_SESSION['duplicate_mobile'] == 1) { ?>
                                            <small class="text-danger">Mobile Number is already registered!</small>
                                        <?php unset($_SESSION['duplicate_mobile']);
                                        } ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="gender">Gender</label>
                                        <select name="gender" id="gender" class="form-control" required>
                                            <option value="male" checked>Male</option>
                                            <option value="female">Female</option>
                                            <option value="other" checked>Other</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="address1">Address 1</label>
                                        <textarea name="address1" id="address1" class="form-control" placeholder="Building/Street/" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="address2">Address 2</label>
                                        <textarea name="address2" id="address2" class="form-control" placeholder="City/State"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="pincode">Pincode</label>
                                        <input type="number" name="pincode" id="pincode" class="form-control" placeholder="Pincode" required minlength="6">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="skills">Skills</label>
                                        <select name="skills[]" id="skills" class="form-control select2" multiple="multiple" required>
                                            <?php
                                            $skills = $obj->fetch("skills");
                                            foreach ($skills as $skill) {
                                                echo '<option value="' . $skill['id'] . '">' . $skill['skill_name'] . '</option>';
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="projects">Projects that you have done</label>
                                        <textarea name="projects" id="projects" class="form-control" rows="7" placeholder="Write a bit about your projects and provide the links as well"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">Education</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="highest_edu">Highest Qualification</label>
                                                <select name="highest_edu" id="highest_edu" class="form-control select2" required>
                                                    <?php
                                                    $qualifications = $obj->fetch("education");
                                                    foreach ($qualifications as $education) {
                                                        echo '<option value="' . $education['id'] . '">' . $education['degree'] . '</option>';
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="percentage">Percentage</label>
                                                <input type="number" class="form-control" name="percentage" id="percentage" placeholder="Marks percentage" min="0" max="100" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label for="institute">Institute Name</label>
                                                <input type="text" class="form-control" id="institute" name="institute" placeholder="Name of last institution you attended" required maxlength="250" pattern="[a-zA-Z]{1,150}" 
                                         oninvalid="this.setCustomValidity('Institute name should contain only alphabets')" 
                                         oninput="this.setCustomValidity('')">       
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="institute_state">Institute State</label>
                                                <select name="institute_state" id="institute_state" class="form-control select2" required>
                                                    <?php
                                                    $states = $obj->fetch("indian_states");
                                                    foreach ($states as $state) {
                                                        echo '<option value="' . $state['id'] . '">' . $state['state'] . '</option>';
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" name="add_student" class="btn btn-primary my-3 float-right">Save Details</button>
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