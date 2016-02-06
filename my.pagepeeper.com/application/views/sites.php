<div class="page-content">
    <div class="header">
        <h2>Manage <strong>Sites</strong></h2>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel">
                <!--<div class="panel-header panel-controls">
                    <h3><i class="fa fa-table"></i> <strong>Sorting </strong> table</h3>
                    <div class="control-btn"><a href="#" class="panel-reload hidden"><i class="icon-reload"></i></a><a class="hidden" id="dropdownMenu1" data-toggle="dropdown"><i class="icon-settings"></i></a><ul class="dropdown-menu pull-right" role="menu" aria-labelledby="dropdownMenu1"><li><a href="#">Action</a></li><li><a href="#">Another action</a></li><li><a href="#">Something else here</a></li></ul><a href="#" class="panel-popout hidden tt" title="Pop Out/In"><i class="icons-office-58"></i></a><a href="#" class="panel-maximize hidden"><i class="icon-size-fullscreen"></i></a><a href="#" class="panel-toggle"><i class="fa fa-angle-down"></i></a><a href="#" class="panel-close"><i class="icon-trash"></i></a></div></div>-->
                <div class="panel-content pagination2 table-responsive">
                    <table class="table table-hover table-dynamic dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                            <thead>
                            <tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Title: activate to sort column ascending" aria-sort="ascending" style="width: 291px;">Title</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="URL: activate to sort column ascending" style="width: 369px;">URL</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Last Change: activate to sort column ascending" style="width: 338px;">Last Change</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Check Frequency: activate to sort column ascending">Check Frequency</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Actions: activate to sort column ascending">Actions</th></tr>
                            </thead>
                            <tbody>
                            <?php
                            $odd = true;
                            foreach ($watches as $watch) {
                                ?>
                                <tr role="row" class="<?php if ($odd) {echo "odd"; $odd = false;} else {echo "even"; $odd = true;} ?>">
                                    <td class="sorting_1"><?php if (strlen($watch['title'])>0) { echo str_replace("&amp;","&",htmlspecialchars($watch['title'])); } else { echo "<i>Unknown</i>"; } ?></td>
                                    <td><a target="_blank" href="<?php echo str_replace("&amp;","&",htmlspecialchars($watch['url'])); ?>"><?php echo str_replace("&amp;","&",htmlspecialchars($watch['display_url'])); ?></a></td>
                                    <td><!--<?php echo $watch['last_change']; ?>--><?php echo $watch['last_change_readable']; ?></td>
                                    <td>Hourly</td>
                                    <td><a style="margin-bottom: 5px; margin-left: 0px; margin-right: 8px;" class="btn btn-sm btn-primary" href="/sites/view/<?php echo $watch['id']; ?>"><i class="icon-eye"></i>&nbsp;&nbsp;View</a><a style="margin-bottom: 5px; margin-left: 0px; margin-right: 8px;" class="btn btn-sm btn-default" href="/sites/edit/<?php echo $watch['id']; ?>"><i class="icon-note"></i>&nbsp;&nbsp;Edit</a><a style="margin-bottom: 5px; margin-left: 0px; margin-right: 0px;" class="btn btn-sm btn-danger" href="/sites/delete/<?php echo $watch['id']; ?>"><i class="icons-office-52"></i>&nbsp;&nbsp;Delete</a></td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table><div class="row"><div class="col-md-6">&nbsp;<!--<div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Showing 1 to <?php echo min(10,count($watches)); ?> of <?php echo count($watches); ?> entries</div></div><div class="col-md-6"><div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate"><ul class="pagination"><li class="paginate_button previous disabled" aria-controls="DataTables_Table_0" tabindex="0" id="DataTables_Table_0_previous"><a href="#"><i class="fa fa-angle-left"></i></a></li><li class="paginate_button active" aria-controls="DataTables_Table_0" tabindex="0"><a href="#">1</a></li><!--<li class="paginate_button " aria-controls="DataTables_Table_0" tabindex="0"><a href="#">2</a></li><li class="paginate_button " aria-controls="DataTables_Table_0" tabindex="0"><a href="#">3</a></li><li class="paginate_button " aria-controls="DataTables_Table_0" tabindex="0"><a href="#">4</a></li>--<li class="paginate_button next" aria-controls="DataTables_Table_0" tabindex="0" id="DataTables_Table_0_next"><a href="#"><i class="fa fa-angle-right"></i></a></li></ul></div>--></div></div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>