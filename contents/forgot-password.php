<!DOCTYPE html>
<html lang="en">

<head>
  <?php include "./components/htmlHeadTags.php" ?>
</head>

<body>
  <?php include "./components/header.php" ?>

  <?php
  require_once "./utils/sanitizeInput.php";
  require_once "./utils/validator.php";
  require_once "./server/dbconn.php";
  require_once "./session.php";

  $email = $passwordNew = $passwordOld = "";
  $emailErr = $passwordNewErr = $passwordOldErr = $error = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["email"])) {
      $emailErr = "Email cannot be empty.";
    } else {
      $email = sanitize_field($_POST["email"]);
      $isValid = validate($email, FILTER_SANITIZE_EMAIL);
      if (!$isValid) {
        $emailErr = "Email not valid.";
        return;
      }
    }

    if (empty($_POST["passwordOld"])) {
      $passwordOldErr = "Old password cannot be empty.";
    } else {
      $isValid = validate_password($passwordOld);
      $passwordOld = sanitize_field($_POST["passwordOld"]);
      if (!$isValid) {
        $passwordOldErr = "Old Password must contain one digit from 1 to 9, one lowercase letter, one uppercase letter, one special character, no space, and it must be 8-16 characters long.";
      }
    }

    if (empty($_POST["passwordNew"])) {
      $passwordNewErr = "New password cannot be empty.";
    } else {
      $isValid = validate_password($passwordNew);
      $passwordNew = sanitize_field($_POST["passwordNew"]);
      if (!$isValid) {
        $passwordNewErr = "Password must contain one digit from 1 to 9, one lowercase letter, one uppercase letter, one special character, no space, and it must be 8-16 characters long.";
      }
    }

    if ($emailErr == "" && $passwordOldErr == "" && $passwordNewErr == "") {
      $conn = getConnection();

      $sql = "SELECT * FROM users WHERE email = ?";

      if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $email);

        if (mysqli_stmt_execute($stmt)) {
          $queryResult = mysqli_stmt_get_result($stmt);

          $user = mysqli_fetch_assoc($queryResult);

          if ($user) {
            //get current password hash
            $passwordHash = $user['password'];

            // verify the old password matches the user's previous password
            if (password_verify($passwordOld, $passwordHash)) {
              // if password matches, hash the new password, prepare the sql query to update it, then execute it.
              $updateSql = "UPDATE users SET password = ? WHERE email = ?";
              $updateStmt = mysqli_prepare($conn, $updateSql);
              $hashed_new_password = password_hash($passwordNew, PASSWORD_BCRYPT);

              mysqli_stmt_bind_param($updateStmt, "ss", $hashed_new_password, $email);

              if (mysqli_stmt_execute($updateStmt)) {

                startSession();
                $isUserLoggedIn = readSessionValue("email");

                // if user is logged in, log them out and make them log in again with new password as a security measure.
                if ($isUserLoggedIn) {
                  clearAllSessionValues();
                }

                header("Location: ./login.php");
                die();
              } else {
                echo "It fails";
              }
            } else {
              $error = "It looks like you may have entered incorrect/invalid credentials. Please try again or reset password using the button below.";
            }
          } else {
            $error = "The user with these credentials does not exist.";
          }

          // echo "Works";
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
          <h4 class="banner__heading heading-4">Reset your password.</h4>
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
          <input class="input" type="password" name="passwordOld" id="passwordOld" placeholder="Enter your old password" />
          <label class="label_floating" for="password">Old Password</label>
          <?php if ($passwordOldErr != "") {
            echo "<p class='form-error'>* {$passwordOldErr}</p>";
          }
          ?>
        </div>

        <div class="input-container">
          <input class="input" type="password" name="passwordNew" id="passwordNew" placeholder="Enter your new password" />
          <label class="label_floating" for="password">New Password</label>
          <?php if ($passwordNewErr != "") {
            echo "<p class='form-error'>* {$passwordNewErr}</p>";
          }
          ?>
        </div>

        <div class="btn-container max-width">
          <button class="btn btn-primary center-btn-text">
            <span>RESET PASSWORD</span>
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