
		</div>
		<div id="footer">
			<nav class="navbar navbar-default bottom1" role="navigation">
				<div class="container">
					<p class="copy"><a href="#">Project Management </a> &copy; <?= date('Y') ?></p>
				</div>
			</nav>
		</div>
		<!-- popup -->
		<div class="modal fade" id="alertDialog" tabindex="-1" role="dialog" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">-</h4>
		      </div>
		      <div class="modal-body">
		        -
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" id="cbOKBtn" data-dismiss="modal">OK</button>
		      </div>
		    </div>
		  </div>
		</div>
		<div class="modal fade" id="confirmDialog" tabindex="-1" role="dialog" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">-</h4>
		      </div>
		      <div class="modal-body">
		        -
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" id="cbBatalBtn" data-dismiss="modal">Batal</button>
		        <button type="button" class="btn btn-primary" id="cbLanjutkanBtn">Lanjutkan</button>
		      </div>
		    </div>
		  </div>
		</div>
		<!-- popup -->
		<script type="text/javascript">
			$(document).ready(function(){
				
				// Main.init();
				// Index.init();
				// $('.subdatepicker').datepicker({
		            // autoclose: true;
		        // });
				$(document).on('keypress','.angka',function(e){
					if((e.which <= 57 && e.which >= 48) || (e.keyCode >= 37 && e.keyCode <= 40) || e.keyCode==9 || e.which==43 || e.which==44 || e.which==45 || e.which==46 || e.keyCode==8){
						return true;
					}else{
						return false;
					}
				});
				
				$('a[href="<?= current_url() ?>"]').addClass('active');
				
				$(document).on('blur','.uang',function(){
					$(this).val(desimal($(this).val(),2));
				}).on('focus','.uang',function(){
					$(this).val(toNum($(this).val()));
				});
				
				if($('.cekboxaction').length){
					$('.cekboxaction').click(function(){
						var altdlg = $('#alertDialog');
							var altdlgbody = altdlg.find('.modal-body');
						if($('.cekbox:checked').length < 1){
							altdlgbody.empty().html("Tidak ada satupun data yang dipilih");
							altdlg.find('.modal-title').html('Peringatan');
							altdlg.modal('show');
							return false;
						}
						
						var a = $(this);
						var cfdlg = $('#confirmDialog');
						var cfdlgbody = cfdlg.find('.modal-body');
						cfdlgbody.empty().html(a.attr('confirm'));
						cfdlg.modal('show');
						cfdlg.find('.modal-title').html('Konfirmasi');
						cfdlg.find('#cbLanjutkanBtn').unbind().click(function(){
							cfdlg.modal('hide');
							$('#dataform').ajaxSubmit({
								dataType: 'json',
								url : a.attr('href'),
								success : function(data){
									if(data.error == 0){
										altdlgbody.empty().html(data.success);
										altdlg.find('.modal-title').html("Berhasil");
										altdlg.modal('show');
										altdlg.find('#cbOKBtn').unbind().click(function(){
											altdlg.modal('hide');
											window.location.reload();
										});
									}else{
										altdlgbody.empty().html(data.error);
										altdlg.find('.modal-title').html("Peringatan");
										altdlg.modal('show');
									}
								},
								error : function(a,b,c){
									alert(b);
								}
							});
						});
						return false;
					});
				}
			
				$("#cekbox").click(function(){ 
				    if ( (this).checked == true ){		 
				       $('.cekbox').prop('checked', true);
					} else {
				       $('.cekbox').prop('checked', false);
					}		 
				 });
			});
		</script>
	</body>	
</html>
