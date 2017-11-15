<?= $this->load->view('header')?>

<?php	
	$taskid = $result[COL_TASKID];
	
	$this->db->where(COL_TASKID, $taskid);
	$assign = $this->db->get(TBL_TASKASSIGNMENTS);
	// echo $this->db->last_query();
	
	$project = $this->db->select(COL_PROJECTNAME)->where(COL_PROJECTID, $result[COL_PROJECTID])->get(TBL_PROJECTS)->row_array();
	$version = $this->db->select(COL_VERSIONNAME)->where(COL_VERSIONID, $result[COL_VERSIONID])->get(TBL_VERSIONS)->row_array();

?>
	<div class="page-wrapper">	
		<div class="row">
			<div class="col-md-12">
				<h1><?= $title ?></h1>
				<div class="row viewtask">
					<div class="col-md-3 taskdetail">
						<div class="statuswarning alert alert-warning" style="display:none;"></div>
						<table class="table">
							<tr><td>Status</td><td><?= $result[COL_TASKSTATUSNAME]?><br/>
								<!-- <?= !IsOtherModuleActive(OTHERMODUL_CANCAHANGESTATUS)  || $result[COL_ISCLOSED] ?'': anchor(site_url('task/changestatus/'.$result[COL_TASKID]), 'edit', array('class' => 'editstatus','data-name' => $result[COL_TASKSTATUSNAME], 'data-id' => $result[COL_TASKID], 'data-idstatus' => $result[COL_TASKSTATUSID])) ?> -->
								</td>
							</tr>
							<tr><td>Percent Complete</td>
								<td><div class="progress">
									  <div class="progress-bar" role="progressbar" aria-valuenow="<?= $result[COL_PERCENTCOMPLETE]?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $result[COL_PERCENTCOMPLETE]?>%;">
									    <?= $result[COL_PERCENTCOMPLETE]?>%
									  </div>
									</div>
								
								<!-- <?= !IsOtherModuleActive(OTHERMODUL_CANCHANGEPERCENTASE)  || $result[COL_ISCLOSED] ?'': anchor(site_url('task/editpersen/'.$result[COL_TASKID]), 'edit', array('class' => 'editpersen', 'data-val' => $result[COL_PERCENTCOMPLETE], 'data-id' => $result[COL_TASKID])) ?> -->
								</td>
							</tr>
							<tr><td>Project</td><td><?= $project[COL_PROJECTNAME] ?></td></tr>
							<tr><td>Jenis Tugas</td><td><?= $result[COL_TASKTYPENAME]?></td></tr>
							<tr><td>Kategori</td><td><?= $result[COL_CATEGORYNAME]?></td></tr>
							<!-- <tr><td>Asignment To</td>
								<td><?php
										foreach($assign->result_array() as $assignment){
											echo $assignment[COL_USERNAME]."<br/>";
										} 
									?>
								</td>
							</tr> -->
							<tr><td>Severity</td><td><?= $result[COL_TASKSEVERITYNAME]?></td></tr>
							<tr><td>Prioritas</td><td><?= $result[COL_TASKPRIORITYNAME]?></td></tr>
							<tr><td>Tanggal Mulai</td><td><?= $result[COL_STARTEDDATE]?></td></tr>
							<tr><td>Tanggal Batas</td><td><?= $result[COL_DUEDATE]?></td></tr>
							<tr><td>Version</td><td><?= empty($version[COL_VERSIONNAME]) ? '-' : $version[COL_VERSIONNAME] ?></td></tr>
							<tr><td>Private</td><td><?= $result[COL_ISPRIVATE] == 1 ? 'Ya' : 'Tidak' ?></td></tr>
							<br />
							<tr><td colspan="2"><small>Created By : <?= $result[COL_CREATEDBY]?><br/>Creatde On : <?= $result[COL_CREATEDON]?></small></td></tr>
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
									<tr><td colspan="2"><small>Closed On : <?= $result[COL_CLOSEDON]?><br/>Lewat Hari : <?= $terlambat == '0'? '-' : $terlambat." hari" ?></small></td></tr>
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
						<!-- <div class="form-group">
							<label>Share Task</label>
							<input type="text" name="TaskShare" class="form-control" value="<?= $viewpublic ?>" readonly=""/>
						</div> -->
						
						<br/>
						<!-- <label class="">Summary Tugas</label>
						<input class="form-control required" type="text" name="Summary" value="<?=  $result[COL_SUMMARY] ?>" /> -->
						<div class="responclose alert alert-success" style="display: none;"></div>
						<!-- <button class="btn btn-default closetask" data-id="<?=$result[COL_TASKID]?>" data-summary="<?= $result[COL_SUMMARY] ?>" data-url="<?= site_url('task/closeTask/'.$result[COL_TASKID])?>">Close Task</button> -->
						<br />
						<br />
						<?php
							if($result[COL_ISCLOSED] == 1){
						?>
						<div class="keterangan" >
							<label>Keterangan Close :</label>
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
											<div class="row komentar-item">
												<div class="col-md-2">
													<h4><?= $com[COL_CREATEDBY] ?></h4>
													<small><?= $com[COL_CREATEDON] ?></small><br/>
													<!-- <?php
													if(IsAllowUpdate(MODULCOMMENT)){
														if(!IsOtherModuleActive(OTHERMODUL_CANEDIT_ANOTHERCOMMENT)){
															if($com[COL_CREATEDBY] == GetUserLogin('UserName')){
																echo anchor(site_url('comment/edit/'.$com[COL_COMMENTID]).'?tid='.$result[COL_TASKID],'Edit', array("class" => "editkomentar","data-idkomentar" => $com[COL_COMMENTID], "data-komentar" => $com[COL_DESCRIPTION], "data-img" => (!empty($att)) ? base_url().'assets/images/media/'.$att[COL_FILENAME] : ""));
															} 
														}else{
															echo anchor(site_url('comment/edit/'.$com[COL_COMMENTID]).'?tid='.$result[COL_TASKID],'Edit', array("class" => "editkomentar","data-idkomentar" => $com[COL_COMMENTID], "data-komentar" => $com[COL_DESCRIPTION], "data-img" => (!empty($att)) ? base_url().'assets/images/media/'.$att[COL_FILENAME] : ""));
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
													?> -->
													
													<!-- <?= !IsAllowUpdate(MODULCOMMENT) ? '' : anchor(site_url('comment/edit/'.$com[COL_COMMENTID]).'?tid='.$result[COL_TASKID],'Edit', array("class" => "editkomentar","data-idkomentar" => $com[COL_COMMENTID], "data-komentar" => $com[COL_DESCRIPTION], "data-img" => (!empty($att)) ? base_url().'assets/images/media/'.$att[COL_FILENAME] : ""))?> --> 
													<!-- <?= !IsAllowDelete(MODULCOMMENT) ? '' : anchor(site_url('comment/delete/'.$com[COL_COMMENTID]),'Hapus',array("class" => "hapuskomentar", 'confirm'=>'Apa anda yakin?'))?> -->
												</div>
												<div class="col-md-10">
													<p><?= $com[COL_DESCRIPTION] ?></p>
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

	$('.showimgmodal').click(function(){
		var src = $(this).data('img');
		var nama = $(this).data('nama');
		var modal = $('#myModal');
		modal.find('img').attr('src',src);
		modal.modal('show');
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

<?= $this->load->view('footer')?>