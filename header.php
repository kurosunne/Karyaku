<?php
require_once("koneksi.php");
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#" class="img-fluid" style="height:50px;">
            <img src="asset/logo.png" style="height:100%" class="img-fluid" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <a href="#" class="btn btn-outline-custom">Advance</a>
                <form class="d-flex ms-xxl-3 me-xxl-5" style="height: 40px;">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" style="width: 70vw;">
                    <button class="btn btn-outline-custom" type="submit">Search</button>
                </form>
                <?php
                if (!isset($_SESSION["active"])) {
                ?>
                    <a href="register.php"><button class="btn btn-outline-custom ms-xxl-5" type="submit">Register</button></a>
                    <a href="login.php"><button class="btn btn-outline-custom2 ms-xxl-2" type="submit">Login</button></a>
                <?php
                } else {
                ?>
                    <div class="mx-xxl-4 me-xxl-5"></div>
                    <li class="nav-item dropdown">
                        <a href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" class="ps-5" aria-expanded="false">
                            <img src="asset/Misc/profil.jpg" class="ms-xxl-5" alt="" height="40px" width="40px">
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown" style="width: 50px;">
                            <li><a class="dropdown-item" href="kontroler.php?action=signOut">Sign Out</a></li>
                        </ul>
                    </li>
                <?php
                }
                ?>
            </ul>
        </div>
    </div>
</nav>