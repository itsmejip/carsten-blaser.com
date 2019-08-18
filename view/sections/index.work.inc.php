<?php global $work; global $lang; ?>
<div class="section work pp-scrollable">
    <div class="section-title"><@trans.title@></div>
    <div class="container-fluid work-table-bg-wrapper">
            <div class="work-table-bg" data-direction="left" style="left:-200%;top:10%;"></div>
            <div class="work-table-bg" data-direction="left" style="left:-175%;top:18%;"></div>
            <div class="work-table-bg" data-direction="left" style="left:-181%;top:22%;"></div>
            <div class="work-table-bg" data-direction="left" style="left:-198%;top:65%;"></div>
            <div class="work-table-bg" data-direction="left" style="left:-219%;top:75%;"></div>
            <div class="work-table-bg" data-direction="left" style="left:-202%;top:81%;"></div>
            <div class="row">
            <div class="col col-md-8 offset-md-2">
                <div class="work-table">
                    
                <?php 
                    $pos = "right";
                    foreach($work as $id => $workItem): ?>
                        <?php $pos = ($pos == "left") ? "right" : "left";?>
                        <div class="work-entry-line">
                            <div id="<?= $id ?>" class="work-entry <?= $pos ?>">
                                <div class="symbol">
                                    <?php 
                                        $imgName = "work-item-e.svg";
                                        if ($workItem["type"] == "work") {
                                            $imgName = "work-item-w.svg";
                                        }
                                        INCLUDE HTML_IMAGE_PATH . $imgName; 
                                    ?>
                                </div>
                                <div class="year">
                                    <?= (is_array($workItem["time"]["from"]) ? $workItem["time"]["from"][$lang] : $workItem["time"]["from"]); ?><br />
                                    <?= (is_array($workItem["time"]["till"]) ? $workItem["time"]["till"][$lang] : $workItem["time"]["till"]); ?>
                                </div>
                                <div class="content">
                                    <h3 class="title"><?= $workItem["title"][$lang] ?></h3>
                                    <p class="text"><?= $workItem["text"][$lang] ?></p>
                                    <div class="location-table"><div>
                                        <div><i class="fas fa-map-marker-alt"></i> <span style="margin-left:10px;font-size:0.7em;"><?= $workItem["location"][$lang] ?></span></div>
                                        <?php if(is_array($workItem["link"])): ?>
                                            <div><i class="fas fa-globe"></i> <a style="margin-left:10px" href="<?= $workItem["link"]["url"] ?>" target="_blank" rel="noreferrer"><?= $workItem["link"]["caption"][$lang] ?></a></div>
                                        <?php endif; ?>
                                    </div></div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <script type="text/javascript">
                        function drawWorkEntryBeziers(offset, stepSize) {
                            <?php foreach($work as $id => $workItem): ?>
                                <?php for($i=0;$i<sizeof($workItem["connector"]);$i++): ?>
                                    <?php $connector = $workItem["connector"][$i]; ?>
                                        drawWorkEntryBezier($('#<?= $id ?>'), '<?= $connector["base_connect"] ?>', {x:<?= $connector["base_weight"]["x"] ?>, y:<?=$connector["base_weight"]["y"] ?>}, $('#<?= $connector["target"] ?>'), '<?= $connector["target_connect"] ?>', {x:<?= $connector["target_weight"]["x"] ?>, y:<?= $connector["target_weight"]["y"] ?>}, offset, stepSize);
                                <?php endfor; ?>
                            <?php endforeach; ?>
                        } 
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>