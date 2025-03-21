<?php include('./layout/header.php'); include('./includes/dbconnection.php'); ?>
<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO user (name, email, password, actual_password, role) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $email, $hashed_password, $password, $role);

    if ($stmt->execute()) {
        echo "Registration successful! ";
        header("Refresh: 2; url=/peerotes/login.php");
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}
?>
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <style>
    .form-label {
      font-weight: bold;
    }
    .form-control {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
    }
    select.form-control {
      width: 100%;
    }
    .btn-submit {
      width: 100%;
      padding: 10px;
      background-color: #7a6ad8;
      color: white;
      border: none;
      border-radius: 5px;
      font-size: 16px;
    }
    .btn-submit:hover {
      background-color: #5e4fa4;
    }
  </style>
</head>




<section class="vh-100" style="background-color: #7a6ad8;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card shadow-2-strong" style="border-radius: 1rem; margin-top: 60px;">

          <div class="card-body p-5 text-center" >

            <h3 class="mb-5">SIGN UP</h3>

            <form method="post">
              <div class="form-group">
                <label for="name" class="form-label">Name:</label>
                <input type="text" name="name" class="form-control" id="name" required>
              </div>

              <div class="form-group">
                <label for="email" class="form-label">Email:</label>
                <input type="email" name="email" class="form-control" id="email" required>
              </div>

              <div class="form-group">
                <label for="password" class="form-label">Password:</label>
                <input type="password" name="password" class="form-control" id="password" required>
              </div>

              <div class="form-group">
                <label for="role" class="form-label">Role:</label>
                <select name="role" class="form-control" id="role">
                <option value="student">Select</option>
                  <option value="student">Student</option>
                  <option value="teacher">Teacher</option>
                </select>
              </div>

              <button type="submit" class="btn-submit">Register</button>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include('./layout/footer.php'); ?>
