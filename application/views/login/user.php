<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Sipedas Online</title>
  <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
  <link rel="shortcut icon" href="<?=base_url('assets/images/w.png')?>">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?=base_url()?>/file/login/css/login.css">
</head>
<body>
  <main class="d-flex align-items-center min-vh-100 py-3 py-md-0">
    <div class="container">
      <div class="card login-card">
        <div class="row no-gutters">
          <div class="col-md-5">
            <img src="<?=base_url()?>/assets/images/2124332.jpg" alt="login" class="login-card-img" style="object-fit:cover;width: 120%">
          </div>
          <div class="col-md-7">
            <div class="card-body">
              <div class="brand-wrapper">
                <div class="row">
                  <div class="col-md-2" style="text-align-last: center;">
                     <img src="<?=base_url()?>/assets/images/w.png" alt="logo" class="logo" style="height: 81px;">
                  </div>
                  <div class="col-md-10" style="padding: 10px;">
                    <h4>Sistem Informasi PKK dan Dasawisma Online (SIPEDAS)</h4>
                  </div>
                </div>
               
                
              </div>
              <p class="login-card-description" style="font-size: 20px">Welcome Back to your account</p>

              <form  action="<?php echo site_url('pengguna/login/cek_login'); ?>" method="post" name="fool_login" onSubmit="return ValidateActInsert()" class="needs-validation" novalidate >
                  <div class="form-group mb-6">
                    <label for="email" class="sr-only">Username</label>
                    <input type="text" name="username" id="username" class="form-control" placeholder="Username" required="">
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                  </div>
                  <div class="form-group mb-6">
                    <label for="password" class="sr-only">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="***********" required="">
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                  </div>
                  <div class="form-group mb-6">
                    <?php echo $captcha;?><br>
                    <label>Masukan Kode diatas</label>
                    <input type="text" name="captcha" class="form-control" id="captcha"  maxlength="4" required="">
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                  </div>
                  <input name="login" id="login" class="btn btn-block login-btn mb-4" type="submit" value="Login">
                </form>
               
            </div>
          </div>
        </div>
      </div>
      
    </div>
  </main>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <script src="<?=base_url('file')?>/js/custom.js"></script>
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

    function ValidateActInsert() {
      var specialChars = /[^a-zA-Z0-9 ]/g;
      if (document.fool_login.username.value.match(specialChars)) {
          swal('Perhatian!','Anda menggunakan spesial karakter','warning');
          document.fool_login.username.focus();
          return false;
      }
      else if (document.fool_login.password.value.match(specialChars)) {
          swal('Perhatian!','Anda menggunakan spesial karakter','warning');
          document.fool_login.password.focus();
          return false;
      }
       else if (document.fool_login.captcha.value.match(specialChars)) {
         swal('Perhatian!','Anda menggunakan spesial karakter','warning');
          document.fool_login.captcha.focus();
          return false;
      }
      return (true);
  }

  
</script>
 
</body>
</html>
