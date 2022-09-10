<?php
include('./config/db.php');
include('./action/core.php');


// Create Instance of core class
$obj = new dataOperaion;

include('./partials/session-manager.php');

if (isset($_GET['id'])) {
    $internship_id = mysqli_real_escape_string($obj->con, trim($_GET['id']));

    $details = $obj->fetchConditionally("internships", "id", $internship_id, 50);

    if (count($details) < 1) {
        header('location: ./index.php', http_response_code(400));
    }

    foreach ($details as $row) {
        $id = $row['id'];
        $title = $row['title'];
        $start_date = $row['start_date'];
        $end_date = $row['end_date'];
        $posted_by = $row['posted_by'];
        $duration = $row['duration'];
        $stipend = $row['stipend'];
        $duration_week = $row['duration_week'];
        $stipend_week = $row['stipend_week'];
        $about_internship = $row['about_internship'];
        $number_of_interns = $row['number_of_interns'];
        $who_can = $row['who_can'];
        $part_time_allowed = $row['part_time_allowed'];
        $posted_at = $row['posted_at'];
    }

    // We can have used join here as well 
    // Just done like this for simplicity

    // Fetch Company Details
    $company = $obj->fetchConditionally("employers", "id", $posted_by);
    foreach ($company as $employer) {
        $company_name = $employer['company_name'];
        $about_company = $employer['about'];
        $company_url = $employer['company_url'];
    }
}else{
    header('location: index.php', http_response_code(403));
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
    <link rel="stylesheet" href="./assets/css/style.css">

    <title>Intern-Connect | <?= $title ?> Internship > <?= $company_name ?> </title>
</head>

<body>
    <!-- Include Nav -->
    <?php include('./partials/nav.php'); ?>
    <div class="container">

        <div class="row py-3">
            <div class="col-md-10 m-auto">
                <?php if (isset($_SESSION['applied']) && $_SESSION['applied'] == 1) {
                    echo '<div class="row">
                        <div class="col-md-12 my-4">
                            <div class="alert alert-success" role="alert">
                                <h4 class="alert-heading">Application Successful!</h4>
                                <p>Your application is on its way</p>
                            </div>
                        </div>
                    </div>';
                    unset($_SESSION['applied']);
                } ?>
                <div class="card">
                    <div class="card-body">
                        <h4 class="py-2"><?= $title ?></h4>
                        <h6 class="card-subtitle mb-2 text-muted"><?= $company_name ?></h6>
                        <h6 class="card-subtitle my-4 text-muted">Location(s):
                            <?php
                            $sql = "SELECT * FROM internship_locations il INNER JOIN locations l ON il.location_id = l.id WHERE il.internship_id = $internship_id";
                            $locations = $obj->custom_query($sql);
                            foreach ($locations as $loc) {
                                echo $loc['city_name'] . ', ';
                            }
                            ?>
                        </h6>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr class="text-muted">
                                        <th>Start Date</th>
                                        <th>Duration</th>
                                        <th>Stipend</th>
                                        <th>Posted On</th>
                                        <th>Apply By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?= date('d M Y', strtotime($start_date)); ?></td>
                                        <td><?= $duration, $duration_week == 0?'<span> month(s)</span>':'<span> week(s)</span>' ?> </td>
                                        <td>Rs. <?= $stipend, $stipend_week == 0?'<span> month</span>':'<span> week</span>' ?></td>
                                        <td><?= date('d M Y', strtotime($posted_at)); ?></td>
                                        <td><?= date('d M Y', strtotime($end_date)); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-info"></div>
                </div>
            </div>
        </div>
        <!-- ./row -->
        <div class="row">
            <div class="col-md-10 m-auto">
                <div class="card">
                    <div class="card-body">
                        <p class="font-weight-bold">About <?= $company_name ?> <a href="<?= $company_url ?>">(<?= $company_url ?>)</a> </p>
                        <p><?= $about_company ?></p>
                        <p class="font-weight-bold">About Internship: </p>
                        <p><?= $about_internship ?></p>
                        <p class="font-weight-bold">Who Can apply?</p>
                        <p><?= $who_can ?></p>
                        <p class="font-weight-bold">Perks</p>
                        <p><?php
                            $sql = "SELECT * FROM internship_perks ip INNER JOIN perks p ON ip.perk_id = p.id WHERE ip.internship_id = $internship_id";
                            $perks = $obj->custom_query($sql);
                            foreach ($perks as $perk) {
                                echo '<b>' . $perk['perk'] . ', </b>';
                            }
                            ?></p>
                    </div>
                    <div class="text-center py-4">
                        <?php 
                            if(isset($_SESSION['employer']) && $_SESSION['employer'] == 1){

                            }elseif(isset($_SESSION['loggedin']) && $_SESSION['student'] == 1){
                                // Check if student has already aplied
                                $applied = $obj->custom_query("SELECT id FROM applied_internships WHERE student_id = '$student_id' AND internship_id = '$internship_id' ");
                                if(count($applied) > 0){
                                    echo '<button type="submit" class="btn btn-primary text-uppercase" disabled>Already Applied</button>';
                                }else{
                                    echo '
                                <form method="post" action="action/action.php">
                                    <input type="hidden" name="student_id" value="'.$student_id .'">
                                    <input type="hidden" name="internship_id" value="'.$internship_id.'">
                                    <button type="submit" name="apply" class="btn btn-primary text-uppercase">Apply Now</button>
                                </form>
                                ';
                                }
                            }else{
                                echo '
                                    <a href="student-auth.php" class="btn btn-primary text-uppercase">Login and Apply</a>
                                ';
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ./Container -->
    <?php include('./partials/footer.php'); ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>