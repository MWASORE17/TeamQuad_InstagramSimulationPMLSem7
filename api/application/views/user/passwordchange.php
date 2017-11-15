<?= $this->load->view('header')?>
<?php

if(!IsUserLogin()){
 	echo "<div class='alert alert-warning'>";
 		echo "Silahkan Login Dulu";
	echo "</div>";
 }else{
 	
?>
<div class="page-wrapper">	
		<div class="row">
			<div class="col-md-12">
				<h1><?= $title ?></h1>
<?php


if($this->input->get('success')){ ?>
	<div class="success alert alert-success">
		Data Disimpan
	</div>
<?php } ?>

<?php if(validation_errors()){ ?>
	<div class="alert alert-error">
		<?= validation_errors() ?>
	</div>
<?php } 
				
	if($this->input->get('msg') == 'plama'){ ?>
		<div class="success alert alert-warning">
			Password Lama tidak cocok
		</div>
<?php } 	
			
	if($this->input->get('msg') == 'pass'){ ?>
		<div class="success alert alert-warning">
			Password baru tidak cocok
		</div>
<?php } ?>
		
	
		<?= form_open(current_url(),array('id'=>'validate', 'enctype'=>'multipart/form-data'))?>
			<div class="form-group">
				<div class="row">
					<div class="col-md-4">
						<label class="">Password Lama</label>
						<input class="form-control required" type="password" name="PasswordLama" id="PasswordLama" value="<?= set_value('Passwordlama') ?>" />
						<!-- <input type="hidden" name="ProjectNo" value="<?= $edit ? $result->ProjectNo : $lastid+1 ?>" /> -->
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">	
					<div class="col-md-4">
						<label class="">Password Baru</label>
						<input class="form-control required" type="password" name="Password" value="" />
					</div>
					<div class="col-md-4">
						<label class="">Ulangi Password</label>
						<input class="form-control required" type="password" name="Password2" value="" />
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-4">
					<button class="btn btn-primary"> Simpan</button>
				</div>
			</div>
			
				
			<?= form_close()?>
			</div>
		</div>
	</div>
</div>

<?php } ?>
<?= $this->load->view('footer')?>