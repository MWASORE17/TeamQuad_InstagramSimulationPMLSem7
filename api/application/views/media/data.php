<?php $this->load->view('admin/header') ?>
	<div class="span-17 col-md-12 forcecenter">
		<div class="page-header">
			<h1>Data Media</h1>
		</div>
		<?php if(!IsAllowDelete(MODULMEDIA) && !IsAllowDelete(MODULMEDIAIKLAN)){ ?>
			<script>
				$(document).ready(function(){
					$('.cekboxaction').hide();
				});
			</script>
		<?php } ?>
		
		<?php
			if(IsAllowView(MODULMEDIA) || IsAllowView(MODULMEDIAIKLAN)){
		?>
		<form id="dataform" method="post" action="#">
			<p>
				<?=anchor('media/delete','<i class="clip-remove"></i> Hapus',array('class'=>'cekboxaction ui btn btn-danger','confirm'=>'Apa anda yakin?'))?>
				<?php if(IsOtherModuleActive(OTHERMODUL_WATERMARKMEDIA)){ ?>
					<?=anchor('media/watermark','<i class="clip-pencil"></i> Watermark',array('class'=>'watermark ui btn btn-success','confirm'=>'Apa anda yakin?'))?>
				<?php } ?>
				<?php if(IsOtherModuleActive(OTHERMODUL_ROTATEMEDIA)){ ?>
					<?=anchor('media/rotation','<i class="clip-spinner-6"></i> Rotasi',array('class'=>'rotasi ui btn btn-warning','confirm'=>'Apa anda yakin?'))?>
				<?php } ?>
			</p>
			<div class="table-responsive">
				<table id="datamedia" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered" width="100%">
					<thead>
						<tr>
							<th style="width: 30px"><input type="checkbox" id="cekbox" /></th>
	                        <th>Gambar</th>
	                        <th>Nama / Lokasi</th>
	                        <th>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$data = array();
						$i = 0;
						foreach ($r->result() as $d) {
							if(FileExtension_Check($d->MediaPath, 'gambar')){
								?>
								<tr>
									<td>
										<input type="checkbox" name="cekbox[]" class="cekbox" value="<?=$d->MediaID?>" /><input type="hidden" name="medias[]" value="<?=$d->MediaID?>" />
										
									</td>
		                            <td><?=(empty($d->MediaPath)) ? '-' : '<img height="100" width="100" src="'.base_url().'assets/images/timthumb.php?src='.base_url().'assets/images/media/'.$d->MediaPath.'&w=100&h=100&q=20" />'?></td>
		                            <td><?=anchor('media/edit/'.$d->MediaID,$d->MediaName).'<br /><textarea class="select" readonly="" style="width:100%; height: 50px;">'.base_url().'assets/images/media/'.$d->MediaPath.'</textarea>'?>
		                            	
		                            </td>
		                            <td>
		                            	<div>
											<div class="btn-group">
												<a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle btn-sm" style="color: #fff">
													<i class="icon-cog"></i> <span class="caret"></span>
												</a>
												<ul class="dropdown-menu pull-right" role="menu">
													<li role="presentation">
														<a href="<?= site_url('media/edit/'.$d->MediaID) ?>" tabindex="-1" role="menuitem">
															<i class="icon-edit"></i> Edit
														</a>
													</li>
													<li role="presentation">
														<a href="<?= site_url('media/crop/'.$d->MediaID) ?>" tabindex="-1" role="menuitem">
															<i class="icon-cut"></i> Crop
														</a>
													</li>
													<li role="presentation">
														<a href="<?= site_url('media/watermark').'?ids='.$d->MediaID ?>" tabindex="-1" role="menuitem">
															<i class="icon-picture"></i> Watermark
														</a>
													</li>
													<li role="presentation">
														<a href="<?= site_url('media/rotasi').'?ids='.$d->MediaID ?>" tabindex="-1" role="menuitem">
															<i class="icon-undo"></i> Rotasi
														</a>
													</li>
												</ul>
											</div>
										</div>
		                            </td>
								</tr>
								<?php
							}else{
								?>
								<tr>
									<td>
										<input type="checkbox" name="cekbox[]" class="cekbox" value="<?=$d->MediaID?>" /><input type="hidden" name="medias[]" value="<?=$d->MediaID?>" />
										
									</td>
		                            <td><h2><?=FileExtension($d->MediaPath)?></h2></td>
		                            <td><?=anchor('media/edit/'.$d->MediaID,$d->MediaName).'<br /><textarea class="select" readonly="" style="width:200px; height: 50px;">'.base_url().'assets/images/media/'.$d->MediaPath.'</textarea>'?></td>
									<td>
		                            	<div>
											<div class="btn-group">
												<a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle btn-sm" style="color: #fff">
													<i class="icon-cog"></i> <span class="caret"></span>
												</a>
												<ul class="dropdown-menu pull-right" role="menu">
													<li role="presentation">
														<a href="<?= site_url('media/edit/'.$d->MediaID,$d->MediaName) ?>" tabindex="-1" role="menuitem">
															<i class="fa fa-edit"></i> Edit
														</a>
													</li>
												</ul>
											</div>
										</div>
		                            </td>
								</tr>
								<?php
							}
							$i++;
						}
						$data = json_encode($data);
						?>
					</tbody>
				</table>
			</div>
		</form>
		<?php }else{ ?>
		<div class="error alert alert-danger">Tidak diizinkan</div>
		<?php } ?>
		<div class="clear"></div>
		<br /><br />
	</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('.select').on('click',function(){
			$(this).select();
		});
	});
		var basewm = '<?=site_url('media/watermark')?>';
		var baser = '<?=site_url('media/rotasi')?>';
		
		$('.watermark').click(function(){
			if($('.cekbox:checked').length){
				var ser = $('#dataform').serialize();
				var ids = "";
				var i = 0;
				$('.cekbox:checked').each(function(){
					i++;
					if(i > 1){
						ids = ids+","+$(this).val();
					}else{
						ids = ids+$(this).val();
					}
				});
				location.href = basewm+'?ids='+ids;
			}else{
				alert('Tak ada yg terpilih');
			}
			return false;
		});
		$('.rotasi').click(function(){
			if($('.cekbox:checked').length){
				var ser = $('#dataform').serialize();
				var ids = "";
				var i = 0;
				$('.cekbox:checked').each(function(){
					i++;
					if(i > 1){
						ids = ids+","+$(this).val();
					}else{
						ids = ids+$(this).val();
					}
				});
				location.href = baser+'?ids='+ids;
			}else{
				alert('Tak ada yg terpilih');
			}
			return false;
		});
		
		var pelangganTable = $('#datamedia').dataTable( {
	        "iDisplayLength": 10,
	        "aLengthMenu": [[10, 20, 50, -1], [10, 20, 50, "Semua"]],
	        "aaSorting" : [],
	        "language": {
			   "sProcessing":   "Sedang proses...",
			   "sLengthMenu":   "Tampilan _MENU_ Baris per halaman",
			   "sZeroRecords":  "Tidak ditemukan data yang sesuai",
			   "sInfo":         "Tampilan _START_ sampai _END_ dari _TOTAL_ entri",
			   "sInfoEmpty":    "Tampil I sampai J dari K data",
			   "sInfoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
			   "sInfoPostFix":  "",
			   "sSearch":       "Cari:",
			   "sUrl":          "",
			   "oPaginate": {
			       "sFirst":    "Awal",
			       "sPrevious": "Sebelumnya",
			       "sNext":     "Berikutnya",
			       "sLast":     "Akhir"
			   }
	        },
	        "dom":"R<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>",
		    "buttons": [
		    			'copyHtml5',
			            'excelHtml5',
			            'csvHtml5',
			            'pdfHtml5',
			            'print'
		    ]
	    });
	    $("input[aria-controls=datamedia]").unbind().bind('keyup',function(e){
		    if (e.keyCode == 13) {
		        pelangganTable.fnFilter(this.value);
			}
		});
</script>

<?php $this->load->view('admin/footer') ?>