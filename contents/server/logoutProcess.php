<?php
include "../session.php";
// start session
startSession();

$isUserLoggedIn = readSessionValue("email");
// ensure only logged in users can clear session
if ($isUserLoggedIn) {
    clearAllSessionValues();

    // redirect to index page.
    header("Location: ../index.php");
} else {
    return;
}
