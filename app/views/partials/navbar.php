<!-- Banner -->
<nav class="navbar navbar-expand-md navbar-light bg-dark">
    <div class="container">

        <a href="<?php echo URLROOT; ?>" class="navbar-brand text-light"><?php echo SITENAME; ?></a>

        <button type="button" class="navbar-toggler bg-light" data-toggle="collapse" data-target="#nav"><span
                class="navbar-toggler-icon"></span></button>

        <div class="collapse navbar-collapse justify-content-between" id="nav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link text-light text-uppercase px-3"
                        href="<?php echo URLROOT; ?>">Home</a>
                </li>
            </ul>

            <form class="form-inline">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search">
                    <div class="input-group-append">
                        <button type="button" class="btn"><i class="fa fa-search text-muted"></i></button>
                    </div>
                </div>
            </form>

            <ul class="navbar-nav">
                <?php if(isset($_SESSION['user_id'])): ?>

                <!-- <li class="nav-item"><a class="nav-link text-light text-uppercase px-3"><?php echo $_SESSION['user_name'] ?></a></li> -->
                
                <li class="nav-item">
                    <a href="<?php echo URLROOT;?>/carts" class="nav-link text-light">
                        <i class="fa fa-shopping-cart fa-lg"></i>
                    </a>
                </li>
                
                <!-- <li class="nav-item">
                    <a href="<?php echo URLROOT . '/pages/notifications'; ?>" class="nav-link text-light">
                        <i class="fa fa-bell fa-lg">
                        </i>
                    </a>
                </li> -->

                <!-- <li class="nav-item">
                    <a href="<?php echo URLROOT; ?>/pages/notifications" class="nav-link text-light">
                        <span class="fa-layers fa-fw">
                            <i class="fas fa-bell fa-lg"></i>
                            <span id="notification"></span>
                        </span>
                    </a>
                </li> -->

                <li class="nav-item dropdown">
                    <a id="notificationButton" href="" class="nav-link text-light" data-toggle="dropdown">
                        <span class="fa-layers fa-fw">
                            <i class="fas fa-bell fa-lg"></i>
                            <span id="notification"></span>
                        </span>
                    </a>
                    <div id="dropdownList" class="dropdown-menu dropdown-menu-right">
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a href="" class="nav-link text-light" data-toggle="dropdown">
                        <i class="fa fa-chevron-circle-down fa-lg"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="<?php echo URLROOT; ?>/orders"
                            class="dropdown-item text-uppercase">My orders</a>
                        <a href="<?php echo URLROOT; ?>/users/logout"
                            class="dropdown-item text-uppercase">Logout</a>
                    </div>
                </li>
                
                <?php else: ?>

                <li class="nav-item"><a href="<?php echo URLROOT; ?>/users/register"
                        class="nav-link text-light text-uppercase px-3">Register</a></li>
                <li class="nav-item"><a href="<?php echo URLROOT; ?>/users/login"
                        class="nav-link text-light text-uppercase px-3">Login</a></li>

                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<!-- END OF NAVBAR -->