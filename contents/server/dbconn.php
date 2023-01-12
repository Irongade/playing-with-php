<?php

function getConnection()
{
    $conn = mysqli_connect("localhost", "unn_w22038122", "Omoayan1997", "unn_w22038122") or die("Cannot connect to DB");

    return $conn;
};

function closeConnection($conn)
{
    return mysqli_close($conn);
}
