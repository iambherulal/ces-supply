<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <span class="brand-link">
        <img src="<?php ces_assests() ?>dbg-logo.png" alt="CES Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><b>CES </b>Supply</span>
    </span>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <!-- <img src="<?php ces_assests() ?>user2-160x160.jpg" class="img-circle elevation-2" alt="User Image"> -->
            </div>
            <div class="info">
                <a href="<?= get_author_posts_url(get_current_user_id()) ?>" class="d-block"><?= get_userdata(get_current_user_id())->display_name;  ?></a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="<?= site_url(); ?>" class="nav-link <?= (is_front_page()) ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <?php if (current_user_can('administrator')) : ?>
                    <li class="nav-item">
                        <a href="<?= site_url('all-deals') ?>" class="nav-link <?= ((is_page('all-deals'))) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-tag"></i>
                            <p>All Deals</p>
                        </a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a href="<?= site_url('deals') ?>" class="nav-link <?= ((is_page('deals'))) ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-list"></i>
                        <p>Deals</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= site_url('activity') ?>" class="nav-link <?= ((is_page('activity'))) ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-history"></i>
                        <p>Activity</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= get_author_posts_url(get_current_user_id()) ?>" class="nav-link <?= ((is_author())) ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Profile</p>
                    </a>
                </li>
                <?php if (current_user_can('vendor')) : ?>
                    <li class="nav-item">
                        <a href="<?= site_url('support') ?>" class="nav-link <?= ((is_page('support'))) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-question"></i>
                            <p>Support</p>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (current_user_can('administrator')) : ?>
                    <li class="nav-item">
                        <a href="<?= site_url('support-center') ?>" class="nav-link <?= ((is_page('support-center'))) ? 'active' : '' ?>">
                            <i class="nav-icon fab fa-wpforms"></i>
                            <p>Support Center</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= site_url('vendors') ?>" class="nav-link <?= ((is_page('vendors'))) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Vendors</p>
                        </a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a href="<?= wp_logout_url(); ?>" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt text-danger"></i>
                        <p class="text">Log Out</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>