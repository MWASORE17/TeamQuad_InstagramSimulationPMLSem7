<?= $this->load->view('header')?>
<?php

 if(!IsUserLogin()){ ?>
 	
	<div class='alert alert-warning'>
 		Silahkan <?= anchor('user', 'Login')?> Dulu
	</div>
				
<?php
 }else if(!IsAllowView(MODULTASK)){
 ?>		
 	<div class='alert alert-warning'>
 		Tidak diizinkan melihat data
	</div>
<?php	
 }else{
 	
	$taskid = $result[COL_TASKID];
	
	$this->db->where(COL_TASKID, $taskid);
	$assign = $this->db->get(TBL_TASKASSIGNMENTS);
	// echo $this->db->last_query();
	
	$project = $this->db->select(COL_PROJECTNAME)->where(COL_PROJECTID, $result[COL_PROJECTID])->get(TBL_PROJECTS)->row_array();
	$version = $this->db->select(COL_VERSIONNAME)->where(COL_VERSIONID, $result[COL_VERSIONID])->get(TBL_VERSIONS)->row_array();
	if (!IsOtherModuleActive(OTHERMODUL_CANCLOSETASK) || $result[COL_ISCLOSED]){
	?>
		<style>
			.closetask{
				display: none;
			}
			/*.keterangan{
				display: inline-block;
			}*/
			
		</style>
		<!-- <script>
			$(document).ready(function(){
				$('.keterangan').show();
			});
		</script> -->
		
	<?php
	}
	
	if ($result[COL_ISCLOSED] == 1){
	?>	
		<script>
			$(document).ready(function(){
				$('.closetask').html('Closed').attr('disabled', true);
			});
		</script>
	<?php	
	}
	
	if($favorite){
	?>	
		<script>
			$(document).ready(function(){
				//$('.favoritetask').attr('disabled', true).addClass('unfavorite');
				$('.favoritetask').addClass('unfavorite').removeClass('favoritetask');
				$('.tfavorit').html('&nbsp;Hapus Favorit');
			});
		</script>
	<?php	
	}
	
	if(!IsAllowInsert(MODULCOMMENT)){
		?>
		 <style>
		 	.add-commnet{
		 		display: none;
		 	}
		 </style>
		<?php
	}
	if(!IsAllowView(MODULCOMMENT)){
		?>
		 <style>
		 	.list-comment{
		 		display: none;
		 	}
		 </style>
		<?php
	}
	
?>
<style>button.btn.btn-default.unfavorite{ color: #f5c921; } span.glyphicon.glyphicon-star { font-weight: bold; }</style>
	<div class="page-wrapper">	
		<div class="row">
			<div class="col-md-12">
				<h1><?= $title ?></h1>
				<div class="row viewtask">
					<div class="col-md-3 taskdetail">
						<div class="statuswarning alert alert-warning" style="display:none;"></div>
						<table class="table">
							<tr><td>Status</td><td><?= $result[COL_TASKSTATUSNAME]?><br/>
								<?= !IsOtherModuleActive(OTHERMODUL_CANCAHANGESTATUS)  || $result[COL_ISCLOSED] ?'': anchor(site_url('task/changestatus/'.$result[COL_TASKID]), 'edit', array('class' => 'editstatus','data-name' => $result[COL_TASKSTATUSNAME], 'data-id' => $result[COL_TASKID], 'data-idstatus' => $result[COL_TASKSTATUSID])) ?>
								</td>
							</tr>
							<tr><td>Percent Complete</td>
								<td><div class="progress">
									  <div class="progress-bar" role="progressbar" aria-valuenow="<?= $result[COL_PERCENTCOMPLETE]?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $result[COL_PERCENTCOMPLETE]?>%;">
									    <?= $result[COL_PERCENTCOMPLETE]?>%
									  </div>
									</div>
								
								<?= !IsOtherModuleActive(OTHERMODUL_CANCHANGEPERCENTASE)  || $result[COL_ISCLOSED] ?'': anchor(site_url('task/editpersen/'.$result[COL_TASKID]), 'edit', array('class' => 'editpersen', 'data-val' => $result[COL_PERCENTCOMPLETE], 'data-id' => $result[COL_TASKID])) ?>
								</td>
							</tr>
							<tr><td>Project</td><td><?= $project[COL_PROJECTNAME] ?></td></tr>
							<tr><td>Jenis Tugas</td><td><?= $result[COL_TASKTYPENAME]?></td></tr>
							<?php 
								//if($result[COL_SWONO]!=null || $result[COL_SWONO]!=""){
								if($result[COL_TASKTYPEID]==$laporanCustomerId){
									echo "<tr><td>SWO No</td><td>" . $result[COL_SWONO] . "</td></tr>";
								}
							?>
							
							<tr><td>Kategori</td><td><?= $result[COL_CATEGORYNAME]?></td></tr>
							<tr><td>Asignment To</td>
								<td><?php
										foreach($assign->result_array() as $assignment){
											echo $assignment[COL_USERNAME]."<br/>";
										} 
									?>
								</td>
							</tr>
							<tr><td>Severity</td><td><?= $result[COL_TASKSEVERITYNAME]?></td></tr>
							<tr><td>Prioritas</td><td><?= $result[COL_TASKPRIORITYNAME]?></td></tr>
							<tr><td>Tanggal Mulai</td><td><?= $result[COL_STARTEDDATE]?></td></tr>
							<tr><td>Tanggal Batas</td><td><?= $result[COL_DUEDATE]?></td></tr>
							<tr><td>Version</td><td><?= empty($version[COL_VERSIONNAME]) ? '-' : $version[COL_VERSIONNAME] ?></td></tr>
							<tr><td>Private</td><td><?= $result[COL_ISPRIVATE] == 1 ? 'Ya' : 'Tidak' ?></td></tr>
							<br />
							<tr><td colspan="2"><small>Created By : <?= $result[COL_CREATEDBY]?><br/>Created On : <?= $result[COL_CREATEDON]?></small></td></tr>
							<?php
								if(!empty($result[COL_UPDATEBY]) && !empty($result[COL_UPDATEON])){
							?>
									<tr><td colspan="2"><small>Update By : <?= $result[COL_UPDATEBY]?><br/>Update On : <?= $result[COL_UPDATEON]?></small></td></tr>
							<?php 
								} 
								if($result[COL_ISCLOSED] == 1){
									
									if($result[COL_DUEDATE] == null || $result[COL_DUEDATE] == '0000-00-00' || $result[COL_DUEDATE] == ''){
										$batas='';
										
									}else{
										$batas = date('d',strtotime($result[COL_DUEDATE]))."-".date('m',strtotime($result[COL_DUEDATE]))."-".date('Y',strtotime($result[COL_DUEDATE]));
									}
									
									if(($result[COL_CLOSEDON] != null || $result[COL_CLOSEDON] != '0000-00-00 00:00:00' || $result[COL_CLOSEDON] != '')){
										$closed = date('d',strtotime($result[COL_CLOSEDON]))."-".date('m',strtotime($result[COL_CLOSEDON]))."-".date('Y',strtotime($result[COL_CLOSEDON]));
									}else{
										$closed='';
									}
									
									if ($result[COL_ISCLOSED] == 1 && $result[COL_CLOSEDON] > $result[COL_DUEDATE] && $batas != '') {
										$terlambat = ((strtotime($closed) - strtotime($batas)) / 86400);
									}else if(date('Y-m-d') > $result[COL_DUEDATE] && $result[COL_ISCLOSED] == 0 && $batas != ''){
										$terlambat = ((strtotime(date("d-m-Y")) - strtotime($batas)) / 86400);
										
									}else{
										$terlambat = '-';
									}
									
									// $batas = date('d',strtotime($result[COL_DUEDATE]))."-".date('m',strtotime($result[COL_DUEDATE]))."-".date('Y',strtotime($result[COL_DUEDATE]));
									// $closed = date('d',strtotime($result[COL_CLOSEDON]))."-".date('m',strtotime($result[COL_CLOSEDON]))."-".date('Y',strtotime($result[COL_CLOSEDON]));
// 									
									// $terlambat = ((strtotime($closed) - strtotime($batas)) / 86400);
									
							?>
									<tr><td colspan="2"><small>Finished On : <?= $result[COL_CLOSEDON]?><br/>Lewat Hari : <?= $terlambat == '0'? '-' : $terlambat." hari" ?></small></td></tr>
							<?php } ?>

                            <?php
                            if($result[COL_STARTCHECKON]) {
                            ?>
                                <tr><td colspan="2"><small>Start Checked By : <?= $result[COL_STARTCHECKBY] ? $result[COL_STARTCHECKBY] : '-'?><br/>Start Checked On : <?= $result[COL_STARTCHECKON]?></small></td></tr>
                            <?php
                            }
                            ?>

                            <?php
                            if($result[COL_FINISHCHECKON]) {
                                ?>
                                <tr><td colspan="2"><small>Finish Checked By : <?= $result[COL_FINISHCHECKBY] ? $result[COL_FINISHCHECKBY] : '-'?><br/>Finish Checked On : <?= $result[COL_FINISHCHECKON]?></small></td></tr>
                                <?php
                            }
                            ?>
							<!-- <tr><td><?= anchor('task/edit/'.$result[COL_TASKID], 'Edit', array("class" => "btn btn-primary"))?></td><td></td></tr> -->
							
						</table>
					</div>
					<div class="col-md-9 taskdescript">
						
						<h2><?=  $result[COL_SUMMARY] ?></h2>
						<p><?=  $result[COL_DESCRIPTION] ?></p>
						<br/>
						
						<?php
						 $att = $this->mattachment->GetAll(array(COL_REFERENCEID => $result[COL_TASKID], COL_MODULEID => MODULTASK));
						 // echo $this->db->last_query();
						 foreach ($att->result_array() as $at) {
						 	
							$valid_ext = array('jpg','jpeg','png','gif','bmp');
							$ext = strtolower(end(explode('.', $at[COL_FILENAME])));
							if(!in_array($ext, $valid_ext)){
								?>
								<span class="glyphicon glyphicon-file"> </span>
								<a target="_blank" href="<?=base_url()?>assets/images/media/<?=$at[COL_FILENAME]?>">
									<?=$at[COL_FILENAME]?>
								</a>
							<?php	
							}else{
									
							?>		
								<span class="glyphicon glyphicon-picture"> </span>
								<a class="showimgmodal" data-nama="<?=$at[COL_FILENAME]?>" data-img="<?=base_url()?>assets/images/media/<?=$at[COL_FILENAME]?>" href="<?=base_url()?>assets/images/media/<?=$at[COL_FILENAME]?>"> 
									<?=$at[COL_FILENAME]?>
								</a>
							<?php
							}															
							?>
							Attachment Tugas
							<br/>
							<?php
						 }
						?>
						
						<br/>
						<div class="form-group">
							<label>Share Task</label>
							<input type="text" name="TaskShare" class="form-control" value="<?= $viewpublic ?>" readonly=""/>
						</div>
						
						<br/>
						<!-- <label class="">Summary Tugas</label>
						<input class="form-control required" type="text" name="Summary" value="<?=  $result[COL_SUMMARY] ?>" /> -->
						<div class="responclose alert alert-success" style="display: none;"></div>
						<button class="btn btn-default favoritetask" data-id="<?=$result[COL_TASKID]?>" data-url="<?= site_url('task/addFavoriteTask/'.$result[COL_TASKID])?>"><span class="glyphicon glyphicon-star"></span><span class="tfavorit">&nbsp;Tambah Favorit</span></button>
						<button class="btn btn-default closetask" data-id="<?=$result[COL_TASKID]?>" data-summary="<?= $result[COL_SUMMARY] ?>" data-url="<?= site_url('task/closeTask/'.$result[COL_TASKID])?>">Sudah Selesai</button>
                        <?php if(!$result[COL_STARTCHECKON] && IsOtherModuleActive(OTHERMODUL_SETSTATUS_CHECKING)) { ?> <button class="btn btn-default startchecking" data-id="<?=$result[COL_TASKID]?>" data-url="<?= site_url('task/startChecking/'.$result[COL_TASKID])?>">Start Checking</button> <?php } ?>
                        <?php if($result[COL_STARTCHECKON] && !$result[COL_ISCHECKED] && IsOtherModuleActive(OTHERMODUL_SETSTATUS_CHECKED)) { ?> <button class="btn btn-default finishchecking" data-id="<?=$result[COL_TASKID]?>" data-url="<?= site_url('task/finishChecking/'.$result[COL_TASKID])?>">Finish Checking</button> <?php } ?>
						<br />
						<br />
						<?php
							if($result[COL_ISCLOSED] == 1){
						?>
						<div class="keterangan" >
							<label>Keterangan Selesai :</label>
							<p>
								<?=	empty($result[COL_CLOSEDMESSAGE]) ? " - " : $result[COL_CLOSEDMESSAGE] ?>
							</p>
						</div>
						<?php
							}
						?>

                        <?php
                        if($result[COL_ISCHECKED] == 1){
                            ?>
                            <div class="keterangan" >
                                <label>Keterangan Hasil Check :</label>
                                <p>
                                    <?=	empty($result[COL_FINISHMESSAGE]) ? " - " : $result[COL_FINISHMESSAGE] ?>
                                </p>
                            </div>
                            <?php
                        }
                        ?>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 tab-pane" id="tab">
						<ul class="nav nav-tabs tab-header" role="tab-list">
						  <li role="presentation" class="active"><a href="#tabs-1" data-toggle="tab" >Komentar (<?= $comment->num_rows() ?>)</a></li>
						  <!-- <li role="presentation"><a href="#tabs-2" data-toggle="tab" >Profile</a></li>
						  <li role="presentation"><a href="#tabs-3" data-toggle="tab" >Messages</a></li> -->
						</ul>
						<div class="tab-content">
							<div id="tabs-1" class="tab-pane active" role="tabpanel">
								<div class="list-comment">
									<div class="rkomentar alert alert-warning" style="display:none;"></div>
									<?php
										if ($comment->num_rows() <= 0){
											echo '<div class="row "><div class="col-md-12">Tidak ada komentar</div></div>';
										}else{
										
										foreach ($comment->result_array() as $com) {
											$this->db->select();
											$this->db->where(COL_REFERENCEID, $com[COL_COMMENTID]);
											$att = $this->db->get(TBL_ATTACHMENTS)->row_array();
									?>			
											<div class="row komentar-item" id="comment-<?=$com[COL_COMMENTID]?>">
												<div class="col-md-2">
													<h4><?= $com[COL_CREATEDBY] ?></h4>
													<small><?= $com[COL_CREATEDON] ?></small><br/>
													<?php
													if(IsAllowUpdate(MODULCOMMENT)){
														if(!IsOtherModuleActive(OTHERMODUL_CANEDIT_ANOTHERCOMMENT)){
															if($com[COL_CREATEDBY] == GetUserLogin('UserName')){
																echo anchor(site_url('comment/edit/'.$com[COL_COMMENTID]).'?tid='.$result[COL_TASKID],'Edit', array("class" => "editkomentar","data-idkomentar" => $com[COL_COMMENTID], "data-komentar" => "", "data-img" => (!empty($att)) ? base_url().'assets/images/media/'.$att[COL_FILENAME] : ""));
															} 
														}else{
															echo anchor(site_url('comment/edit/'.$com[COL_COMMENTID]).'?tid='.$result[COL_TASKID],'Edit', array("class" => "editkomentar","data-idkomentar" => $com[COL_COMMENTID], "data-komentar" => "", "data-img" => (!empty($att)) ? base_url().'assets/images/media/'.$att[COL_FILENAME] : ""));
														}
													}
													
													if(IsAllowDelete(MODULCOMMENT)){
														if(!IsOtherModuleActive(OTHERMODUL_CANDELETE_ANOTHERCOMMENT)){
															if($com[COL_CREATEDBY] == GetUserLogin('UserName')){
																echo anchor(site_url('comment/delete/'.$com[COL_COMMENTID]),'Hapus',array("class" => "hapuskomentar", 'confirm'=>'Apa anda yakin?'));
															} 
														}else{
															echo anchor(site_url('comment/delete/'.$com[COL_COMMENTID]),'Hapus',array("class" => "hapuskomentar", 'confirm'=>'Apa anda yakin?'));
														}
													}
													?>
													
													<!-- <?= !IsAllowUpdate(MODULCOMMENT) ? '' : anchor(site_url('comment/edit/'.$com[COL_COMMENTID]).'?tid='.$result[COL_TASKID],'Edit', array("class" => "editkomentar","data-idkomentar" => $com[COL_COMMENTID], "data-komentar" => $com[COL_DESCRIPTION], "data-img" => (!empty($att)) ? base_url().'assets/images/media/'.$att[COL_FILENAME] : ""))?> --> 
													<!-- <?= !IsAllowDelete(MODULCOMMENT) ? '' : anchor(site_url('comment/delete/'.$com[COL_COMMENTID]),'Hapus',array("class" => "hapuskomentar", 'confirm'=>'Apa anda yakin?'))?> -->
												</div>
												<div class="col-md-10">
													<p style="<?=$com[COL_COMMENTYPEID]!=COMMENTTYPE_BUG?'':'color:red;'?>"><?= $com[COL_DESCRIPTION] ?></p>
													<br/>
													<?php
													 $att = $this->mattachment->GetAll(array(COL_REFERENCEID => $com[COL_COMMENTID], COL_MODULEID => MODULCOMMENT));
													 // echo $this->db->last_query();
													 foreach ($att->result_array() as $at) {
													 	$valid_ext = array('jpg','jpeg','png','gif','bmp');
														$ext = strtolower(end(explode('.', $at[COL_FILENAME])));
														if(!in_array($ext, $valid_ext)){
															?>
															<span class="glyphicon glyphicon-file"> </span><a target="_blank" href="<?=base_url()?>assets/images/media/<?=$at[COL_FILENAME]?>"><?=$at[COL_FILENAME]?></a>
														<?php	
														}else{
														
														 ?>
														 <span class="glyphicon glyphicon-picture"> </span>
														<a class="showimgmodal" data-nama="<?=$at[COL_FILENAME]?>" data-img="<?=base_url()?>assets/images/media/<?=$at[COL_FILENAME]?>" href="<?=base_url()?>assets/images/media/<?=$at[COL_FILENAME]?>"> 
														<?=$at[COL_FILENAME]?>
														</a>
														<?php } ?>
														
													Attachment Komentar
													<br/>
													<?php
													 }
													?>
													
												</div>
											</div>
									<hr />
									<?php	} 
										}	?>
									
								</div>
								<div class="add-commnet">
									<h4>Tambah Komentar</h4>
									<?= form_open('comment/add',array('id'=>'validate', 'enctype'=>'multipart/form-data'))?>
										<div class="respon alert alert-warning" style="display:none;"></div>
										<input type="hidden" name="taskid" value="<?= $result[COL_TASKID] ?>" />
										<!-- <input type="file" class="input-file" name="userfile" id="userfile" style="display: inline-block" /> -->
										<!-- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; atau &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->
										<!-- <a href="<?=site_url('media/select')?>" class="pilihmedia btn btn-default">Pilih dari media</a> -->
										<!-- <input type="hidden" id="MediaID" name="MediaID" value="" />
										<br /><br />
										<span class="uploadstatus"></span>
										<div class="success infomedia alert alert-success" style="display: none">
											
										</div> -->
										<div class="uploaderContainer" style="border: 1px solid #e7e7e7; border-radius: 5px;">
											<div id="fileUploader"></div>
										</div>
										<br/>
										<div id="imgFilesShow">
										</div>
										
										<!-- <button class="btn btn-default addfile">Sertakan Gambar</button>
										<br/> -->
										
										<textarea class="form-control isi-komentar" name="isikomentar"></textarea>
										<br/>

                                        <div class="col-md-3" style="padding-left: 0px;<?=!IsOtherModuleActive(OTHERMODUL_SELECT_COMMENTTYPE)?'display:none;':''?>">
                                            <?php
                                            $commenttypes = $this->db->order_by(COL_COMMENTYPEID,'asc')->get(TBL_COMMENTTYPES)->result_array();
                                            ?>
                                            <label for="CommentType">Tipe :</label>
                                            <select id="CommentType" class="form-control" name="CommentType" autocomplete="false" style="width: 80%; display: inline">
                                                <?php
                                                foreach($commenttypes as $type) {
                                                    echo '<option value="'.$type[COL_COMMENTYPEID].'">'.$type[COL_COMMENTTYPENAME].'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
										<?= form_close() ?>
                                        <button class="btn btn-primary kirim-komentar">Kirim</button>
								</div>
							</div>
							<!-- <div id="tabs-2" class="tab-pane" role="tabpanel">
								Test Tab 2
							</div>
							<div id="tabs-3" class="tab-pane" role="tabpanel">
								Test Tab 3
							</div> -->
						</div>
					</div>
					

				</div>
					
			</div>
		</div>
	</div>
	
	<form style="display: none" id="uploader" enctype="multipart/form-data">
		<input type="file" name="userfile" id="userfile" style="display: inline-block" />
	</form>
<script type="text/javascript">
$(document).ready(function(){
	var imgindex = 0;
			
	$(document).on('click','.pilihgambar',function(){
		var myindex = $('.pilihgambar').index(this);
		imgindex = myindex;
		$('#userfile').click();
		return false;
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
							var fileClear = $("#FileClear-" + fileRespon.mediaid).dxButton(
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
			
	$('.editpersen').click(function(){
		var url = $(this).attr('href');
		var modal = $('#modalkomen');
		var persen  = $(this).data('val');
		var ID = $(this).data('id');
				
		modal.find('.modal-title').html('Edit Persentase');
		modal.find('.modal-body').html('<form id="form-modal" method="post"><label>Persentase</label><div class="input-group"><input name="Persentase-modal" value="'+persen+'" type="text" class="Persentase-modal form-control" /><span class="input-group-addon" id="basic-addon2">%</span></div></form>');
		modal.find('.ok').html('Simpan')
		modal.modal('show');
		modal.find('.ok').unbind().click(function(){
			var Persentase = $('.Persentase-modal').val();
			// alert(Persentase+url);
			$('#form-modal').ajaxSubmit({				
				dataType: 'json',
				url : url,
				data: {id: ID, persentase: Persentase},
				type : "post",
				beforeSend: function(){
					modal.find('.ok').html('loading...');
				},
				success : function(data){
					modal.modal('hide');
					
					if (data.success){
	            		$(".statuswarning").show().html(data.success);
	            		persen = Persentase;
	            		window.location.reload();
	            	}else{
	            		$(".statuswarning").show().html(data.error);
	            	}
				
				},
				error: function(jqXHR, textStatus, errorThrown) {
	                alert(jqXHR.responseText+' SILAHKAN HUBUNGI PROGRAMMER');
	                location.reload();
	            },
				
			});
						
		});
		return false;
	});
	$('.closetask').click(function(){
		var id = $(this).data('id');
		var url = $(this).data('url');
		var modal = $('#modalkomen');
		var sumary = $(this).data('summary');
		modal.find('.modal-title').html('Peringatan');
		modal.find('.modal-body').html('<p>Tugas <b>'+sumary+'</b> Sudah Selesai?</p>'+
										'<div class="alert alert-warning alert-modal" style="display:none;"></div>'+
										'<form>'+
										'<label>Keterangan Selesai</label>'+
										'<textarea class="form-control desc-modal"></textarea>'+
										'</form>');
		modal.modal('show');
		modal.find('.ok').html('OK');
		modal.find('.ok').unbind().click(function(){
			var desc = $('.desc-modal').val();
			if (desc == ''){
				$('.alert-modal').show().html('Anda belum isi keterangan');
			}else{
				$.ajax({
		           url : url,
		           data: {ClosedMessage : desc},
		           dataType : "json",
		           type : "post",
		           
		           beforeSend: function(){
		           		modal.modal('hide');
		            	$(".closetask").html("Loading...");
		           },
		           success: function(data){
		           		
		           		$(".closetask").html("Closed").attr('disabled',true);
		            	if (data.success){
		            		//$(".responclose").show().html(data.success);
		            		location.reload();
		            		// $(".komentar-item").children(':last').append('<div class="row komentar-item"><div class="col-md-2"><h4>Admin cth</h4><small>tanggal</small><br/>Edit | Hapus </div><div class="col-md-6"><p>Descripsi</p></div></div><hr />');
		            		// window.location.reload();
		            	}else{
		            		$(".responclose").show().html(data.error);
		            	}
		          },
		          error: function(jqXHR, textStatus, errorThrown) {
		                alert(jqXHR.responseText+' SILAHKAN HUBUNGI PROGRAMMER');
		                location.reload();
		           },
	      
	   			});
	   		}
		});
	});

    $('.startchecking').click(function(){
        var id = $(this).data('id');
        var url = $(this).data('url');
        var modal = $('#modalkomen');
        modal.find('.modal-title').html('Konfirmasi');
        modal.find('.modal-body').html('<p>Mulai check tugas ini?</p>');
        modal.modal('show');
        modal.find('.ok').html('OK');
        modal.find('.ok').unbind().click(function(){
            $.ajax({
                url : url,
                //data: {ClosedMessage : desc},
                dataType : "json",
                type : "post",

                beforeSend: function(){
                    modal.modal('hide');
                    $(".startchecking").html("Loading...");
                },
                success: function(data){
                    if (data.success){
                        //$(".responclose").show().html(data.success);
                        location.reload();
                    }else{
                        $(".responclose").show().html(data.error);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                        alert(jqXHR.responseText+' SILAHKAN HUBUNGI PROGRAMMER');
                        location.reload();
                },

            });
        });
    });

    $('.finishchecking').click(function(){
        var id = $(this).data('id');
        var url = $(this).data('url');
        var modal = $('#modalkomen');
        var sumary = $(this).data('summary');
        modal.find('.modal-title').html('Konfirmasi');
        modal.find('.modal-body').html('<p><b>Apa anda yakin tugas ini sudah di check?</b></p>'+
            '<div class="alert alert-warning alert-modal" style="display:none;"></div>'+
            '<form>'+
            '<label>Keterangan</label>'+
            '<textarea class="form-control desc-modal"></textarea>'+
            '</form>');
        modal.modal('show');
        modal.find('.ok').html('OK');
        modal.find('.ok').unbind().click(function(){
            var desc = $('.desc-modal').val();
            if (desc == ''){
                $('.alert-modal').show().html('Anda belum isi keterangan');
            }else{
                $.ajax({
                    url : url,
                    data: {FinishMessage : desc},
                    dataType : "json",
                    type : "post",

                    beforeSend: function(){
                        modal.modal('hide');
                        $(".finishchecking").html("Loading...");
                    },
                    success: function(data){
                        if (data.success){
                            //$(".responclose").show().html(data.success);
                            location.reload();
                            // $(".komentar-item").children(':last').append('<div class="row komentar-item"><div class="col-md-2"><h4>Admin cth</h4><small>tanggal</small><br/>Edit | Hapus </div><div class="col-md-6"><p>Descripsi</p></div></div><hr />');
                            // window.location.reload();
                        }else{
                            $(".responclose").show().html(data.error);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert(jqXHR.responseText+' SILAHKAN HUBUNGI PROGRAMMER');
                        location.reload();
                    },

                });
            }
        });
    });
	
	$('.showimgmodal').click(function(){
		var src = $(this).data('img');
		var nama = $(this).data('nama');
		var modal = $('#myModal');
		modal.find('img').attr('src',src);
		modal.modal('show');
		return false;
	});
	
	// $('.editkomentar').click(function(){
		// var url = $(this).attr('href');
		// var modal = $('#modalkomen');
		// var komentar = $(this).data('komentar');
		// var img = $(this).data('img');
		// var idComment = $(this).data('idkomentar');
		// if (img != ''){
			// var dataimg = '<img class="img-modal" src="'+img+'"/><input type="hidden" id="MediaID-modal[]" name="MediaID-modal[]" value="" />'
		// }else{
			// var dataimg = '';
		// }
// 		
		// modal.find('.modal-title').html('Edit Komentar');
		// modal.find('.modal-body').html('<form id="form-modal" method="post"><label>Gambar</label><input type="file" name="userfile[]"><div class="row"><div class="col-md-4">'+dataimg+'</div></div><label>Komentar</label><textarea name="komentar-modal" class="form-control komentar-modal">'+komentar+'</textarea></form>');
		// modal.find('.ok').html('Kirim')
		// modal.modal('show');
		// modal.find('.ok').on('click',function(){
			// var komen = $('.komentar-modal').val();
			// var media = $('#MediaID-modal').val();
// 			
			// $('#form-modal').ajaxSubmit({				
				// dataType: 'json',
				// url : '<?=site_url("comment/editcomment/")?>',
				// data: {id: idComment, komentar: komen, media: media},
				// type : "post",
				// beforeSend: function(){
					// modal.find('.ok').html('loading...');
				// },
				// success : function(data){
					// modal.modal('hide');
// 					
					// if (data.success){
	            		// $(".rkomentar").show().html(data.success);
	            		// // $(".komentar-item").children(':last').append('<div class="row komentar-item"><div class="col-md-2"><h4>Admin cth</h4><small>tanggal</small><br/>Edit | Hapus </div><div class="col-md-6"><p>Descripsi</p></div></div><hr />');
	            		// window.location.reload();
	            	// }else{
	            		// $(".rkomentar").show().html(data.error);
	            	// }
// 				
				// },
// 				
			// });
// 						
		// });
		// return false;
	// });
	
	$('.addfile').click(function(){
		$('.input-file').toggle(1000);
	})
	
	// $('#userfile').change(function(){
		// $(this).attr('disable',true);
		// $('.uploadstatus').html('Sedang mengupload file <img src="<?=base_url()?>assets/images/load.gif" alt="ajaxloading" />');
		// $('#validate').ajaxSubmit({
			// dataType: 'json',
			// url: '<?=site_url('media/upload')?>',
			// success : function(data){
				// $('.removemedia').show();
				// $('#MediaID').val(data.mediaid);
				// $('.infomedia').html('<img src="<?=base_url()?>assets/images/media/'+data.mediapath+'" width="100" /> <br />Gambar sudah dipilih <strong>'+data.mediapath+'</strong>.  <a href="#" class="removemedia removemedia btn btn-danger"><i class="clip-close"></i></a>').show();
				// $(this).attr('disable',false);
				// $('.uploadstatus').empty();
			// }
		// });
	// });
	
	$(".kirim-komentar").click(function(){
		isi = $(".isi-komentar").val();
		Media = $("#MediaID").val();
        commentype = $("#CommentType").val();
		
		var modal = $('#modalkomen');
		var modalalert = $('#modalalert');
		if(isi==''){
			
			modalalert.find('.modal-title').html('Peringatan');
			modalalert.find('.modal-body').html('<p>Komentar Kosong!!!</p>');
			modalalert.modal('show');
			modalalert.find('.ok').hide();
			modalalert.find('.ok').on('click',function(){
				modalalert.modal('hide');
			});
			return false;
		}
		
		modal.find('.modal-title').html('Peringatan');
		modal.find('.modal-body').html('<p>Apakah anda yakin mengirim komentar ?</p>');
		modal.modal('show');
		modal.find('.ok').html('OK');
		modal.find('.ok').unbind().click(function(){
			
			
				$.ajax({
		           url : "<?= site_url('comment/add') ?>",
		           // data : {taskid : <?= $result[COL_TASKID] ?>, isikomentar : isi, MediaID : Media },
		           data : $('#validate').serialize(),
		           dataType : "json",
		           type : "post",
		           
		           beforeSend: function(){
		           		modal.find('.ok').html('Loading...');
		           		$(".kirim-komentar").html("Loading...");
		           },
		           success: function(data){
		           		$(".kirim-komentar").html("Kirim");
		            	if (data.success){
		            		modal.modal('hide');
		            		$(".respon").show().html(data.success);
		            		// $(".komentar-item").children(':last').append('<div class="row komentar-item"><div class="col-md-2"><h4>Admin cth</h4><small>tanggal</small><br/>Edit | Hapus </div><div class="col-md-6"><p>Descripsi</p></div></div><hr />');
		            		$(".isi-komentar").val('');
		            		window.location.reload();
		            	}else{
		            		$(".respon").show().html(data.error);
		            	}
		           },
		           error: function(jqXHR, textStatus, errorThrown) {
		                alert(jqXHR.responseText+' SILAHKAN HUBUNGI PROGRAMMER');
		                modal.modal('hide');
		                $(".isi-komentar").val('');
		                location.reload();
		            },
      
   				});
   			
		});
	});
	
	$('.hapuskomentar').click(function(){
		var d = $(this);
		var url = d.attr('href');
		if(confirm('Apakah anda yakin?')){
			
			d.hide();
			d.after('Loading...');
			
			$.ajax({
				url: url,
				type: 'get',
				dataType: 'json',
				success: function(data){
					// var td = d.parent('td');
					d.remove();
					// var tdexist = $('td').has('.sold').html(data.success);
					// td.html('<span class="sold">Sold</span>');
					$('.rkomentar').html(data.success);
					alert("komentar telah dihapus");
					window.location.reload();
				},
				error: function(jqXHR, textStatus, errorThrown) {
	                alert(jqXHR.responseText+' SILAHKAN HUBUNGI PROGRAMMER');
	                location.reload();
	            },
			});
			return false;				
		}else{
			return false;
		}
		
	});
	
	$('.editstatus').click(function(){
		var url = $(this).attr('href');
		var mdlstt = $('#mdlChangeStatus');
		var status  = $(this).data('name');
		var ID = $(this).data('id');
		// var IDstatus = $(this).data('idstatus');
		mdlstt.modal('show');
		mdlstt.find('.saveStatus').unbind().click(function(){
			// alert('Y');
			var IDstatus = $('#TaskStatusID').val();
			$.ajax({
				url: url,
				data: {id: ID, statusID: IDstatus, },
				dataType: "json",
				type: "get",
				beforeSend: function(){
					$('.saveStatus').html('Loading...');
				},
				success: function(data){
					mdlstt.modal('hide');
					var mdlcfm = $('#modalConfirm');
					if(data.error == 0){
						mdlcfm.find('.modal-body').html(data.success);
						mdlcfm.modal('show');
						$('.saveStatus').html('Simpan');
						mdlcfm.find('.Confirm').click(function(){
							mdlcfm.modal('hide');
							location.reload();
						});
						// alert(data.success);
					}else{
						mdlcfm.find('.modal-body').html(data.error);
						mdlcfm.modal('show');
						$('.saveStatus').html('Simpan');
						mdlcfm.find('.Confirm').click(function(){
							mdlcfm.modal('hide');
							location.reload();
						});
						// alert(data.error);
					}
				},
				error: function(a,b,c){
					alert('System Error');
				}
			})
		});
		
		return false;
	});
	$('.favoritetask').click(function(){
		var dis = $(this);
		var id = $(this).data('id');
		var url = $(this).data('url');
		//dis.find('span').text('Sending...');
		$.ajax({
			url : url,
			data : {taskid : dis.attr('taskid')},
			type: 'post',
			dataType : 'json',
			success : function(data){
				//dis.find('span').text(oldtext);
				if(data.success){
					$('.favoritetask').addClass('unfavorite').removeClass('favoritetask');
					$('.tfavorit').html('&nbsp;Hapus Favorit');
					window.location.reload();
				}
				else{
					$(".responclose").show().html(data.error);
					location.reload();
				}
			},
			error : function(){
				alert(jqXHR.responseText+' SILAHKAN HUBUNGI PROGRAMMER');
		        location.reload();
			}
		});
		return false;
	});
	$('.unfavorite').click(function(){
		var dis = $(this);
		var id = $(this).data('id');
		var url = $(this).data('url');
		//dis.find('span').text('Sending...');
		$.ajax({
			url : '<?= site_url('task/removeFavoriteTask/'.$result[COL_TASKID])?>',
			data : {taskid : dis.attr('taskid')},
			type: 'post',
			dataType : 'json',
			success : function(data){
				if(data.success){
					$('.favoritetask').removeClass('unfavorite').addClass('favoritetask');
					$('.tfavorit').html('&nbsp;Tambah Favorit');
					window.location.reload();
				}
				else{
					$(".responclose").show().html(data.error);
				}
			},
			error : function(){
				alert(jqXHR.responseText+' SILAHKAN HUBUNGI PROGRAMMER');
		        location.reload();
			}
		});
		return false;
	});
});

</script>

<div class="modal fade" style="display: none" id="myModal">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
     
      <div class="modal-body">
      	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        
        <img src="<?=base_url()?>assets/images/media/<?=$result[COL_FILENAME]?>" />
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modalkomen">
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
        <button type="button" class="btn btn-primary ok">Simpan</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalalert">
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
        <button type="button" class="btn btn-primary ok">Simpan</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="mdlChangeStatus">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <label class="modal-title">Edit Status Tugas</label>
      </div>
      <div class="modal-body">
      	<!-- <?= form_open('task/editstatus/'.$result[COL_TASKSTATUSID])?> -->
			<div class="form-group">
				<div class="row row5">
					<div class="col-md-12 statusTugas">
						<label class="">Status Tugas</label>
						<select name="TaskStatusID" id="TaskStatusID" class="form-control">
							<?=GetComboboxCI($taskstatus, "TaskStatusID", "TaskStatusName", $result[COL_TASKSTATUSID])?>
						</select>
						
					</div>
					
				</div>
			</div>
		<!-- <?= form_close()?> -->
        <!-- <p>Loading&hellip;</p> -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary saveStatus">Simpan</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalConfirm">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <label class="modal-title"></label>
      </div>
      <div class="modal-body">
        <!-- <p>Loading&hellip;</p> -->
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
        <button type="button" class="btn btn-primary Confirm">Ok</button>
      </div>
    </div>
  </div>
</div>

<?php } ?>
<?= $this->load->view('footer')?>
