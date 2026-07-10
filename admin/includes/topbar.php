<div class="admin-topbar">
    <button class="sidebar-toggle" id="sidebarToggle"><i class="fas fa-bars"></i></button>
    <div class="topbar-right">
        <span class="admin-user"><i class="fas fa-user-circle"></i> <?= sanitize($_SESSION['admin_name'] ?? 'Admin') ?></span>
    </div>
</div>
