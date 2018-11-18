<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="../assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Absen <?php echo isset($title) ? ' | ' . $title : null; ?></title>
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
	<!-- CSS Files -->
	<link href="<?php echo media_url('css/bootstrap.min.css') ?> " rel="stylesheet" />
	<link href="<?php echo media_url('library/swall/sweetalert2.min.css') ?> " rel="stylesheet" />
	<link href="<?php echo media_url('library/bootstrap-datepicker/bootstrap-datepicker.min.css') ?> " rel="stylesheet" />
	<link href="<?php echo media_url('css/paper-dashboard.css?v=2.0.0')  ?>" rel="stylesheet" />

	<script src="<?php echo media_url('js/core/jquery.min.js') ?>"></script>
</head>

<body class="">
	<div class="wrapper ">
		<?php $this->load->view('merchant/sidebar'); ?>
		<div class="main-panel">
			<nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
				<div class="container-fluid">
					<div class="navbar-wrapper">
						<div class="navbar-toggle">
							<button type="button" class="navbar-toggler">
								<span class="navbar-toggler-bar bar1"></span>
								<span class="navbar-toggler-bar bar2"></span>
								<span class="navbar-toggler-bar bar3"></span>
							</button>
						</div>
						<a class="navbar-brand" href="#pablo">Merchant</a>
					</div>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-bar navbar-kebab"></span>
						<span class="navbar-toggler-bar navbar-kebab"></span>
						<span class="navbar-toggler-bar navbar-kebab"></span>
					</button>
					<div class="collapse navbar-collapse justify-content-end" id="navigation">
						<ul class="navbar-nav">
							<li class="nav-item btn-rotate dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<i class="nc-icon nc-single-02"></i>
									<p>
										<span class="d-lg-none d-md-block"><?php echo $this->session->userdata('ufullname_merchant'); ?></span>
									</p>
								</a>
								<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
									<a class="dropdown-item" href="<?php echo site_url('merchant/profile') ?>">Profile</a>
									<a class="dropdown-item" href="<?php echo site_url('merchant/auth/logout?location=' . htmlspecialchars($_SERVER['REQUEST_URI'])) ?>">Logout</a>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</nav>

			<div class="content">
				<?php isset($main) ? $this->load->view($main) : null; ?>
			</div>

			<footer class="footer footer-black  footer-white ">
				<div class="container-fluid">
					<div class="row">
						<div class="credits ml-auto">
							<span class="copyright">
								&copy; Copyright <script>document.write(new Date().getFullYear())</script> APPSKU All Right Reserved
							</span>
						</div>
					</div>
				</div>
			</footer>
		</div>
	</div>
	<!--   Core JS Files   -->
	<script src="<?php echo media_url('js/core/popper.min.js') ?>"></script>
	<script src="<?php echo media_url('js/core/bootstrap.min.js') ?>"></script>
	<script src="<?php echo media_url('library/swall/sweetalert2.min.js') ?>"></script>
	<script src="<?php echo media_url('library/bootstrap-datepicker/bootstrap-datepicker.min.js') ?>"></script>
	<script src="<?php echo media_url('js/plugins/perfect-scrollbar.jquery.min.js') ?>"></script>
	<script src="<?php echo media_url('js/plugins/bootstrap-notify.js') ?>"></script>
	<script src="<?php echo media_url('js/paper-dashboard.min.js?v=2.0.0') ?>"></script>
	<script src="<?php echo media_url('js/jquery.inputmask.bundle.js') ?>"></script>

	<?php if ($this->session->flashdata('success')) { ?>
		<script type="text/javascript">
			$.notify('<?php echo $this->session->flashdata('success'); ?>',
			{
				className: 'success',
				globalPosition: 'top center',
				type: 'success'
			});
		</script>
	<?php } ?>

	<?php if ($this->session->flashdata('failed')) { ?>
		<script type="text/javascript">
			$.notify('<?php echo $this->session->flashdata('failed'); ?>',
			{
				className: 'danger',
				globalPosition: 'top center',
				type: 'danger'
			});
		</script>
	<?php } ?>

	<script type="text/javascript">
		$(document).ready(function(){
			$('.numeric').inputmask("numeric", {
				removeMaskOnSubmit: true,
				radixPoint: ".",
				groupSeparator: ",",
				digits: 2,
				autoGroup: true,
				prefix: 'Rp ', 
				rightAlign: false,
			});
		});
	</script>

	<script type="text/javascript">
		$(".input-group.date").datepicker({
    format: "yyyy-mm-dd",
    autoclose: true,
    todayHighlight: true
  });
	</script>

</body>

</html>