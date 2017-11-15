<?php $this->load->view('header') ?>
<div class="page-header">
    <h1>Laporan Checking</h1>
</div>

<?php
if(!IsOtherModuleActive(OTHERMODUL_SHOW_CHECKINGREPORT)){
    ?>
    <div class="alert alert-warning">
        Tidak diizinkan melihat data
    </div>
    <?php
}
?>
<div class="page-wrapper">
    <div class="row">
        <div class="col-md-12">
            <?=form_open('task/laporanchecking',array('id' => 'validate', 'method'=>'get'))?>
            <div class="form-group">
                <div class="col-md-4 col-sm-4">
                    <label>Per Tanggal </label>
                    <div class="input-group">
					        <span class="add-on input-group-btn">
				                <button disabled type="button" class="btn btn-default tanggal">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </button>
				            </span>
                        <input style="" readonly="" required data-date="" data-date-format="yyyy-mm-dd" id="dp1356593248900" class="StartDate form-control date-picker date1" type="text" value="<?=$this->input->get('Date') ? $this->input->get('Date') : date('Y-m-d') ?>" name="Date" >
					    	<span class="add-on input-group-btn">
				                <button type="button" class="btn btn-default clear-tanggal1">
                                    <span>Clear</span>
                                </button>
				            </span>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    <label>&nbsp;</label>
                    <div class="input-group">
                        <button type="submit" class="ui btn btn-primary">Tampilkan Laporan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row" style="margin-top: 20px; padding-top: 10px; border-top: 1px solid #dedede;">
        <div class="col-md-12">
            <?php
            $data = array();
            $i = 0;
            foreach($result as $item) {
                // Get assignments
                $assign = $this->mtask->GetAssignString($item[COL_TASKID]);

                $nowdate = $this->input->get('Date') ? date('Y-m-d', strtotime($this->input->get('Date'))) : date('Y-m-d');
                $closedate = date('Y-m-d', strtotime($item[COL_CLOSEDON]));
                $checkdate = date('Y-m-d', strtotime($item[COL_STARTCHECKON]));
                // Keterlambatan
                if($item[COL_STARTCHECKON]) {
                    $telat = (strtotime($checkdate) - strtotime($closedate)) / 86400;
                }
                else {
                    $telat = (strtotime($nowdate) - strtotime($closedate)) / 86400;
                }

                $data[$i] = array(
                    $item[COL_TASKID],
                    $item[COL_PROJECTNAME],
                    anchor(site_url('task/view/'.$item[COL_TASKID]), $item[COL_SUMMARY]),
                    $assign,
                    date('d-m-Y H:i:s', strtotime($item[COL_CLOSEDON])),
                    $item[COL_STARTCHECKON] ? date('d-m-Y H:i:s', strtotime($item[COL_STARTCHECKON])) : '-',
                    $item[COL_STARTCHECKBY] ? $item[COL_STARTCHECKBY] : '-',
                    intval($telat).' hari'
                );
                $i++;
            }
            $data = json_encode($data);
            ?>
            <table id="datachecking" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered" width="100%">
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('.date-picker').datepicker({
        dateFormat: "yyyy-mm-dd",
        changeYear : true,
        changeMonth: true,
        showOn: "button",
        buttonImage: "<?= base_url() ?>assets/images/calendar.gif",
        buttonImageOnly: true,
        minDate: "-12M",
        maxDate: 0
    });

    $('.clear-tanggal1').click(function(){
        $('.date1').val('');

    });

    var checkingTable = $('#datachecking').dataTable({
        "aaData": <?=$data?>,
        "aaSorting" : [[0,'desc']],
        //"scrollY" : 400,
        "scrollX" : "150%",
        "iDisplayLength": 50,
        "aLengthMenu": [[50, 100, 1000, -1], [50, 100, 1000, "Semua"]],
        "aoColumns": [
            {"sTitle": "ID"},
            {"sTitle": "Project"},
            {"sTitle": "Summary"},
            {"sTitle": "Assign To"},
            {"sTitle": "Tanggal Selesai"},
            {"sTitle": "Tanggal Check"},
            {"sTitle": "Checker"},
            {"sTitle": "Keterlambatan"}
        ],
        "dom":"R<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>",
        "buttons": ['copyHtml5','excelHtml5','csvHtml5','pdfHtml5','print']
    });
</script>
<?php $this->load->view('footer') ?>
