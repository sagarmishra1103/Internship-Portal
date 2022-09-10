<?php
include('./config/db.php');
include('./action/core.php');


// Create Instance of core class
$obj = new dataOperaion;

include('./partials/student-auth-control.php');
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

    <title>Intern-Connect | My Applications</title>
</head>

<body>
    <!-- Include Nav -->
    <?php include('./partials/nav.php'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="pt-3 text-center text-muted">My Applications</h3>
            </div>
        </div>
        <?php
        $sql = "SELECT ai.*, i.* FROM internships i INNER JOIN 
        applied_internships ai ON i.id = ai.internship_id INNER JOIN
        students s ON ai.student_id = s.id WHERE s.id = $student_id";
        $internships = $obj->custom_query($sql);
        if (count($internships) == 0) {
            echo '
            <div class="row py-3">
                <div class="col-md-10 m-auto">
                    <div class="card">
                        <div class="card-body">
                            <h3>You have not applied for any internship yet.</h3>
                            <hr>
                            <a class="text-info" href="index.php">APPLY FOR INTERNSHIP NOW</a>
                        </div>
                    </div>
                </div>
            </div>';
        }

        foreach ($internships as $row) {
            $internship_id = $row['internship_id'];
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

            $status = $row['application_status'];
            if($status == 'Applied'){
                $class = 'bg-secondary text-white';
            }elseif($status == 'In Touch'){
                $class = 'bg-warning text-white';
            }elseif($status == 'Shortlisted'){
                $class = 'bg-primary text-white';
            }elseif($status == 'Rejected'){
                $class = 'bg-danger text-white';
            }elseif($status == 'Selected'){
                $class = 'bg-success text-white';
            }

            // $company_name = $employer['company_name'];
            // $about_company = $employer['about'];
            // $company_url = $employer['company_url'];
            ?>

            <div class="row py-3">
                <div class="col-md-10 m-auto">
                    <div class="card">
                        <div class="card-header py-1 mb-0 <?= $class ?>">
                            <span>Status: <b><?= $status ?></b></span>
                        </div>
                        <div class="card-body">
                            <h4 class="py-2"><a href="internship-details.php?id=<?= $internship_id ?>"><?= $title ?></a></h4>
                        
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
                                            <td><?= $duration, $duration_week == 0 ? '<span> month(s)</span>' : '<span> week(s)</span>' ?> </td>
                                            <td>Rs. <?= $stipend, $stipend_week == 0 ? '<span> month</span>' : '<span> week</span>' ?></td>
                                            <td><?= date('d M Y', strtotime($posted_at)); ?></td>
                                            <td><?= date('d M Y', strtotime($end_date)); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer py-1">
                            <?php
                                if ($part_time_allowed == 0) {
                                    echo '<span class="text-muted float-left">full time</span>';
                                } else {
                                    echo '<span class="text-muted float-left">part time allowed</span>';
                                }
                                ?>
                            <a class="float-right text-info" href="internship-details.php?id=<?= $internship_id ?>">VIEW DETAILS</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <!-- Container -->
    <?php include('./partials/footer.php'); ?>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>