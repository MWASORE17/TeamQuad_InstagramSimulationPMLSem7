<?= $this->load->view('header')?>


<?php

 if(!IsUserLogin()){ ?>
 	
	<div class='alert alert-warning'>
 		Silahkan <?= anchor('user', 'Login')?> Dulu
	</div>
				
<?php
 }else if(!IsAllowView(MODULCOMMENT)){
 ?>		
 	<div class='alert alert-warning'>
 		Tidak diizinkan melihat data
	</div>
<?	
 }else{

	if(!IsAllowDelete(MODULCOMMENT)){
?>		
		<style>
			.cekboxaction{
				display:none;
			}
		</style>	
		
<?php		
	}

		$data = array();
		$i = 0;
		foreach ($c->result_array() as $d){
			$task = $this->mtask->getbyid($d[COL_TASKID])->row_array();
            if($d[COL_COMMENTYPEID] == COMMENTTYPE_BUG) $comment = '<a style="color:red;" tabindex="0"  data-placement="auto" role="button" data-toggle="popover" data-trigger="focus" title="'.$d[COL_CREATEDBY].'" data-content="'.$d[COL_DESCRIPTION].'">'.substr($d[COL_DESCRIPTION],0,25).'...</a>';
			else $comment = '<a tabindex="0"  data-placement="auto" role="button" data-toggle="popover" data-trigger="focus" title="'.$d[COL_CREATEDBY].'" data-content="'.$d[COL_DESCRIPTION].'">'.substr($d[COL_DESCRIPTION],0,25).'...</a>';
			// $percent = '<div class="progress">
						  // <div class="progress-bar" role="progressbar" aria-valuenow="'.$d[COL_PERCENTCOMPLETE].'" aria-valuemin="0" aria-valuemax="100" style="width: '.$d[COL_PERCENTCOMPLETE].'%;">
						    // '.$d[COL_PERCENTCOMPLETE].'%
						  // </div>
						// </div>';
			// $assign = $this->mtask->GetAssignString($d[COL_TASKID]);
			// // echo $this->last_query();
			// $rlastcomment = $this->mtask->GetLastComment($d[COL_TASKID])->row_array();
			// $lastcomment = empty($rlastcomment) ? "-" : '<a tabindex="0"  data-placement="auto" role="button" data-toggle="popover" data-trigger="focus" title="'.$rlastcomment[COL_CREATEDBY].'" data-content="'.$rlastcomment[COL_DESCRIPTION].'">'.substr($rlastcomment[COL_DESCRIPTION],0,25).'</a>';
			// $lastcommentdate = empty($rlastcomment) ? "-" : $rlastcomment[COL_CREATEDON];
			// $p = $this->mtaskpriority->GetByID($d[COL_TASKPRIORITYID])->row_array();
// 			
			// if($d[COL_DUEDATE] == '' || $d[COL_DUEDATE] == '0000-00-00' || $d[COL_DUEDATE] == null){
				// $sisahari = '-';
			// }
			// $enddate = explode("-", $d[COL_DUEDATE]);
			// $tgl = $enddate[2];
			// $bln= $enddate[1];
			// $thn = $enddate[0];
			// $enddate1 = $tgl.'-'.$bln.'-'.$thn;
			// $sekarang = date("d-m-Y");
			// if ($d[COL_DUEDATE] > date("Y-m-d")){
				// $sisahari = (strtotime($enddate1) - strtotime($sekarang)) / 86400;
			// }else{
				// $sisahari = 0;
			// }
			// if(!IsAllowUpdate(MODULTASK)){
				// $edittask = $d[COL_SUMMARY];
			// }else{
				// $edittask = anchor('task/edit/'.$d[COL_TASKID],$d[COL_SUMMARY]);
			// }
// 			
			// if($d[COL_DUEDATE] == null || $d[COL_DUEDATE] == '0000-00-00' || $d[COL_DUEDATE] == ''){
				// $batas='';
// 				
			// }else{
				// $batas = date('d',strtotime($d[COL_DUEDATE]))."-".date('m',strtotime($d[COL_DUEDATE]))."-".date('Y',strtotime($d[COL_DUEDATE]));
			// }
// 			
			// if(($d[COL_CLOSEDON] != null || $d[COL_CLOSEDON] != '0000-00-00 00:00:00' || $d[COL_CLOSEDON] != '')){
				// $closed = date('d',strtotime($d[COL_CLOSEDON]))."-".date('m',strtotime($d[COL_CLOSEDON]))."-".date('Y',strtotime($d[COL_CLOSEDON]));
			// }else{
				// $closed='';
			// }
// 			
			// if ($d[COL_ISCLOSED] == 1 && $d[COL_CLOSEDON] > $d[COL_DUEDATE] && $batas != '') {
				// $terlambat = ((strtotime($closed) - strtotime($batas)) / 86400);
			// }else if(date('Y-m-d') > $d[COL_DUEDATE] && $d[COL_ISCLOSED] == 0 && $batas != ''){
				// $terlambat = ((strtotime(date("d-m-Y")) - strtotime($batas)) / 86400);
// 				
			// }else{
				// $terlambat = '-';
			// }
// 			
			// $project = $this->db->select(COL_PROJECTNAME)->where(COL_PROJECTID, $d[COL_PROJECTID])->get(TBL_PROJECTS)->row_array();
// 			
// 			
			$data[$i] = array(
							// '<input type="checkbox" class="cekbox" name="cekbox[]" value="'.$d[COL_COMMENTID].'" />',
							$d[COL_COMMENTID],
							$comment,
							$d[COL_CREATEDBY],
							$d[COL_CREATEDON],
							$task[COL_SUMMARY],
							anchor('task/view/'.$d[COL_TASKID],'View Tugas'),
						);
			$i++;
		}
		$data = json_encode($data);
	// }	
	?>

	<div class="page-wrapper">	
		<div class="row">
			<div class="col-md-12">
				<h1><?= $title ?></h1>
					
					<div class="row">
						<div class="col-md-4">
							<?= form_open(current_url(),array('method'=>'get')) ?>
							<div class="input-group search">
												
								<select name="Search" class="form-control ">
									
									<option value="all" <?= $s == 'all'? 'selected': '' ?>>Semua</option>
									<?=
										GetComboboxCI($u, 'UserName', 'UserName',$s?$s:'');
									?>
									<!-- <option value="0" <?= $s == '0'? 'selected': '' ?>>Belum Selesai</option>
									<option value="1" <?= $s == '1'? 'selected': '' ?>>Sudah Selesai</option> -->						
								</select>
								<!-- <input type="hidden" name="projectid" value="<?= $this->input->get('projectid') ?>" /> -->
								<span class="input-group-btn">
							        <button type="submit" class="btn btn-primary" type="button">Tampilkan</button>
							    </span>
							    
							</div>
							<?= form_close() ?>
						</div>
					</div>
				
				    <br />
					<div class="row">
						<div class="col-md-12">
							<p>
								<!-- <?=anchor('task/delete','<i class="clip-remove"></i> Hapus',array('class'=>'cekboxaction ui btn btn-danger','confirm'=>'Apa anda yakin?'))?> -->
								
							</p>
						</div>
					</div>
					<!-- <div class="table-responsive"> -->
						<form id="dataform" method="post" action="#">
							<table id="databerita" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered" width="100%">
							</table>
						</form>
					<!-- </div> -->
					<div class="clear"></div>

				</div>
			</div>
		</div>
		<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>


<script type="text/javascript">
$(document).ready(function(){
	

		var pelangganTable = $('#databerita').dataTable({
	        "aaData": <?=$data?>,
	        // "bJQueryUI": true,
	        "aaSorting" : [[3,'desc']],
        	// "sPaginationType": "full_numbers",
        	"scrollY" : 400,
        	"scrollX" : "150%",
        	"iDisplayLength": 100,
    		"aLengthMenu": [[100, 1000, 5000, -1], [100, 1000, 5000, "Semua"]],
	        "aoColumns": [
	        	// {"sTitle": "<input type=\"checkbox\" id=\"cekbox\" class=\"cekbox\" />","sWidth":15,bSortable:false},
	        	{"sTitle": "ID"},
	            {"sTitle": "Komentar"},
	            {"sTitle": "Oleh"},
	            {"sTitle": "Tanggal"},
	            {"sTitle": "Tugas"},
	            {"sTitle": "Act"}
	        ],
	        "dom":"R<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>",
		    "buttons": ['copyHtml5','excelHtml5','csvHtml5','pdfHtml5','print']
	    });
	    $("input[aria-controls=databerita]").unbind().bind('keyup',function(e){
		    if (e.keyCode == 13) {
		        pelangganTable.fnFilter(this.value);
		    }
		});
		$('#dataform').find('input').keydown(function(e){
			if(e.which == 13){
				return false;
			}
		});
		
		$(function () {
		  $('[data-toggle="popover"]').popover();
		});
		
		// $('[data-toggle="tooltip"]').tooltip();   
		
});


</script>
<?php } ?>
<?= $this->load->view('footer')?>