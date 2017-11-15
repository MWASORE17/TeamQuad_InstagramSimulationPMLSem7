
<?php #$this->load->view('admin/header') ?>
<style>
	.mediacontainer > li {
	  display: inline-block;
	}
	.modal-body {
	  height: 300px;
	  overflow: scroll;
	  padding: 20px;
	  position: relative;
	}
	.modal-footer{
		margin-top: 0px;
	}
</style>
<p style="text-align: right;width: 100%">
	<input type="text" id="FilterMedia" name="FilterMedia" />
	<button type="button" id="xFind" class="btn btn-default">Cari</button>
</p>
<div class="clear"></div>
<ul class="mediacontainer multiselectmediacontainer row">
<?php
$sasa = 0;
foreach ($r->result() as $d) {
	if(!FileExtension_Check($d->MediaPath, 'gambar')){
		continue;
	}
	$sasa++;
	?>
	<li class="col-md-3 col-sm-4" keyword="<?=$d->MediaPath?> <?=$d->MediaName?>">
	<?php
		echo (empty($d->MediaPath)) ? '-' : '<img height="100" width="100" src="'.base_url().'assets/images/timthumb.php?src='.base_url().'assets/images/media/'.$d->MediaPath.'&w=100&h=100&q=20" />'."<hr /><input id='cec-".$sasa."' type='checkbox' mediaid='".$d->MediaID."' title='".$d->MediaName."' src='".$d->MediaPath."' class='selectit' />";
		//<label for='cec-".$sasa."'>Pilih</label>";
		echo "<label for='cec-".$sasa."'></label>";
	?>
	</li>
	<?php
}
?>
</ul>

<script type="text/javascript">
	$('#FilterMedia').keypress(function(e){
		if(e.which == 13){
			if($('#FilterMedia').val()==""){
				$('.mediacontainer li').show();
				return false;
			}
			$('.mediacontainer li').hide();
			$('.mediacontainer').find('li[keyword*='+$('#FilterMedia').val()+']').fadeIn(500);
		}
	});
	$('#xFind').click(function(){
		if($('#FilterMedia').val()==""){
			return false;
		}
		
		$('.mediacontainer li').hide();
		$('.mediacontainer').find('li[keyword*='+$('#FilterMedia').val()+']').fadeIn(500);
	});
</script>

<?php #$this->load->view('admin/footer') ?>