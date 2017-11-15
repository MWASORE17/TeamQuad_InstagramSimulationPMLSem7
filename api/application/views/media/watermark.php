<?php $this->load->view(ADMINHEADERVIEW) ?>
<link rel="stylesheet" href="<?=base_url()?>assets/colorpicker/css/colorpicker.css" type="text/css" />
<script type="text/javascript" src="<?=base_url()?>assets/colorpicker/js/colorpicker.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/colorpicker/js/eye.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/colorpicker/js/utils.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/colorpicker/js/layout.js?ver=1.0.2"></script>

<style>
	input[type="text"], textarea, .form select {
  	box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
  	}

</style>
<div class="page-header">
	<h1>Watermark</h1>
</div>
<?php
	if(validation_errors()){
		?>
		<div class="alert alert-danger">
			<?=validation_errors()?>
		</div>
		<?php
	}
?>

<?=$images?>
<?=form_open(current_url()."?ids=".$this->input->get('ids'))?>
<div class="form-group">
	<div class="row">
		<div class="col-md-4 col-sm-4">
			<label>Text Watermark</label>
			<input type="text" class="form-control" name="WatermarkText" />
		</div>
		<div class="col-md-4 col-sm-4">
			<label>Jenis Font</label>
			<select name="WatermarkFont" class="form-control">
				<?php
					foreach ($fonts as $font) {
						?>
						<option value="<?=$font?>" style="font-family: <?=FontName($font)?>; font-size: 16px;"><?=FontName($font)?></option>
						<?php
					}
				?>
			</select>
		</div>
		<div class="col-md-4 col-sm-4">
			<label>Ukuran Font</label>
			<div class="input-group">
				<input type="text" name="WatermarkSize" value="18" class="form-control">
				<span class="input-group-addon">Cth: 18</span>
			</div>
		</div>
	</div>
</div>

<!-- <label>Transparansi</label>
<div style="width: 300px; display: inline-block" id="slider"></div>
<input type="text" class="transparancy" readonly="" style="width: 50px" name="WatermarkOpacity" />% -->

<div class="form-group">
	<div class="row">
		<div class="col-md-4 col-sm-4">
			<label>Warna Text</label>
			<input type="text" class="form-control" id="colorPickerBackground" name="WatermarkColor" />
		</div>
		<div class="col-md-4 col-sm-4">
			<label>Posisi Vertikal</label>
			<select name="VerticalPosition" class="form-control">
				<option value="top">Atas</option>
				<option value="bottom">Bawah</option>
				<option value="middle">Pertengahan</option>
			</select>
		</div>
		<div class="col-md-4 col-sm-4">
			<label>Posisi Horizontal</label>
			<select name="HorizontalPosition" class="form-control">
				<option value="left">Kiri</option>
				<option value="right">Kanan</option>
				<option value="center">Tengah</option>
			</select>
		</div>
	</div>
</div>
<p>
	<input type="checkbox" checked="" name="KeepOldImage" value="1" id="Keepz" /> <label for="Keepz">Jaga Data Lama</label> 
</p>
<p>
	<button class="ui btn btn-primary">Simpan</button>
</p>
<?=form_close()?>

<script>
	$(function() {
        $( "#slider" ).slider({
            value:50,
            min: 0,
            max: 100,
            step: 10,
            slide: function( event, ui ) {
                $( ".transparancy" ).val(ui.value);
            }
        });
        $(".transparancy").val($( "#slider" ).slider( "value" ));
        
        $('#colorPickerBackground').ColorPicker({
			onSubmit: function(hsb, hex, rgb, el) {
				$(el).val(hex);
				$(el).css('background','#'+hex);
				$(el).ColorPickerHide();
			},
			onBeforeShow: function () {
				$(this).ColorPickerSetColor(this.value);
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});
    });
</script>

<?php $this->load->view(ADMINFOOTERVIEW) ?>
