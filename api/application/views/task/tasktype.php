<?= $this->load->view('header')?>

<?php
	$status = $this->input->get('statid');
	
?>
	<div class="page-wrapper">	
		<div class="row">
			<div class="col-md-12">
				<h1><?= $title ?></h1>
				
				<?= form_open('task/editstatus/'.$id)?>
					<div class="form-group">
						<div class="row row5">
							<div class="col-md-4 statusTugas">
								<label class="">Status Tugas</label>
								<select name="TaskStatusID" id="TaskStatusID" class="form-control">
									<?=GetComboboxCI($result, "TaskStatusID", "TaskStatusName", $status)?>
								</select>
								
							</div>
							
						</div>
					</div>
					<div class="form-group">
						<div class="row row5">
							<div class="col-md-4 statusTugas">
								<button class="btn btn-primary" name="submit">Simpan</button>
							</div>
							
						</div>
					</div>
					
				<?= form_close()?>
			</div>
		</div>		
	</div>

<?= $this->load->view('footer')?>