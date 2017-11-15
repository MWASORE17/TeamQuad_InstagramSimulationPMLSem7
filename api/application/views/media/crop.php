<?php $this->load->view(ADMINHEADERVIEW) ?>
<h2>Crop</h2>

<link rel="stylesheet" href="<?=base_url()?>assets/css/jquery.Jcrop.css" type="text/css" media="screen" title="no title" charset="utf-8"/>
<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.Jcrop.min.js"></script>

<div class="col-sm-6">
	<div class="input-group">
		<span class="input-group-addon">Pilih ukuran</span>
		<select class="form-control" id="selectsize">
			<option value="nullxnull">Free Size</option>
			<?php
				if(!empty($sizes)){
					foreach ($sizes as $sz) {
						echo '<option value="'.$sz->w.'x'.$sz->h.'">'.$sz->name.'('.$sz->w.'x'.$sz->h.')</option>';
					}
				}
			?>
		</select>
	</div>
</div>
<div class="clearfix"></div>
<div style="padding:15px;" class="col-md-12">
<?=$images?>
</div>
<form action="<?=current_url()?>" method="post">
		<div class="cinfo">
			<input type="hidden" id="file_name" name="file_name" value="./assets/images/media/<?=$result->MediaPath?>" />
			<input type="hidden" id="x" name="x" />
			<input type="hidden" id="y" name="y" />
			<input type="hidden" id="ratio" name="ratio" />
		</div>
		<input type="hidden" id="w" name="w" readonly="" /><input readonly="" type="hidden" id="h" name="h" />
		<p>
		<input type="checkbox" checked="" name="KeepOldImage" value="1" id="Keepz" /> <label for="Keepz">Jaga Data Lama</label> 
		</p>
		<p>
		<button class="ui btn btn-primary" name="Submit" value="Submit">Simpan</button>
		</p>
</form>

<script type="text/javascript">
	var oriw = <?= $orig_w ?>;
	$(function(){
		var holderw = 0;
		var cropholder = $('.jcrop-holder');
		var holderh = cropholder.height();
		var holderw = cropholder.width();
		var jcrop = $.Jcrop($('#cropbox'),{
			setSelect: [10,10,100,100],
			onSelect: updateCoords,
			onChange: updateCoords,
			trueSize: [<?= $orig_w ?>,<?= $orig_h ?>]
		});
		$('#selectsize').change(function(){
			var cropholder = $('.jcrop-holder');
			var holderh = cropholder.height();
			var holderw = cropholder.width();
			var myval = $(this).val();
			var split = myval.split('x');
			var ap = split[0]/split[1];
			jcrop.destroy();
			jcrop = $.Jcrop($('#cropbox'),{
				setSelect: [10,10,holderw*50/100,holderh*50/100],
				onSelect: updateCoords,
				onChange: updateCoords,
				aspectRatio: split[0] == 'null' ? null : ap
			});
			return false;
		});
	});

	function updateCoords(c)
	{
		var cropholder = $('.jcrop-holder');
		var holderh = cropholder.height();
		var holderw = cropholder.width();
		$("#ratio").val(oriw/holderw);
		$("#x").val(c.x);
		$("#y").val(c.y);
		$("#w").val(c.w);
		$("#h").val(c.h);
	}
</script>

<?php $this->load->view(ADMINFOOTERVIEW) ?>
