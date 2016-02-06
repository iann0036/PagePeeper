<div class="page-content">
    <div class="header">
        <h2>Edit <strong>Site</strong></h2>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel">
                <div class="panel-content">
                    <form method="post" role="form">
                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                        <div class="form-body">
                            <div class="row">
                                <div class="col-lg-12" style="padding-bottom: 15px;">
                                    <div style="margin-left: 4px; padding-bottom: 12px;">
                                        <h3><strong>Site</strong> URL</h3>
                                    </div>
                                    <b style="font-size: 18px; font-family: 'Lato', 'Open Sans', Helvetica, sans-serif !important; font-weight: 700; color: #595F6E; margin-top: 4px; margin-left: 4px;"><?php echo $url; ?></b>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <div style="margin-left: 4px;">
                                            <h3><strong>Notification</strong> Options</h3>
                                            <div class="input-group">
                                                <div class="icheck-list">
                                                    <label><input<?php if ($email_check) { echo " checked"; } ?> name="email_notify" type="checkbox" data-checkbox="icheckbox_square-green"> Notify via E-mail</label>
                                                    <label><input<?php if ($sms_check) { echo " checked"; } ?> name="sms_notify" type="checkbox" data-checkbox="icheckbox_square-green"> Notify via SMS</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br /><br />
                            <div class="row">
                                <div class="col-lg-12">
                                    <div style="margin-left: 4px;">
                                        <button type="submit" class="btn btn-lg btn-success">Edit Site</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>