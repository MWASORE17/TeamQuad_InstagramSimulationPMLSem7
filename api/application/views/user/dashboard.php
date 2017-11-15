<?= $this->load->view('header')?>
<?php

 if(!IsUserLogin()){ ?>
 	<div class='alert alert-warning'>
 		Silahkan <?= anchor('user', 'Login')?> Dulu
 		<style>
 			.content{
 				display: none;
 			}
 		</style>
	</div>
<?php
 }
 ?>

    <div class="page-wrapper content">
        <div class="col-md-6">
            <div class="col-md-12">
                <h1>Task Comments</h1>
                <?php
                if($task->result_array()) {
                    foreach ($task->result_array() as $n) {
                        // Get last comment
                        $this->db->where(COL_TASKID, $n[COL_TASKID]);
                        $this->db->order_by(COL_COMMENTID, 'desc');
                        $lastcomment = $this->db->get(TBL_COMMENTS)->row_array();
                        ?>
                        <div class="col-md-12">
                            <div class="news-lists" style="height:auto; padding: 10px 10px;">
                                <h4><?= anchor('task/view/' . $n[COL_TASKID], $n[COL_SUMMARY]) ?></h4>

                                <p>
                                    <small>Last comment :</small>
                                </p>
                                <?php if ($lastcomment) { ?>
                                    <p>
                                        <a style="<?= $lastcomment[COL_COMMENTYPEID] != COMMENTTYPE_BUG ? '' : 'color:red;' ?>"
                                           href="<?= site_url('task/view/' . $n[COL_TASKID]) . '#comment-' . $lastcomment[COL_COMMENTID] ?>">
                                            <?= strlen($lastcomment[COL_DESCRIPTION]) > 50 ? substr(strip_tags($lastcomment[COL_DESCRIPTION]), 0, 50) . "..." : $lastcomment[COL_DESCRIPTION] ?>
                                        </a>
                                    </p>
                                    <p>
                                        <small>Posted by: <b><?= $lastcomment[COL_CREATEDBY] ?></b> On
                                            :<b><?= $lastcomment[COL_CREATEDON] ?></b></small>
                                    </p>
                                <?php } else { ?><p>-</p><?php } ?>
                            </div>
                        </div>
                        <?php
                    }
                }
                else echo '<i>No data available</i>';
                ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="col-md-12">
                <h1>Daftar Berita</h1>
                <?php
                if($news->result_array()) {
                    foreach ($news->result_array() as $n) {
                        ?>
                        <div class="col-md-12">
                            <div class="news-lists">
                                <h4><?= anchor('news/view/' . $n[COL_NEWSID], $n[COL_NEWSTITLE]) ?></h4>

                                <p><?= substr(strip_tags($n[COL_DESCRIPTION]), 0, 50) . "..." ?></p>
                                <br/>

                                <p>
                                    <small>Posted by: <?= $n[COL_CREATEDBY] ?> On : <?= $n[COL_CREATEDON] ?></small>
                                </p>
                            </div>
                        </div>
                        <?php
                    }
                }
                else echo '<i>No data available</i>';
                ?>
            </div>
        </div>
    </div>

    <div class="page-wrapper content">
		<div class="row">

        </div>
    </div>

<script type="text/javascript">
$(document).ready(function(){

		$('[data-toggle="tooltip"]').tooltip();

});

</script>

<?= $this->load->view('footer')?>