<?php $this->load->view('admin/header') ?>

<!-- <link rel="stylesheet" href="<?=base_url()?>assets/blueimp/css/bootstrap.min.css"> -->
<!-- Generic page styles -->
<link rel="stylesheet" href="<?=base_url()?>assets/blueimp/css/style.css">
<link rel="stylesheet" href="<?=base_url()?>assets/blueimp/css/bootstrap-image-gallery.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/blueimp/css/jquery.fileupload-ui.css">
<noscript><link rel="stylesheet" href="<?=base_url()?>assets/blueimp/css/jquery.fileupload-ui-noscript.css"></noscript>

<style type="text/css">
	html,body {
	  font-size: 12px;
	  line-height: auto;
	  margin: 0;
	  padding:0;
	}
</style>
	<div class="page-header">
		<h1>Bulk Upload</h1>
	</div>
	<?php
		if(IsAllowInsert(MODULMEDIA)){
	?>
		<form id="fileupload" action="//jquery-file-upload.appspot.com/" method="POST" enctype="multipart/form-data">
	        <!-- Redirect browsers with JavaScript disabled to the origin page -->
	        <noscript><input type="hidden" name="redirect" value="http://blueimp.github.com/jQuery-File-Upload/"></noscript>
	        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
	        <div class="fileupload-buttonbar">
	            <div class="span7">
	                <!-- The fileinput-button span is used to style the file input field as button -->
	                <span class="btn btn-success fileinput-button">
	                    <i class="icon-plus icon-white"></i>
	                    <span>Add files...</span>
	                    <input type="file" name="userfile" multiple>
	                </span>
	                <button type="submit" class="btn btn-primary start">
	                    <i class="icon-upload icon-white"></i>
	                    <span>Start upload</span>
	                </button>
	                <button type="reset" class="btn btn-warning cancel">
	                    <i class="icon-ban-circle icon-white"></i>
	                    <span>Cancel upload</span>
	                </button>
	                <button type="button" class="btn btn-danger delete">
	                    <i class="icon-trash icon-white"></i>
	                    <span>Delete</span>
	                </button>
	                <input type="checkbox" class="toggle">
	            </div>
	            <!-- The global progress information -->
	            <div class="span5 fileupload-progress fade">
	                <!-- The global progress bar -->
	                <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
	                    <div class="bar" style="width:0%;"></div>
	                </div>
	                <!-- The extended global progress information -->
	                <div class="progress-extended">&nbsp;</div>
	            </div>
	        </div>
	        <!-- The loading indicator is shown during file processing -->
	        <div class="fileupload-loading"></div>
	        <br>
	        <!-- The table listing the files available for upload/download -->
	        <table role="presentation" class="table table-striped"><tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody></table>
	    </form>
	<?php } ?>

<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td class="preview"><span class="fade"></span></td>
        <td class="name"><span>{%=file.name%}</span></td>
        <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
        {% if (file.error) { %}
            <td class="error" colspan="2"><span class="label label-important">Error</span> {%=file.error%}</td>
        {% } else if (o.files.valid && !i) { %}
            <td>
                <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar" style="width:0%;"></div></div>
            </td>
            <td class="start">{% if (!o.options.autoUpload) { %}
                <button class="btn btn-primary">
                    <i class="icon-upload icon-white"></i>
                    <span>Start</span>
                </button>
            {% } %}</td>
        {% } else { %}
            <td colspan="2"></td>
        {% } %}
        <td class="cancel">{% if (!i) { %}
            <button class="btn btn-warning">
                <i class="icon-ban-circle icon-white"></i>
                <span>Cancel</span>
            </button>
        {% } %}</td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        {% if (file.error) { %}
            <td></td>
            <td class="name"><span>{%=file.name%}</span></td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
            <td class="error" colspan="2"><span class="label label-important">Error</span> {%=file.error%}</td>
        {% } else { %}
            <td class="preview">{% if (file.thumbnail_url) { %}
                <a href="{%=file.url%}" title="{%=file.name%}" rel="gallery" download="{%=file.name%}"><img src="{%=file.thumbnail_url%}"></a>
            {% } %}</td>
            <td class="name">
                <a href="{%=file.url%}" title="{%=file.name%}" rel="{%=file.thumbnail_url&&'gallery'%}" download="{%=file.name%}">{%=file.name%}</a>
            </td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
            <td colspan="2"></td>
        {% } %}
        <td class="delete">
            <button class="btn btn-danger" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}"{% if (file.delete_with_credentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                <i class="icon-trash icon-white"></i>
                <span>Delete</span>
            </button>
            <input type="checkbox" name="delete" value="1">
        </td>
    </tr>
{% } %}
</script>
<script src="<?=base_url()?>assets/blueimp/js/vendor/jquery.ui.widget.js"></script>
<script src="<?=base_url()?>assets/blueimp/js/tmpl.min.js"></script>
<script src="<?=base_url()?>assets/blueimp/js/load-image.min.js"></script>
<script src="<?=base_url()?>assets/blueimp/js/canvas-to-blob.min.js"></script>
<script src="<?=base_url()?>assets/blueimp/js/bootstrap.min.js"></script>
<script src="<?=base_url()?>assets/blueimp/js/jquery.iframe-transport.js"></script>
<script src="<?=base_url()?>assets/blueimp/js/jquery.fileupload.js"></script>
<script src="<?=base_url()?>assets/blueimp/js/jquery.fileupload-fp.js"></script>
<script src="<?=base_url()?>assets/blueimp/js/jquery.fileupload-ui.js"></script>
<script type="text/javascript">
$(function () {
    'use strict';

    // Initialize the jQuery File Upload widget:
    $('#fileupload').fileupload({
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: '<?=site_url('media/upload_img')?>',
        completed : function(){
        	//alert('Upload selesai');
        	//location.href = '<?=site_url('media')?>';
        }
    });
    /*
	if (window.location.hostname === 'blueimp.github.com') {
        // Demo settings:
        $('#fileupload').fileupload('option', {
            url: '//jquery-file-upload.appspot.com/',
            maxFileSize: 5000000,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
            process: [
                {
                    action: 'load',
                    fileTypes: /^image\/(gif|jpeg|png)$/,
                    maxFileSize: 20000000 // 20MB
                },
                {
                    action: 'resize',
                    maxWidth: 1440,
                    maxHeight: 900
                },
                {
                    action: 'save'
                }
            ]
        });
        // Upload server status check for browsers with CORS support:
        if ($.support.cors) {
            $.ajax({
                url: '//jquery-file-upload.appspot.com/',
                type: 'HEAD'
            }).fail(function () {
                $('<span class="alert alert-error"/>')
                    .text('Upload server currently unavailable - ' +
                            new Date())
                    .appendTo('#fileupload');
            });
        }
    } else {
        // Load existing files:
        $.ajax({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            url: $('#fileupload').fileupload('option', 'url'),
            dataType: 'json',
            context: $('#fileupload')[0],
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        }).done(function (result) {
            if (result && result.length) {
                $(this).fileupload('option', 'done')
                    .call(this, null, {result: result});
            }
        });
    }
    */

});
</script>
<?php $this->load->view('admin/footer') ?>