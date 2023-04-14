<?php 

	namespace component;

	class header{

		public function header(){

	$header = '
           <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="?url=dashboard" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">Menu</span>
       </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->
    

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
          </a>
        </li><!-- End Search Icon-->

          
           <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
           <img src="assets/img/logo.png" alt="Profile">
            <span class="d-none d-md-block dropdown-toggle ps-2"></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>Dr.Maria Mendoza</h6>
              <span>User</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="?url=login">
                <i class="bi bi-box-arrow-right"></i>
                <span>Cerrar Seción.</span>
              </a>
            </li>


          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>

    </nav><!-- End Icons Navigation -->

  </header>
  <!-- End Header -->
  ';

  	echo $header;

		}
	}



 ?>