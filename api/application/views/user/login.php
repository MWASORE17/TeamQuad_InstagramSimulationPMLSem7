<html>
	<head>
		<title>Project Management</title>
		<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
		<link href="<?=base_url()?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="<?=base_url()?>assets/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
		<link href="<?=base_url()?>assets/bootstrap/css/font-awesome.css" rel="stylesheet" type="text/css" />
		<link href="<?=base_url()?>assets/bootstrap/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
		<link href="<?=base_url()?>assets/style.css" rel="stylesheet" type="text/css" />
		
		<script src="<?=base_url()?>assets/js/jquery-1.11.1.min.js" type="text/javascript"> </script>
		<script src="<?=base_url()?>assets/bootstrap/js/bootstrap.js" type="text/javascript"> </script>
		<script src="<?=base_url()?>assets/bootstrap/js/bootstrap.min.js" type="text/javascript"> </script>
		
	</head>
	<body>
		<div class="container">

			<div class="row">
				<div class="col-md-4"></div>
				<div class="col-md-4 login-wrapper">
					<div class="row">
						<div class="col-md-6 logo">
							<img class="" style="display: none" src="<?=base_url()?>assets/images/logo-web.png" />
						</div>
						<div class="col-md-6"></div>
					</div>
					<div class="row">
						<div class="col-md-12 login-body">
							<h1>Login</h1>
							<?php if(validation_errors()){ ?>
								<div class="success alert alert-warning">
									<?= validation_errors() ?>
								</div>
							<?php } ?>
							
							<?php				
								if($this->input->get('msg') == 'notmatch'){ ?>
									<div class="success alert alert-warning">
										Username atau Password Salah
									</div>
							<?php } ?>
							<?= form_open('user/login') ?>
							<div class="form-group">
								<label>Username</label>
								<input class="form-control required" name="UserName" type="text" value="<?= set_value('UserName') ?>" />
							</div>
							<div class="form-group">
								<label>Password</label>
								<input class="form-control" name="Password" type="password" />
							</div>
							<input type="submit" class="btn btn-primary" id="Submit" value="Login"/>
							<?= form_close()?>
						</div>
					</div>
				</div>
				<div class="col-md-4"></div>
			</div>
			
		</div>
	</body>	
</html>