<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <a data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Сделать рассылку" onclick='mailing();'><i class="fa fa-envelope"></i></a>

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

          <ul class="nav nav-tabs">
            <li class="active"><a href="#subscribes-tab" data-toggle="tab">Подписчики</a></li>
            <li><a href="#setting-tab" data-toggle="tab">Настройка</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="subscribes-tab">

                <div class="table-responsive">
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <td style="width: 1px;" class="text-center">
                          <input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" />
                        </td>
                        <td class="text-left">
                          <?php echo $column_email; ?>
                        </td>
                        <td class="text-left">
                          <?php echo $column_ip; ?>
                        </td>
                        <td class="text-left">
                          <?php echo $column_date_added; ?>
                        </td>
                        <td class="text-left">
                          <?php echo $column_date_last_send; ?>
                        </td>
                        <td class="text-left"><?php echo $column_action; ?></td>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if ($subscribes) { ?>
                      <?php foreach ($subscribes as $subscribe) { ?>
                      <tr>
                        <td class="text-center"><?php // if (in_array($subscribe['subscribe_id'], $selected)) { ?>
                          <!-- <input type="checkbox" name="selected[]" value="<?php echo $subscribe['subscribe_id']; ?>" checked="checked" /> -->
                          <?php // } else { ?>
                          <input type="checkbox" name="selected[]" value="<?php echo $subscribe['subscribe_id']; ?>" />
                          <?php // } ?>
                        </td>
                        <td class="text-left"><?php echo $subscribe['email']; ?></td>
  <!--                       <td class="text-left">
                          <?php if ($subscribe['approve'] == 1) { ?>
                            <?php echo $text_yes; ?>
                          <?php } else { ?>
                            <?php echo $text_no; ?>
                          <?php } ?>
                        </td> -->
                        <td class="text-left"><?php echo $subscribe['ip']; ?></td>
                        <td class="text-left"><?php echo $subscribe['date_added']; ?></td>
                        <td class="text-left"><?php echo $subscribe['date_last_send']; ?></td>
                        <td class="text-left">
                          <a href='<?php print $delete.$subscribe["subscribe_id"]; ?>' data-toggle="tooltip" title="" class="btn btn-primary remove" data-original-title="Удалить подписчика"><i class="fa fa-remove"></i></a>
                          <a href='<?php print $send.$subscribe["subscribe_id"]; ?>' data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Отправить подписчику письмо"><i class="fa fa-envelope"></i></a>

                          <?php // if ($subscribe['approve'] !== 1) { ?>
                      <!--     <a href="<?php echo $subscribe['approve']; ?>" data-toggle="tooltip" title="<?php echo $button_approve; ?>" class="btn btn-success"><i class="fa fa-thumbs-o-up"></i></a> -->
                          <?php // } else { ?>
                          <!-- <button type="button" class="btn btn-success" disabled><i class="fa fa-thumbs-o-up"></i></button> -->
                          <?php // } ?>
                        </td>
                      </tr>
                      <?php } ?>
                      <?php } else { ?>
                      <tr>
                        <td class="text-center" colspan="6"><?php echo $text_no_results; ?></td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>


            </div>
<style type="text/css">
.btn-primary.remove {
    color: #fff;
    background-color: #e21e1e;
    border-color: #ab0a0a;
}
.btn-primary.remove:hover {
    color: #fff;
    background-color: #c80303;
    border-color: #6c0000;
}
</style>
            <div class="tab-pane" id="setting-tab">

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
                          <label class="col-sm-2 control-label" for="input-subscribe_message"><?php echo $entry_subscribe_message; ?></label>
                          <div class="col-sm-10">
                              <textarea class="form-control" type="text" name="ghost_popup_subscribe_message" id="input-ghost_subscribe_message"><?php echo $ghost_popup_subscribe_message; ?></textarea>
                          </div>
                      </div>

            </div>
          </div>

                </form>
            </div>
        </div>
    </div>
<script type="text/javascript">

$('#input-ghost_subscribe_message').summernote({height: 300});

function mailing() {
    var token = '<?php print $token; ?>';
    $.ajax({
      type: 'post',
      url:  'index.php?route=module/ghost_popup/send_message&token=<?php print $token; ?>',
      dataType: 'json',
      data: $('#ghost_popup input, #ghost_popup textarea'),
      success: function(json) {
          location.reload();
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
      }
    });
}

</script>
<?php echo $footer; ?>
