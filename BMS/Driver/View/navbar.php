<?php
require_once '../Services/NavbarServices.php';

$navbarServices = new NavbarServices();

$navbarResponse = $navbarServices->userNavbar();

if ($navbarResponse && !empty($navbarResponse)) {
    ?>

    <link rel="stylesheet" href="../../../Common/Common file/user_navbar.css">


    <div class="mobile-nav">
        <div class='wrapper'>
            <div class='app'>
                <div class='nav'>
                    <div class='nav-bar'>
                        <div class='logo'>AstronuX</div>
                        <div class="dropdown-l">
                            <button class="dropdown-toggle" onclick="toggleDropdown()">
                                <i class="fa-duotone fa-solid fa-globe"></i>
                            </button>
                            <ul class="dropdown-menu-l">
                                <li class="menu-item" onclick="changeLanguage('en')">
                                    <span class="item-icon">
                                        <i class="fa-duotone fa-solid fa-language"></i>
                                    </span>
                                    <span class="item-txt">
                                        English
                                    </span>
                                </li>
                                <li class="menu-item" onclick="changeLanguage('ta')">
                                    <span class="item-icon">
                                        <i class="fa-duotone fa-solid fa-language"></i>
                                    </span>
                                    <span class="item-txt">
                                        Tamil
                                    </span>
                                </li>
                            </ul>
                        </div>

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

    <script src="../../../Common/Common file/navbar.js"></script>
    <script src="../../../Common/Common file/mobile_navbar.js"></script>
    <script src="./Js/ajax.js"></script>

    <?php
} else {
    echo "Navigation bar unavailable. We'll be back soon.";
}
?>