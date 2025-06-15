<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h2><?php echo (!empty($title)?html_escape($title):null) ?></h2>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	                <div class="border_preview">
	                <?php echo form_open_multipart("backend/documents/$level/form") ?>

	                    <div class='form-group row'>
	                        <label for='document_title' class='col-sm-3 col-form-label'><?php echo display('document_title'); ?> <i class="text-danger">*</i></label>
	                        <div class='col-sm-8'>
	                            <input name='document_title' class='form-control' type='text' id='document_title'>
	                        </div>
	                    </div>
	                    <div class='form-group row'>
	                        <label for='year' class='col-sm-3 col-form-label'>Year <i class="text-danger">*</i></label>
	                        <div class='col-sm-8'>
	                            <select class='form-control' name="year" id="year">
	                            	<option><?php echo display('select_year'); ?></option>
	                            	<?php
	                            		for($i=$current_year;$i>=2000;$i--){
	                            			echo "<option value='".html_escape($i)."'>".html_escape($i)."</option>";
	                            		}
	                            	?>
	                            </select>
	                        </div>
	                    </div>
	                    <div class='form-group row'>
	                        <label for='document_cover' class='col-sm-3 col-form-label'>Document Cover Photo(Max 2MB) 400×270 <i class="text-danger">*</i></label>
	                        <div class='col-sm-8'>
	                            <input class="form-control" type="file" name="document_cover" id="document_cover">
	                        </div>
	                    </div>
	                    <div class='form-group row'>
	                        <label for='upload_document' class='col-sm-3 col-form-label'><?php echo display('document'); ?>(Max 2MB) <i class="text-danger">*</i></label>
	                        <div class='col-sm-8'>
	                            <input class="form-control" type="file" name="upload_document" id="upload_document">
	                        </div>
	                    </div>

	                    <div class="row">
	                        <div class="col-sm-9 col-sm-offset-3">
	                            <button type="submit" class="btn btn-success  w-md m-b-5"><?php echo display('save'); ?></button>
	                        </div>
	                    </div>
	                    <input type="hidden" name="level" value="<?php echo html_escape($level); ?>">

	                <?php echo form_close() ?>
	                </div>
                </div>
            </div>
        </div>
    </div>
</div>
 