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
	$role = GetUserLogin('RoleID');
	
	if($edit){
		if(!IsAllowUpdate(MODULTASK)){
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
	}else{
		if(!IsAllowInsert(MODULTASK)){
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
	
	if(!IsOtherModuleActive(MODULCANCHANGEASSIGN)){
	// echo $this->db->last_query();
	 ?>		
		<script>
			$(document).ready(function(){
				$('.cats').attr('disabled',true);
			});
			</script>
	<?php
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
		
	
		<?= form_open(current_url(),array('id'=>'validate', 'enctype'=>'multipart/form-data'))?>
			<div class="form-group">
				<div class="row">
					<div class="col-md-4">
						<label class="">ID Tugas</label>
						<input  class="form-control required" type="text" disabled name="TaskID" value="<?= $edit ? $result[COL_TASKID]: $lastid+1 ?>" />
						<input type="hidden" name="TaskID" value="<?= $edit ? $result[COL_TASKID] : $lastid ?>" />
					</div>
				
					<div class="col-md-8">
						<label class="">Summary Tugas</label>
						<input <?= $role != ADMINROLE ? IsOtherModuleActive(MODULCANCHANGEPERCENTASE) || IsOtherModuleActive(MODULCANCAHANGESTATUS) ? 'disabled' : '': '' ?> class="form-control required" type="text" name="Summary" value="<?= $edit ? $result[COL_SUMMARY] : set_value('Summary') ?>" />
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<div class="row">
					<div class="col-md-4">
						<label class="">Kategori</label>
						<select <?= $role != ADMINROLE ? IsOtherModuleActive(MODULCANCHANGEPERCENTASE) || IsOtherModuleActive(MODULCANCAHANGESTATUS) ? 'disabled' : '': '' ?> name="CategoryID" id="CategoryID" class="required form-control">
							<?=GetComboboxCI($Category, "CategoryID", "CategoryName",$edit?$result[COL_CATEGORYID]:set_value('CategoryID'))?>
						</select>
					</div>
					<div class="col-md-4">
						<label class="">Jenis Tugas</label>
						<select <?= $role != ADMINROLE ? IsOtherModuleActive(MODULCANCHANGEPERCENTASE) || IsOtherModuleActive(MODULCANCAHANGESTATUS) ? 'disabled' : '': '' ?> name="TaskTypeID" id="TaskTypeID" class="required form-control">
							<?=GetComboboxCI($TaskType, "TaskTypeID", "TaskTypeName",$edit?$result[COL_TASKTYPEID]:set_value('TaskTypeID'))?>
						</select>
					</div>
					<div class="col-md-4">
						<label class="">Project</label>
						<select <?= $role != ADMINROLE ? IsOtherModuleActive(MODULCANCHANGEPERCENTASE) || IsOtherModuleActive(MODULCANCAHANGESTATUS) ? 'disabled' : '': '' ?> name="ProjectID" id="ProjectID" class="required form-control">
							<?=GetComboboxCI($Project, "ProjectID", "ProjectName",$edit?$result[COL_PROJECTID]:set_value('ProjectID'))?>
						</select>
					</div>
				
				</div>
			</div>
			
			<div class="form-group">
				<div class="row">
					<div class="col-md-4">
						<label class="">Prioritas</label>
						<select <?= $role != ADMINROLE ? IsOtherModuleActive(MODULCANCHANGEPERCENTASE) || IsOtherModuleActive(MODULCANCAHANGESTATUS) ? 'disabled' : '': '' ?> name="TaskPriorityID" id="TaskPriorityID" class="required form-control">
							<?=GetComboboxCI($Priority, "TaskPriorityID", "TaskPriorityName",$edit?$result[COL_TASKPRIORITYID]:set_value('TaskPriorityID'))?>
						</select>
					</div>
					<div class="col-md-4">
						<label class="">Severity</label>
						<select <?= $role != ADMINROLE ? IsOtherModuleActive(MODULCANCHANGEPERCENTASE) || IsOtherModuleActive(MODULCANCAHANGESTATUS) ? 'disabled' : '': '' ?> name="TaskSeverityID" id="TaskSeverityID" class="required form-control">
							<?=GetComboboxCI($Severity, "TaskSeverityID", "TaskSeverityName",$edit?$result[COL_TASKSEVERITYID]:set_value('TaskSeverityID'))?>
						</select>
					</div>
					<div class="col-md-4 col-sm-4">
						<label>Assign To </label><br>
						<select <?= $role != ADMINROLE ? IsOtherModuleActive(MODULCANCHANGEPERCENTASE) || IsOtherModuleActive(MODULCANCAHANGESTATUS) ? 'disabled' : '': '' ?> class="cats" id="kategori" name="AssignmentTo[]" multiple="">
							
							<?php 
							
							if (!$edit){
								// $this->db->order_by(COL_USERNAME,'asc');
								// $user = $this->db->get(TBL_USERS); 
								GetCombobox("SELECT * FROM ".TBL_USERS." order by ".COL_USERNAME." asc", COL_USERNAME, COL_USERNAME,set_value('AssignmentTo'));
								
							}else{
								
								// $this->db->order_by(COL_USERNAME,'asc');
								// $user = $this->db->get(TBL_USERS); 
// 								
								GetCombobox("SELECT * FROM ".TBL_USERS." order by ".COL_USERNAME." asc", COL_USERNAME, COL_USERNAME, $userassign);
								
							} ?>
						</select>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<div class="row">
									 
					<div class="col-md-4">
						<label class="">Tanggal Mulai</label>
						<div class="input-group">
					        <input class="form-control subdatepicker" <?= $role != ADMINROLE ? IsOtherModuleActive(MODULCANCHANGEPERCENTASE) || IsOtherModuleActive(MODULCANCAHANGESTATUS) ? 'disabled' : '': '' ?> data-date="<?=$edit?$result[COL_STARTEDDATE]:set_value('StartedDate')?>" data-date-format="yyyy-mm-dd" id="StartedDate" type="text" value="<?=$edit?$result[COL_STARTEDDATE]:set_value('StartedDate')?>" name="StartedDate" readonly="">
					    	<span class="add-on input-group-btn">
				                <button type="button" class="btn btn-default">
				                    <span class="glyphicon glyphicon-calendar"></span>
				                </button>
				            </span>
				        </div>
					</div>
					
					<div class="col-md-4">
						<label class="">Tanggal Selesai</label>
						<div class="input-group">
					        <input class="form-control subdatepicker" <?= $role != ADMINROLE ? IsOtherModuleActive(MODULCANCHANGEPERCENTASE) || IsOtherModuleActive(MODULCANCAHANGESTATUS) ? 'disabled' : '': '' ?> data-date="<?=$edit?$result[COL_DUEDATE]:set_value('DueDate')?>" data-date-format="yyyy-mm-dd" id="DueDate" type="text" value="<?=$edit?$result[COL_DUEDATE]:set_value('DueDate')?>" name="DueDate" readonly="">
					    	<span class="add-on input-group-btn">
				                <button type="button" class="btn btn-default">
				                    <span class="glyphicon glyphicon-calendar"></span>
				                </button>
				            </span>
				        </div>
					</div>
				</div>
			</div>
			
			<script type="text/javascript">
										$('.subdatepicker').datepicker({
											dateFormat: "yyyy-mm-dd",
											changeYear : true,
											changeMonth: true,
											showOn: "button",
											buttonImage: "http://192.168.1.13/melody3llg/assets/images/calendar.gif",
											buttonImageOnly: true,
											minDate: "-12M", 
											maxDate: 0
										});
									</script>
			
			<?php
			if ($edit){
			?>
			<div class="form-group">
				<div class="row">
					<div class="col-md-4">
						<label class="">Status Tugas</label>
						<select name="TaskStatusID" id="TaskStatusID" class="form-control">
							<?=GetComboboxCI($StatusTask, "TaskStatusID", "TaskStatusName",$edit?$result[COL_TASKSTATUSID]:set_value('TaskStatusID'))?>
						</select>
					</div>
					<div class="col-md-4">
						
						<label class="">Persentase Complete</label>
						<div class="input-group">
							<input name="Persentase" type="text" id="Persentase" class="form-control" />
							<span class="input-group-addon" id="basic-addon2">%</span>
						</div>	
					</div>
				</div>
			</div>
			
			<?php
			}
			?>
			<div class="form-group">
				<?php if(!$edit){ ?>
				<label>Gambar</label>
				<input type="file" name="userfile" id="userfile" style="display: inline-block" />
				<!-- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; atau &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->
				<!-- <a href="<?=site_url('media/select')?>" class="pilihmedia btn btn-default">Pilih dari media</a> -->
				<input type="hidden" id="MediaID" name="MediaID" value="" />
				<br /><br />
				<span class="uploadstatus"></span>
				<div class="success infomedia alert alert-success" style="display: none">
					
				</div>
				
				<?php }else{ ?>
				
				<label>Gambar</label>
				<input type="file" <?= $role != ADMINROLE ? IsOtherModuleActive(MODULCANCHANGEPERCENTASE) || IsOtherModuleActive(MODULCANCAHANGESTATUS) ? 'disabled' : '': '' ?> name="userfile" id="userfile" style="display: inline-block" />
				
				<!-- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; atau &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				
				<a href="<?=site_url('media/select')?>" class="pilihmedia btn btn-default">Pilih dari media</a> -->
				<input type="hidden" id="MediaID" name="MediaID" value="<?php if (!empty($attach)){ echo $attach[COL_ATTACHMENTID]; } ?>" />
				<br /><br />
				<span class="uploadstatus"></span>
				<div class="success infomedia alert alert-success" style="<?php if(empty($attach)){ ?>display: none<?php } ?>">
					<?php
						if(!empty($attach)){
						// $media = $this->db->where(COL_MEDIAID,$result->DefaultImage)->get(TBL_MEDIA)->row();
							// if(!empty($media)){
					?>
							<img src="<?=base_url()?>assets/images/media/<?=$attach[COL_FILENAME]?>" width="100" /> <br />Gambar sudah dipilih <strong><?=$attach[COL_FILENAME]?></strong>.'
							<a href="#" class="removemedia btn btn-danger"><i class="clip-close"></i></a>
							<?php
							// }
						}
					?>
					
				</div>
				
				<?php } ?>
			</div>
			
			<label>Description</label>		
			<textarea class="editor required" id="<?=rand()?>" rows="20" cols="70" name="Description"><?= $edit ? $result[COL_DESCRIPTION] : set_value('Description') ?></textarea></td>
			<br />
			
			<div class="form-group">
				<div class="row">
					<div class="col-md-4 col-sm-4">
						<div class="form-group">
						<label>Is Private</label><br/>
						<input <?= $role != ADMINROLE ? IsOtherModuleActive(MODULCANCHANGEPERCENTASE) || IsOtherModuleActive(MODULCANCAHANGESTATUS) ? 'disabled' : '': '' ?> type="checkbox" <?=$edit? $result[COL_ISPRIVATE]?'checked=""':'' : 'checked=""'?>  name="IsPrivate" id="IsPrivate" value="1" style="vertical-align: middle" /> <label for="IsPrivate">Private</label>
						</div>
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
	
	<script>
		$(document).ready(function(){
			$('.cats').multiselect({
		        includeSelectAllOption: true,
		        maxHeight: 150,
		        numberDisplayed: 1
		    });
			
			$('#validate').submit(function(){
				for(var instanceName in CKEDITOR.instances)
	    			CKEDITOR.instances[instanceName].updateElement();
			}).validate({
				submitHandler : function(form){
					$('textarea.ckeditor').each(function () {
					   var $textarea = $(this);
					   $textarea.val(CKEDITOR.instances[$textarea.attr('name')].getData());
					});
					//alert('sa');
					var max = parseFloat(toNum($('#LimitCouponPerUser').val()));
					var maxakumulasi = parseFloat(toNum($('#MaximumAkumulasi').val()));
					//alert(max+" dan "+maxakumulasi);
					if(max > maxakumulasi && maxakumulasi > 0){
						alert('Max coupon per user tidak boleh lebih besar dari Max. Akumulasi');
						return false;
					}
					form.submit();
				}
			});
			$('.select').click(function(){
				$(this).select();
			});
						
			$('#userfile').change(function(){
				var idGambar = $('#MediaID').val();
				$(this).attr('disable',true);
				$('.uploadstatus').html('Sedang mengupload file <img src="<?=base_url()?>assets/images/load.gif" alt="ajaxloading" />');
				$('#validate').ajaxSubmit({
					dataType: 'json',
					data: {idgambar : idGambar},
					url: '<?=site_url('media/upload')?>',
					success : function(data){
						$('.removemedia').show();
						$('#MediaID').val(data.mediaid);
						$('.infomedia').html('<img src="<?=base_url()?>assets/images/media/'+data.mediapath+'" width="100" /> <br />Gambar sudah dipilih <strong>'+data.mediapath+'</strong>.  <a href="#" class="removemedia removemedia btn btn-danger"><i class="clip-close"></i></a>').show();
						$(this).attr('disable',false);
						$('.uploadstatus').empty();
					}
				});
			});
			
			$(document).on('click','.removemedia',function(){
				var kos = 0;
				var yakin = confirm('Apa anda yakin?');
				if(!yakin){
					return false;
				}
				$('#MediaID').val(kos);
				$(this).closest('.infomedia').empty().hide();
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
	        <!-- <button type="button" class="btn btn-primary ok">OK</button> -->
	      </div>
	    </div>
	  </div>
	</div>
<?php } ?>
<?= $this->load->view('footer')?>