<?= $this->load->view('header')?>
<?php
 $imagenum = 0;

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
		if(!IsAllowUpdate(MODULNEWS)){
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
		}
		// }else if(!IsOtherModuleActive(OTHERMODUL_CANEDITTASKANOTHERUSER)){
			// $taskid = $result[COL_TASKID];
			// $userlogin = GetUserLogin("UserName");
// 			
// 			
		// }
	}else{
		if(!IsAllowInsert(MODULNEWS)){
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
				<div class="row row1">
					<!-- <div class="col-md-4">
						<label class="">ID Tugas</label>
						<input  class="form-control required" type="text" disabled name="TaskID" value="<?= $edit ? $result[COL_TASKID]: $lastid+1 ?>" />
						
					</div> -->
					<input type="hidden" name="NewsID" value="<?= $edit ? $result[COL_NEWSID] : '' ?>" />
					<div class="col-md-8">
						<label class="">Judul Berita</label>
						<input  class="form-control required summary" type="text" name="NewsTitle" value="<?= $edit ? $result[COL_NEWSTITLE] : set_value('NewsTitle') ?>" />
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<div class="row row4">
									 
					<div class="col-md-4">
						<label class="">Start Date</label>
						<div class="input-group">
					        <span class="add-on input-group-btn">
				                <button disabled type="button" class="btn btn-default tanggal">
				                    <span class="glyphicon glyphicon-calendar "></span>
				                </button>
				            </span>
					        <input id="StartDate" class="form-control subdatepicker required date1" readonly="" data-date="<?=$edit?$result[COL_STARTEDDATE]:date('Y-m-d')?>" data-date-format="yyyy-mm-dd" id="StartedDate" type="text" value="<?=$edit?$result[COL_STARTEDDATE]:date('Y-m-d')?>" name="StartedDate">
					    	<span class="add-on input-group-btn">
				                <button type="button" class="btn btn-default clear-tanggal1">
				                    <span> Clear</span>
				                </button>
				            </span>
				        </div>
					</div>
					
					<div class="col-md-4">
						<label class="">Exp Date</label>
						<div class="input-group">
							<span class="add-on input-group-btn">
				                <button disabled type="button" class="btn btn-default tanggal">
				                    <span class="glyphicon glyphicon-calendar "></span>
				                </button>
				            </span>
					        <input class="form-control subdatepicker required date2 endDate" readonly="" data-date="<?=$edit?$result[COL_EXPIREDDATE]:set_value('ExpiredDate')?>" data-date-format="yyyy-mm-dd" id="ExpiredDate" type="text" value="<?=$edit?$result[COL_EXPIREDDATE]:set_value('ExpiredDate')?>" name="ExpiredDate" >
					    	<span class="add-on input-group-btn">
				                <button type="button" class="btn btn-default clear-tanggal2">
				                    <span >Clear</span>
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
					buttonImage: "<?= base_url() ?>assets/images/calendar.gif",
					buttonImageOnly: true,
					minDate: "-12M", 
					maxDate: 0,
					autoClose: true 
				});
				
				
				$('.clear-tanggal1').click(function(){
					$('.date1').val('<?= isodate(date('Y-m-d')) ?>');
					
				});
				$('.clear-tanggal2').click(function(){
					$('.date2').val('<?= date('Y-m-d') ?>');
					
				});
				
														
			</script>
			
			<div class="row7">
				<label>Description</label>		
				<textarea class="editor required" id="<?=rand()?>" rows="20" cols="70" name="Description"><?= $edit ? $result[COL_DESCRIPTION] : set_value('Description') ?></textarea></td>
				<br />
			</div>
			<!-- <div class="form-group">
				<div class="row row8">
					<div class="col-md-4 col-sm-4">
						<div class="form-group">
						<label>Is Private</label><br/>
						<input  type="checkbox" <?=$edit? $result[COL_ISPRIVATE]?'checked=""':'' : 'checked=""'?>  name="IsPrivate" id="IsPrivate" value="1" style="vertical-align: middle" /> <label for="IsPrivate">Private</label>
						</div>
					</div>
					
				</div>
			</div> -->
			
				
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
	<form style="display: none" id="uploader" enctype="multipart/form-data">
		<input type="file" name="userfile" id="userfile" style="display: inline-block" />
	</form>
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
						$('.infomedia').eq(idx).html('<img src="<?=base_url()?>assets/images/media/'+data.mediapath+'" width="100" /> <br />Gambar sudah dipilih <strong>'+data.mediapath+'</strong>.  <a href="#" class="removemedia removemedia btn btn-danger"><i class="clip-close"></i></a> <a href="#" class="pilihgambar">Ganti Gambar...</a>').show();
						$('.pilihgambar').eq(idx).remove();
						$('.uploadstatus').eq(idx).empty();
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
						'<a href="#" class="pilihgambar">Pilih Gambar...</a>'+
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
	        }, "Exp date must be after start date");
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