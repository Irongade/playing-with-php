<?php
include "../session.php";
include "../utils/sanitizeInput.php";
include "../utils/validator.php";
include "../server/dbconn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    startSession();
    $userEmail = readSessionValue("email");

    // if user is not logged in redirect to login.php
    if (!isset($userEmail)) {
        header("Location: ../login.php");
        die();
    }

    // santize all the form data fields.
    $tourId = sanitize_field($_POST['tourId']);
    $totalCost = sanitize_field($_POST['cost']);
    $date = sanitize_field($_POST['departure_date']);
    $numOfPeople = sanitize_field($_POST['people_count']);
    $notes = sanitize_field($_POST['notes']);

    // get sql connection
    $conn = getConnection();

    // fetch user information, as this is needed to create a booking
    $fetchUserSql = "SELECT * FROM users WHERE email = ?";

    $fetchUserStmt = mysqli_prepare($conn, $fetchUserSql);

    mysqli_stmt_bind_param($fetchUserStmt, "s", $userEmail);

    if (mysqli_stmt_execute($fetchUserStmt)) {
        $queryResult = mysqli_stmt_get_result($fetchUserStmt);

        $user = mysqli_fetch_assoc($queryResult);

        if ($user) {
            // create booking
            $bookTourSql = "INSERT into bookings (user_id, tour_id, total_cost, tour_date, no_of_guest, booking_notes) VALUES (?, ?, ?, ?, ?, ?)";

            $bookTourStmt = mysqli_prepare($conn, $bookTourSql);

            mysqli_stmt_bind_param($bookTourStmt, "iiisis", $user['id'], $tourId, $totalCost, $date, $numOfPeople, $notes);

            // if successful, redirect to alert page.
            if (mysqli_stmt_execute($bookTourStmt)) {
                header("Location: ../alert.php?type=success");
                die();
            } else {
                header("Location: ../dashboard.php");
                die();
            }
        }
    } else {
        header("Location: ../dashboard.php");
        die();
    }
}
