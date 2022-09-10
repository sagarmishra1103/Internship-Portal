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

    <!-- custom stylesheet -->
    <link rel="stylesheet" href="./assets/css/style.css">

    <title>Karaamozi | Applications Received</title>
</head>

<body>
    <!-- Include Nav -->
    <?php include('./partials/nav.php'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="pt-3 text-center text-muted">Applications Received</h3>
            </div>
        </div>
        <?php
        $sql = "SELECT s.first_name, s.last_name, ai.internship_id, ai.student_id, ai.applied_on, ai.application_status, i.title, i.posted_by, i.posted_at
        FROM internships i INNER JOIN 
        applied_internships ai ON i.id = ai.internship_id INNER JOIN
        students s ON ai.student_id = s.id WHERE i.posted_by = $employer_id";
        $applications = $obj->custom_query($sql);
        if (count($applications) == 0) {
            echo '
            <div class="row py-3">
                <div class="col-md-10 m-auto">
                    <div class="card">
                        <div class="card-body">
                            <h3>You have not posted any internship yet.</h3>
                            <hr>
                            <a class="text-info" href="index.php">POST NTERNSHIP NOW</a>
                        </div>
                    </div>
                </div>
            </div>';
        } ?>
        <div class="row mb-5">
            <div class="col-md-10 m-auto py-2">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Posted On</th>
                                <th>Applied On</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($applications as $application) { ?>
                                <tr>
                                    <td><a href="internship-details.php?id=<?= $application['internship_id'] ?>"><?= $application['title'] ?></a></td>
                                    <td><?= $application['first_name'] . ' ' . $application['last_name'] ?></td>
                                    <td><?= $application['application_status'] ?></td>
                                    <td><?= date('d M Y', strtotime($application['posted_at'])) ?></td>
                                    <td><?= date('d M Y', strtotime($application['applied_on'])) ?></td>
                                    <td><a href="view-application.php?id=<?= $application['internship_id'] ?>&s_id=<?= $application['student_id'] ?>">view application</a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
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
</body>

</html>