<!DOCTYPE html>
<html>

<head>
    <?php include "./components/htmlHeadTags.php" ?>
</head>

<body>

    <?php include "./components/header.php" ?>

    <main>
        <section class="dashboard-container">

            <?php
            require_once "./session.php";
            // restricted page.
            restricted('./login.php?error="restricted"');

            $firstName = readSessionValue('firstname');

            $displayName = isset($firstName) ? $firstName : "Customer";

            echo "<div class='dashboard__name__container'> 
                    <div class='dashboard-name'>
                        <div>
                            <h2>Hello {$displayName}, </h2>
                        </div>
                    </div> 
                    <div>
                        <a class='btn btn-primary' href='./server/logoutProcess.php'>
                            <span> Log out</span>
                        </a>
                    </div>
                </div>";
            ?>

            <div class='dashboard-header'>
                <div>
                    <h2>Your Bookings</h2>
                </div>
                <hr class='dashboard_line'>
            </div>

            <?php
            include "./server/getBookings.php";

            $bookings = getBookings();

            if (!isset($bookings) || count($bookings) < 1) {
                echo "
                    <div class='no_bookings_container'>
                        <div class='booking__icon'>
                            <img src='../assets/svgs/Info.svg' alt='Location icon' />
                        </div>
                        <p> You have not made any bookings yet.</p>
                    </div>
                ";
            }

            if (isset($bookings)) {
                echo '<div class="bookings-list">';
                foreach ($bookings as $booking) {

                    $noOfGuests = $booking['no_of_guest'];
                    $noOfGuests = $noOfGuests == 1 ? "$noOfGuests guest" : "$noOfGuests guests";

                    echo "<div class='card'>
                    <div class='card__header'>
                        <div class='card__heading-container'>
                            <h3 class='card__heading-text heading-4'>{$booking['name']}</h3>
                        </div>
                        <div class='card__picture'>
                            <img class='card__picture-img' src='../assets/imgs/{$booking['imagePath']}.jpeg' alt='Card item image' loading='lazy' />
                        </div>
                    </div>
                    <div class='card__details'>
                        <h4 class='card__header'>{$booking['name']}</h4>
                        <div class='card__text'>
                            <div class='truncate__line'>
                                <p class='card__description'>
                                {$booking['summary']}
                                </p>
                            </div>
                        </div>
                        <div class='card__data'>
                            <div class='card__icon'>
                                <img src='../assets/svgs/Location.svg' alt='Location icon' />
                            </div>
                            <p>{$booking['startLocation']}</p>
                        </div>
                        <div class='card__data'>
                            <div class='card__icon'>
                                <img src='../assets/svgs/CardDate.svg' alt='Location icon' />
                            </div>
                            <p>{$booking['tour_date']}</p>
                        </div>
                        <div class='card__data'>
                            <div class='card__icon'>
                                <img src='../assets/svgs/Pounds.svg' alt='Location icon' />
                            </div>
                            <p>£{$booking['total_cost']} </p>
                        </div>
                        <div class='card__data'>
                            <div class='card__icon'>
                                <img src='../assets/svgs/Person.svg' alt='Location icon' />
                            </div>
                            <p>{$noOfGuests}</p>
                        </div>
                    </div>
                    <div class='card__footer'>
                    <div>
                        <a href='./server/cancelBooking.php?id={$booking['booking_id']}' class='btn btn-primary card__btn cancel_booking_btn'>
                            <span> Cancel Booking </span>
                        </a>
                    </div>
                </div>
                    
                    </div>";
                }
                echo "</div>";
            }

            ?>
            <div class="dashboard-header">
                <div>
                    <h2>Available Bookings</h2>
                </div>
                <hr class='dashboard_line'>
            </div>
            <?php
            include "./server/getTours.php";

            $tours = getTours();

            if (!isset($tours) || count($tours) < 1) {
                echo "
                    <div class='no_bookings_container'>
                        <div class='booking__icon'>
                            <img src='../assets/svgs/Info.svg' alt='Location icon' />
                        </div>
                        <p> There are no available tours.</p>
                    </div>
                ";
            }

            if (isset($tours)) {
                echo '<div class="bookings-list">';
                foreach ($tours as $tour) {
                    $date = date("M d, Y");

                    echo "<div class='card'>
                    <div class='card__header'>
                        <div class='card__heading-container'>
                        <h3 class='card__heading-text heading-4'>{$tour['name']}</h3>
                        </div>
                        <div class='card__picture'>
                        <img class='card__picture-img' src='../assets/imgs/{$tour['imagePath']}.jpeg' alt='Card item image' loading='lazy' />
                        </div>
                    </div>
                    <div class='card__details'>
                        <h4 class='card__header'>{$tour['name']}</h4>
                        <div class='card__text'>
                            <div class='truncate__line'>
                                <p class='card__description'>
                                {$tour['summary']}
                                </p>
                            </div>
                        </div>
                        <div class='card__data'>
                        <div class='card__icon'>
                            <img src='../assets/svgs/Location.svg' alt='Location icon' />
                        </div>
                        <p>{$tour['startLocation']}</p>
                        </div>
                        <div class='card__data'>
                        <div class='card__icon'>
                            <img src='../assets/svgs/CardDate.svg' alt='Location icon' />
                        </div>
                        <p>{$date}</p>
                        </div>
                        <div class='card__data'>
                        <div class='card__icon'>
                            <img src='../assets/svgs/Pounds.svg' alt='Location icon' />
                        </div>
                        <p>£{$tour['price']} per person</p>
                        </div>
                        <div class='card__data'>
                        <div class='card__icon'>
                            <img src='../assets/svgs/Rating.svg' alt='Rating icon' />
                        </div>
                        <p>{$tour['rating']} ({$tour['no_of_ratings']})</p>
                        </div>
                    </div>

                    <div class='card__footer'>
                        <div>
                        <a href='booking.php?id={$tour['tourId']}' class='btn btn-primary card__btn'>
                            <span> Start Now</span>
                        </a>
                        </div>
                    </div>
                    </div>";
                }
                echo "</div>";
            }
            ?>
        </section>
    </main>
</body>

</html>