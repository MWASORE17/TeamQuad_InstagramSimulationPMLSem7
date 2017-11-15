<?= $this->load->view('header')?>
<?php

 if(!IsUserLogin()){
 ?>	
 	<div class='alert alert-warning'>
 		Silahkan <?= anchor('user', 'Login')?> Dulu
	</div>
<?php	
 }else if(!IsAllowView(MODULTASKCATEGORIES)){
 ?>		
 	<div class='alert alert-warning'>
 		Tidak diizinkan melihat data
	</div>
<?	
 }else{
		
	if(!IsAllowDelete(MODULTASKCATEGORIES)){
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
		
		$a = $this->mcategory->GetByID($d[COL_PARENTCATEGORYID]);
		$data[$i] = array(
						'<input type="checkbox" class="cekbox" name="cekbox[]" value="'.$d[COL_CATEGORYID].'" />',
						$d[COL_CATEGORYID],
						anchor('category/edit/'.$d[COL_CATEGORYID],$d[COL_CATEGORYNAME]),
						$a->CategoryName
						
					);
		$i++;
	}
	$data = json_encode($data);
	?>

	<div class="page-wrapper">	
		<div class="row">
			<div class="col-md-12">
				<h1><?= $title ?></h1>
										
					<!-- <?php
					 echo CheckRow(TBL_TASKS, COL_CATEGORYID, 5);
					?> -->
					<p>
						<?=anchor('category/delete','<i class="clip-remove"></i> Hapus',array('class'=>'cekboxaction ui btn btn-danger','confirm'=>'Apa anda yakin?'))?>
						
					</p>
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


<script type="text/javascript">
$(document).ready(function(){
	

		var pelangganTable = $('#databerita').dataTable({
	        "aaData": <?=$data?>,
	        // "bJQueryUI": true,
	        "aaSorting" : [[1,'desc']],
        	// "sPaginationType": "full_numbers",
        	"scrollY" : 400,
        	"scrollX" : "150%",
        	"iDisplayLength": 100,
    		"aLengthMenu": [[100, 1000, 5000, -1], [100, 1000, 5000, "Semua"]],
	        "aoColumns": [
	        	{"sTitle": "<input type=\"checkbox\" id=\"cekbox\" class=\"cekbox\" />","sWidth":15,bSortable:false},
	        	{"sTitle": "ID Kategori"},
	            {"sTitle": "Nama Kategori"},
	            {"sTitle": "Parent Kategori"}
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

});


</script>
<?php } ?>
<?= $this->load->view('footer')?>