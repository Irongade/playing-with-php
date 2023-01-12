<!DOCTYPE html>
<html lang="en">

<head>
  <?php include "./components/htmlHeadTags.php" ?>
</head>

<body>
  <?php include "./components/header.php" ?>

  <?php
  include "./utils/sanitizeInput.php";
  include "./utils/validator.php";
  include "./server/dbconn.php";

  $email = $password = "";
  // the $error variable is used for general errors.
  $emailErr = $passwordErr = $error = "";

  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $errorMsg = $_GET['error'];

    if (isset($errorMsg)) {
      $error = "The requested page is only available to logged in users, kindly login or register to access the page.";
    }
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "It runs!!";
    if (empty($_POST["email"])) {
      $emailErr = "Email cannot be empty.";
    } else {
      $email = sanitize_field($_POST["email"]);
      $isValid = validate($email, FILTER_SANITIZE_EMAIL);
      if (!$isValid) {
        $emailErr = "Email not valid.";
      }
    }

    if (empty($_POST["password"])) {
      $passwordErr = "Password cannot be empty.";
    } else {
      $password = sanitize_field($_POST["password"]);
      $isValid = validate_password($password);
      if (!$isValid) {
        $passwordErr = "Password must contain one digit from 1 to 9, one lowercase letter, one uppercase letter, one special character, no space, and it must be 8-16 characters long.";
      }
    }

    // if there are no errors, proceed with the sql queries
    if ($emailErr == "" && $passwordErr == "") {
      $conn = getConnection();

      $sql = "SELECT * FROM users WHERE email = ?";

      if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        $isSuccess = mysqli_stmt_execute($stmt);

        if ($isSuccess) {
          $queryResult = mysqli_stmt_get_result($stmt);

          $user = mysqli_fetch_assoc($queryResult);

          if ($user) {
            $passwordHash = $user['password'];

            if (password_verify($password, $passwordHash)) {
              startSession();

              setSessionValue("email", $user['email']);
              setSessionValue("firstname", $user['firstname']);

              // close the connection
              mysqli_close($conn);
              // redirect to dashboard
              header("Location: ./dashboard.php");
              // exit.
              die();
            } else {
              $error = "It looks like you may have entered incorrect/invalid credentials. Please try again or reset password using the button below.";
            }
          } else {
            $error = "The user with these credentials does not exist. Please try again or create a new account using the button below.";
          }
        } else {
          $error = "Something went wrong.";
        }
      } else {
        echo "Prepared statement could not be constructed";
      }

      mysqli_close($conn);
    }
  }
  ?>
  <main>
    <section class="auth-section">
      <form method="post" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="auth-form-header">
          <?php include "./components/AuthFormAnimation.php" ?>
          <h4 class="banner__heading heading-4">Sign into your account.</h4>
          <?php if ($error != "") {
            echo "<p class='form-header-error'>{$error}</p>";
          }
          ?>
        </div>
        <div class="input-container">
          <input class="input" type="email" name="email" id="email" placeholder="Enter your email" />
          <label class="label_floating" for="email">Email</label>
          <?php if ($emailErr != "") {
            echo "<p class='form-error'>* {$emailErr}</p>";
          }
          ?>
        </div>

        <div class="input-container">
          <input class="input" type="password" name="password" id="password" placeholder="Enter your password" />
          <label class="label_floating" for="password">Password</label>
          <?php if ($passwordErr != "") {
            echo "<p class='form-error'>* {$passwordErr}</p>";
          }
          ?>
        </div>

        <div class="btn-container max-width">
          <button class="btn btn-primary center-btn-text">
            <span>SIGN IN</span>
          </button>
        </div>
        <div class="auth-subtext-container">
          <p><a href="forgot-password.php">Forgot password? </a></p>
          <p><a href="register.php">Create new account </a></p>
        </div>
      </form>
    </section>
  </main>
</body>

</html>