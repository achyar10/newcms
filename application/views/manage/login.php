<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <!-- Favicon icon -->
  <link rel="icon" type="image/png" sizes="16x16" href="">
  <title>Absen | Login Page</title>
  <!-- CSS Files -->
  <link href="<?php echo media_url('css/bootstrap.min.css') ?> " rel="stylesheet" />
  <link href="<?php echo media_url('css/paper-dashboard.css?v=2.0.0')  ?>" rel="stylesheet" />
  <script src="<?php echo media_url('js/core/jquery.min.js') ?>"></script>

</head>

<body class="login-page" style="background:linear-gradient(120deg, #6BD098 50%, #ECF0F5 50%);">
  <div class="wrapper">
    <div class="full-page section-image">
      <div class="content">
        <div class="container">
          <div class="col-lg-4 col-md-6 ml-auto mr-auto">
            <form class="form" action="<?php echo site_url('manage/auth/login') ?>" method="POST">

              <?php
              if (isset($_GET['location'])) {
                echo '<input type="hidden" name="location" value="';
                if (isset($_GET['location'])) {
                  echo htmlspecialchars($_GET['location']);
                }
                echo '" />';
              } ?>

              <div class="card card-login">
                <div class="card-header">
                  <div class="card-header">
                    <h3 class="text-center">Login</h3>
                  </div>
                </div>
                <div class="card-body">
                  <?php if ($this->session->flashdata('failed')) { ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                      <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close"><i class="nc-icon nc-simple-remove"></i>
                      </button>
                      <span>Email atau Password Salah!!</span>
                    </div>
                  <?php } ?>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="nc-icon nc-email-85"></i>
                      </span>
                    </div>
                    <input type="email" name="email" class="form-control" placeholder="Email" autofocus="">
                  </div>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="nc-icon nc-key-25"></i>
                      </span>
                    </div>
                    <input type="password" name="password" placeholder="Password" class="form-control">
                  </div>
                  <button type="submit" class="btn btn-success btn-block mt-4 mb-3">Login</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!--   Core JS Files   -->
      <script src="<?php echo media_url('js/core/popper.min.js') ?>"></script>
      <script src="<?php echo media_url('js/core/bootstrap.min.js') ?>"></script>
      <script src="<?php echo media_url('js/paper-dashboard.min.js?v=2.0.0') ?>"></script>
      <script type="text/javascript">
        $('form').submit(function(event) {
          if ($(this).hasClass('submitted')) {
            event.preventDefault();
          } else {
            $(this).find(':submit')
            .html('<i class="fa fa-spinner fa-spin"></i> Loading...')
            .attr('disabled', 'disabled');
            $(this).addClass('submitted');
          }
        });
      </script>

    </body>

    </html>