<?php 
    use Jip\Library\Session;

    global $path;
    global $lang;

    $presenter = new Jip\Presenter\HeaderPresenter($path, $lang, Session::get()->getCsrfToken()->getToken());
    $presenter->showView();
    
    INCLUDE_ONCE VIEW_PATH . 'language.selection.inc.php';

    $presenter = new Jip\Presenter\SideMenuPresenter($lang, $path);
    $presenter->showView();

    $presenter = new Jip\Presenter\StreamNotifierPresenter($lang);
    $presenter->showView();
?>
<div class="page-pilling-sections">
    <?php 
        $presenter = new Jip\Presenter\StartPresenter($lang);
        $presenter->showView();
  
        $presenter = new Jip\Presenter\AboutmePresenter($lang);
        $presenter->showView();
  
        $presenter = new Jip\Presenter\WorkPresenter(RESOURCES_DATA_PATH . "index.work.data.json", $lang);
        $presenter->showView();

        $presenter = new Jip\Presenter\PortfolioPresenter(RESOURCES_DATA_PATH . "index.portfolio.data.json", $lang);
        $presenter->showView();

        $presenter = new Jip\Presenter\SkillPresenter(RESOURCES_DATA_PATH . "index.skill.data.json", $lang);
        $presenter->showView();
    
        $presenter = new Jip\Presenter\ContactPresenter($lang);
        $presenter->showView();
    ?>
</div>
<?php 
     $presenter = new Jip\Presenter\FooterPresenter($lang);
     $presenter->showView(); 
?>
