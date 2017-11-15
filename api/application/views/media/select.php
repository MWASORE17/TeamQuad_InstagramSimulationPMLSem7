
<?php #$this->load->view('admin/header') ?>

<p style="float: right">
	<input type="text" id="FilterMedia" name="FilterMedia" />
	<button type="button" id="xFind">Cari</button>
</p>
<div class="clear"></div>
<ul class="mediacontainer">
<?php
foreach ($r->result_array() as $d) {
	if(!FileExtension_Check($d[COL_FILENAME], 'gambar')){
		continue;
	}
	?>
	<li keyword="<?=$d[COL_FILENAME]?> <?=$d[COL_FILENAME]?>">
	<?php
		echo (empty($d[COL_FILENAME])) ? '-' : '<img height="100" width="100" src="'.base_url().'assets/images/timthumb.php?src='.base_url().'assets/images/media/'.$d[COL_FILENAME].'&w=100&h=100&q=20" />'."<hr /><a href='#' mediaid='".$d[COL_ATTACHMENTID]."' title='".$d[COL_FILENAME]."' src='".$d[COL_FILENAME]."' class='selectit'>Pilih</a>";
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