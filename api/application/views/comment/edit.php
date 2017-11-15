<?= $this->load->view('header')?>
<?php

 if(!IsUserLogin()){ ?>
 	
	<div class='alert alert-warning'>
 		Silahkan <?= anchor('user', 'Login')?> Dulu
	</div>
				
<?php
 }else{
?> 	

	<div class="page-wrapper">	
		<div class="row">
			<div class="col-md-12">
				<h1><?= $title ?></h1>
				<div class="row">
					<?= form_open(current_url(),array('id'=>'validate', 'enctype'=>'multipart/form-data')) ?>
					<div class="form-group">
						<input type="hidden" name="taskid" value="<?= $this->input->get('tid') ?>" />
						<label>File</label>
						
							<!-- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; atau &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<a href="<?=site_url('media/select')?>" class="pilihmedia btn btn-default">Pilih dari media</a> -->
							<div class="uploaderContainer">
							<?php
								$imagenum = 0;
								$attachs = $attach;
								foreach ($attachs->result_array() as $attach) {
									
									$valid_ext = array('jpg','jpeg','png','gif','bmp');
									$ext = strtolower(end(explode('.', $attach[COL_FILENAME])));
									if(!in_array($ext, $valid_ext)){
										$type = FILETYPE_FILE;
									}else{
										$type = FILETYPE_IMAGE;
									}		
								
							?>
								<div class="uploader">
									<input type="hidden" class="MediaID" name="MediaID[]" value="<?php if (!empty($attach)){ echo $attach[COL_ATTACHMENTID]; } ?>" />
									
									<span class="uploadstatus"></span>
									<div class="success infomedia alert alert-success" style="<?php if(empty($attach)){ ?>display: none<?php } ?>">
										<?php
										if($type != FILETYPE_IMAGE ){
										?>	
											File sudah dipilih <strong><?=$attach[COL_FILENAME]?></strong>.'
										<?php
										}else{
											?>
											<img src="<?=base_url()?>assets/images/media/<?=$attach[COL_FILENAME]?>" width="100" /> <br />File sudah dipilih <strong><?=$attach[COL_FILENAME]?></strong>.'
										<?php } ?>
										<a href="#" class="removemedia btn btn-danger"><i class="clip-close"></i></a>
										<a href="#" class="pilihgambar">Ganti File...</a>
									</div>
								</div>
							<?php
									$imagenum++;
								}
							?>
							</div>
							
							<a href="#" id="addAttachment">+ Tambah File</a>
						
					</div>
					<div class="form-group">
						<label>Komentar</label>
						<textarea class="form-control isi-komentar" name="isikomentar"><?= $comment[COL_DESCRIPTION] ?></textarea>
						
					</div>
                    <div class="col-md-3" style="padding-left: 0px;<?=!IsOtherModuleActive(OTHERMODUL_SELECT_COMMENTTYPE)?'display:none;':''?>">
                        <?php
                        $commenttypes = $this->db->order_by(COL_COMMENTYPEID,'asc')->get(TBL_COMMENTTYPES)->result_array();
                        ?>
                        <label for="CommentType">Tipe :</label>
                        <select id="CommentType" class="form-control" name="CommentType" autocomplete="false" style="width: 80%; display: inline">
                            <?php
                            foreach($commenttypes as $type) {
                                if($type[COL_COMMENTYPEID] == $comment[COL_COMMENTYPEID]) echo '<option value="'.$type[COL_COMMENTYPEID].'" selected>'.$type[COL_COMMENTTYPENAME].'</option>';
                                else echo '<option value="'.$type[COL_COMMENTYPEID].'">'.$type[COL_COMMENTTYPENAME].'</option>';
                            }
                            ?>
                        </select>
                    </div>
					<button class="btn btn-default">Simpan</button>	
					<?= form_close() ?>
				</div>
			</div>		
		</div>
	</div>
	<form style="display: none" id="uploader" enctype="multipart/form-data">
		<input type="file" name="userfile" id="userfile" style="display: inline-block" />
	</form>	
<?php
 }
?> 

<script>
	$(document).ready(function(){
		var imgindex = <?= $imagenum ?>;
		
		$(document).on('click','.pilihgambar',function(){
			var myindex = $('.pilihgambar').index(this);
			imgindex = myindex;
			$('#userfile').click();
			return false;
		});
		
		$('#userfile').change(function(){
			var idx = imgindex;
			var idGambar = $('.MediaID').eq(idx).val();
			$(this).attr('disable',true);
			$('.uploadstatus').eq(idx).html('Sedang mengupload file <img src="<?=base_url()?>assets/images/load.gif" alt="ajaxloading" />');
			$('#uploader').ajaxSubmit({
				dataType: 'json',
				data: {idgambar : idGambar},
				url: '<?=site_url('media/upload')?>',
				success : function(data){
					$('.removemedia').eq(idx).show();
					$('.MediaID').eq(idx).val(data.mediaid);
					if(data.type == <?= FILETYPE_FILE ?>){
						$('.infomedia').eq(idx).html('File sudah dipilih <strong>'+data.mediapath+'</strong>.  <a href="#" class="removemedia removemedia btn btn-danger"><i class="clip-close"></i></a> <a href="#" class="pilihgambar">Ganti File...</a>').show();
					}else{
						$('.infomedia').eq(idx).html('<img src="<?=base_url()?>assets/images/media/'+data.mediapath+'" width="100" /> <br />File sudah dipilih <strong>'+data.mediapath+'</strong>.  <a href="#" class="removemedia removemedia btn btn-danger"><i class="clip-close"></i></a> <a href="#" class="pilihgambar">Ganti File...</a>').show();
					}
					$('.pilihgambar').eq(idx).remove();
					$('.uploadstatus').eq(idx).empty();
				},
				error: function(jqXHR, textStatus, errorThrown) {
	                alert(jqXHR.responseText+' SILAHKAN HUBUNGI PROGRAMMER');
	                
	            },
			});
		});
		
		$(document).on('click','.removemedia',function(){
			var kos = 0;
			var yakin = confirm('Apa anda yakin?');
			if(!yakin){
				return false;
			}
			$('#MediaID').val(kos);
			$(this).closest('.uploader').empty().hide();
			return false;
		});
		
		$(document).on('click','.pilihmedia',function(){
			var a = this;
			var par = $(this).parents('li');
			var idx = $('#gambars li').index(par);
			var mdl = $('#mymodal').modal();
			mdl.find('.modal-title').html('Pilih dari media');
			mdl.find('.modal-body').html('<p>Loading&hellip;</p>');
			mdl.find('.modal-body').load($(a).attr('href'),{},function(d){
				var dlg = this;
				mdl.find('.selectit').unbind().click(function(){
					$('.removemedia').show();
					$('#MediaID').val($(this).attr('mediaid'));
					$('.infomedia').html('<img src="<?=base_url()?>assets/images/media/'+$(this).attr('src')+'" width="100" /> <br />Gambar sudah dipilih <strong>'+$(this).attr('title')+'</strong>. <a href="#" class="removemedia removemedia btn btn-danger"><i class="clip-close"></i></a>').show();
					mdl.modal('hide');
					return false;
				});
			})
			return false;
		});	
		$('#addAttachment').click(function(){
			var contentuploader = '<div class="uploader">'+
					'<a href="#" class="pilihgambar">Pilih File...</a>'+
					'<input type="hidden" class="MediaID" name="MediaID[]" value="" />'+
					'<span class="uploadstatus"></span>'+
					'<div class="success infomedia alert alert-success" style="display: none">'+
					'</div>'+
				'</div>';
			$('.uploaderContainer').append(contentuploader);
			return false;
		});
	});		
</script>

<?= $this->load->view('footer')?>