<?php

function sanitize_field($str)
{
    // remove different characters from both sides of the string e.g. \n
    $str = trim($str);
    // remove any slash character \
    $str = stripslashes($str);
    // remove any html special characters
    $str = htmlspecialchars($str);
    return $str;
}
