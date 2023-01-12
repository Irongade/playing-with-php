<!DOCTYPE html>
<html>

<head>
    <?php include "./components/htmlHeadTags.php" ?>
</head>

<body>

    <?php include "./components/header.php" ?>

    <?php
    require_once './session.php';

    restricted("./login.php")
    ?>
    <main>
        <section class="alert-container">

            <?php
            require_once "./utils/sanitizeInput.php";
            $imgPath = "";
            $alert_header = "";
            $alert_description = "";
            $btn_text = "";
            $redirect_to = "";

            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                $alertType =  sanitize_field(isset($_GET['type']) ? $_GET['type']  : "");

                // for 404 pages.
                if ($alertType == "404") {
                    $imgPath = "../assets/gifs/404.gif";
                    $alert_header = "";
                    $alert_description = "";
                } else if ($alertType == "success") {
                    $imgPath = "../assets/gifs/SuccessAnimation.gif";
                    $alert_header = "Congratulations!";
                    $alert_description = "You have successfully booked this tour.";
                } else {
                    $imgPath = "../assets/gifs/404.gif";
                    $alert_header = "";
                    $alert_description = "";
                }

                echo "<div class='alert__image_container'>
                        <img class='alert__image' src='{$imgPath}' alt='Alert gif animation' />
                    </div>

                    <div class='alert__info__container'>
                        <div class='alert__text__conatiner'>
                            <h1 class='alert__text__header'>{$alert_header}</h1>
                            <p class='alert__text__text'>{$alert_description}</p>
                        </div>

                        <div class='alert__btn__container'>
                            <a class='btn btn-primary' href='./dashboard.php'>
                                <span> Return to Dashboard </span>
                                <img class='btn-arrow' src='../assets/svgs/GoBack.svg' alt='Button arrow' />
                            </a>
                        </div>
                    </div>";
            }
            ?>
        </section>
    </main>
</body>

</html>