<?php $this->load->view('header') ?>

<div class="page-header">
    <h1>Laporan Bugs</h1>
</div>
<?php
if(!IsOtherModuleActive(OTHERMODUL_CANLOOKREPORT)){
    ?>
    <div class="alert alert-warning">
        Tidak diizinkan melihat data
    </div>
    <script>
        $(document).ready(function(){
            $('.page-wrapper').hide();
        });
    </script>
    <?php
}


?>
<div class="page-wrapper">
    <div class="row">
        <div class="col-md-12">
            <?=form_open('task/laporanbugs',array('method'=>'post','id' => 'validate'))?>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <label>Tanggal </label>
                        <!-- <input id="FromDate" type="text" size="30" style="width: 30%" class="required datepicker" name="FromDate" value=""  />  -->
                        <div class="input-group">
					        <span class="add-on input-group-btn">
				                <button disabled type="button" class="btn btn-default tanggal">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </button>
				            </span>
                            <input style="" data-date="" data-date-format="yyyy-mm-dd" id="dp-fromdate" class="FromDate form-control date-picker date1" type="text" value="<?= $fromdate ? $fromdate : date('Y-m-d') ?>" name="FromDate" >
                            <span class="input-group-addon">-</span>
                            <input style="" data-date="" data-date-format="yyyy-mm-dd" id="dp-todate" class="ToDate form-control date-picker date1" type="text" value="<?= $todate ? $todate : date('Y-m-d') ?>" name="ToDate" >
					    	<span class="add-on input-group-btn">
				                <button type="button" class="btn btn-default clear-tanggal1">
                                    <span>Clear</span>
                                </button>
				            </span>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label>Project </label><br>
                        <select class="cats" id="kategori" name="ProjectID[]" multiple="">
                            <?php
                            #$cats = GetProductCats();
                            $project = $this->db->select()->get(TBL_PROJECTS);
                            ?>
                            <?php GetComboboxCI($project, COL_PROJECTID, COL_PROJECTNAME,$projects) ?>
                        </select>
                    </div>
                </div>
            </div>
            <button type="submit" class="ui btn btn-primary">Tampilkan Laporan</button>

            <?= form_close() ?>
        </div>
    </div>
    <div class="row" style="margin-top: 40px;">
        <div class="col-md-12">
            <table border="1" class="datatable table table-striped table-bordered" id="databugs">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Project</th>
                    <th>Task</th>
                    <th>Komentar</th>
                    <th>Oleh</th>
                    <th width="15%">Tanggal</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach($comments as $com) {
                    ?>
                    <tr>
                        <td><?=$com[COL_COMMENTID]?></td>
                        <td><?=$com[COL_PROJECTNAME]?></td>
                        <td><?=anchor(site_url('task/view/'.$com[COL_TASKID]), $com[COL_SUMMARY])?></td>
                        <td><a href="<?=site_url('task/view/'.$com[COL_TASKID]).'#comment-'.$com[COL_COMMENTID]?>"><?=$com[COL_DESCRIPTION]?></a></td>
                        <td><?=$com[COL_CREATEDBY]?></td>
                        <td><?=$com[COL_CREATEDON]?></td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        // $(".cats").dropdownchecklist( { icon: { placement: 'right', toOpen: 'ui-icon-arrowthick-1-s'
        // , toClose: 'ui-icon-arrowthick-1-n'}
        // , maxDropHeight: 300, width: 300 } );
        $('.cats').multiselect({
            includeSelectAllOption: true,
            maxHeight: 150,
            numberDisplayed: 1
        });

        var bugsTable = $('#databugs').dataTable( {
            "iDisplayLength": 10,
            "aLengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
            "aaSorting" : [[5,'desc']],
            "dom":"R<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>",
            "buttons": ['copyHtml5','excelHtml5','csvHtml5','pdfHtml5','print']
        });

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
        $('.clear-tanggal2').click(function(){
            $('.date2').val('');

        });
        // $('#dpFrom,#dpUntil').datepicker();

    });
</script>
<?php $this->load->view('footer') ?>
