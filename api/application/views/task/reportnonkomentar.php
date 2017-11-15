<?php $this->load->view('header') ?>

<div class="page-header">
	<h1>Laporan Non Komentar</h1>
</div>
<?php
	if(!IsOtherModuleActive(OTHERMODUL_CANLOOKREPORT)){
			?>
			<div class="alert alert-warning">
				Tidak diizinkan melihat data
			</div>
			<!-- <script>
				$(document).ready(function(){
					$('form').hide();
				});
			</script> -->
			<?php
		}
	
			
	?>
<div class="page-wrapper">	
	<div class="row">
		<div class="col-md-12">
			<?=form_open('task/laporannonkomentar',array('target'=>'_blank', 'id' => 'validate'))?>
			<div class="form-group">
				<div class="row">
					<div class="col-md-4 col-sm-4">
						<label>Untuk Tanggal </label> 
						<!-- <input id="FromDate" type="text" size="30" style="width: 30%" class="required datepicker" name="FromDate" value=""  />  -->
						<div class="input-group">
					        <span class="add-on input-group-btn">
				                <button disabled type="button" class="btn btn-default tanggal">
				                    <span class="glyphicon glyphicon-calendar"></span>
				                </button>
				            </span>
					        <input style="" readonly="" required data-date="" data-date-format="yyyy-mm-dd" id="dp1356593248900" class="StartDate form-control date-picker date1" type="text" value="<?= date('Y-m-d') ?>" name="Date" >
					    	<span class="add-on input-group-btn">
				                <button type="button" class="btn btn-default clear-tanggal1">
				                    <span>Clear</span>
				                </button>
				            </span>
				        </div>
					</div>
					<div class="col-md-4 col-sm-4">
						<label>Project </label><br>
						<select class="cats" id="kategori" name="ProjectID[]" multiple="">
							<?php 
							#$cats = GetProductCats();
							$project = $this->db->select()->get(TBL_PROJECTS);
							?>
							<?php GetComboboxCI($project, COL_PROJECTID, COL_PROJECTNAME,'') ?>
						</select>
					</div>
				</div>
			</div>
			<button type="submit" class="ui btn btn-primary">Tampilkan Laporan</button>

			<?= form_close() ?>
		</div>
	</div>
</div>		

<script type="text/javascript">
	$(document).ready(function(){
		// $(".cats").dropdownchecklist( { icon: { placement: 'right', toOpen: 'ui-icon-arrowthick-1-s'
                                            // , toClose: 'ui-icon-arrowthick-1-n'}
            								// , maxDropHeight: 300, width: 300 } );
        $('.cats').multiselect({
	        includeSelectAllOption: true,
	        maxHeight: 150,
	        numberDisplayed: 1
	    });
	    
	    $('.date-picker').datepicker({
			dateFormat: "yyyy-mm-dd",
			changeYear : true,
			changeMonth: true,
			showOn: "button",
			buttonImage: "<?= base_url() ?>assets/images/calendar.gif",
			buttonImageOnly: true,
			minDate: "-12M", 
			maxDate: 0
		});
		
		$('.clear-tanggal1').click(function(){
			$('.date1').val('');
			
		});
		$('.clear-tanggal2').click(function(){
			$('.date2').val('');
			
		});	
	    // $('#dpFrom,#dpUntil').datepicker();
	    
	    $.validator.addMethod("endDate", function(value, element) {
            var startDate = $('.StartDate').val();
            return Date.parse(startDate) <= Date.parse(value) || value == "";
        }, "End date must be after start date");
        $('#validate').validate();
	});
</script>
<?php $this->load->view('footer') ?>
