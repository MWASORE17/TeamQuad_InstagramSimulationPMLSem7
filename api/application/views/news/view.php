<?= $this->load->view('header')?>

<div class="page-wrapper">	
	<div class="row">
		<div class="col-md-12">
			<h1><?= $news[COL_NEWSTITLE] ?></h1>
			<p><?= $news[COL_DESCRIPTION] ?></p>
			
			<br />
			<br />
			<p><small>Posted by: <?= $news[COL_CREATEDBY] ?>  On : <?= $news[COL_CREATEDON] ?></small></p>
			
		</div>
	</div>
</div>	


<?= $this->load->view('footer')?>