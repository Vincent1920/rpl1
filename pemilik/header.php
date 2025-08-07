<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="../index.php">neek</a>

  <div class="navbar-nav ms-auto me-3">
    <div class="nav-item text-nowrap">
      <ul class="navbar-nav">

        <?php if (isset($_SESSION['username'])): ?>
          
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#" id="userDropdown" role="button"
               data-bs-toggle="dropdown" aria-expanded="false">
              <?php echo $_SESSION['username']; ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end z-3 position-absolute  " aria-labelledby="userDropdown">
              <!-- <li><a class="dropdown-item" href="#">Profil</a></li> -->
              <li><a class="dropdown-item" href="../php/login/logout.php">Logout</a></li>
            </ul>
          </li>
        <?php else: ?>
          
          <li class="nav-item">
            <a class="nav-link text-white" href="../login/login.php">Login</a>
          </li>
        <?php endif; ?>

      </ul>
    </div>
  </div>
</header>
