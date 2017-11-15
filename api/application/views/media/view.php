<?php
$result = $result;
?>
<!-- <h2><?=$result->MerchandiseName?></h2> -->
<div>
<div id="fotorama">
<?php
	foreach ($images as $image) {
		?>
		<img width="500" height="350" src="<?=base_url()?>assets/images/uploaded/<?=$image->ImagePath?>" alt="<?=$image->ImagePath?>" />
		<?php
	}
?>
</div>
</div>
<table width="480">
	<tr valign="top">
		<td>Description</td>
		<td>:</td>
		<td><?=$result->Description;?></td>
	</tr>
	<tr>
		<td>Category</td>
		<td>:</td>
		<td><?=$category->MerchandiseCategoryName;?></td>
	</tr>
	<?php if(!empty($result->SalePrice)){ ?>
	<tr>
		<td>Price</td>
		<td>:</td>
		<td> <span style="text-decoration:line-through;">$<?=desimal($result->NormalPrice,2);?></span> $<?=desimal($result->SalePrice,2);?></td>
	</tr>
	<?php }else{ ?>
		<tr>
		<td>Price</td>
		<td>:</td>
		<td>$<?=desimal($result->NormalPrice,2);?></td>
	</tr>
	<?php } ?>
	<tr valign="top">
		<td>Weight</td>
		<td>:</td>
		<td><?=desimal($result->Weight);?> Gram(s)</td>
	</tr>
	<!-- <tr>
		<td colspan="3" align="center">
			<br />
			<?=anchor('market/buy/'.$result->MerchandiseID, 'Add to cart', array('class' => 'cart'));?>
		</td>
	</tr> -->
</table>
<br />
<script type="text/javascript">
				$('#fotorama').fotorama({
					backgroundColor: '#FFF',
  					arrowsColor: 'black',
  					thumbsPreview: false,
  					touchStyle: false,
  					width: 500,
  					height : 350
				});
</script>