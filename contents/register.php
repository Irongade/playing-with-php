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
  $firstname = $email = $lastname = $password = $passwordConfirm = "";
  // the $error variable is used for general errors.
  $firstnameErr = $emailErr = $lastnameErr = $passwordErr = $passwordConfirmErr = $error = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["firstname"])) {
      $firstnameErr = "Firstname cannot be empty";
    } else {
      $firstname = sanitize_field($_POST["firstname"]);
    }

    if (empty($_POST["lastname"])) {
      $lastnameErr = "Lastname cannot be empty";
    } else {
      $lastname = sanitize_field($_POST["lastname"]);
    }

    if (empty($_POST["email"])) {
      $emailErr = "Email cannot be empty";
    } else {
      $email = sanitize_field($_POST["email"]);
      $isValid = validate($email, FILTER_SANITIZE_EMAIL);
      if (!$isValid) {
        $emailErr = "Email not valid.";
      }
    }

    if (empty($_POST["password"])) {
      $passwordErr = "Password cannot be empty";
    } else {
      $password = sanitize_field($_POST["password"]);
      $isValid = validate_password($password);
      if (!$isValid) {
        $passwordErr = "Password must contain one digit from 1 to 9, one lowercase letter, one uppercase letter, one special character, no space, and it must be 8-16 characters long.";
      }
    }

    if (empty($_POST["passwordConfirm"])) {
      $passwordConfirmErr = "Password confirmation cannot be empty";
    } else {
      $passwordConfirm = sanitize_field($_POST["passwordConfirm"]);

      $isValid = validate_password($password);
      if (!$isValid) {
        $passwordConfirmErr = "Confirm Password must contain one digit from 1 to 9, one lowercase letter, one uppercase letter, one special character, no space, and it must be 8-16 characters long.";
      }

      if ($passwordConfirmErr == "" && $passwordConfirm !== $password) {
        $passwordConfirmErr = "Password confirmation does not match password.";
      }
    }

    // if there are no errors, proceed with the sql queries
    if ($emailErr == "" && $passwordErr == "" && $firstnameErr == "" && $lastnameErr == "" && $passwordConfirmErr == "") {
      $hashed_password = password_hash($password, PASSWORD_BCRYPT);

      $conn = getConnection();

      $sql = "INSERT INTO users (firstname, lastname, email, password)VALUES (?, ?, ?, ?)";

      if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssss", $firstname, $lastname, $email, $hashed_password);
        $isSuccess = mysqli_stmt_execute($stmt);

        if ($isSuccess) {
          startSession();
          setSessionValue("email", $email);
          setSessionValue("firstname", $firstname);

          // close the connection
          mysqli_close($conn);
          // redirect to dashboard
          header("Location: ./dashboard.php");
          // exit.
          die();
        } else {
          $error = "Email already exists. Please try again or log into your account using the button below.";
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

          <h4 class="banner__heading heading-4">Create a new account.</h4>
          <?php if ($error != "") {
            echo "<p class='form-header-error'>{$error}</p>";
          }
          ?>
        </div>

        <div class="input-container">
          <input class="input" type="text" name="firstname" id="firstname" placeholder="Enter your first name" />
          <label class="label_floating" for="firstname">First Name</label>
          <?php if ($firstnameErr != "") {
            echo "<p class='form-error'>* {$firstnameErr}</p>";
          }
          ?>
        </div>

        <div class="input-container">
          <input class="input" type="text" name="lastname" id="lastname" placeholder="Enter your last name" />
          <label class="label_floating" for="lastname">Last name</label>
          <?php if ($lastnameErr != "") {
            echo "<p class='form-error'>* {$lastnameErr}</p>";
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
          <input class="input" type="password" name="password" id="password" placeholder="Enter your password (min 6 chars)" />
          <label class="label_floating" for="password">Password</label>
          <?php if ($passwordErr != "") {
            echo "<p class='form-error'>* {$passwordErr}</p>";
          }
          ?>
        </div>

        <div class="input-container">
          <input class="input" type="password" name="passwordConfirm" id="passwordConfirm" placeholder="Enter your password confirmation (min 6 chars)" />
          <label class="label_floating" for="passwordConfirm">Confirm Password</label>
          <?php if ($passwordConfirmErr != "") {
            echo "<p class='form-error'>* {$passwordConfirmErr}</p>";
          }
          ?>
        </div>

        <div class="btn-container max-width">
          <button class="btn btn-primary center-btn-text">
            <span>SIGN UP</span>
          </button>
        </div>
        <div class="auth-subtext-container">
          <p>Already have an account?: <a href="login.php">Sign in </a></p>
        </div>
      </form>
    </section>
  </main>
</body>

</html>