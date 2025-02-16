<?php $session = \Config\Services::session(); ?>
<?php if (session()->get('isLoggedIn')): ?>
<li class="menu-header">Main Menu</li>
<li class="nav-item dropdown">
                <li><a class="nav-link" href="<?=base_url()?>"><i class="fas fa-home"></i> <span>Halaman Utama</span></a></li>
                <li><a class="nav-link" href="<?=base_url("sewa")?>"><i class="fas fa-address-book"></i> <span>Sewa</span></a></li>
                <?php else: ?>
                <?php endif; ?>

                <!-- <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a> -->

                <!-- <ul class="dropdown-menu">

                  <li><a class="nav-link" href=""></a></li>
                  <li><a class="nav-link" href="">Ecommerce Dashboard</a></li>
                </ul> -->
              <!-- </li> -->
              <!-- <li class="menu-header">Starter</li>
              <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Layout</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="layout-default.html">Default Layout</a></li>
                  <li><a class="nav-link" href="layout-transparent.html">Transparent Sidebar</a></li>
                  <li><a class="nav-link" href="layout-top-navigation.html">Top Navigation</a></li>
                </ul>
              </li> -->
              <?php if(session()->get('role') === 'admin'): ?>
              <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-th"></i> <span>Admin</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="bootstrap-alert.html">Alert</a></li>
                  <li><a class="nav-link" href="bootstrap-badge.html">Badge</a></li>
                  <li><a class="nav-link" href="bootstrap-breadcrumb.html">Breadcrumb</a></li>
                </ul>
              </li>
              <?php endif; ?>