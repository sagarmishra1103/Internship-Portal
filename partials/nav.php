<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a href="index.php" class="pl-md-6rem brand-logo">
    <h4>Intern-Connect</h4>
    <!-- <img src="./assets/images/logo.svg" alt="Intern-Connect" style="height: 40px;"> -->
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav ml-md-auto pr-md-6rem">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Internships <span class="sr-only">(current)</span></a>
      </li>
      <?php
      if ($student_control == 0 && $employer_control == 1) {
        // if the user is employer
        echo '<li class="nav-item active">
      <a class="nav-link" href="post-internship.php">Post an Internship</a>
    </li>
    <li class="nav-item active">
      <a class="nav-link" href="my-internships.php">My Internships</a>
    </li>
    <li class="nav-item active">
      <a class="nav-link" href="applications-received.php">Applications</a>
    </li>
    <li class="nav-item active">
      <span class="nav-link text-muted" href="#">Hello, <b class="text-info">' . $first_name . '</b></span>
    </li>
    <li class="nav-item active">
      <a class="nav-link text-muted" href="logout.php">Logout</a>
    </li>
    ';
      } elseif ($student_control == 1 && $employer_control == 0) {
        // if the user is Student
        echo '<li class="nav-item active">
        <a class="nav-link" href="my-applications.php">My Applications</a>
      </li>
      <li class="nav-item active">
        <span class="nav-link text-muted" href="#">Hello, <b class="text-info">' . $first_name . '</b></span>
      </li>
      <li class="nav-item active">
        <a class="nav-link text-muted" href="logout.php">Logout</a>
      </li>
      ';
      } else {
        // Default View
        echo '<li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Login
      </a>
      <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
        <a class="dropdown-item" href="student-auth.php">Login as Student</a>
        <a class="dropdown-item" href="employer-auth.php">Login as Employer</a>
      </div>
    </li>';
    
    echo '<li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Register
      </a>
      <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
        <a class="dropdown-item" href="student-register.php">Register as Student</a>
        <a class="dropdown-item" href="employer-registration.php">Register as Employer</a>
      </div>
    </li>';
      }
      ?>
    </ul>
  </div>
</nav>