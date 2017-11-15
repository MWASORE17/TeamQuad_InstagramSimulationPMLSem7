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

	if($edit){
		if(!IsAllowUpdate(MODULUSER)){
			?>
			<div class="alert alert-danger">
				Tidak diizinkan mengubah
			</div>
			<style>
				form{
					display: none;
				}
			</style>
			<script>
				$(document).ready(function(){
					$('button').remove();
				});
			</script>
			<?php
		}
	}else{
		if(!IsAllowInsert(MODULUSER)){
		?>
			<div class="alert alert-danger">
				Tidak diizinkan membuat baru
			</div>
			<script>
			$(document).ready(function(){
				$('form').hide();
			});
			</script>
		<?php
		
		}
	}
			
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
				
	if($this->input->get('msg') == 'user'){ ?>
		<div class="success alert alert-warning">
			Username Telah Terdaftar
		</div>
<?php } 	
			
	if($this->input->get('msg') == 'pass'){ ?>
		<div class="success alert alert-warning">
			Password tidak cocok
		</div>
<?php } ?>
		
	
		<?= form_open()?>
			<div class="form-group">
				<div class="row">
					<div class="col-md-4">
						<label class="">UserName</label>
						<?php
						if($edit){
						?>
						<input class="form-control required" disabled type="text" name="UserName" value="<?= $result[COL_USERNAME] ?>" />
						<input type="hidden" name="UserName" value="<?= $result[COL_USERNAME] ?>" />
						<?php
						}else{
						?>
						<input class="form-control required" type="text" name="UserName" value="<?=  set_value('UserName') ?>" />
						<!-- <input type="hidden" name="UserName" value="<?= $edit ? $result[COL_USERNAME] : set_value('UserName') ?>" /> -->
						<?php
						}
						?>
					</div>
					<div class="col-md-4">
						<label class="">Email Address</label>
						<input class="form-control required" type="EmailAddress" name="EmailAddress" value="<?= $edit ? $result[COL_EMAILADDRESS] : set_value('EmailAddress') ?>" />
					</div>
					<div class="col-md-4">
						<label class="">Password</label>
						<input class="form-control required" type="password" name="Password" value="" />
					</div>
					<div class="col-md-4">
						<label class="">Ulangi Password</label>
						<input class="form-control required" type="password" name="Password2" value="" />
					</div>
					
				</div>
			
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-4">
					<div class="form-group">
						<label class="">Role</label>
						<select name="RoleNo" id="RoleNo" class="form-control">
								<?= GetComboboxCI($role, "RoleID", "RoleName",$edit?$result[COL_ROLEID] : set_value('RoleNo'))?>
						</select>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<div class="row">
					<div class="col-md-4 col-sm-4">
						<div class="form-group">
							<label>Is Suspend?</label><br/>
							<input type="checkbox" <?=$edit? $result[COL_ISSUSPEND]?'checked=""':'' : ''?>  name="IsSuspend" id="IsSuspend" value="1" style="vertical-align: middle" /> <label for="IsSuspend">Suspend</label>
						</div>
					</div>
				</div>
			</div>
				
			<div class="form-group">
				<div class="row">
					<div class="col-md-4 col-sm-4">
						<button class="btn btn-primary" type="submit">Simpan</button>
					</div>	
				</div>
			</div>
						
				
			<?= form_close()?>
			</div>
		</div>
	</div>
</div>

<?php } ?>
<?= $this->load->view('footer')?>