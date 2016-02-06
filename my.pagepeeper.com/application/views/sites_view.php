<div class="page-content">
    <div class="header">
        <h2>View <strong>Site</strong></h2>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel">
                <div class="panel-content">
                    <div class="tab_right">
                        <ul class="nav nav-tabs nav-green"><?php
                            for ($i=0; $i<count($data) && $i<24; $i++) {
                                echo "<li";
                                if ($i==0)
                                    echo " class='active'";
                                echo "><a data-toggle='tab' href='#tab_".$data[$i]->id."'><i class='icon-clock'></i> ".$data[$i]->readable_time."</a></li>";
                            } ?>
                        </ul>
                        <div class="tab-content" style="min-height: <?php echo (min(24,count($data))*40); ?>px;">
                            <a href="/sites/"><button type="button" class="btn btn-primary" style="float: right;">&lArr; Back to Sites</button></a>
                            <h2 style="margin-top: 0;"><?php echo $url; ?></h2>
                            <?php
                            for ($i=0; $i<count($data) && $i<24; $i++) {
                                echo '<div class="';
                                if ($i==0)
                                    echo 'active in ';
                                echo 'tab-pane fade" id="tab_'.$data[$i]->id.'"><p>';
                                if ($i==(count($data)-1) || $i==23)
                                    echo 'Initial page crawl';
                                else
                                    echo 'Change detected at '.date('g:i A, jS F',strtotime($data[$i]->time)).'</p>';

                                if ($data[$i]->image != null) {
                                    if ($i==(count($data)-1) || $i==23)
                                        echo "<h3><b>Initial Screenshot</b></h3>";
                                    else
                                        echo "<h3><b>Screenshot Change</b></h3>";
                                    echo "<div style='box-shadow: 6px 6px 5px #888888; max-height: 480px; overflow: hidden; max-width: 480px;'><a href='/screenshots/".$data[$i]->image;
                                    if (!($i==(count($data)-1) || $i==23))
                                        echo "_diff";
                                    echo ".png' target='_blank'><img style='max-width: 480px;' src='/screenshots/".$data[$i]->image."_thumb.png' /></a></div><br /><br />";
                                } else {
                                    echo "<h3><b>No Visual Change Detected</b></h3>";
                                }

                                if (!is_array($data[$i]->diff) || count($data[$i]->diff) < 1) {
                                    if ($i!=(count($data)-1) && $i!=23)

                                        echo "<h3><b>No Code Differences Detected</b></h3>";
                                } else {
                                    echo "<h3><b>".count($data[$i]->diff)." Code Differences Detected</b></h3>";
                                    foreach ($data[$i]->diff as $change) {
                                        echo "<h4>".$change['linecount']." lines ".$change['type']." ";

                                        if (in_array($change["friendlymetadata"],$ignored_changes))
                                            echo "<small>(you are currently ignoring future changes like this)</small>";
                                        else
                                            echo "<small><a href='/sites/ignorechange/".$userwatch_id."/".$change['friendlymetadata']."/'>(ignore this change in the future)</a></small></h4>";

                                        if ($change['type']=="changed" || $change['type']=="added") {
                                            echo '<h5>Lines Added</h5><pre class="prettyprint linenums">';
                                            foreach ($change['added'] as $line) {
                                                echo htmlentities($line) . PHP_EOL;
                                            }
                                            echo '</pre>';
                                        }
                                        if ($change['type']=="changed" || $change['type']=="removed") {
                                            echo '<h5>Lines Removed</h5><pre class="prettyprint linenums">';
                                            foreach ($change['removed'] as $line) {
                                                echo htmlentities($line) . PHP_EOL;
                                            }
                                            echo "</pre>";
                                        }
                                        echo "<br />";
                                    }
                                }
                                echo "</div>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
