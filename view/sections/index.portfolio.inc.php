<?php global $portfolio; global $lang ?>
<div class="section portfolio pp-scrollable" id="sec-portfolio">
    <div class="portfolio-container">
        <?php foreach ($portfolio as $item): ?>
            <?php if (is_null($item["active"]) || $item["active"]): ?>
            <a href="#" class="portfolio-item" id="<?= $item["id"] ?>">
                <span class="head">
                    <img src="<?= (!empty($item["cover"]["url"][$lang]) ? $item["cover"]["url"][$lang] : "/shared/portfolio/no-image.png"); ?>" alt="<?= $item["cover"]["alt"][$lang] ?>" />   
                </span>
                <span class="title">
                <?= $item["title"][$lang] ?><br /><small><?= $item["subtitle"][$lang] ?></small>
                </span> 
                <span class="text">
                    <?= $item["text"][$lang] ?>
                </span>    
                <span class="details">
                    <span class="list">
                        <?php for($i=0;$i<sizeof($item["dev"]);$i++): ?>
                        <span class="entry"><?= $item["dev"][$i][$lang]; ?></span>
                        <?php endfor; ?>
                    </span>
                </span>
            </a>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <div id="portfolio-detail-modal" class="modal fade" role="dialog" aria-labelledby="portfolioItem" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><span class="pf-title"><!-- AJAX --></span> <small class="pf-subtitle"><!-- AJAX --></small></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="<@trans.close@>">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <div class="container-fluid">
                        <div class="row pf-header">
                            <div class="col-lg-7">
                                <div class="cover">
                                    <img src="" alt="<!-- AJAX -->">
                                </div>
                                <div class="details ">
                                    <div class="caption"><@trans.media@></div>
                                    <div class="list media">
                                        <!-- AJAX -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 side-details">
                                <div class="details">
                                    <div class="caption"><@trans.dev@></div>
                                    <div class="list dev">                               
                                        <!-- AJAX -->
                                    </div>
                                </div>
                                
                                <div class="details">
                                    <div class="caption"><@trans.tools@></div>
                                    <div class="list tools">                               
                                        <!-- AJAX -->
                                    </div>
                                </div>
                                <div class="details">
                                    <div class="list links">                               
                                        <!-- AJAX -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-content">
                                <!-- AJAX -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>