<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="ghost_popup" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
            </div>
            <h1><?php echo $heading_title; ?></h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>

    <div class="container-fluid content">
        <?php if ($error_warning) { ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <?php if ($success) { ?>
        <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
          <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
            </div>
            <div class="panel-body">
              <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal" id='ghost_popup'>
                <div class="tab-pane">
                      <div class="form-group">
                          <label class="col-sm-2 control-label" for="input-name"><?php echo $on_off_text; ?></label>
                          <div class="col-sm-10">
                            <select name="ghost_popup_status" id="input-status" class="form-control">
                              <?php if ($ghost_popup_status) { ?>
                              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                              <option value="0"><?php echo $text_disabled; ?></option>
                              <?php } else { ?>
                              <option value="1"><?php echo $text_enabled; ?></option>
                              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-2 control-label" for="input-ghost_popup_cookie"><?php echo $entry_ghost_popup_cookie; ?></label>
                          <div class="col-sm-10">
                              <input class="form-control" type="text" name="ghost_popup_cookie" value="<?php echo $ghost_popup_cookie; ?>" id="input-ghost_popup_cookie">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-2 control-label" for="input-ghost_popup_timeout"><?php echo $entry_ghost_popup_timeout; ?></label>
                          <div class="col-sm-10">
                              <input class="form-control" type="text" name="ghost_popup_timeout" value="<?php echo $ghost_popup_timeout; ?>" id="input-ghost_popup_timeout">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-2 control-label" for="input-popup_content"><?php echo $entry_ghost_popup_content; ?></label>
                          <div class="col-sm-10">
                              <textarea class="form-control" type="text" name="ghost_popup_content" id="input-ghost_popup_content"><?php echo $ghost_popup_content; ?></textarea>
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="col-sm-2 control-label" for="input-popup_template_content"><?php echo $entry_template_content; ?></label>
                          <div class="col-sm-10">
                              <textarea class="form-control" type="text" name="ghost_popup_template_content" id="input-ghost_popup_template_content" readonly style="cursor: auto;" ><?php echo $value_template_content; ?></textarea>
                          </div>
                      </div>
                </div>
              </form>
            </div>
        </div>
    </div>
<script type="text/javascript">
$('#input-ghost_popup_content').summernote({height: 300});
</script>
<?php echo $footer; ?>
