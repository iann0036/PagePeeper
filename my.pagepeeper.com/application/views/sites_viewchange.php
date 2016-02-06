<div class="page-content">
    <div class="header">
        <h2>View <strong>Site</strong></h2>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel">
                <div class="panel-content">
                    <h3><?php if (is_array($diffdata)) { echo count($diffdata); } ?> Differences Detected</h3>
                    <?php
                        if (!is_array($diffdata)) {
                            echo "No difference detected.";
                        } else {
                            foreach ($diffdata as $change) {
                                echo "<h4>".$change['linecount']." lines ".$change['type']."</h4>";
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
                            }
                        }
                        ?>
                    <h3>Full Source Code</h3>
                    <pre class="prettyprint linenums"><?php echo htmlentities($updatedata->data); ?></pre>
                </div>
            </div>
        </div>
    </div>
</div>
