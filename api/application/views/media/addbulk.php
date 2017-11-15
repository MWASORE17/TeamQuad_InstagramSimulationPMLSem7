<?php $this->load->view('admin/header') ?>

<link href="<?php echo base_url(); ?>assets/uploadify/uploadify.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url();?>assets/uploadify/swfobject.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/uploadify/jquery.uploadify.v2.1.4.min.js"></script>

	<div class="page-header">
		<h1>Bulk Upload</h1>
	</div>
	<?php
		if(IsAllowInsert(MODULMEDIA)){
	?>
	
	<fieldset>
		<legend>Upload</legend>
		<form id="innerForm" class="Confirm" confirm="Are you sure?" method="post" enctype="multipart/form-data" action="<?=site_url('media/bulked')?>">
		<table border="0">
			<tr>
				<td>
					<input id="file_upload" name="file_upload" type="file" />
					<a href="javascript:$('#file_upload').uploadifyUpload();" class="ui"> Upload File! </a>
					<div id="target"></div>
				</td>
			</tr>
		</table>
		</form>
	</fieldset>
	
	<?php } ?>

<script type="text/javascript">
						$(document).ready(function(){
							$('#file_upload').uploadify({
						        'uploader'  : '<?=base_url()?>assets/uploadify/uploadify.swf',
						        'script'    : '<?=base_url()?>assets/uploadify/uploadify.php',
						        'cancelImg' : '<?=base_url()?>assets/uploadify/cancel.png',
						        'folder'    : '<?=base_url()?>assets/images/media',
						        'auto'      : false,
						        'multi'		: true,
						        'fileExt'     : '<?=ALLOWEDFILES?>',
  								'fileDesc'    : 'This Files(jpg,gif,png,pdf)',
						        'removeCompleted' : false,
						        'onAllComplete' : function(){
						        	$('#GeneralDialog').dialog('destroy');
									$('#GeneralDialog').html("All file has been uploaded");
									$('#GeneralDialog').dialog({
										modal : true,
										resizable : false,
										buttons : {
											OK : function() {
												$(this).dialog('close');
												location.href = "<?=site_url('media')?>";
											}
										}
									});
						        },
								'scriptData' : {}
						      });  
						});
</script>

<?php $this->load->view('admin/footer') ?>
