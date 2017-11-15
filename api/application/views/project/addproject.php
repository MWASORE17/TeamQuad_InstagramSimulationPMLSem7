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
		if(!IsAllowUpdate(MODULPROJECT)){
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
		if(!IsAllowInsert(MODULPROJECT)){
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
					
					<input type="hidden" name="ProjectNo" value="<?= $edit ? $result[COL_PROJECTID] : '' ?>" />
					<div class="col-md-8">
						<label class="">Nama Project</label>
						<input class="form-control required" type="text" name="ProjectName" value="<?= $edit ? $result[COL_PROJECTNAME] : set_value('ProjectName') ?>" />
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<div class="row">
					<div class="col-md-4 col-sm-4">
						<div class="form-group">
						<label>Anyone Can View</label><br/>
						<input type="checkbox" <?=$edit? $result[COL_ISANYONECANVIEW]?'checked=""':'' : 'checked=""'?>  name="IsAnyoneCanView" id="IsAnyoneCanView" value="1" style="vertical-align: middle" /> <label for="IsAnyoneCanView">Bisa Lihat</label>
						</div>
					</div>
					<div class="col-md-4 col-sm-4">
						<div class="form-group">
						<label>Anyone Can Add Task</label><br/>
						<input type="checkbox" <?=$edit ? $result[COL_ISANYONECANADDTASK]?'checked=""':'' : ''?> name="IsAnyoneCanAddTask" id="IsAnyoneCanAddTask" value="1" style="vertical-align: middle" /> <label for="IsAnyoneCanAddTask">Tambah Tugas</label>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-4 col-sm-4">
						<div class="form-group">
						<label>Is Notif On Reply</label><br/>
						<input type="checkbox" <?=$edit? $result[COL_ISNOTIFONREPLY]?'checked=""':'' : 'checked=""'?>  name="IsNotifOnReply" id="IsNotifOnReply" value="1" style="vertical-align: middle" /> <label for="IsNotifOnReply">Notif</label>
						</div>
					</div>
					<div class="col-md-4 col-sm-4">
						<div class="form-group">
						<label>Is Comment Closed</label><br/>
						<input type="checkbox" <?=$edit ? $result[COL_ISCOMMENTCLOSED]?'checked=""':'' : ''?> name="IsCommentClosed" id="IsCommentClosed" value="1" style="vertical-align: middle" /> <label for="IsCommentClosed">Comment</label>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-4 col-sm-4">
						<div class="form-group">
						<label>Is Active</label><br/>
						<input type="checkbox" <?=$edit ? $result[COL_ISACTIVE]?'checked=""':'' : 'checked=""'?> name="IsActive" id="IsActive" value="1" style="vertical-align: middle" /> <label for="IsActive">Aktif</label>
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


<?php } ?>
<?= $this->load->view('footer')?>