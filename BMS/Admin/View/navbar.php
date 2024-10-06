<?php
require_once '../Services/NavbarServices.php';

$navbarServices = new NavbarServices();

$navbarResponse = $navbarServices->adminNavbar();

if ($navbarResponse && !empty($navbarResponse)) {
    ?>

    <link rel="stylesheet" href="../../../Common/Common file/admin_navbar.css">

    <nav class="sidebar labtop-nav close">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="../../../Common/Assets/Developer/svg/logo.svg" alt="">
                    <!-- <i class="fa-solid fa-diamond"></i> -->
                </span>

                <div class="text logo-text">
                    <span class="name">stronu<span class="first-color">X</span></span>
                    <span class="profession"></span>
                </div>
            </div>

            <i class='bx bx-chevron-right toggle'></i>
        </header>

        <div class="menu-bar">
            <div class="menu">

                <ul class="menu-links">
                    <?php
                    foreach ($navbarResponse as $navbarData) {
                        ?>
                        <li class="nav-link">
                            <a href="<?=$navbarData['url']?>">
                                <?=$navbarData['icon']?>
                                <span class="text nav-text"><?=$navbarData['label']?></span>
                            </a>
                        </li>
                        <?php
                    }
                    ?>

                </ul>
            </div>

            <div class="bottom-content">
                <li class="">
                    <a href="#" class="logout">
                        <!-- <i class='bx bx-log-out icon'></i> -->
                        <i class="fa-duotone fa-arrow-right-from-bracket icon"></i>
                        <span class="text nav-text">Logout</span>
                    </a>
                </li>

                <!-- <li class="mode">
                    <div class="sun-moon">
                        <i class='bx bx-moon icon moon'></i>
                        <i class='bx bx-sun icon sun'></i>
                    </div>
                    <span class="mode-text text">Dark mode</span>

                    <div class="toggle-switch">
                        <span class="switch"></span>
                    </div>
                </li> -->

            </div>
        </div>

    </nav>

    <div class="mobile-nav">
        <div class='wrapper'>
            <div class='app'>
                <div class='nav'>
                    <div class='nav-bar'>
                        <div class='logo'>AstronuX</div>
                        <div class='nav-btn'>
                            <div class='btn-bar menu'></div>
                            <div class='btn-bar menu'></div>
                            <div class='btn-bar menu'></div>
                            <div class='btn-bar close'></div>
                            <div class='btn-bar close'></div>
                        </div>
                    </div>
                    <div class='nav-content' style="display: none;">
                        <ul class="nav-list" style="display: none; position: relative; z-index: 10;">
                            <?php
                            foreach ($navbarResponse as $navbarData) {
                                ?>
                                <li>
                                    <a href="<?=$navbarData['url']?>">
                                        <?=$navbarData['icon']?>
                                        <span class="nav-text"><?=$navbarData['label']?></span>
                                    </a>
                                </li>
                                <?php
                            }

                            ?>
                            <li class="">
                                <a href="#" class="logout">
                                    <!-- <i class='bx bx-log-out icon'></i> -->
                                    <i class="fa-duotone fa-arrow-right-from-bracket icon"></i>
                                    <span class="nav-text">Logout</span>
                                </a>
                            </li>
                        </ul>

                        <div class='background'>
                            <div class='portion'></div>
                            <div class='portion'></div>
                            <div class='portion'></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="home">

    <script src="../../../Common/Common file/navbar.js"></script>
    <script src="../../../Common/Common file/mobile_navbar.js"></script>
    <script src="./Js/ajax.js"></script>
    <script src="../../../Common/Common file/common_function.js"></script>

    <?php
} else {
    echo "Navigation bar unavailable. We'll be back soon.";
}
?>