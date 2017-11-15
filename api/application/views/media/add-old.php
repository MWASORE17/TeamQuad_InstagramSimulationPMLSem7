<?php
$this -> load -> view('admin/header');
?>
<?php if(validation_errors()){ ?>
	<div class="error"><?=validation_errors()?></div>
<?php } ?>
<h2>Media Baru</h2>

<?php
	if(!IsAllowInsert(MODULMEDIA)){
		?>
		<div class="error">
			Tidak diizinkan menambah baru
		</div>
		<script>
			$(document).ready(function(){
				$('form').hide();
			});
		</script>
		<?php
	}
?>

<form enctype="multipart/form-data" action="<?=site_url('media/add')?>" method="post" id="validate">
	<table border="0" width="100%" class="form">
		<tr>
			<td><label for="MerchandiseName">Nama</label></td>
			<td>:</td>
			<td>
			<input id="MerchandiseName" type="text" size="30" class="required posttitle" name="MediaName" value=""  />
			</td>
		</tr>
		<tr valign="top">
			<td><label for="Description">Keterangan</label></td>
			<td>:</td>
			<td>			<textarea id="Description" style="width: 400px; height: 200px;" name="Description"></textarea></td>
		</tr>
		<tr valign="top">
			<td><label for="DefaultImage">Gambar</label></td>
			<td>:</td>
			<td>
			<input type="file" size="30" class="required" name="userfile" /><br />
			</td>
		</tr>
		<tr>
			<td align="center" colspan="3">
				<button class="ui" type="submit">Simpan</button>
			</td>
		</tr>
	</table>
</form>
<?php
$this -> load -> view('admin/footer');
?>