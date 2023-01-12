<?php
// start session.
function startSession()
{
    if (session_status() == PHP_SESSION_NONE) {
        ini_set("session.save_path", "/home/unn_w22038122/sessionData");
        session_start();
    }
}

// set a particular session value
function setSessionValue($sessionName, $sessionValue)
{
    if (session_status() == PHP_SESSION_NONE) {
        echo "Session does not exist.";
        return;
    }
    $_SESSION[$sessionName] = $sessionValue;
}

// read a specific session value and return it.
function readSessionValue($sessionName)
{
    if (isset($_SESSION[$sessionName])) {
        return $_SESSION[$sessionName];
    } else {
        return null;
    }
}

// remove a specific session value.
function removeSessionValue($sessionName)
{
    if (isset($_SESSION[$sessionName])) {
        unset($_SESSION[$sessionName]);
        return true;
    } else {
        return null;
    }
}

// clear session values.
function clearAllSessionValues()
{
    session_unset();
    session_destroy();
    return;
}

// restricting user access for pages.
function restricted($redirectPage)
{
    startSession();
    $isUserLoggedIn = readSessionValue("email");

    // if user is not logged in, redirect to 'redirectPage'
    if (!$isUserLoggedIn) {
        header("Location: $redirectPage");
        die();
    }
}
