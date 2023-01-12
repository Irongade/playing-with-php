<?php
function validate($val, $validationType)
{
    if (filter_var($val, $validationType)) {
        return filter_var($val, $validationType);
    } else {
        return false;
    }
}

// special validator function for passwords using regex.
function validate_password($val)
{
    $passwordRegex = "/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*\W)(?!.* ).{8,16}$/";
    if (preg_match($passwordRegex, $val)) {
        return true;
    } else {
        return false;
    }
}
