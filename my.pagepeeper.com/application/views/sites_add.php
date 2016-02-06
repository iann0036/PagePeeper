<div class="page-content">
    <div class="header">
        <h2>Add <strong>Site</strong></h2>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel">
                <!--<div class="panel-header">
                    <h3><i class="icon-cog"></i> <strong>Site Settings</strong> <small>options for your new monitored site</small></h3>
                </div>-->
                <div class="panel-content">
                    <form method="post" role="form">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div style="margin-left: 4px;">
                                        <h3><strong>Site</strong> URL</h3>
                                    </div>
                                    <span style="margin-bottom: 0;" class="input input--hoshi">
                                    <input style="padding-top: 0; margin-top: 4px;" class="input__field input__field--hoshi" type="text" name="url" id="url"<?php if ($addurl) { echo ' value="'.$addurl.'"'; } ?> />
                                    <label class="input__label input__label--hoshi input__label--hoshi-color-2" for="url">
                                        <span style="padding: 0;" class="input__label-content input__label-content--hoshi"></span>
                                    </label>
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <div style="margin-left: 4px;">
                                            <h3><strong>Notification</strong> Options</h3>
                                            <div class="input-group">
                                                <div class="icheck-list">
                                                    <label><input checked name="email_notify" type="checkbox" data-checkbox="icheckbox_square-green"> Notify via E-mail</label>
                                                    <label><input name="sms_notify" type="checkbox" data-checkbox="icheckbox_square-green"> Notify via SMS</label>
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
                                        <button type="submit" class="btn btn-lg btn-success">Add Site</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.onload = function() {
            $('#url').focus();
        };
    </script>
</div>