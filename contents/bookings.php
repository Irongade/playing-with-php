<!DOCTYPE html>
<html lang="en">

<head>
  <?php include "./components/htmlHeadTags.php" ?>
</head>

<body>
  <?php include "./components/header.php" ?>

  <main>
    <section class="bookings-container">
      <div class="bookings-header">
        <h2>Available Destinations</h2>
      </div>
      <?php
      include "./server/getTours.php";

      $tours = getTours();

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
              <span>{$tour['startLocation']}</span>
            </div>
            <div class='card__data'>
              <div class='card__icon'>
                <img src='../assets/svgs/CardDate.svg' alt='Location icon' />
              </div>
              <span>{$date}</span>
            </div>
            <div class='card__data'>
              <div class='card__icon'>
                <img src='../assets/svgs/Pounds.svg' alt='Location icon' />
              </div>
              <span>£{$tour['price']} per person</span>
            </div>
            <div class='card__data'>
              <div class='card__icon'>
                <img src='../assets/svgs/Rating.svg' alt='Location icon' />
              </div>
              <span>{$tour['rating']} ({$tour['no_of_ratings']})</span>
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

  <button type="submit"></button>
  <?php include "./components/footer.php" ?>
</body>

</html>