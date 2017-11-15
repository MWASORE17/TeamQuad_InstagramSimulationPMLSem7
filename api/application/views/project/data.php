<?= $this->load->view('header')?>
<?php

 if(!IsUserLogin()){ ?>
 	
	<div class='alert alert-warning'>
 		Silahkan <?= anchor('user', 'Login')?> Dulu
	</div>
				
<?php
 }else if(!IsAllowView(MODULPROJECT)){
 ?>		
 	<div class='alert alert-warning'>
 		Tidak diizinkan melihat data
	</div>
<?	
 }else{
 	
	if(!IsAllowDelete(MODULPROJECT)){
?>			
		<style>
			.cekboxaction{
				display:none;
			}
		</style>
		
<?php		
	}
	
	$data = array();
	$i = 0;
	foreach ($c->result_array() as $d){
		if ($d[COL_ISACTIVE] == 1){
			$aktif = 'Aktif';
		}else{
			$aktif = 'Tidak Aktif';
		}
		$data[$i] = array(
						'<input type="checkbox" class="cekbox" name="cekbox[]" value="'.$d[COL_PROJECTID].'" />',
						$d[COL_PROJECTID],
						anchor('project/edit/'.$d[COL_PROJECTID],$d[COL_PROJECTNAME]),
						anchor(site_url('task').'?projectid='.$d[COL_PROJECTID],'Lihat Tugas'),
						$d[COL_CREATEDON],
						$d[COL_CREATEDBY],
						$aktif,
						
					);
		$i++;
	}
	$data = json_encode($data);
	?>
	
	<div class="page-wrapper">	
		<div class="row">
			<div class="col-md-12">
				<h1><?= $title ?></h1>
										
					
					<p>
						<?=anchor('project/delete','<i class="clip-remove"></i> Hapus',array('class'=>'cekboxaction ui btn btn-danger','confirm'=>'Apa anda yakin?'))?>
						
					</p>
					<!-- <div class="table-responsive"> -->
						<form id="dataform" method="post" action="#">
							<table id="databerita" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered" width="100%">
							</table>
						</form>
					<!-- </div> -->
					<div class="clear"></div>

				</div>
			</div>
		</div>
<!-- <ul id="contextMenu" class="dropdown-menu" role="menu" style="display:none" >
    <li><a tabindex="-1" href="#">Action</a></li>
    <li><a tabindex="-1" href="#">Another action</a></li>
    <li><a tabindex="-1" href="#">Something else here</a></li>
    <li class="divider"></li>
    <li><a tabindex="-1" href="#">Separated link</a></li>
</ul> -->

<script type="text/javascript">
$(document).ready(function(){
	

		var pelangganTable = $('#databerita').dataTable({
	        "aaData": <?=$data?>,
	        // "bJQueryUI": true,
	        "aaSorting" : [[1,'desc']],
        	// "sPaginationType": "full_numbers",
        	"scrollY" : 400,
        	"scrollX" : "150%",
        	"iDisplayLength": 100,
    		"aLengthMenu": [[100, 1000, 5000, -1], [100, 1000, 5000, "Semua"]],
	        "aoColumns": [
	        	{"sTitle": "<input type=\"checkbox\" id=\"cekbox\" class=\"cekbox\" />","sWidth":15,bSortable:false},
	        	{"sTitle": "ID Project"},
	            {"sTitle": "Nama Project"},
	            {"sTitle": "Lihat Tugas"},
	            {"sTitle": "Dibuat Tanggal"},
	            {"sTitle": "Dibuat Oleh"},
	            {"sTitle": "Status"}
	        ],
	        "dom":"R<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>",
		    "buttons": ['copyHtml5','excelHtml5','csvHtml5','pdfHtml5','print']
	    });
	    $("input[aria-controls=databerita]").unbind().bind('keyup',function(e){
		    if (e.keyCode == 13) {
		        pelangganTable.fnFilter(this.value);
		    }
		});
		$('#dataform').find('input').keydown(function(e){
			if(e.which == 13){
				return false;
			}
		});
		
		
		// (function ($, window) {
// 		
		    // $.fn.contextMenu = function (settings) {
// 		
		        // return this.each(function () {
// 		
		            // // Open context menu
		            // $(this).on("contextmenu", function (e) {
		                // // return native menu if pressing control
		                // if (e.ctrlKey) return;
// 		                
		                // //open menu
		                // var $menu = $(settings.menuSelector)
		                    // .data("invokedOn", $(e.target))
		                    // .show()
		                    // .css({
		                        // position: "absolute",
		                        // left: getMenuPosition(e.clientX, 'width', 'scrollLeft'),
		                        // top: getMenuPosition(e.clientY, 'height', 'scrollTop')
		                    // })
		                    // .off('click')
		                    // .on('click', 'a', function (e) {
		                        // $menu.hide();
// 		                
		                        // var $invokedOn = $menu.data("invokedOn");
		                        // var $selectedMenu = $(e.target);
// 		                        
		                        // settings.menuSelected.call(this, $invokedOn, $selectedMenu);
		                    // });
// 		                
		                // return false;
		            // });
// 		
		            // //make sure menu closes on any click
		            // $(document).click(function () {
		                // $(settings.menuSelector).hide();
		            // });
		        // });
// 		        
		        // function getMenuPosition(mouse, direction, scrollDir) {
		            // var win = $(window)[direction](),
		                // scroll = $(window)[scrollDir](),
		                // menu = $(settings.menuSelector)[direction](),
		                // position = mouse + scroll;
// 		                        
		            // // opening menu would pass the side of the page
		            // if (mouse + menu > win && menu < mouse) 
		                // position -= menu;
// 		            
		            // return position;
		        // }    
// 		
		    // };
		// })(jQuery, window);
// 		
		// $(".pro").contextMenu({
		    // menuSelector: "#contextMenu",
		    // menuSelected: function (invokedOn, selectedMenu) {
		        // var msg = "You selected the menu item '" + selectedMenu.text() +
		            // "' on the value '" + invokedOn.text() + "'";
		        // alert(msg);
		    // }
		// });

});

</script>

<?php } ?>
<?= $this->load->view('footer')?>