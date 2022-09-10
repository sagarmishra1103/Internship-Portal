<?php
include('./config/db.php');
include('./action/core.php');


// Create Instance of core class
$obj = new dataOperaion;

include('./partials/employer-auth-control.php');
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

    <title>Intern-Connext | Internships that matter</title>
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
                    <p class="mb-0">You can now move to login and post internships for free! <a href="employer-auth.php"> Login</a></p>
                </div>
            </div>
        </div>';
            unset($_SESSION['employer_registration']);
        } ?>

        <div class="row">
            <div class="col-md-12">
                <h3 class="pt-3 text-center text-muted">Post an Internship</h3>
            </div>
        </div>
        <div class="row py-3">
            <div class="col-md-10 m-auto">
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="action/action.php">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" name="title" class="form-control" id="title" aria-describedby="titleHelp" placeholder="e.g. Web Development, Android Development" required maxlength="250">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="start_date">Start Date for Internship</label>
                                        <input type="date" name="start_date" class="form-control" id="start_date" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="end_date">Last Date for applying</label>
                                        <input type="date" name="end_date" class="form-control" id="end_date" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row my-3">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="location">Location of internship</label>
                                        <select name="locations[]" id="location" class="form-control select2" multiple="multiple" required>
                                            <?php
                                            $locations = $obj->fetch("locations");
                                            foreach ($locations as $location) {
                                                echo '<option value="' . $location['id'] . '">' . $location['city_name'] . ' (' . $location['city_state'] . ')' . '</option>';
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="duration">Duration</label>
                                        <input type="number" class="form-control" name="duration" id="duration" placeholder="Duration" required>
                                    </div>
                                </div>
                                <div class="col-md-2 mt-4">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="months" name="duration_week" value="0" class="custom-control-input" checked>
                                        <label class="custom-control-label" for="months">months</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="weeks" name="duration_week" value="1" class="custom-control-input">
                                        <label class="custom-control-label" for="weeks">weeks</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row my-3">
                                <div class="col-md-4 mb-3">
                                    <label for="stipend">Stipend</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroupPrepend">₹</span>
                                        </div>
                                        <input type="number" class="form-control" id="stipend" name="stipend" placeholder="Stipend" aria-describedby="inputGroupPrepend" required>
                                    </div>
                                </div>
                                <div class="col-md-3 mt-4">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="s_months" name="stipend_week" value="0" class="custom-control-input" checked>
                                        <label class="custom-control-label" for="s_months">months</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="s_weeks" name="stipend_week" value="1" class="custom-control-input">
                                        <label class="custom-control-label" for="s_weeks">weeks</label>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="interns">Number of Interns Required</label>
                                        <input type="number" name="number_of_interns" class="form-control" id="interns" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row my-3">
                                <div class="col-md-5">
                                    is part time allowed for this internship ?
                                </div>
                                <div class="col-md-7">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="regular" name="part_time" value="1" class="custom-control-input">
                                        <label class="custom-control-label" for="regular">yes</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="workfromhome" name="part_time" value="0" class="custom-control-input" checked>
                                        <label class="custom-control-label" for="workfromhome">no</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="skills">Skills Required</label>
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
                                        <label for="about">About this Internship</label>
                                        <textarea name="about_internship" id="about" class="form-control" rows="10" placeholder="Write a bit about this internship" required></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="who_can">Who can apply?</label>
                                        <textarea name="who_can" id="who_can" class="form-control" rows="10" placeholder="What characteristics you want in candidates?" required></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="perks">Perks Offered</label>
                                        <select name="perks[]" id="perks" class="form-control select2" multiple="multiple" required>
                                            <?php
                                            $perks = $obj->fetch("perks");
                                            foreach ($perks as $perk) {
                                                echo '<option value="' . $perk['id'] . '">' . $perk['perk'] . '</option>';
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- ID of Current user -->
                            <input type="hidden" value="<?= $employer_id ?>" name="company_id">
                            <button type="submit" name="add_internship" class="btn btn-primary float-right">Add Internship</button>
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