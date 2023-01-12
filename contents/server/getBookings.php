<?php
require_once "./session.php";
require_once "./utils/sanitizeInput.php";
require_once "./utils/validator.php";
require_once "./server/dbconn.php";

function getBookings()
{
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        startSession();
        $userEmail = readSessionValue("email");

        // get sql connection
        $conn = getConnection();

        // get user object, so we can extract user's id from it. which will then be used to fetch bookings made by the user.
        $fetchUserSql = "SELECT * FROM users WHERE email = ?";

        $fetchUserStmt = mysqli_prepare($conn, $fetchUserSql);

        mysqli_stmt_bind_param($fetchUserStmt, "s", $userEmail);

        if (mysqli_stmt_execute($fetchUserStmt)) {
            $queryResult = mysqli_stmt_get_result($fetchUserStmt);

            $user = mysqli_fetch_assoc($queryResult);

            if ($user) {
                // this sql statment selects all the bookings made by the user and gets more information of the bookings from the tours using the INNER JOIN.
                //  It also ensures that the tours returned are scheduled for dates in the future i.e. no past dates.
                $getBookingsSql = "SELECT * FROM bookings INNER JOIN tours ON bookings.tour_id = tours.tourId WHERE user_id = ? AND tour_date >= CURDATE()";

                $getBookingsStmt = mysqli_prepare($conn, $getBookingsSql);

                mysqli_stmt_bind_param($getBookingsStmt, "s", $user['id']);

                if (mysqli_stmt_execute($getBookingsStmt)) {

                    $result = mysqli_stmt_get_result($getBookingsStmt);
                    $bookings = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    closeConnection($conn);
                    return $bookings;
                }
            }
        } else {
            closeConnection($conn);
            return null;
        }
    }
}
