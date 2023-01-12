<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "./components/htmlHeadTags.php" ?>
</head>

<body>
    <?php include "./components/header.php" ?>

    <main>
        <?php
        require_once "./server/getTour.php";
        require_once './components/video.php';

        // restricted page
        restricted('./login.php?error="restricted"');

        $tour = getTour();

        // if tour does not exist, go to 404 page.
        if (!isset($tour)) {
            header("Location: ./alert.php?type=404");
        }

        if (isset($tour)) {
            $videoElement = renderVideo("../assets/videos/{$tour['videoPath']}.mp4");
            $date = date("M d, Y");
            $minDate = date("Y-m-d");

            echo "<section class='booking__video'> {$videoElement} </section>";
            echo "<section class='booking__header'>
                    <h1 class='heading-2'>
                        {$tour['name']}
                    </h1>
                    <div class='booking__body'>
                        <div class='booking__overview'>
                            <h2 class='booking__overview-heading '>Quick Facts</h2>
                            <div class='booking__overview-box'>
                                <div class='booking__icon'>
                                    <img src='../assets/svgs/CardDate.svg' alt='Date icon' />
                                </div>
                                <p class='booking__box-key heading-5'>Next date:</p>
                                <p class='booking__box-value'>{$date}.</p>
                            </div>

                            <div class='booking__overview-box'>
                                <div class='booking__icon'>
                                    <img src='../assets/svgs/Meter.svg' alt='Difficulty icon' />
                                </div>
                                <p class='booking__box-key heading-5'>Difficulty:</p>
                                <p class='booking__box-value'>{$tour['difficulty']}.</p>
                            </div>

                            <div class='booking__overview-box'>
                                <div class='booking__icon'>
                                    <img src='../assets/svgs/Flag.svg' alt='Flag icon' />
                                </div>
                                <p class='booking__box-key heading-5'>Checkpoints:</p>
                                <p class='booking__box-value'>{$tour['no_of_stops']} stops.</p>
                            </div>

                            <div class='booking__overview-box'>
                                <div class='booking__icon'>
                                    <img src='../assets/svgs/Rating.svg' alt='Rating icon' />
                                </div>
                                <p class='booking__box-key heading-5'>Rating:</p>
                                <p class='booking__box-value'>{$tour['rating']} / 5 ({$tour['no_of_ratings']}).</p>
                            </div>

                            <div class='booking__overview-box'>
                                <div class='booking__icon'>
                                    <img src='../assets/svgs/Pounds.svg' alt='Price icon' />
                                </div>
                                <p class='booking__box-key heading-5'>Price:</p>
                                <p class='booking__box-value'>£{$tour['price']} per person.</p>
                            </div>
                        </div>
                        <hr class='booking__separator' />
                        <div class='booking__overview'>
                            <h2 class='booking__overview-heading'>ABOUT {$tour['name']}</h2>
                            <p class='booking__overview-description'>{$tour['description']}</p>
                        </div>
                    </div>
                </section>";

            // form
            echo "<section class='booking__form-container'>
                    <div class='banner-form'>
                        <form method='post' action='./server/makeBooking.php'>
                            <div class=''>
                                <label class='visually-hidden' for='tourId'>Tour ID</label>
                                <input class='input visually-hidden' type='number' name='tourId' id='tourId' placeholder='Tour Id' value='{$tour['tourId']}' />
                            </div>
                            <div class=''>
                                <label class='visually-hidden' for='costPerPerson'>Cost Per Person</label>
                                <input class='input visually-hidden' type='number' name='costPerPerson' id='costPerPerson' placeholder='Cost per person' value='{$tour['price']}' />
                            </div>

                            <div class='input-container'>
                                <input class='input' type='text' name='name' id='name' readonly value='{$tour['name']}' placeholder='Tour name' />
                                <label class='label_floating' for='name'>Tour Name</label>
                            </div>

                            <div class='input-container'>
                                <label class='label_normal' for='departure-date'>Depature Date</label>
                                <input required class='input' type='date' min='{$minDate}' name='departure_date' id='departure_date' placeholder='Depature Date' />
                            </div>

                            <div class='input-container'>
                                <input required class='input' type='number' name='people_count' id='people_count' placeholder='How many people?' value='1' onchange='updateCost()' min='1' />
                                <label class='label_floating' for='people_count'>No of Guests</label>
                            </div>

                            <div class='input-container'>
                                <input required class='input' type='number' name='cost' id='cost' placeholder='Cost' readonly value='{$tour['price']}' />
                                <label class='label_floating' for='cost'>Total Cost (£)</label>
                            </div>

                            <div class='input-container'>
                                <textarea class='input' type='text' name='notes' id='notes' cols='30' rows='5' placeholder='Additional notes'></textarea>
                                <label class='label_floating' for='notes'>Additional Notes</label>
                            </div>

                            <div class='btn-container max-width'>
                                <button type='submit' class='btn btn-primary center-btn-text'>
                                    <span> Book Now</span>
                                    <img class='btn-arrow paper__plane' src='../assets/svgs/PaperPlane.svg' alt='Button arrow' />
                                </button>
                            </div>
                        </form>
                    </div>
                </section>";
        }
        ?>
    </main>

    <?php include "./components/footer.php" ?>

    <script>
        function updateCost() {
            let peopleCountValue = document.getElementById("people_count").value;
            let costPerPersonValue = document.getElementById("costPerPerson").value;

            if (Number.isInteger(+peopleCountValue) && Number.isInteger(+costPerPersonValue) && +peopleCountValue > 0) {
                let newCostValue = +costPerPersonValue * +peopleCountValue;
                console.log();
                document.getElementById('cost').value = Math.floor(newCostValue);
            }

            if (+peopleCountValue < 1) {
                document.getElementById('people_count').value = 1;
            }
        }
    </script>
</body>

</html>