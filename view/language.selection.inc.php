<?php 
    use Jip\Library\Session;
?>

<div class="lang-selection">
    <?php foreach(SUPPORTED_LANGUAGES as $langValue):?>
        <?php if($langValue == Session::get()->getLang()): ?>
            <div class="lang-item active" data-lang="<?= $langValue ?>"><?= $langValue ?></div>
        <?php else: ?>
            <a href="#" class="lang-item" data-lang="<?= $langValue ?>"><?= $langValue ?></a>
        <?php endif; ?>
    <?php endforeach; ?>
    <form id="lang-change-form" method="post" action="/">
        <input type="hidden" name="key" value="change_lang" />
        <input type="hidden" name="lang" value="" />
    </form>
</div>