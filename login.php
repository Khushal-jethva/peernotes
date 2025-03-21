
<?php include('./layout/header.php');
include('./includes/dbconnection.php') ?>
<?php
// session_start();

$aemail = "admin1@gmail.com" ;
$apass = "admin" ;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(($email == $aemail) && ($password==$apass) ){
      header("Location: admin/index.php");
    }else {
    $sql = "SELECT * FROM user WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['approve'] = $row['approve'];

            if ($row['role'] == 'student') {
                header("Location: notes.php");
            } else {
                if($row['approve']== '1'){
                  header("Location: teacher1/index.php");
                }else{
                  echo "ask admin to approved you";
                }
                
            }
            // exit();
        } else {
            echo "Invalid credentials!";
        }
    } else {
        echo "User not found!";
    }

    $stmt->close();
}
}
?>


<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>


<!-- <div class="main-banner" id="top">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 style="color: white;">Notes</h1>
            </div>
        </div>
    </div>
</div> -->
<section class="vh-100" style="background-color: #7a6ad8;;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
      <form method="post">
        <div class="card shadow-2-strong" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">

            <h3 class="mb-5">LOGIN</h3>


           
   

 

   


            <div data-mdb-input-init class="form-outline mb-4">
            <!-- <label>Email:</label>
            <input type="email" name="email" required><br> -->

              <input type="email" id="typeEmailX-2" class="form-control form-control-lg" name="email" required />
              <label class="form-label" for="typeEmailX-2">Email</label>
            </div>

            <div data-mdb-input-init class="form-outline mb-4">
            <!-- <label>Password:</label>
            <input type="password" name="password" required><br> -->

              <input type="password" id="typePasswordX-2" class="form-control form-control-lg"  name="password" required/>
              <label class="form-label" for="typePasswordX-2">Password</label>
            </div>
            <button type="submit">Login</button>
            <!-- Checkbox -->
            <!-- <div class="form-check d-flex justify-content-start mb-4">
              <input class="form-check-input" type="checkbox" value="" id="form1Example3" />
              <label class="form-check-label" for="form1Example3"> Remember password </label>
            </div> -->

            <!-- <button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg btn-block" type="submit" style="background-color:  #7a6ad8;">Login</button> -->

            <hr class="my-4">

            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include('./layout/footer.php') ?>