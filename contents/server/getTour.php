<?php
require_once "./server/dbconn.php";
require_once "./utils/sanitizeInput.php";

// fetch a specific tour or excursion information
function getTour()
{
    if ($_SERVER["REQUEST_METHOD"] == "GET") {

        // get connection
        $conn = getConnection();

        // get tour id from query Parameter.
        $tour_id =  $_GET['id'];

        // if tour id is not present, return null
        if (!isset($tour_id)) {
            return null;
        }

        // then sanitize the tour id incase of malicious attack through query parameters values.
        $sanitized_tour_id = sanitize_field($tour_id);

        $sql = "SELECT * FROM tours WHERE tourId = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {

            mysqli_stmt_bind_param($stmt, "s", $sanitized_tour_id);
            $queryResult = mysqli_stmt_execute($stmt);

            // if query is successful, return the tour information or a null value.
            if ($queryResult) {
                $result = mysqli_stmt_get_result($stmt);
                $tour = mysqli_fetch_assoc($result);
            } else {
                $tour = null;
            }
        } else {
            $tour = null;
        }

        // close the connection and return result;
        closeConnection($conn);
        return $tour;
    }
}
