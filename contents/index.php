<!DOCTYPE html>
<html lang="en">

<head>
  <?php include "./components/htmlHeadTags.php" ?>
</head>

<body>
  <?php include "./components/header.php" ?>

  <main>
    <section class="banner hero">
      <div class="banner-text">
        <h1 class="banner__heading heading-1">
          Visit South Island <br />
          The best place to get away
        </h1>
        <div class="btn-container">
          <a class="btn btn-primary" href="./bookings.php">
            <span> Start Now</span>
            <img class="btn-arrow" src="../assets/svgs/Arrow-White.svg" alt="Button arrow" />
          </a>
        </div>
      </div>
      <div class="banner-logo">
        <img src="../assets/svgs/BannerLogo.svg" alt="Enjoy Logo" />
      </div>
    </section>

    <div class="banner video">
      <?php
      require_once "./components/video.php";
      echo renderVideo("../assets/videos/banner-video.mp4");
      ?>
    </div>

    <section class="banner location-container">
      <div class="banner-logo">
        <img src="../assets/svgs/DifferentLogo.svg" alt="Different locations Logo" />
      </div>
      <div class="banner-text">
        <h2 class="banner__heading heading-2">30 different Locations</h2>
        <h3 class="banner__heading heading-4">Witness breathtaking sights</h3>
        <div class="btn-container">
          <a class="btn btn-secondary" href="./bookings.php">
            <span> Start Now</span>
            <img class="btn-arrow" src="../assets/svgs/Arrow-Blue.svg" alt="Button arrow" />
          </a>
        </div>
      </div>
    </section>

    <!-- features -->
    <section class="banner feature">
      <div class="feature-box">
        <div class="feature-box__icon">
          <img src="../assets/svgs/Money.svg" alt="Money Logo" />
        </div>
        <h3 class="feature-box__heading">Affordable</h3>
        <p class="feature-box__text">
          Adventure on a budget. Choose from our variety of budget packages
          and go on a once in a lifetime adventure to the most beautiful
          destinations. We also offer discounts for solo, family and group
          travellers.
        </p>
      </div>

      <div class="feature-box">
        <div class="feature-box__icon">
          <img src="../assets/svgs/Compass.svg" alt="Compass Logo" />
        </div>
        <h3 class="feature-box__heading">Meet Nature</h3>
        <p class="feature-box__text">
          Become one with nature and explore. Let’s make your travel dreams
          come true by taking you to the most beautiful destinations. Discover
          your truest self while connecting with the universe.
        </p>
      </div>

      <div class="feature-box">
        <div class="feature-box__icon">
          <img src="../assets/svgs/Heart.svg" alt="Heart Logo" />
        </div>
        <h3 class="feature-box__heading">Healthy Life</h3>
        <p class="feature-box__text">
          You’re one click away from your next dose of adventure. Life is a
          journey, we need to keep taking to unlock our best healthiest
          selves. To keep the blue’s away, book your next trip with us.
        </p>
      </div>
    </section>

    <section class="banner form-container">
      <div class="banner-logo">
        <img src="../assets/svgs/JoinUs.svg" alt="Join us banner Logo" />
      </div>
      <?php include "./components/bookingForm.php" ?>
    </section>
  </main>
  <?php include "./components/footer.php" ?>
</body>

</html>