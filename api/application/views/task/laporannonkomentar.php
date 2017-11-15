<?php
if(!IsOtherModuleActive(OTHERMODUL_CANLOOKREPORT)){
?>
	<div class='alert alert-warning'>
 		Tidak diizinkan melihat data
	</div>
<?php	
}else{
	$date = $this->input->post('Date');
?>
	<!DOCTYPE html>
	<html>
	<head>
		<title>Laporan tugas yang tidak dikomentari</title>
		<style type="text/css">
			body{
				font-family: Verdana;
				font-size: 0.9em;
			}
			table{
				border-collapse: collapse;
			}
		</style>
	</head>
	<body>
		<h2 align="center"><?= $title ?></h2>
	
	
		<table  cellpadding="5" cellspacing="0" width="100%" border="1" style="font-size: 11px;">
			<thead>
				<tr>
					<th>ID</th>
					<th>Project</th>
					<th>Summary</th>
					<th>Assign To</th>
					<th>Status</th>
					<th>Tgl Mulai</th>
					<th>Tgl Selesai</th>
					<th>Komentar pd Hari ini (Tgl <?= $date ?>)</th>
				</tr>
			</thead>
			<tbody>
		<?php		
		foreach($result->result_array() as $result1){
			$project = $this->db->where(COL_PROJECTID,$result1[COL_PROJECTID])->get(TBL_PROJECTS)->row_array();
			$priority = $this->db->where(COL_TASKPRIORITYID,$result1[COL_TASKPRIORITYID])->get(TBL_TASKPRIORITIES)->row_array();
			$status = $this->db->where(COL_TASKSTATUSID,$result1[COL_TASKSTATUSID])->get(TBL_TASKSTATUS)->row_array();
			$assign = $this->mtask->GetAssignString($result1[COL_TASKID]);
			
			if($result1[COL_DUEDATE] == null || $result1[COL_DUEDATE] == '0000-00-00' || $result1[COL_DUEDATE] == ''){
				$batas='';
				
			}else{
				$batas = date('d',strtotime($result1[COL_DUEDATE]))."-".date('m',strtotime($result1[COL_DUEDATE]))."-".date('Y',strtotime($result1[COL_DUEDATE]));
			}
			
			if(($result1[COL_CLOSEDON] != null || $result1[COL_CLOSEDON] != '0000-00-00 00:00:00' || $result1[COL_CLOSEDON] != '')){
				$closed = date('d',strtotime($result1[COL_CLOSEDON]))."-".date('m',strtotime($result1[COL_CLOSEDON]))."-".date('Y',strtotime($result1[COL_CLOSEDON]));
			}else{
				$closed='';
			}
			
			if ($result1[COL_ISCLOSED] == 1 && $result1[COL_CLOSEDON] > $result1[COL_DUEDATE] && $batas != '') {
				$terlambat = ((strtotime($closed) - strtotime($batas)) / 86400);
			}else if(date('Y-m-d') > $result1[COL_DUEDATE] && $result1[COL_ISCLOSED] == 0 && $batas != ''){
				$terlambat = ((strtotime(date("d-m-Y")) - strtotime($batas)) / 86400);
				
			}else{
				$terlambat = '-';
			}
			$this->db->where('date('.COL_CREATEDON.')',$date);
			$this->db->order_by('CreatedOn','asc');
			$comments = $this->db->where(COL_TASKID,$result1[COL_TASKID])->get(TBL_COMMENTS);
		?>	
				<tr>
					<td><?= $result1[COL_TASKID] ?></td>
					<td><?= $project[COL_PROJECTNAME] ?></td>
					<td><?= $result1[COL_SUMMARY] ?></td>
					<td><?= $assign ?></td>
					<td><?= $status[COL_TASKSTATUSNAME] ?></td>
					<td><?= $result1[COL_STARTEDDATE] ?></td>
					<td><?= $result1[COL_DUEDATE] ?></td>
					<td>
						<?php
							$ada = 0;
							foreach($comments->result_array() as $com){
								echo $com[COL_CREATEDBY].':<br />'.word_limiter(strip_tags($com[COL_DESCRIPTION]),20).'<hr />';
								$ada++;
							}
							if(!$ada){
								echo '<div style="color:red">Tidak ada komentar</div><hr />';
							}
						?>
						<?php if($result1[COL_ISCOMPLETED]){ ?>
						<strong>Selesai hari ini</strong>:<br />
						<?= $result1[COL_COMPLETEMESSAGE] ? $result1[COL_COMPLETEMESSAGE] : "-" ?>
						<?php } ?>
					</td>
				</tr>
				
		<?php		
		}
		?>	</tbody>
		</table>
		<p align="right">
			Dicetak pada <?=date('d M Y H:i:s')?>
		</p>
	</body>
	</html>
<?php
}
?>
