<?php
include('./config/db.php');
include('./action/core.php');


// Create Instance of core class
$obj = new dataOperaion;

include('./partials/employer-auth-control.php');

if (isset($_GET['id']) && isset($_GET['s_id'])) {
    $internship_id = mysqli_real_escape_string($obj->con, trim($_GET['id']));
    $student_id = mysqli_real_escape_string($obj->con, trim($_GET['s_id']));
    // Fetch the internship details
    $sql = "SELECT * FROM internships i INNER JOIN applied_internships ai
     ON i.id = ai.internship_id WHERE ai.internship_id = '$internship_id' AND i.posted_by = '$employer_id' AND ai.student_id = '$student_id' ";

    $internships = $obj->custom_query($sql);

    // Fetch the student details who applied
    $query = "SELECT * FROM students s INNER JOIN applied_internships ai
    ON s.id = ai.student_id WHERE ai.student_id = '$student_id' AND ai.internship_id = '$internship_id' ";

    $students = $obj->custom_query($query);
} else {
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

    <title>Intern-Connect | View Application</title>
</head>

<body>
    <!-- Include Nav -->
    <?php include('./partials/nav.php'); ?>
    <div class="container">

        <div class="row py-3">
            <div class="col-md-10 m-auto">
                <?php if (count($internships) < 1 || count($students) < 1) {
                    echo '<div class="row text-center py-5">
                        <div class="col-md-12 my-4">
                            <div class="alert alert-danger py-5" role="alert">
                                <h1>400</h1>
                                <h4 class="alert-heading">Oops!</h4>
                                <p>That\'s an error</p>
                            </div>
                        </div>
                    </div>';
                    unset($_SESSION['internship_added']);
                    return false;
                }
                foreach ($internships as $internship) { ?>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="py-2"><?= $internship['title'] ?><span class="float-right">Current Status: <b><?= $internship['application_status'] ?></b></span></h4>
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
                                            <td><?= date('d M Y', strtotime($internship['start_date'])); ?></td>
                                            <td><?= $internship['duration'], $internship['duration_week'] == 0 ? '<span> month(s)</span>' : '<span> week(s)</span>' ?> </td>
                                            <td>Rs. <?= $internship['stipend'], $internship['stipend_week'] == 0 ? '<span> month</span>' : '<span> week</span>' ?></td>
                                            <td><?= date('d M Y', strtotime($internship['posted_at'])); ?></td>
                                            <td><?= date('d M Y', strtotime($internship['end_date'])); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <!-- ./row -->
        <?php
        foreach ($students as $student) { ?>
            <div class="row">
                <div class="col-md-10 m-auto">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <h4>Details of Student</h4>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <span class="float-left font-weight-bold">Name</span>
                                            <span class="float-right">
                                                <?= $student['first_name'] . ' ' . $student['last_name'] ?>
                                            </span>
                                        </li>
                                        <li class="list-group-item">
                                            <span class="float-left font-weight-bold">Email ID</span>
                                            <span class="float-right"><?= $student['email_id'] ?></span>
                                        </li>
                                        <li class="list-group-item">
                                            <span class="float-left font-weight-bold">Gender</span>
                                            <span class="float-right"><?= $student['gender'] ?></span>
                                        </li>
                                        <li class="list-group-item">
                                            <span class="float-left font-weight-bold">Mobile No.</span>
                                            <span class="float-right"><?= $student['mobile'] ?></span>
                                        </li>

                                        <li class="list-group-item">
                                            <span class="float-left font-weight-bold">Projects: </span><br>
                                            <p><?= $student['projects'] ?></p>
                                        </li>

                                    </ul>
                                </div>
                                <!-- ./col8 -->
                                <div class="col-md-4 text-center">
                                    <h4>Action</h4>
                                    <small>Click any of the buttons to change the status</small>
                                    <form action="action/action.php" method="post">
                                        <?php if ($internship['application_status'] == 'Rejected' || $internship['application_status'] == 'Selected') {
                                                echo '<b>'.$internship['application_status'].'</b>';
                                            } else { ?>
                                            <input type="hidden" name="student_id" value="<?= $student_id ?>">
                                            <input type="hidden" name="internship_id" value="<?= $internship_id ?>">
                                            <button type="submit" name="shortlist" class="btn btn-outline-primary my-2">Shortlisted</button><br>
                                            <button type="submit" name="in_touch" class="btn btn-outline-warning my-2">In Touch</button><br>
                                            <button type="submit" name="selected" class="btn btn-outline-success my-2">Selected</button><br>
                                            <button type="submit" name="rejected" class="btn btn-outline-danger my-2">Rejected</button><br>
                                        <?php } ?>
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h3>Skills</h3>
                                    <p><?php
                                            $sql = "SELECT s.skill_name FROM student_skills ss INNER JOIN skills s ON ss.skill_id = s.id WHERE ss.student_id = $student_id";
                                            $skills = $obj->custom_query($sql);
                                            foreach ($skills as $skill) {
                                                echo $skill['skill_name'] . ', ';
                                            }
                                            ?></p>
                                </div>
                            </div>

                            <div class="row py-3">
                                <div class="col-md-12">
                                    <h3>Education</h3>
                                    <p><?php
                                            $sql = "SELECT * FROM student_education se INNER JOIN
                                             education e ON se.highest_edu = e.id
                                             INNER JOIN indian_states ins ON se.institute_state = ins.id
                                             WHERE se.student_id = $student_id";
                                            $education = $obj->custom_query($sql);
                                            foreach ($education as $edu) { ?>

                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item">
                                                    <span class="float-left font-weight-bold">Highest Education</span>
                                                    <span class="float-right">
                                                        <?= $edu['degree'] ?>
                                                    </span>
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="float-left font-weight-bold">Institute</span>
                                                    <span class="float-right"><?= $edu['institute'] ?></span>
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="float-left font-weight-bold">Percentage</span>
                                                    <span class="float-right"><?= $edu['percentage'] ?></span>
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="float-left font-weight-bold">Institute State</span>
                                                    <span class="float-right"><?= $edu['state'] ?></span>
                                                </li>

                                            <?php } ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

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