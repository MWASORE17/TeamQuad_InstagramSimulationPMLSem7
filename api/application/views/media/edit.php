<?php
$this -> load -> view('admin/header');
?>
	<?php if(validation_errors()){ ?>
		<div class="error alert alert-error"><?=validation_errors()?></div>
	<?php } ?>
	<div class="page-header">
		<h1>Media Baru</h1>
	</div>
	<?php
		if($edit){
			if(!IsAllowUpdate(MODULMEDIA) && !IsAllowUpdate(MODULMEDIAIKLAN)){
				?>
				<div class="error alert alert-danger">
					Tidak diizinkan mengubah
				</div>
				<script>
				$(document).ready(function(){
					$('button').hide();
				});
				</script>
				<?php
			}
		}else{
			if(!IsAllowInsert(MODULMEDIA) && !IsAllowInsert(MODULMEDIAIKLAN)){
				?>
				<div class="error alert alert-danger">
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
	?>
	
	<?php
		if(!IsAllowView(MODULMEDIA) && !IsAllowView(MODULMEDIAIKLAN)){
			?>
			<div class="error alert alert-danger">
				Tidak diizinkan melihat
			</div>
			<script>
				$(document).ready(function(){
					$('form').hide();
				});
			</script>
			<?php
		}
	?>
	
	<?php
		if($this->input->get('success') == 1){
	?>
	<div class="success alert alert-success">
		Media sudah disimpan
	</div>		
	<?php
		}
	?>
	
	<form enctype="multipart/form-data" action="<?=current_url()?>" method="post" id="validate">
		<div class="form-group">
			<div class="col-md-6 col-sm-6">
				<label for="MerchandiseName">Nama Media</label>
				<input id="MerchandiseName" type="text" size="30" class="required posttitle form-control" name="MediaName" value="<?=$edit?$result->MediaName:set_value('MediaName')?>"  />
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-6 col-sm-6">
				<label for="Description">Keterangan</label>
				<textarea id="Description" class="form-control" style="height:200px;" name="Description"><?=$edit?$result->Description:set_value('Description')?></textarea>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-6 col-sm-6">
				<?php if($edit){ ?>
				<?php if(FileExtension_Check($result->MediaPath, 'gambar')){ ?>
					<label for="DefaultImage">Gambar</label>
					<img height="150" src="<?=base_url()?>assets/images/media/<?=$result->MediaPath?>" />
					<textarea readonly="" class="select" style="height:30px; width: 100%"><?=base_url().'assets/images/media/'.$result->MediaPath?></textarea>
					<input type="file" size="30" name="userfile" /><br />
				<?php } ?>
				<?php }else{ ?>
					<label for="DefaultImage">Gambar</label>
					<input type="file" size="30" class="required" name="userfile" />
				<?php } ?>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-6 col-sm-6">
				<button class="ui btn btn-primary" type="submit">Simpan</button>
			</div>
		</div>
		<!-- <table border="0" width="100%" class="form">
			<?php if($edit){ ?>
			<?php if(FileExtension_Check($result->MediaPath, 'gambar')){ ?>
			<tr valign="top">
				<td><label for="DefaultImage">Gambar</label></td>
				<td>:</td>
				<td>
				<img height="150" src="<?=base_url()?>assets/images/media/<?=$result->MediaPath?>" />
				<br />
				<input type="file" size="30" name="userfile" /><br />
				<textarea readonly="" class="select" style="height:30px; width: 100%"><?=base_url().'assets/images/media/'.$result->MediaPath?></textarea>
				</td>
			</tr>
			<?php } ?>
			<?php }else{ ?>
			<tr valign="top">
				<td><label for="DefaultImage">Gambar</label></td>
				<td>:</td>
				<td>
					<input type="file" size="30" class="required" name="userfile" /><br />
				</td>
			</tr>
			<?php } ?>
			<tr>
				<td align="center" colspan="3">
					<button class="ui btn btn-primary" type="submit">Simpan</button>
				</td>
			</tr>
		</table> -->
					<?php if($edit){ ?>
					<table class="meta ui-state-default" border="1">
						<tr>
							<td>
								Dibuat Oleh:
							</td>
							<td><?=$result->CreatedBy?></td>
						</tr>
						<tr>
							<td>
								Dibuat Pada:
							</td>
							<td><?=$result->CreatedOn?></td>
						</tr>
						<tr>
							<td>
								Diubah Oleh:
							</td>
							<td><?=$result->UpdateBy?></td>
						</tr>
						<tr>
							<td>
								Diubah Pada:
							</td>
							<td><?=$result->UpdateOn?></td>
						</tr>
					</table>
					<?php } ?>
					<br />
	</form>
<script type="text/javascript">
	$(document).ready(function(){
		$('#validate').validate();
		$('.select').on('click',function(){
			$(this).select();
		});
	});
</script>
<?php
$this -> load -> view('admin/footer');
?>