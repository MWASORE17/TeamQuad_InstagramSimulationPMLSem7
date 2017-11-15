<?= $this->load->view('header')?>
<?php

 if(!IsUserLogin()){
 	echo "Silahkan Login Dulu";
 }else{
?>
<div class="page-wrapper">	
		<div class="row">
			<div class="col-md-12">
				<h1><?= $title ?></h1>
<?php

	if($edit){
		if(!IsAllowUpdate(MODULTASKCATEGORIES)){
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
		if(!IsAllowInsert(MODULTASKCATEGORIES)){
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
				<!-- <div class="col-md-4">
					<div class="form-group">
						<label class="">ID Kategori</label>
						<input class="form-control" type="text" disabled name="CategoryID" value="<?= $edit ? $result->CategoryID : $lastid+1 ?>" />
						
						  	
						  	
						
					</div>
				</div> -->
				<input type="hidden" name="CategoryID" value="<?= $edit ? $result->CategoryID : '' ?>" />
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label class="">Nama Kategori</label>
							<input class="form-control" type="text" name="CategoryName" value="<?= $edit ? $result->CategoryName : set_value('CategoryName') ?>" />
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="">Parent Kategori</label>
							<!-- <input class="form-control" type="text"  name="ParentCategory" value="<?= $edit ? $result->ParentCategoryID : set_value('ParentCategory') ?>" /> -->
						
							<select name="ParentCategory" id="ParentCategory" class="form-control">
								<?= GetComboboxCI($parentcategory, "CategoryID", "CategoryName",$edit?$result->ParentCategoryID:set_value('CategoryID'))?>
							</select>
						
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<button class="btn btn-primary" type="submit" >Simpan</button>
					</div>
				</div>
				<?= form_close()?>
			</div>
		</div>
	</div>


<?php } ?>
<?= $this->load->view('footer')?>