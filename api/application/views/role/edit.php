<?php $this->load->view('header')?> 

<?php
if(!IsUserLogin()){
 	echo "<div class='alert alert-warning'>";
 		echo "Silahkan Login Dulu";
	echo "</div>";
}else if(!IsAllowUpdate(MODULROLE)){
	echo "<div class='alert alert-warning'>";
 		echo "Tidak diizinkan mengubah data";
	echo "</div>";
}else{
?>
<div class="page-wrapper">	
		<div class="row">
			<div class="col-md-12">
				<h1><?= $title ?></h1>
<?php
	
	if(!IsAllowUpdate(MODULROLE)){
			?>
			<div class="alert alert-danger">
				Tidak diizinkan mengubah
			</div>
			<script>
			$(document).ready(function(){
				$('button').hide();
			});
			</script>
			<?php
		}
				
if($this->input->get('success')){ ?>
	<div class="success alert alert-success">
		Role sudah disimpan
	</div>
<?php } ?>

<?php if(validation_errors()){ ?>
	<div class="alert alert-danger">
		<?= validation_errors() ?>
	</div>
<?php } ?>



<?= form_open(site_url('role/edit/'.$result[COL_ROLEID]),array('id'=>'validate')) ?>

<div class="form-group">
	<div class="row">
		<div class="col-md-4 col-sm-4">
			<label>Nama Role</label>
			<input value="<?=$result[COL_ROLENAME]?>" type="text" class="required form-control" name="RoleName" /><br />
		</div>
	</div>
	
</div>

<!-- <div class="form-group">
	<div class="col-md-4 col-sm-4">
		<div class="row">
			<label>Izinkan Login Admin</label><br />
			<input type="checkbox" class=""  value="1" name="IsUserCanLogin" />
			<label for="IsUserCanLogin">Izinkan Login Admin</label>
		</div>
	</div>
</div> -->
<br />

<style type="text/css">
	#modules th{
		background: #FFEE98;
	}
	a.ui{
		margin: 3px;
	}
</style>



<fieldset>
	<legend>Hak Backend</legend>
	<?php if($result[COL_ROLEID] != UNLOGINROLE){ ?>
		<label>Berdasarkan Modul</label>
		<table id="modules" class="table tab-bordered table-striped">
			<tr>
				<th>
					Modul
				</th>
				<th class="text-center">
					Buat
					<br />
					<input type="checkbox" class="maintopcekbox" id="cekbox-buat" />
				</th>
				<th class="text-center">Ubah <br /> <input type="checkbox" class="maintopcekbox" id="cekbox-ubah" /></th>
				<th class="text-center">Hapus
					<br />
					<input type="checkbox" class="maintopcekbox" id="cekbox-hapus" />
				</th>
				<th class="text-center">Lihat
					<br />
					<input type="checkbox" class="maintopcekbox" id="cekbox-lihat" />
					</th>
			</tr>
			<?php
				foreach ($modules->result_array() as $modul) {
					$id = $modul[COL_MODULEID];
					?>
					<tr>
						<td>
							<input type="checkbox" class="mainleftcekbox" id="cekbox-<?=$id?>" />
							<label for="cekbox-<?=$id?>"><?=$modul[COL_MODULENAME]?></label>
							<input type="hidden" name="modules[]" value="<?=$modul[COL_MODULEID]?>" />
						</td>
						<td align="center"><input <?php if(IsAllowInsert($id,$result[COL_ROLEID])) echo 'checked=""' ?> class="cekbox-buat cekbox-<?=$id?>" type="checkbox" name="<?=$modul[COL_MODULEID]?>-Buat" value="1" /></td>
						<td align="center"><input <?php if(IsAllowUpdate($id,$result[COL_ROLEID])) echo 'checked=""' ?> class="cekbox-ubah cekbox-<?=$id?>" type="checkbox" name="<?=$modul[COL_MODULEID]?>-Ubah" value="1" /></td>
						<td align="center"><input <?php if(IsAllowDelete($id,$result[COL_ROLEID])) echo 'checked=""' ?> class="cekbox-hapus cekbox-<?=$id?>" type="checkbox" name="<?=$modul[COL_MODULEID]?>-Hapus" value="1" /></td>
						<td align="center"><input <?php if(IsAllowView($id,$result[COL_ROLEID])) echo 'checked=""' ?> class="cekbox-lihat cekbox-<?=$id?>" type="checkbox" name="<?=$modul[COL_MODULEID]?>-Lihat" value="1" /></td>
					</tr>
					<?php
				}
			?>
		</table>
		<label>Berdasarkan Modul Lain</label> (<label><input type="checkbox" class="allocekbox" value="1" /> Semua Modul Lain</label>)
		<div class="row">
			<?php
				foreach ($othermodules->result_array() as $modul) {
					$id = $modul[COL_OTHERMODULEID];
					?>
					<div class="col-md-4 col-sm-6">
						<label for="ocekbox-<?=$id?>"><input <?php if(IsOtherModuleActive($id,$result[COL_ROLEID])) echo 'checked=""' ?> type="checkbox" name="othermodules[]" value="<?= $id ?>" class="ocekbox" id="ocekbox-<?=$id?>" /> <?=$modul[COL_OTHERMODULENAME]?></label>
					</div>
					<?php
				}
			?>
		</div>

		<br />
	<?php } ?>
	
</fieldset>

<br />

<p>
	<button class="ui btn btn-primary" type="submit">Simpan</button>
</p>

<?= form_close(); ?>
</div>
</div>
</div>

<?php } ?>
<script type="text/javascript">
$(document).ready(function(){
		
	$('.mainleftcekbox').click(function(){
		if($(this).prop('checked')){
			$('.'+$(this).attr('id')).prop('checked',true);
		}else{
			$('.'+$(this).attr('id')).prop('checked',false);
		}
	});
	$('.maintopcekbox').change(function(){
		if($(this).prop('checked')){
			$('.'+$(this).attr('id')).prop('checked',true);
		}else{
			$('.'+$(this).attr('id')).prop('checked',false);
		}
	});	
	$('.allocekbox').change(function(){
		var me = $(this);
		$('.ocekbox').prop('checked',me.is(':checked'));
	});
});
</script>
<div class="modal fade" id="mymodal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <label class="modal-title"></label>
      </div>
      <div class="modal-body">
        <p>Loading&hellip;</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary ok">OK</button>
      </div>
    </div>
  </div>
</div>


<?php $this->load->view('footer') ?>