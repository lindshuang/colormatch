<?php
    // no need to start session since started on all pages that include nav.php
    // session_start();
?>

<nav class="navbar navbar-expand-md navbar-light nav-custom">
    <div class="d-flex flex-grow-1">
        <span class="w-100 d-lg-none d-block"><!-- hidden spacer to center brand on mobile --></span>
        <a class="navbar-brand d-none d-lg-inline-block" href="index.php">
            <img class = "logo" alt = "logo" src = "./images/colormatch.png">
        </a>
        <a class="navbar-brand-two mx-auto d-lg-none d-inline-block" href="index.php">
            <img class = "logo-mobile" alt = "logo" src = "./images/colormatch.png">        
        </a>
        <div class="w-100 text-right">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#myNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </div>

    <?php if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true): ?>
         <div class="collapse navbar-collapse flex-grow-1 text-right" id="myNavbar">
        <ul class="navbar-nav ml-auto flex-nowrap">
            <li class="nav-item">
                <a href="instructions.php" class="nav-link m-2 menu-item <?= ($activePage == 'instructions') ? 'active-item':''; ?>">instructions</a>
            </li>
            <li class="nav-item">
                <a href="index.php" class="nav-link m-2 menu-item <?= ($activePage == 'play') ? 'active-item':''; ?>">play</a>
            </li>
            <li class="nav-item">
                <a href="results.php" class="nav-link m-2 menu-item <?= ($activePage == 'results') ? 'active-item':''; ?>">results</a>
            </li>
            <li class="nav-item">
                <a href="#" id = "logout-btn" class="nav-link m-2 menu-item">logout</a>
            </li>
        </ul>
    </div>

    <?php else:?>

     <div class="collapse navbar-collapse flex-grow-1 text-right" id="myNavbar">
        <ul class="navbar-nav ml-auto flex-nowrap">
            <li class="nav-item">
                <a href="instructions.php" class="nav-link m-2 menu-item <?= ($activePage == 'instructions') ? 'active-item':''; ?>">instructions</a>
            </li>
            <li class="nav-item">
                <a href="index.php" class="nav-link m-2 menu-item <?= ($activePage == 'play') ? 'active-item':''; ?>">play</a>
            </li>
        </ul>
    </div>

<?php endif;?>
</nav>
