 <!-- Topbar -->
 <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

<!-- Sidebar Toggle (Topbar) -->
<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
    <i class="fa fa-bars"></i>
</button>

<!-- Topbar Navbar -->
<ul class="navbar-nav ml-auto">
    <div class="topbar-divider d-none d-sm-block"></div>

    <!-- Nav Item - User Information -->
    <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span
                class="mr-2 d-none d-lg-inline text-gray-600 small"><?= isset($_SESSION['name']) ? $_SESSION['name'] : "John Doe" ?></span>
        </a>

        <form method="post" action="">
            <button type="submit" name="logout" class="btn btn-danger">
            <i class="fas fa-right-from-bracket"></i>
            </button>
        </form>
        
    </li>

</ul>

</nav>
<!-- End of Topbar -->


<?php 

if (isset($_POST['logout'])) {
    header('location: ../index.php');
    session_unset();
    session_destroy();
}
?>