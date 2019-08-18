<?php global $skills; ?>
<div class="section skills pp-scrollable">
    <div class="container-fluid">
        <div class="word-wrapper" style="margin-bottom:30px;">
            <div class="word-line">
                <a href="#" data-keys="creative,aps,ail,aae,app" class="word-part"><h4>Design</h4></a>
                <a href="#" data-keys="js" class="word-part"><h1>Javascript</h1></a>
                <a href="#" data-keys="php,js" class="word-part"><h3>Frameworks</h3></a>
                <a href="#" data-keys="css" class="word-part"><h1>CSS</h1></a>
                <a href="#" data-keys="html,json" class="word-part"><h4>Markup languages</h4></a>
            </div>

            <div class="word-line">
                <a href="#" data-keys="creative,aps,ail,aae,app" class="word-part"><h4>Graphics</h4></a> 
                <a href="#" data-keys="java" class="word-part"><h1>Java</h1></a>
                <a href="#" data-keys="php,apache" class="word-part"><h1>PHP</h1></a>
                <a href="#" data-keys="scrum" class="word-part"><h5>Agile/Scrum</h5></a>
                <a href="#" data-keys="mantis" class="word-part"><h4>Bugs</h4></a>    
            </div>

            <div class="word-line">
                <a href="#" data-keys="cplus" class="word-part"><h3>C#</h3></a>
                <a href="#" data-keys="mysql" class="word-part"><h1>MySQL</h1></a>
                <a href="#" data-keys="html" class="word-part"><h1>HTML</h1></a>
                
                <a href="#" data-keys="vbnet" class="word-part"><h4>VB .net</h4></a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 skill-col">
            <?php 
                $currentRow=1;
                $sectionCount = 0;
                $rowChange = false;
                foreach ($skills as $section):
            ?>
                <?php $sectionCount++; $rowChange = ($currentRow != $section["row"]); ?>
                
                <?php if ($rowChange): ?>
                    </div>
                    <?php $currentRow = $section["row"];?>
                    <div class="col-lg-3 skill-col">
                <?php endif; ?>
                
                <?php 
                    $bg = "bg-primary";
                    if ($sectionCount % 4 == 0) {
                        $bg = "bg-danger";
                    } elseif ($sectionCount % 3 == 0) {
                        $bg = "bg-success";
                    } elseif ($sectionCount % 2 == 0) {
                        $bg = "bg-info";
                    } 
                ?>
                    <div class="skill-list <?= $bg ?>">
                        <h4><?= $section["title"] ?></h4>
                <?php foreach ($section["items"] as $skill): ?>
                        <div class="skill-line" data-key="<?= $skill["key"] ?>">
                            <div class="name">
                                <?= $skill["title"] ?>
                                <small><?= $skill["text"] ?></small>
                            </div>
                            <div class="value">
                                <?php for($i=1;$i<=$skill["points"];$i++): ?>
                                <i class="fas fa-carrot"></i>
                                <?php endfor; ?>
                            </div>
                        </div>
                <?php endforeach; ?>
                    </div>
            <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>