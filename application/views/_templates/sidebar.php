    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-broadcast-tower"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Iki Admin<sup>12</sup></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- QUERY MENU -->
      <?php

      $rule_id = $this->session->userdata('rule_id');
      $queryMenu = "SELECT `user_menu`.`menu`, `user_menu`.`id` FROM `user_menu` JOIN `user_access_menu` ON `user_menu`.`id` = `user_access_menu`.`menu_id` WHERE `user_access_menu`.`rule_id` = {$rule_id} ";
      $menu = $this->db->query($queryMenu)->result_array();
      ?>

      <!-- DAFTAR MENU -->
      <?php foreach ($menu as $m) : ?>

        <!-- Heading -->
        <div class="sidebar-heading">
          <?= $m['menu']; ?>
        </div>

        <!-- QUERY SUB MENU -->
        <?php
        $menu_id = $m['id'];
        // $querySubMenu = "SELECT * FROM `user_menu` JOIN `user_sub_menu` ON `user_menu`.`id`=`user_sub_menu`.`menu_id` WHERE `user_sub_menu`.`menu_id`={$menu_id} AND `user_sub_menu`.`is_active` = 1";
        $querySubMenu = "SELECT * FROM `user_sub_menu` WHERE `menu_id` = $menu_id AND `is_active` = 1";
        $subMenu = $this->db->query($querySubMenu)->result_array();
        ?>

        <!-- DAFTAR SUB MENU -->
        <?php foreach ($subMenu as $sm) : ?>
          <?php $url = $sm['url']; ?>
          <?php if ($sm['title'] == $title) : ?>
            <li class="nav-item active">
            <?php else : ?>
            <li class="nav-item">
            <?php endif; ?>

            <a class="nav-link pb-0" href="<?= base_url($url); ?>">
              <i class="<?= $sm['icon']; ?>"></i>
              <span><?= $sm['title']; ?></span></a>
            </li>

          <?php endforeach; ?>

          <!-- Divider -->
          <hr class="sidebar-divider mt-3">

        <?php
      endforeach;
        ?>

        <!-- Nav Item - Log Out -->
        <li class="nav-item">
          <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Logout</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
          <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
    <!-- End of Sidebar -->