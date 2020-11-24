<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-air-freshener"></i>
        </div>
        <div class="sidebar-brand-text mx-3">
            <?php
            $where = [
                'id' => $user['role_id']
            ];
            $session = $this->db->get_where('user_role', $where)->row_array();
            echo $session['role'];
            ?>
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Query Menu -->
    <?php
    $roleId = $this->session->userdata('role_id');
    $queryMenu = "SELECT `user_menu`.`id`,`menu`
                        FROM `user_menu` JOIN `user_access_menu`
                        ON `user_menu`.`id` = `user_access_menu`.`menu_id`
                        WHERE `user_access_menu`.`role_id` = $roleId 
                        ORDER BY `user_access_menu`.`menu_id` ASC ";
    $menu2 = $this->db->query($queryMenu)->result_array();
    ?>
    <!-- Looping Menu -->
    <?php foreach ($menu2 as $m2) :  ?>
        <div class="sidebar-heading">
            <?= $m2['menu']; ?>
        </div>
        <!-- Menyiapkan Sub Menu Berdasarkan Menu -->
        <?php
        $menuId = $m2['id'];
        $querySubMenu = "SELECT * FROM `user_sub_menu` 
                        WHERE `menu_id` = $menuId 
                        AND `is_active` = 1 ";
        $subMenuSidebar = $this->db->query($querySubMenu)->result_array();
        foreach ($subMenuSidebar as $sms) : ?>
            <!-- Judul sidebar aktif -->
            <?php if ($title == $sms['title']) : ?>
                <li class="nav-item active">
                <?php else : ?>
                <li class="nav-item">
                <?php endif; ?>
                <a class="nav-link pb-0" href="<?= base_url($sms['url']) ?>">
                    <i class="<?= $sms['icon']; ?>"></i>
                    <span><?= $sms['title']; ?></span></a>
                </li>
            <?php endforeach; ?>
            <!-- Divider -->
            <hr class="sidebar-divider mt-1 mb-1">
        <?php endforeach; ?>

        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('auth/logout'); ?> " onclick="return confirm('Ready to leave?')">
                <i class="fas fa-fw fa-sign-out-alt"></i>
                <span>Logout</span></a>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
        <?php
        // echo $id_menu['id'];
        ?>
</ul>
<!-- End of Sidebar -->