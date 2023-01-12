<?php
require_once "../session.php";
require_once "../utils/sanitizeInput.php";
require_once "../utils/validator.php";
require_once "../server/dbconn.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $bookingId = sanitize_field($_GET['id']);
    $error = "";

    if (isset($bookingId)) {
        echo $bookingId;

        startSession();
        $userEmail = readSessionValue("email");

        $conn = getConnection();

        $fetchUserSql = "SELECT * FROM users WHERE email = ?";

        $fetchUserStmt = mysqli_prepare($conn, $fetchUserSql);

        mysqli_stmt_bind_param($fetchUserStmt, "s", $userEmail);

        if (mysqli_stmt_execute($fetchUserStmt)) {
            $queryResult = mysqli_stmt_get_result($fetchUserStmt);

            $user = mysqli_fetch_assoc($queryResult);

            if ($user) {
                $cancelBookingSql = "DELETE FROM bookings WHERE booking_id = ? AND user_id = ?";

                $cancelBookingStmt = mysqli_prepare($conn, $cancelBookingSql);

                mysqli_stmt_bind_param($cancelBookingStmt, "ii", $bookingId, $user['id']);

                if (mysqli_stmt_execute($cancelBookingStmt)) {
                    closeConnection($conn);
                } else {
                    $error = "?msg='Cancel booking failed.'";
                }
            }
        }
    }

    header("Location: ../dashboard.php$error");
    die();
}
