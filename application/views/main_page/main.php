<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>SI - Peralatan Medis</title>

  <link rel="shortcut icon" href="<?=base_url('assets/images/w.png')?>">
  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <link rel="stylesheet" href="<?=base_url('file')?>/modules/datatables/datatables.min.css">
  <link rel="stylesheet" href="<?=base_url('file')?>/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?=base_url('file')?>/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">

  <script src="<?=base_url('file')?>/modules/datatables/datatables.min.js"></script>
  <script src="<?=base_url('file')?>/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?=base_url('file')?>/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>


  <!-- General JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="<?=base_url('file')?>/js/stisla.js"></script>
  <!-- <script src="https://unpkg.com/sweetalert@2.1.2/dist/sweetalert.min.js"></script> -->
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
  <!-- Template JS File -->
  <script src="<?=base_url('file')?>/js/scripts.js"></script>
  <script src="<?=base_url('file')?>/js/custom.js"></script>

  <!-- Template CSS -->
  <link rel="stylesheet" href="<?=base_url('file')?>/css/style.css">
  <link rel="stylesheet" href="<?=base_url('file')?>/css/components.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>

<body>
  <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
          </ul>
          <div class="search-element">
            <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="250">
            <button class="btn" type="submit"><i class="fas fa-search"></i></button>
            <div class="search-backdrop"></div>
          
          </div>
        </form>
        <ul class="navbar-nav navbar-right">
        
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="<?=base_url('file')?>/img/avatar/avatar-1.png" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block">Hi, <?=$this->session->userdata('nama')?></div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <!-- <div class="dropdown-title">Logged in 5 min ago</div> -->
              <!-- <a href="features-profile.html" class="dropdown-item has-icon">
                <i class="far fa-user"></i> Profile
              </a>
              <a href="features-activities.html" class="dropdown-item has-icon">
                <i class="fas fa-bolt"></i> Activities
              </a>
              <a href="features-settings.html" class="dropdown-item has-icon">
                <i class="fas fa-cog"></i> Settings
              </a> -->
              <div class="dropdown-divider"></div>
              <a href="<?=base_url('welcome/logout')?>" class="dropdown-item has-icon text-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>
            </div>
          </li>
        </ul>
      </nav>
      <div class="main-sidebar">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <img src="<?=base_url()?>/assets/images/w.png" alt="logo" class="logo" style="height: 100px;margin-top: 10px"><br>
            <a href="<?=base_url()?>">SI - Peralatan Medis</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="<?=base_url()?>">SI</a>
          </div><br><br>
          <ul class="sidebar-menu">
             <!--  <li class="menu-header">Dashboard</li> -->
             
              <li id="dashboard"><a class="nav-link" href="<?=base_url('Dashboard')?>">General Dashboard</a></li>
             

              <?php  if($this->session->userdata('level')=='Admin Prasarana'){?>
              
                <li class="menu-header">Data Alat</li>

                <li id="alat"><a class="nav-link" href="<?= base_url('Alat')?>" ><i class="fas fa-medkit "></i> <span>Data Kelola Alat</span></a></li>

                <li id="peralatan"><a class="nav-link" href="<?= base_url('peralatan')?>" ><i class="fas fa-stethoscope"></i> <span>Data Peralatan Medis</span></a></li>

                <li id="kondisi"><a class="nav-link" href="<?= base_url('kondisi')?>" ><i class="fas fa-user-md "></i> <span>Data Kondisi Alat</span></a></li>

                <li id="mutasi"><a class="nav-link" href="<?= base_url('mutasi')?>" ><i class="fas fa-tasks"></i> <span>Data Mutasi Alat</span></a></li>

                <li class="menu-header">Pemeliharaan Alat</li>

                <li class="nav-item dropdown" id="setting">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Pemeliharaan</span></a>
                <ul class="dropdown-menu" id="setting_data">
                 
                  <li id="pemeliharaan"><a class="nav-link" href="<?=base_url('pemeliharaan')?>">Kartu Pemeliharaan</a></li>
                  <li id="kalibrasi"><a class="nav-link" href="<?=base_url('kalibrasi')?>">Data Kalibrasi</a></li>
                  <li id="afkir"><a class="nav-link" href="<?=base_url('afkir')?>">Data Afkir</a></li>
                </ul>
                </li>

                <li class="menu-header">Data Pengguna</li>

                 <li id="pengguna"><a class="nav-link" href="<?= base_url('Pengguna')?>" ><i class="fas fa-user-circle"></i> <span>Data Penguna</span></a></li>




                <li class="nav-item dropdown" id="setting-menu">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Setting</span></a>
                <ul class="dropdown-menu" id="setting-atur">
                 
                  <li id="ruangan"><a class="nav-link" href="<?=base_url('ruangan')?>">Nama Ruangan</a></li>
                  <li id="history"><a class="nav-link" href="<?=base_url('history')?>">Tgl Pemeliharaan</a></li>
                 
                </ul>
                </li>

              <?php } ?>

              

             

            </ul>

            <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
              <a href="<?=base_url('welcome/logout')?>" class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-rocket"></i> Logout
              </a>
            </div>
        </aside>
      </div>

      <!-- Main Content -->
      <div class="main-content">
        <?php $this->load->view($page);?>
        
      </div>
     <!--  <script src="<?=base_url('file')?>/js/check.js"></script> -->

      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; 2023 <div class="bullet"></div> <a href="<?=base_url()?>">Sistem Informasi Peralatan Medis</a>
        </div>
        <div class="footer-right">
          1.0.0
        </div>
      </footer>
    </div>
  </div>

  

  <script type="text/javascript">
   
    $(document).ready(function(){
            $(".select2").select2();
            var parent = '<?php echo $this->session->flashdata('parent'); ?>';
            var child = '<?php echo $this->session->flashdata('child'); ?>';
            var middle = '<?php echo $this->session->flashdata('middle'); ?>';
            if(parent != ""){ 
                $('#'+parent).addClass('active'); 
                if(child != ""){
                    $('#'+parent+'-collapse').addClass('in');
                    $('#'+child).addClass('active');
                    $('#'+middle).css('display','block');
                }
            }
            var type = '<?=$this->session->flashdata('type');?>';
            if(type != "")
            {
                var msg = '<?=$this->session->flashdata('msg');?>';
                var title = '<?=$this->session->flashdata('title');?>';
                Swal.fire({
                  icon: type,
                  title: title,
                  text: msg
                })
            }
        });
  </script>
</body>
</html>
