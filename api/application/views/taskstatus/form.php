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
		if(!IsAllowUpdate(MODULTASKSTATUS)){
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
		if(!IsAllowInsert(MODULTASKSTATUS)){
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
<?php } ?>
		
	
		<?= form_open()?>
			<div class="form-group">
				<div class="row">
					<!-- <div class="col-md-4">
						<label class="">ID Status Tugas</label>
						<input class="form-control required" type="text" disabled name="TaskStatusID" value="<?= $edit ? $result->TaskStatusID: $lastid+1 ?>" />
						
					</div> -->
					<input type="hidden" name="TaskStatusID" value="<?= $edit ? $result->TaskStatusID : '' ?>" />
					<div class="col-md-4">
						<label class="">Nama Status Tugas</label>
						<input class="form-control required" type="text" name="TaskStatusName" value="<?= $edit ? $result->TaskStatusName : set_value('TaskStatusName') ?>" />
					</div>
					<div class="col-md-4">
						<label class="">Order</label>
						<input class="form-control required" type="text" name="Order" value="<?= $edit ? $result->Order : set_value('Order') ?>" />
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<div class="row">
					<div class="col-md-4 col-sm-4">
						<button class="btn btn-primary" type="submit" >Simpan</button>
					</div>	
				</div>
			</div>
						
				
			<?= form_close()?>
			</div>
		</div>
	</div>


<?php } ?>
<?= $this->load->view('footer')?>