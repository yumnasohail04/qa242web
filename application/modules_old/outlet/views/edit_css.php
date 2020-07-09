    <div class="content-wrapper">
    	<h3>
    		Edit Stylesheet
    		<a href="<?php echo ADMIN_BASE_URL . 'outlet'; ?>"><button type="button" class="btn btn-primary pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;Back</button></a>
    	</h3>
    	<div class="panel panel-default">
    		<div class="panel-body">
    			<form action="<?= ADMIN_BASE_URL . 'outlet/save_css/' . $id ?>" method="post">
    				<div class="col-md-12">
    					<textarea name="text" id='editor' style="max-width: 100%; max-height: 100%; min-width: 100%; min-height: 300px;"><?= $css_data ?></textarea>
    				</div>
    				<div style="margin-top: 10px;" class="col-md-12"></div>
    				<div style="padding-left: 20px">
    					<button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp;Save</button>
    					<a href="<?php echo ADMIN_BASE_URL . 'outlet'; ?>" class="btn btn-default" style="margin-left:20px;">
    						<i class="fa fa-undo"></i>&nbsp;Cancel
    					</a>
    				</div>
    			</form>
    		</div>
    	</div>
    </div>