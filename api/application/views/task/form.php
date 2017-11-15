<?= $this->load->view('header')?>
<!-- <script src="<?= base_url() ?>assets/js/jquery-ui-1.8.18.custom.min.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.ui.datepicker.validation.min.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.validate.min.js"></script> -->
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
				?>		
				<p>
					Last Update By : <strong><?= empty($result[COL_UPDATEBY]) ? '-' : $result[COL_UPDATEBY] ?></strong>  
					 On : <strong><?= empty($result[COL_UPDATEON])||$result[COL_UPDATEON] =='0000-00-00 00:00:00'||$result[COL_UPDATEON] == null ? '-' : $result[COL_UPDATEON] ?></strong>
					
				</p>
				<?php } ?>
<?php
	$role = GetUserLogin('RoleID');
	
	if($edit){
		if(!IsAllowUpdate(MODULTASK) || $result[COL_ISCLOSED]){
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
		}else if(!IsOtherModuleActive(OTHERMODUL_CANEDITTASKANOTHERUSER)){
			$taskid = $result[COL_TASKID];
			$userlogin = GetUserLogin("UserName");
			
			
		}
	}else{
		if(!IsAllowInsert(MODULTASK)){
		?>
			<div class="alert alert-danger">
				Tidak diizinkan membuat baru
			</div>
			
			<style>
			 	form{
			 		display: none;
			 	}
			 </style>
			
		<?php
		
		}
	}
	
	if(!IsOtherModuleActive(OTHERMODUL_CANCHANGEASSIGN)){
	// echo $this->db->last_query();
	 ?>	
	 	<style>
		 	.assign{
		 		display: none;
		 	}
		 </style>	
		
	<?php
	}
	
	
	
	if (!IsOtherModuleActive(OTHERMODUL_CANCHANGEPERCENTASE)){
		?>
		 <style>
		 	.persentaseTugas{
		 		display: none;
		 	}
		 </style>
		<?php
	}
	if (!IsOtherModuleActive(OTHERMODUL_CANCAHANGESTATUS)){
		?>
		 <style>
		 	.statusTugas{
		 		display: none;
		 	}
		 </style>
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
<?php } 

	if($this->input->get('error') == 'ed'){
		?>
		<div class="error">Tanggal Selesai tidak boleh dibawah Tanggal Mulai</div>
		<?php
	}
?>
		
	
		<?= form_open(current_url(),array('id'=>'validate', 'enctype'=>'multipart/form-data'))?>
			<div class="form-group">
				<div class="row row1">
					<!-- <div class="col-md-4">
						<label class="">ID Tugas</label>
						<input  class="form-control required" type="text" disabled name="TaskID" value="<?= $edit ? $result[COL_TASKID]: $lastid+1 ?>" />
						
					</div> -->
					<input type="hidden" name="TaskID" value="<?= $edit ? $result[COL_TASKID] : '' ?>" />
					<div class="col-md-8">
						<label class="">Summary Tugas</label>
						<input  class="form-control required summary" type="text" name="Summary" value="<?= $edit ? $result[COL_SUMMARY] : set_value('Summary') ?>" />
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<div class="row row2 row-field">
					<div class="col-md-4">
						<label class="">Kategori</label>
						<select name="CategoryID" id="CategoryID" class="required form-control">
							<?=GetComboboxCI($Category, "CategoryID", "CategoryName",$edit?$result[COL_CATEGORYID]:set_value('CategoryID'))?>
						</select>
					</div>
					<div class="col-md-4">
						<label class="">Jenis Tugas</label>
						<select  name="TaskTypeID" id="TaskTypeID" class="required form-control">
							<?=GetComboboxCI($TaskType, "TaskTypeID", "TaskTypeName",$edit?$result[COL_TASKTYPEID]:set_value('TaskTypeID'))?>
						</select>
					</div>
					<div class="col-md-4" id="swoNo">
						<label class="">SWONo</label>
						<input class="form-control swo" type="text" name="Swono" value="<?=$edit ? $result[COL_SWONO]:set_value('Swono')?>"/>
					</div>
					
					
				
				</div>
			</div>
			
			<div class="form-group row3">
				<div class="row">
				<div class="col-md-4">
						<label class="">Project</label>
						<select  name="ProjectID" id="ProjectID" class="required form-control">
							<?=GetComboboxCI($Project, "ProjectID", "ProjectName",$edit?$result[COL_PROJECTID]:set_value('ProjectID'))?>
						</select>
					</div>
					<div class="col-md-4">
						<label class="">Prioritas</label>
						<select  name="TaskPriorityID" id="TaskPriorityID" class="required form-control">
							<?=GetComboboxCI($Priority, "TaskPriorityID", "TaskPriorityName",$edit?$result[COL_TASKPRIORITYID]:set_value('TaskPriorityID'))?>
						</select>
					</div>
					<div class="col-md-4">
						<label class="">Severity</label>
						<select  name="TaskSeverityID" id="TaskSeverityID" class="required form-control">
							<?=GetComboboxCI($Severity, "TaskSeverityID", "TaskSeverityName",$edit?$result[COL_TASKSEVERITYID]:set_value('TaskSeverityID'))?>
						</select>
					</div>
					
				</div>
			</div>
			
			<div class="form-group">
				<div class="row row4">
					<div class="col-md-4 col-sm-4 version">
						<label>Version </label><br>
						<select  name="VersionID" id="VersionID" class="required form-control">
							<?=GetComboboxCI($Version, "VersionID", "VersionName",$edit?$result[COL_VERSIONID]:set_value('VersionID'))?>
						</select>
					</div>
									 
					<div class="col-md-4">
						<label class="">Tanggal Mulai</label>
						<div class="input-group">
					        <span class="add-on input-group-btn">
				                <button disabled type="button" class="btn btn-default tanggal">
				                    <span class="glyphicon glyphicon-calendar "></span>
				                </button>
				            </span>
					        <input id="StartDate" class="form-control subdatepicker date1" readonly="" <?= !IsOtherModuleActive(OTHERMODUL_CANCHANGE_STARTDATE) ? 'disabled=""' : '' ?> data-date="<?=$edit?$result[COL_STARTEDDATE]:set_value('StartedDate')?>" data-date-format="yyyy-mm-dd" id="StartedDate" type="text" value="<?=$edit?$result[COL_STARTEDDATE]:date('Y-m-d')?>" name="StartedDate">
					    	<?php if(!IsOtherModuleActive(OTHERMODUL_CANCHANGE_STARTDATE)){ ?>
								<input type="hidden" value="<?= $edit?$result[COL_STARTEDDATE]:date('Y-m-d')?>" name="StartedDate" />
							<?php } ?>
					    	<span class="add-on input-group-btn">
				                <button type="button" <?= !IsOtherModuleActive(OTHERMODUL_CANCHANGE_STARTDATE) ? 'disabled=""' : '' ?> class="btn btn-default clear-tanggal1">
				                    <span >Clear</span>
				                </button>
				            </span>
				        </div>
					</div>
					
					<div class="col-md-4">
						<label class="">Tanggal Selesai</label>
						<div class="input-group">
					        <span class="add-on input-group-btn">
				                <button disabled type="button" class="btn btn-default tanggal">
				                    <span class="glyphicon glyphicon-calendar "></span>
				                </button>
				            </span>
					        <input id="EndDate" class="form-control subdatepicker required date2 endDate" readonly=""  data-date="<?=$edit?$result[COL_DUEDATE]:set_value('DueDate')?>" data-date-format="yyyy-mm-dd" id="DueDate" type="text" value="<?=$edit?$result[COL_DUEDATE]:set_value('DueDate')?>" name="DueDate" >
					    	<span class="add-on input-group-btn">
				                <button type="button" class="btn btn-default clear-tanggal2">
				                    <span >Clear</span>
				                </button>
				            </span>
				        </div>
					</div>
					<div class="col-md-4 col-sm-4 assign">
						<label>Assign To </label><br>
						<select  class="cats" id="kategori" name="AssignmentTo[]" multiple="">
							
							<?php 
							
							if (!$edit){
								// $this->db->order_by(COL_USERNAME,'asc');
								// $user = $this->db->get(TBL_USERS); 
								GetCombobox("SELECT * FROM ".TBL_USERS." order by ".COL_USERNAME." asc", COL_USERNAME, COL_USERNAME,set_value('AssignmentTo'));
								
							}else{
								
								// $this->db->order_by(COL_USERNAME,'asc');
								// $user = $this->db->get(TBL_USERS); 
								
								GetCombobox("SELECT * FROM ".TBL_USERS." order by ".COL_USERNAME." asc", COL_USERNAME, COL_USERNAME, $userassign);
								
							} ?>
						</select>
					</div>
				</div>
			</div>
			
			<script type="text/javascript">
				$('.subdatepicker').datepicker({
					dateFormat: "yyyy-mm-dd",
					changeYear : true,
					changeMonth: true,
					showOn: "button",
					buttonImage: "<?= base_url() ?>assets/images/calendar.gif",
					buttonImageOnly: true,
					minDate: "-12M", 
					maxDate: 0,
					autoclose: true,
					
				});
				
				$('.clear-tanggal1').click(function(){
					$('.date1').val('<?= isodate(date('Y-m-d')) ?>');
					
				});
				$('.clear-tanggal2').click(function(){
					$('.date2').val('<?= date('Y-m-d') ?>');
					
				});
				
				// var from = $('.date1').val();
				// var to = $('.date2').val();
// 				
				// if(Date.parse(from) > Date.parse(to)){
				   // alert("Invalid Date Range");
				// }
				// else{
				   // alert("Valid date Range");
				// }
// 				
// 				
				 // $('submit').click(function(){
			        // var myDAte = $('.date2').datepicker( "getDate" );
			        // var curDate = $('.date1').datepicker( "getDate" );
// 			
			        // if(curDate>myDAte){
			            // alert('current date is high');
			        // }
			        // else{
			            // alert('selected date is high');
			        // }
			    // });
							
				// $('.date2').change(function(){
					// // alert('y');
					// var currentDate = $( ".date2" ).datepicker( "getDate" );
					// var date1 = $('.date1').val();
					// alert(currentDate);
					// // var date2 = $('.date2').val();
					// if (date2 < date1){
						// alert('Tanggal berakhir tidak boleh lebih kecil');
					// }
				// });
				
			</script>
			
			<?php
			if ($edit){
			?>
			<div class="form-group">
				<div class="row row5">
					<div class="col-md-4 statusTugas">
						<label class="">Status Tugas</label>
						<select name="TaskStatusID" id="TaskStatusID" class="form-control">
							<?=GetComboboxCI($StatusTask, "TaskStatusID", "TaskStatusName",$edit?$result[COL_TASKSTATUSID]:set_value('TaskStatusID'))?>
						</select>
					</div>
					<div class="col-md-4 persentaseTugas">
						
						<label class="">Persentase Complete</label>
						<div class="input-group">
							<input name="Persentase" value="<?= $edit?$result[COL_PERCENTCOMPLETE]:set_value('Percentase') ?>" type="text" id="Persentase" class="form-control" />
							<span class="input-group-addon" id="basic-addon2">%</span>
						</div>	
					</div>
				</div>
			</div>
			
			<?php
			}
			?>
			<div class="form-group">
				<div class="row6" >
					<div id="fileUploader" style="border: 1px solid #e7e7e7; border-radius: 5px;"></div>
				</div>
			</div>
			
			<div class="form-group">
                <div class="row row6">                    
                    <div id="imgFilesShow" class="col-md-12">
                        <?php $imagenum = 0; 
						if($edit){ 
						
							$attachs = $attach;
							foreach ($attachs->result_array() as $attach) {
								
								$valid_ext = array('jpg','jpeg','png','gif','bmp');
								$ext = strtolower(end(explode('.', $attach[COL_FILENAME])));
								if(!in_array($ext, $valid_ext)){
						?>
						
							<div class="col-md-4 col-sm-4 text-center other-pic" style="margin-bottom:10px">
								<div class="pull-right clearFile" id="FileClear-<?php if (!empty($attach)){ echo $attach[COL_ATTACHMENTID]; } ?>"></div>
								<span><strong><?=$attach[COL_FILENAME]?></strong></span>
								<input type="hidden" class="MediaID" name="MediaID[]" value="<?php if (!empty($attach)){ echo $attach[COL_ATTACHMENTID]; } ?>" />
							</div>
								
						<?php
								}else{
						?>
						
							<div class="col-md-4 col-sm-4 text-center other-pic" style="margin-bottom:10px">
								<div class="pull-right clearFile" id="FileClear-<?php if (!empty($attach)){ echo $attach[COL_ATTACHMENTID]; } ?>"></div>
								<img src="<?=base_url()?>assets/images/media/<?=$attach[COL_FILENAME]?>" style="max-height:250px; max-width:85%;" />
								<span><strong><?=$attach[COL_FILENAME]?></strong></span>
								<input type="hidden" class="MediaID" name="MediaID[]" value="<?php if (!empty($attach)){ echo $attach[COL_ATTACHMENTID]; } ?>" />
							</div>
								
						<?php
								}
								$imagenum++;
							}
						}?>
				
                    </div>
                </div>
            </div>
			
			<div class="row7">
				<label>Description</label>		
				<textarea class="editor required" id="<?=rand()?>" rows="20" cols="70" name="Description"><?= $edit ? $result[COL_DESCRIPTION] : set_value('Description') ?></textarea></td>
				<br />
			</div>
			<div class="form-group">
				<div class="row row8">
					<div class="col-md-4 col-sm-4">
						<div class="form-group">
						<label>Is Private</label><br/>
						<input  type="checkbox" <?=$edit? $result[COL_ISPRIVATE]?'checked=""':'' : 'checked=""'?>  name="IsPrivate" id="IsPrivate" value="1" style="vertical-align: middle" /> <label for="IsPrivate">Private</label>
						</div>
					</div>
					
				</div>
			</div>
			
				
			<div class="form-group">
				<div class="row">
					<div class="col-md-4 col-sm-4">
						<button class="btn btn-primary Submit" type="submit" >Simpan</button>
					</div>	
				</div>
			</div>
						
				
			<?= form_close()?>
			</div>
		</div>
	</div>
	<form style="display: none" id="uploader" enctype="multipart/form-data">
		<input type="file" name="userfile" id="userfile" style="display: inline-block" />
	</form>
	<script>
		function setSwo(bool){
			//alert('tes');
			if(bool)
				$("#swoNo").show();
			else
				$("#swoNo").hide();
		}
		$(document).ready(function(){
			var edit = "<?php echo $edit ?>";
			var imgindex = <?= $imagenum ?>;
			var laporanCustomerId = "<?php echo $laporanCustomerId; ?>";
			if(!(edit && laporanCustomerId==$("#TaskTypeID option:selected").val()))
				setSwo(false);
			$("#TaskTypeID").change(function() {
				
				if($("#TaskTypeID option:selected").val()!= laporanCustomerId){
					setSwo(false);
				}
				else{
					setSwo(true);
				}
			});
			
			var file = $("#fileUploader").dxFileUploader(
                        $.extend({
							uploadUrl: '<?=site_url('media/upload')?>' + '?idgambar=' + imgindex,
							name: "userfile",
                            onUploaded: function (e) {
                                console.log(e);
                                var fileRespon = JSON.parse(e.request.response);
								var imgbox = "";
								console.log(fileRespon);
								if(fileRespon){
									if (fileRespon.isimage) {
										imgbox = '<div class="col-md-4 col-sm-4 text-center other-pic" style="margin-bottom:10px">' +
													'<div class="pull-right" id="FileClear-' + fileRespon.mediaid + '"></div>' +
													'<img src="' + fileRespon.fullmediapath + '" style="max-height:250px; max-width:85%;" />' +
													'<span><strong>' + fileRespon.mediapath + '</strong></span>' +
													'<input type="hidden" class="MediaID" name="MediaID[]" value="' + fileRespon.mediaid + '" />' +
												'</div>';

									} else {
										imgbox = '<div class="col-md-4 col-sm-4 text-center other-pic" style="margin-bottom:10px">' +
													'<div class="pull-right" id="FileClear-' + fileRespon.mediaid + '"></div>' +
													'<span><strong>' + fileRespon.mediapath + '</strong></span>' +
													'<input type="hidden" class="MediaID" name="MediaID[]" value="' + fileRespon.mediaid + '" />' +
												'</div>';
									}												
								}
								imgindex++;
								$("#imgFilesShow").append(imgbox);
								$("#FileClear-" + fileRespon.mediaid).dxButton(
									$.extend({}, mydxconfig.button, {
										icon: 'close',
										visible: true,
										type: 'normal',
										onClick: function (e) {
											var diss = e.element.context;
											$(diss).parent().remove();
											file.reset();
										}
									})
								);
                            }
                        }, mydxconfig.fileuploaderimg)
                    ).dxFileUploader("instance");
					
			var fileClear = $(".clearFile").dxButton(
								$.extend({}, mydxconfig.button, {
									icon: 'close',
									visible: true,
									type: 'normal',
									onClick: function (e) {
										var diss = e.element.context;
										$(diss).parent().remove();
										file.reset();
									}
								})
							).dxButton("instance");
												
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
						if(data.error){
							alert(data.error);
							$('.uploadstatus').eq(idx).hide();
						}else{
							$('.removemedia').eq(idx).show();
							$('.MediaID').eq(idx).val(data.mediaid);
							if(data.type == <?= FILETYPE_FILE ?>){
								$('.infomedia').eq(idx).html('File sudah dipilih <strong>'+data.mediapath+'</strong>.  <a href="#" class="removemedia removemedia btn btn-danger"><i class="clip-close"></i></a> <a href="#" class="pilihgambar">Ganti File...</a>').show();
							}else{
								$('.infomedia').eq(idx).html('<img src="<?=base_url()?>assets/images/media/'+data.mediapath+'" width="100" /> <br />File sudah dipilih <strong>'+data.mediapath+'</strong>.  <a href="#" class="removemedia removemedia btn btn-danger"><i class="clip-close"></i></a> <a href="#" class="pilihgambar">Ganti File...</a>').show();
							}
							
							$('.pilihgambar').eq(idx).remove();
							$('.uploadstatus').eq(idx).empty();
						}
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
			
			$.validator.addMethod("endDate", function(value, element) {
	            var startDate = $('#StartDate').val();
	            return Date.parse(startDate) <= Date.parse(value) || value == "";
	        }, "End date must be after start date");
	        $('#validate').validate();
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
