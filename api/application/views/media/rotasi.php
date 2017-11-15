<?php $this->load->view(ADMINHEADERVIEW) ?>
<link rel="stylesheet" href="<?=base_url()?>assets/colorpicker/css/colorpicker.css" type="text/css" />
<script type="text/javascript" src="<?=base_url()?>assets/colorpicker/js/colorpicker.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/colorpicker/js/eye.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/colorpicker/js/utils.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/colorpicker/js/layout.js?ver=1.0.2"></script>

<style>
	input[type="text"], textarea, .form select {
  	box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
  	width: auto;
  	}

</style>
<div class="page-header">
	<h1>Rotasi</h1>
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
		<div class="col-md-4 col-sm-6">
			<label>Rotasi Ke</label>
			<select name="RotationTo" class="form-control">
				<option value="270">Kanan</option>
				<option value="90">Kiri</option>
				<option value="180">180 Derajat</option>
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
