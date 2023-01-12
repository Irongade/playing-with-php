<header class="header">
    <nav class="nav-bar">
        <div tabindex="0" class="nav-bar__logo">
            <a href="index.php">
                <img src="../assets/svgs/Logo.svg" alt="Company Logo" />
            </a>
        </div>

        <ul class="nav">


            <li class="nav__item">
                <a class="nav__link" target="_blank" href="../documents/AcademicReport.pdf">Report</a>
            </li>
            <li class="nav__item">
                <a class="nav__link" target="_blank" href="../documents/Credits.pdf">Credits</a>
            </li>
            <li class=" nav__item">
                <a class="nav__link" target="_blank" href="../documents/features.txt">Features</a>
            </li>
            <?php
            require_once "./session.php";

            startSession();
            $isSessionPresent = readSessionValue("email");
            if ($isSessionPresent) {
                echo "<li class='avatar__container'>
                <button aria-haspopup='true' aria-expanded='false' class='avatar__img-btn' onclick='toggleAvatarDropdown()'>
                    <img src='../assets/svgs/Avatar.svg' class='avatar__img' alt='Image'>
                </button>
                <div id='avatar__dropdown-id' class='avatar__dropdown'>
                    <a href='dashboard.php'>Dashboard</a>
                    <a href='forgot-password.php'>Reset Password</a>
                    <a href='server/logoutProcess.php'>Logout</a>
                </div>
            </li>";
            } else {
                echo "<li class='nav__item'>
                    <a class='nav__link' href='login.php'>Login</a>
                </li>";
            }

            ?>
        </ul>

        <button class="nav__hamburger">
            <img src="../assets/svgs/MenuLogo.svg" alt="hamburger-icon" />
        </button>
    </nav>
</header>

<script>
    function toggleAvatarDropdown() {
        document.getElementById("avatar__dropdown-id").classList.toggle("show__dropdown");
    }
</script>