<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=!empty($title) ? $title.' | ' : ''?>Project Management</title>
 
    <!-- Bootstrap -->
    <!-- <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet"> -->
 	
 	<script src="<?= base_url() ?>assets/admintemplate/js/jquery-1.11.2.min.js"></script>
 	<!-- <script type="text/javascript" src="<?= base_url() ?>assets/js/jquery-ui-1.8.18.custom.min.js" charset="UTF-8"></script>
 	<script type="text/javascript" src="<?= base_url() ?>assets/js/jquery-1.7.1.min.js" charset="UTF-8"></script>
 	<script type="text/javascript" src="<?= base_url() ?>assets/js/jquery.simpletip-1.3.1.min.js" charset="UTF-8"></script> -->
	
	<!-- <script src="<?= base_url() ?>assets/admintemplate/plugins/jquery-ui-1.11.2/jquery-ui.min.js"></script> -->
	
	<!-- DX -->
	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dx/css/dx.spa.css" />
	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dx/css/dx.common.css" />
	<link rel="dx-theme" data-theme="generic.light" href="<?= base_url() ?>assets/dx/css/dx.light.css" />
	<!-- <link rel="dx-theme" data-theme="generic.light.compact" href="<?= base_url() ?>assets/dx/css/dx.light.compact.css" /> -->
	<link rel="dx-theme" data-theme="generic.dark" href="<?= base_url() ?>assets/dx/css/dx.dark.css" />
	<!-- <link rel="dx-theme" data-theme="generic.dark.compact" href="<?= base_url() ?>assets/dx/css/dx.dark.compact.css" /> -->
	<link rel="dx-theme" data-theme="generic.contrast" href="<?= base_url() ?>assets/dx/css/dx.contrast.css" />
	<!-- <link rel="dx-theme" data-theme="generic.contrast.compact" href="<?= base_url() ?>assets/dx/css/dx.contrast.compact.css" /> -->
	<link rel="dx-theme" data-theme="android5.light" href="<?= base_url() ?>assets/dx/css/dx.android5.light.css" />
	<link rel="dx-theme" data-theme="ios7.default" href="<?= base_url() ?>assets/dx/css/dx.ios7.default.css" />
	<!--<link rel="dx-theme" data-theme="win8.black" href="css/dx.win8.black.css" data-active="true" />
	<link rel="dx-theme" data-theme="win8.white" href="css/dx.win8.white.css" />
	<link rel="dx-theme" data-theme="win10.black" href="<?= base_url() ?>assets/dx/css/dx.win10.black.css" /> -->
	<link rel="dx-theme" data-theme="win10.white" href="<?= base_url() ?>assets/dx/css/dx.win10.white.css" />
	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dx/css/dx.customdtgrid.css"  />
	
	<script type="text/javascript" src="<?= base_url() ?>assets/dx/js/cldr.min.js"></script>
	<script type="text/javascript" src="<?= base_url() ?>assets/dx/js/cldr/event.min.js"></script>
	<script type="text/javascript" src="<?= base_url() ?>assets/dx/js/cldr/supplemental.min.js"></script>
	<script type="text/javascript" src="<?= base_url() ?>assets/dx/js/globalize.min.js"></script>
	<script type="text/javascript" src="<?= base_url() ?>assets/dx/js/jszip.min.js"></script>
	<script src="<?= base_url() ?>assets/dx/js/dx.all.js"></script>
	
	<script type="text/javascript" src="<?= base_url() ?>assets/dx/js/my.dx.config.js?v=<?=time()?>"></script>
		
 	<!-- <script src="<?=base_url()?>assets/js/jquery-1.11.1.min.js" type="text/javascript"> </script> -->
 	<link href="<?=base_url()?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url()?>assets/style.css?v=1" rel="stylesheet" type="text/css" />
    <link href="<?=base_url()?>assets/admintemplate/fonts/style.css" rel="stylesheet" type="text/css" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- <script type="text/javascript" src="<?= base_url() ?>assets/js/jquery-ui-1.8.18.custom.min.js" charset="UTF-8"></script> -->
	<link rel="stylesheet" href="<?= base_url() ?>assets/admintemplate/plugins/fullcalendar/fullcalendar/fullcalendar.css">
	
	<script src="<?=base_url()?>assets/bootstrap/js/bootstrap.min.js" type="text/javascript"> </script>
	
    <!-- datatable css -->
	<link rel="stylesheet" href="<?= base_url() ?>assets/datatable/media/css/dataTables.bootstrap.min.css">
    
    <script type="text/javascript" src="<?=base_url()?>assets/datatable/media/js/jquery.dataTables.min.js?ver=1"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/datatable/media/js/dataTables.bootstrap.min.js"></script>
      <script type="text/javascript" src="<?=base_url()?>assets/datatable/media/js/ColReorderWithResize.js"></script>
	
	<script type="text/javascript" src="<?= base_url() ?>assets/js/jquery.form.js"></script>
	<script type="text/javascript" src="<?= base_url() ?>assets/js/jquery.validate.min.js"></script>
	<script type="text/javascript" src="<?= base_url() ?>assets/js/function.js"></script>
	
	<script type="text/javascript" src="<?= base_url() ?>assets/admintemplate/plugins/bootstrap/js/bootstrap-multiselect.js"></script>
	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/admintemplate/plugins/bootstrap/css/bootstrap-multiselect.css" />
	
	<script type="text/javascript" src="<?= base_url() ?>assets/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="<?= base_url() ?>assets/ckeditor/adapters/jquery.js"></script>
	
	<script type="text/javascript" src="<?=base_url()?>assets/admintemplate/asset/js/bootstrap-datepicker.js?v=2"></script>
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admintemplate/asset/css/datepicker.css" />	
	
	<!-- datatable buttons ext + resp + print -->
	<script type="text/javascript" src="<?=base_url()?>assets/datatable/ext/buttons/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/datatable/ext/buttons/buttons.bootstrap.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/datatable/ext/buttons/buttons.print.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/datatable/ext/buttons/buttons.print.min.js"></script>
	<link href="<?=base_url()?>assets/datatable/ext/buttons/buttons.bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="<?=base_url()?>assets/datatable/ext/responsive/css/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="<?=base_url()?>assets/datatable/ext/jszip/jszip.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/datatable/ext/pdfmake/build/pdfmake.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/datatable/ext/pdfmake/build/vfs_fonts.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/datatable/ext/responsive/js/dataTables.responsive.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/datatable/ext/buttons/buttons.html5.min.js"></script>
	
	<!-- <script type="text/javascript" src="<?=base_url()?>assets/tag/jquery.tagsinput.js" charset="UTF-8"></script>
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/tag/jquery.tagsinput.css" /> -->
	
	<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
	<!-- <script src="<?= base_url() ?>assets/admintemplate/plugins/flot/jquery.flot.js"></script>
	<script src="<?= base_url() ?>assets/admintemplate/plugins/flot/jquery.flot.pie.js"></script>
	<script src="<?= base_url() ?>assets/admintemplate/plugins/flot/jquery.flot.resize.min.js"></script>
	<script src="<?= base_url() ?>assets/admintemplate/plugins/flot/jquery.flot.symbol.js"></script>
	<script src="<?= base_url() ?>assets/admintemplate/plugins/flot/jquery.flot.axislabels.js"></script> -->
	
	<!-- <script src="<?= base_url() ?>assets/admintemplate/plugins/jquery.sparkline/jquery.sparkline.js"></script>
	<script src="<?= base_url() ?>assets/admintemplate/plugins/jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script>
	<script src="<?= base_url() ?>assets/admintemplate/plugins/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script> -->
	
	<!-- <script src="<?= base_url() ?>assets/admintemplate/js/index.js"></script> -->
	<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
	
	<!-- SmartMenus jQuery Bootstrap Addon CSS -->
    <link href="<?= base_url() ?>assets/smartmenus-1.0/addons/bootstrap/jquery.smartmenus.bootstrap.css" rel="stylesheet">
	<script type="text/javascript" src="<?= base_url() ?>assets/smartmenus-1.0/jquery.smartmenus.js"></script>
	
	<!-- SmartMenus jQuery Bootstrap Addon -->
	<script type="text/javascript" src="<?= base_url() ?>assets/smartmenus-1.0/addons/bootstrap/jquery.smartmenus.bootstrap.js"></script>
	
	<script type="text/javascript">
			$(document).ready(function(){
				if($('.editor').length){
						$('.editor').ckeditor({
							fullPage : false,
							extraPlugins : 'docprops'
						});
				}
			});
		</script>
			
  </head>
  <body>
  	<?php
  		
	if(!IsAllowInsert(MODULTASK)){
		?>
		<style>
			#tambah-tugas-menu{
				display:none;
			}
		</style>
		
		<?php			
	}
	if(!IsAllowView(MODULTASK)){
		?>
		<style>
			#daftar-tugas-menu{
				display:none;
			}
			#daftar-tugas-favorite{
				display:none;
			}
		</style>
		
		<?php			
	}
	if(!IsAllowView(MODULTASK) && !IsAllowView(MODULTASK)){
		?>
		<style>
			#tugas-menu{
				display:none;
			}
		</style>
		
		<?php			
	}
	
  	if(!IsAllowInsert(MODULTASKCATEGORIES)){
		?>
		<style>
			#tambah-kategori-menu{
				display:none;
			}
		</style>
		
		<?php			
	}
	if(!IsAllowView(MODULTASKCATEGORIES)){
		?>
		<style>
			#daftar-kategori-menu{
				display:none;
			}
		</style>
		
		<?php			
	}
	if(!IsAllowInsert(MODULTASKCATEGORIES) && !IsAllowView(MODULTASKCATEGORIES)){
		?>
		<style>
			#kategori-menu{
				display:none;
			}
		</style>
		
		<?php			
	}
	
	
	if(!IsAllowInsert(MODULPROJECT)){
		?>
		<style>
			#tambah-project-menu{
				display:none;
			}
		</style>
		
		<?php			
	}
	if(!IsAllowView(MODULPROJECT)){
		?>
		<style>
			#daftar-project-menu{
				display:none;
			}
		</style>
		
		<?php			
	}
	if(!IsAllowInsert(MODULPROJECT) && !IsAllowView(MODULPROJECT)){
		?>
		<style>
			#project-menu{
				display:none;
			}
		</style>
		
		<?php			
	}
	
	if(!IsAllowInsert(MODULVERSIONS)){
		?>
		<style>
			#tambah-version-menu{
				display:none;
			}
		</style>
		
		<?php			
	}
	if(!IsAllowView(MODULVERSIONS)){
		?>
		<style>
			#daftar-version-menu{
				display:none;
			}
		</style>
		
		<?php			
	}
	if(!IsAllowInsert(MODULVERSIONS) && !IsAllowView(MODULVERSIONS)){
		?>
		<style>
			#version-menu{
				display:none;
			}
		</style>
		
		<?php			
	}
	
	if(!IsAllowInsert(MODULTASKTYPE)){
		?>
		<style>
			#tambah-jenistugas-menu{
				display:none;
			}
		</style>
		
		<?php			
	}
	if(!IsAllowView(MODULTASKTYPE)){
		?>
		<style>
			#daftar-jenistugas-menu{
				display:none;
			}
		</style>
		
		<?php			
	}
	if(!IsAllowInsert(MODULTASKTYPE) && !IsAllowView(MODULTASKTYPE)){
		?>
		<style>
			#jenistugas-menu{
				display:none;
			}
		</style>
		
		<?php			
	}
	
	if(!IsAllowInsert(MODULTASKSTATUS)){
		?>
		<style>
			#tambah-statustugas-menu{
				display:none;
			}
		</style>
		
		<?php			
	}
	if(!IsAllowView(MODULTASKSTATUS)){
		?>
		<style>
			#daftar-statustugas-menu{
				display:none;
			}
		</style>
		
		<?php			
	}
	if(!IsAllowInsert(MODULTASKSTATUS) && !IsAllowView(MODULTASKSTATUS)){
		?>
		<style>
			#statustugas-menu{
				display:none;
			}
		</style>
		
		<?php			
	}
	
	if(!IsAllowInsert(MODULTASKRESOLUTION)){
		?>
		<style>
			#tambah-resolusitugas-menu{
				display:none;
			}
		</style>
		
		<?php			
	}
	
	if(!IsAllowView(MODULTASKRESOLUTION)){
		?>
		<style>
			#daftar-resolusitugas-menu{
				display:none;
			}
		</style>
		
		<?php			
	}
	if(!IsAllowInsert(MODULTASKRESOLUTION) && !IsAllowView(MODULTASKRESOLUTION)){
		?>
		<style>
			#resolusitugas-menu{
				display:none;
			}
		</style>
		
		<?php			
	}
	
	if(!IsAllowInsert(MODULNEWS)){
		?>
		<style>
			#tambah-news-menu{
				display:none;
			}
		</style>
		
		<?php			
	}
	if(!IsAllowView(MODULNEWS)){
		?>
		<style>
			#daftar-news-menu{
				display:none;
			}
		</style>
		
		<?php			
	}
	if(!IsAllowInsert(MODULNEWS) && !IsAllowView(MODULNEWS)){
		?>
		<style>
			#news-menu{
				display:none;
			}
		</style>
		
		<?php			
	}
	if(!IsAllowInsert(MODULTASKRESOLUTION) && !IsAllowView(MODULTASKRESOLUTION) 
		&& !IsAllowInsert(MODULTASKSTATUS) && !IsAllowView(MODULTASKSTATUS) 
		&& !IsAllowInsert(MODULTASKTYPE) && !IsAllowView(MODULTASKTYPE) 
		&& !IsAllowInsert(MODULPROJECT) && !IsAllowView(MODULPROJECT) 
		&& !IsAllowInsert(MODULTASKCATEGORIES) && !IsAllowView(MODULTASKCATEGORIES)
		&& !IsAllowInsert(MODULNEWS) && !IsAllowView(MODULNEWS)
		&& !IsAllowInsert(MODULVERSIONS) && !IsAllowView(MODULVERSIONS)
	  ){
		?>
		<style>
			#master-menu{
				display:none;
			}
		</style>
		
		<?php			
	}
	if(!IsOtherModuleActive(OTHERMODUL_CANLOOKREPORT)){
		?>
		<style>
			#laporan-menu{
				display:none;
			}
			#telat-laporan-menu{
				display: none;
			}
            #bugs-laporan-menu{
                display: none;
            }
		</style>
		
		<?php			
	}
	
	$a = GetUserLogin('RoleID');
	#if($a != ADMINROLE){
	if(FALSE){
	?>	
		<style>
			#komentar-menu{
				display:none;
			}
			#daftar-komentar-menu{
				display: none;
			}
		</style>
	<?php
	}
	
	
	if(!IsAllowInsert(MODULUSER)){
		?>
		<style>
			#tambah-user-menu{
				display:none;
			}
		</style>
		
		<?php			
	}
	if(!IsAllowView(MODULUSER)){
		?>
		<style>
			#daftar-user-menu{
				display:none;
			}
		</style>
		
		<?php			
	}
	if(!IsAllowInsert(MODULUSER) && !IsAllowView(MODULUSER)){
		?>
		<style>
			#user-menu{
				display:none;
			}
		</style>
		
		<?php			
	}
	
  	if(!IsAllowInsert(MODULROLE)){
		?>
		<style>
			#tambah-role-menu{
				display:none;
			}
		</style>
		
		<?php			
	}
	if(!IsAllowView(MODULROLE)){
		?>
		<style>
			#daftar-role-menu{
				display:none;
			}
		</style>
		
		<?php			
	}
	if(!IsAllowInsert(MODULROLE) && !IsAllowView(MODULROLE)){
		?>
		<style>
			#role-menu{
				display:none;
			}
		</style>
		
		<?php			
	}
	if(!IsAllowInsert(MODULROLE) && !IsAllowView(MODULROLE)
		&& !IsAllowInsert(MODULUSER) && !IsAllowView(MODULUSER)
	  ){
		?>
		<style>
			#setting-menu{
				display:none;
			}
		</style>
		
		<?php			
	}
	
	if(!IsUserLogin()){
		?>
		<style>
			#change-password,#logout{
				display:none;
			}
		</style>
		
	<?php	
	}
  	
  	
  	if(IsUserLogin()){
		?>
		<style>
			#login{
				display:none;
			}
		</style>
		
	<?php	
	}
  	?>
  	
  	
     <!-- <div class="container"> -->
		    <nav class="navbar navbar-default navbar-fixed-top top-menu" role="navigation">
			  <div class="container-fluid">
			    <!-- Brand and toggle get grouped for better mobile display -->
			    <div class="navbar-header">
			      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
			        <span class="sr-only">Toggle navigation</span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			      </button>
			      <?php
			      	if(IsUserLogin()){
						echo anchor('dashboard','MPSSOFT','class="navbar-brand"');
					}else{	
			      		echo anchor(site_url(),'MPSSOFT','class="navbar-brand"');
			      	}
			      ?>
			      <!-- <a class="navbar-brand" href="">Melody</a> -->
			    </div>
			 
			    <!-- Collect the nav links, forms, and other content for toggling -->
			    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			      <ul class="nav navbar-nav">
			        <!-- <li><a href="#">Product</a></li> -->
			        <li id="master-menu" class="dropdown">
			          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Master <span class="caret"></span></a>
			          <ul class="dropdown-menu" role="menu">
			          	<li id="kategori-menu"><a href="#">Kategori <span class="caret"></span></a>
			          		<ul class="dropdown-menu">
			          			<li id="tambah-kategori-menu"><?= anchor('category/add','Tambah kategori')?></li>
			            		<li id="daftar-kategori-menu"><?= anchor('category','Daftar kategori')?></li>
			          		</ul>
			          	</li>
			            <li id="project-menu"><a href="#">Project <span class="caret"></span></a>
			          		<ul class="dropdown-menu">
			          			<li id="tambah-project-menu"><?= anchor('project/add','Tambah Project')?></li>
			            		<li id="daftar-project-menu"><?= anchor('project','Daftar Project')?></li>
			          		</ul>
			          	</li>
			          	<li id="version-menu"><a href="#">Version <span class="caret"></span></a>
			          		<ul class="dropdown-menu">
			          			<li id="tambah-version-menu"><?= anchor('version/add','Tambah Version')?></li>
			            		<li id="daftar-version-menu"><?= anchor('version','Daftar Version')?></li>
			          		</ul>
			          	</li>
			            <li id="jenistugas-menu"><a href="#">Jenis Tugas <span class="caret"></span></a>
			          		<ul class="dropdown-menu">
			          			<li id="tambah-jenistugas-menu"><?= anchor('tasktype/add','Tambah Jenis Tugas')?></li>
			            		<li id="daftar-jenistugas-menu"><?= anchor('tasktype','Daftar Jenis Tugas')?></li>
			          		</ul>
			          	</li>
			          	<li id="statustugas-menu"><a href="#">Status Tugas <span class="caret"></span></a>
			          		<ul class="dropdown-menu">
			          			<li id="tambah-statustugas-menu"><?= anchor('taskstatus/add','Tambah Status Tugas')?></li>
			            		<li id="daftar-statustugas-menu"><?= anchor('taskstatus','Daftar Status Tugas')?></li>
			          		</ul>
			          	</li>
			          	<li id="resolusitugas-menu"><a href="#">Resolusi Tugas <span class="caret"></span></a>
			          		<ul class="dropdown-menu">
			          			<li id="tambah-resolusitugas-menu"><?= anchor('taskresolution/add','Tambah Resolusi Tugas')?></li>
			            		<li id="daftar-resolusitugas-menu"><?= anchor('taskresolution','Daftar Resolusi Tugas')?></li>
			          		</ul>
			          	</li>
			          	<li id="news-menu"><a href="#">Berita <span class="caret"></span></a>
			          		<ul class="dropdown-menu">
			          			<li id="tambah-news-menu"><?= anchor('news/add','Tambah Berita')?></li>
			            		<li id="daftar-news-menu"><?= anchor('news','Daftar Berita')?></li>
			          		</ul>
			          	</li>
			          </ul>
			        </li>
			       	 
			        <li id="tugas-menu" class="dropdown">
			          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Tugas <span class="caret"></span></a>
			          <ul class="dropdown-menu" role="menu">
			            <li id="tambah-tugas-menu"><?= anchor('task/add','Tambah Tugas')?></li>
			            <li id="daftar-tugas-menu"><?= anchor('task','Daftar Tugas')?></li>
			            <li id="daftar-tugas-favorite"><?= anchor(site_url('task').'?Search=all&favorite='.GetUserLogin('UserName'),'Daftar Tugas Favorite')?></li>
			            <!-- <li><?= anchor('task/assigment','Assignment Tugas')?></li> -->
			          </ul>
			        </li>
			        
			        <li id="komentar-menu" class="dropdown">
			          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Komentar <span class="caret"></span></a>
			          <ul class="dropdown-menu" role="menu">
			            <!-- <li id="tambah-tugas-menu"><?= anchor('task/add','Tambah Tugas')?></li> -->
			            <li id="daftar-komentar-menu"><?= anchor('comment','Daftar Komentar Terakhir')?></li>
			            <!-- <li><?= anchor('task/assigment','Assignment Tugas')?></li> -->
			          </ul>
			        </li>
			        
			        <li id="laporan-menu" class="dropdown">
			          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Laporan <span class="caret"></span></a>
			          <ul class="dropdown-menu" role="menu">
			          	<li id="telat-laporan-menu"><?= anchor('task/laporan','Laporan Tugas Terlambat Selesai')?></li>
			          	<li id="nonkomentar-laporan-menu"><?= anchor('task/laporannonkomentar','Laporan Tugas Non Komentar')?></li>
                        <li id="bugs-laporan-menu"><?= anchor('task/laporanbugs','Laporan Bugs')?></li>
                          <li id="checking-laporan-menu"><?= anchor('task/laporanchecking','Laporan Checking')?></li>
			          </ul>
			        </li>  
			      </ul>
			      <!-- <form class="navbar-form navbar-left" role="search">
			        <div class="form-group">
			          <input type="text" class="form-control" placeholder="Search">
			        </div>
			        <button type="submit" class="btn btn-default">Submit</button>
			      </form> -->
			      <ul class="nav navbar-nav navbar-right">
			        <!-- <form class="navbar-form navbar-left" role="search">
				        <div class="form-group">
				          <select type="text" class="form-control" placeholder="Search">
				          	<option>All</option>
				          	<option>-</option>	
				          </select>
				        </div>
				        
				      </form> -->
			        <li id="setting-menu" class="dropdown">
			          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-cog"></span> Setting <span class="caret"></span></a>
			          <ul class="dropdown-menu" role="menu">
			          	<li id="user-menu"><a href="#">User <span class="caret"></span></a>
			          		<ul class="dropdown-menu">
			          			<li id="tambah-user-menu"><?= anchor('user/add','Tambah User')?></li>
			            		<li id="daftar-user-menu"><?= anchor('user/datauser','Daftar User')?></li>
			          		</ul>
			          	</li>
			            <li id="role-menu"><a href="#">Role <span class="caret"></span></a>
			          		<ul class="dropdown-menu">
			          			<li id="tambah-role-menu"><?= anchor('role/add','Tambah Role')?></li>
			            		<li id="daftar-role-menu"><?= anchor('role','Daftar Role')?></li>
			          		</ul>
			          	</li>
			            
			            <!-- <li><?= anchor('category','Daftar kategori')?></li> -->
			          </ul>
			        </li>
			        <!-- <li><a href="#"><span class="glyphicon glyphicon-user"></span> <?= GetUserLogin('UserName') ?></a></li> -->
			        <li class="dropdown">
			          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> <?= GetUserLogin('UserName') ?> </span> <span class="caret"></span></a>
			          <ul class="dropdown-menu" role="menu">
			            
			            <li id="change-password"><?=anchor('user/changepass','Ganti Password')?></li>
			            <li id="login" ><?=anchor(site_url(),'Login')?></li>
			            <li class="divider"></li>
			            <li id="logout"><?=anchor('user/logout','Logout')?></li>
			          </ul>
			        </li>
			      </ul>
			    </div><!-- /.navbar-collapse -->
			  </div><!-- /.container-fluid -->
			</nav>
		    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		    
		    
		    <!-- Include all compiled plugins (below), or include individual files as needed -->
		    <!-- <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script> -->
		   
	<!-- </div> -->
	<!-- <p>
 
 
	</p> -->
	<div class="container page-body">
