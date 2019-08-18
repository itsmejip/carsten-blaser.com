<?php
    global $path;
    $linkPath = ($path != '/') ? '/' : '';
?>
<div class="sidemenu bg-dark d-none d-md-block d-lg-block d-xl-block">
      <nav class="menu-wrapper links">
            <ul id="anchor-menu" class="menu text-center">
                <li data-menuanchor="about-me">
                    <a href="<?= $linkPath ?>#about-me">
                        <i class="fas fa-street-view fa-2x"></i>   
                        <span><@trans.aboutme@></span>
                    </a>
                </li>
                <li data-menuanchor="work">
                    <a href="<?= $linkPath ?>#work">
                        <i class="fas fa-heartbeat fa-2x"></i>    
                        <span><@trans.work@></span>
                    </a>
                </li>
                <li data-menuanchor="portfolio">
                    <a href="<?= $linkPath ?>#portfolio">
                        <i class="fas fa-folder-open fa-2x"></i>
                        <span><@trans.portfolio@></span>
                    </a>
                </li>
                <li data-menuanchor="skills">
                    <a href="<?= $linkPath ?>#skills">
                        <i class="fas fa-cogs fa-2x"></i>
                        <span><@trans.skills@></span>
                    </a>
                </li>
                <?php if (false): ?>
                <li data-menuanchor="blog">
                    <a href="<?= $linkPath ?>#blog">
                        <i class="fas fa-cubes fa-2x"></i>
                        <span><@trans.blog@></span>
                    </a>
                </li>
                <li data-menuanchor="poems">
                    <a href="<?= $linkPath ?>#poems">
                        <i class="fas fa-feather-alt fa-2x"></i>
                        <span><@trans.poems@></span>
                    </a>
                </li>
                <?php endif; ?>
                
                <li data-menuanchor="contact">
                    <a href="<?= $linkPath ?>#contact">
                        <i class="fas fa-address-book fa-2x" style="margin-left:6px"></i> 
                        <span><@trans.contact@></span>
                    </a>
                </li>
            </ul>
      </nav>

      <nav class="menu-wrapper social">
            <ul class="menu">
                <li>
                    <a href="https://www.linkedin.com/in/carsten-blaser-23a4a0141" target="_blank" rel="noreferrer">
                        <i class="fab fa-linkedin fa-2x"></i>
                    </a>
                </li>
                <li>
                    <a href="https://www.twitter.com/___jip" target="_blank"  rel="noreferrer">
                        <i class="fab fa-twitter-square fa-2x"></i>
                    </a>
                </li>
                <li>
                    <a href="https://www.twitch.tv/wtfjip" target="_blank" rel="noreferrer">
                        <i class="fab fa-twitch fa-2x"></i>
                    </a>
                </li>
                <li>
                    <a href="mailto:jip@carsten-blaser.com">
                        <i class="fas fa-envelope-square fa-2x"></i>
                    </a>
                </li>
            </ul>
      </nav>
</div>