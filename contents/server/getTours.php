<?php
require_once __DIR__ . "/dbconn.php";
function getTours()
{
    if ($_SERVER["REQUEST_METHOD"] == "GET") {

        // get sql connection
        $conn = getConnection();

        $sql = "SELECT * FROM tours";

        if ($stmt = mysqli_prepare($conn, $sql)) {

            $queryResult = mysqli_stmt_execute($stmt);

            // fetch all tours.
            if ($queryResult) {
                $result = mysqli_stmt_get_result($stmt);
                $tours = mysqli_fetch_all($result, MYSQLI_ASSOC);
            } else {
                $tours = null;
            }
        } else {
            $tours = null;
        }

        // close connection and return tours.
        closeConnection($conn);
        return $tours;
    }
}
