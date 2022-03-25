<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading">Core</div>
                    <a class="nav-link" href="<?php echo url("") ?>">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>
                    <div class="sb-sidenav-menu-heading">Interface</div>
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                        <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                        Pages
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                            <?php
                            if ($_SESSION["user"]["title"] === "Admin") {
                                $modules = ["users", "roles", "products", "categories"];
                            } else {
                                $modules = ["products"];
                            }
                            foreach ($modules as $key => $value) {
                            ?>
                                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapse<?php echo $key ?>" aria-expanded="false" aria-controls="pagesCollapse<?php echo $key ?>">
                                    <?php echo $value; ?>
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapse<?php echo $key ?>" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="<?php echo url($value); ?>">Index</a>
                                        <?php
                                        if ($_SESSION['user']['title'] === "Customer") {
                                        ?>
                                            <a class="nav-link" href="<?php echo url("orders.php"); ?>">orders</a>
                                            <a class="nav-link" href="<?php echo url("cart.php"); ?>">Cart</a>
                                        <?php
                                        }
                                        ?>
                                        <?php
                                        if ($_SESSION['user']['title'] === "Admin" || $_SESSION['user']['title'] === "Seller") {
                                        ?>
                                            <a class="nav-link" href="<?php echo url($value . "/create.php"); ?>">Create</a>
                                        <?php
                                        }
                                        ?>
                                    </nav>
                                </div>
                            <?php
                            }
                            ?>
                        </nav>
                    </div>
                </div>
            </div>
        </nav>
    </div>