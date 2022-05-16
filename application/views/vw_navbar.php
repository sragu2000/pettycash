<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <nav class="navbar navbar-light bg-light">
      <a class="navbar-brand" href="<?php echo base_url("home") ?>">
      <i class="fa-solid fa-house"></i> &nbsp; Home
      </a>
    </nav>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" href="<?php echo base_url('home/addanalysis'); ?>"><i class="fas fa-plus"></i>&nbsp;Add Category</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fa-solid fa-magnifying-glass"></i>&nbsp;Search
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="<?php echo base_url('home/viewPayments'); ?>">Search By Year and Month</a></li>
            <li><a class="dropdown-item" href="<?php echo base_url('home/viewPaymentsYear'); ?>">Search By Year</a></li>
          </ul>
        </li>
      </ul>

      <a class="nav-link active text-danger" href="<?php echo base_url('home/logout'); ?>">
        <i class="fas fa-power-off"></i> &nbsp;Logout</a>
    </div>
  </div>
</nav>