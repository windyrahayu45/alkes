<!DOCTYPE html>
<html lang="en">
<head>
  <title>SI - Peralatan Medis</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->  
  <link rel="icon" type="image/png" href="<?=base_url('assets/images/w.png')?>"/>
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?=base_url('file/login/')?>vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?=base_url('file/login/')?>fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?=base_url('file/login/')?>fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?=base_url('file/login/')?>vendor/animate/animate.css">
<!--===============================================================================================-->  
  <link rel="stylesheet" type="text/css" href="<?=base_url('file/login/')?>vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?=base_url('file/login/')?>vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?=base_url('file/login/')?>vendor/select2/select2.min.css">
<!--===============================================================================================-->  
  <link rel="stylesheet" type="text/css" href="<?=base_url('file/login/')?>vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?=base_url('file/login/')?>css/util.css">
  <link rel="stylesheet" type="text/css" href="<?=base_url('file/login/')?>css/main.css">
<!--===============================================================================================-->
</head>
<body>
  
  <div class="limiter">
    <div class="container-login100">
      <div class="wrap-login100">
        <div class="login100-form-title" style="background-image: url(<?=base_url('file/login/')?>images/bg-01.jpg);">
          <span class="login100-form-title-1">
           Rumah Sakit Umum Daerah Kota Solok<br> SI - Peralatan Medis
          </span>
        </div>

        <form action="<?php echo site_url('welcome/login'); ?>" method="post" name="fool_login" onSubmit="return ValidateActInsert()" class="login100-form validate-form">
          <div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
            <span class="label-input100">Username</span>
            <input class="input100" type="text" name="username" placeholder="Masukan username" id="username">
            <span class="focus-input100"></span>
          </div>

          <div class="wrap-input100 validate-input m-b-18" data-validate = "Password is required">
            <span class="label-input100">Password</span>
            <input class="input100" type="password" name="password" placeholder="Masukan password">
            <span class="focus-input100"></span>
          </div>


          <div class="wrap-input100 validate-input m-b-18" data-validate = "Keamanan is required">
            <?php echo $captcha;?><br>
            <span class="label-input100">Keamanan</span>
            <input class="input100" type="text" name="captcha" placeholder="Masukan Kode Diatas">
            <span class="focus-input100"></span>
          </div>

          

          <div class="container-login100-form-btn">
            <button class="login100-form-btn" style="background-color: #6777ef">
              Login
            </button>
          </div>


        <!--   <div class="col-lg-12" style="margin-top: 20px;">
        
            <div>
              <a href="#" class="txt1">
                Forgot Password?
              </a>
            </div>
          </div> -->

        </form>
      </div>
    </div>
  </div>
  
<!--===============================================================================================-->
  <script src="<?=base_url('file/login/')?>vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
  <script src="<?=base_url('file/login/')?>vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
  <script src="<?=base_url('file/login/')?>vendor/bootstrap/js/popper.js"></script>
  <script src="<?=base_url('file/login/')?>vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
  <script src="<?=base_url('file/login/')?>vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
  <script src="<?=base_url('file/login/')?>vendor/daterangepicker/moment.min.js"></script>
  <script src="<?=base_url('file/login/')?>vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
  <script src="<?=base_url('file/login/')?>vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
  <script src="<?=base_url('file/login/')?>js/main.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script type="text/javascript">

    var type = '<?=$this->session->flashdata('type');?>';
    if(type != "")
    {
        var msg = '<?=$this->session->flashdata('msg');?>';
        var title = '<?=$this->session->flashdata('title');?>';
        //swal(title,msg,type);
        Swal.fire({
          icon: type,
          title: title,
          text: msg
        })
    }
  </script>
</body>
</html>