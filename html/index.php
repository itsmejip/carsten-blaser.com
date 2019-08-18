<?php 
    REQUIRE_ONCE __DIR__ . "/../app.php";

    use Jip\Library\Router;
    use Jip\Library\Session;
    use Jip\Presenter\IndexPresenter;

    $router = new Router();

    /**
     * Default pages 
     */
    $router->addStatusCodeDelegate(404, function () {
        echo '<h1>404 - Page not found.</h1>';
    });

    $router->addStatusCodeDelegate(405, function () {
        echo '<h1>405 - Wrong method.</h1>';
    });

    /**
     * Default get 
     */
    $router->add(IndexPresenter::PATH, function() {
        /**
         * Language set by get variable
         */
        if (isset($_GET["lang"])) {
            Session::get()->setLang($_GET["lang"]);
        }

        showIndexView();
    });

    /**
     * Default post request
     */
    $router->add(IndexPresenter::PATH, function() {
        handleLangChange();
        handleContactFormRequest();
        showIndexView();
    }, 'post');

    /**
     * Ajax post
     */
    $router->add('/ajax.php', function() {
        $ajaxRequestHandler = new Jip\Library\Ajax\AjaxRequestHandler(RESOURCES_DATA_PATH . "requestLibrary.json");
        $ajaxRequestHandler->handleRequest(Session::get()->getCsrfToken());
    }, 'post');

    /**
     * Ajax get
     */
    $router->add('/ajax.php', function() {
        $ajaxRequestHandler = new Jip\Library\Ajax\AjaxRequestHandler(RESOURCES_DATA_PATH . "requestLibrary.json");
        $ajaxRequestHandler->handleRequest(Session::get()->getCsrfToken());
    }, 'get');

    /**
     * Legals get
     */
    $router->add(Jip\Presenter\LegalsPresenter::PATH, function() {
       $presenter = new Jip\Presenter\LegalsPresenter(Session::get()->getLang());
       $presenter->showView();
    }, 'get');

    /**
     * Privacy policy get
     */
    $router->add(Jip\Presenter\PrivacyPolicyPresenter::PATH, function() {
        $presenter = new Jip\Presenter\PrivacyPolicyPresenter(Session::get()->getLang());
        $presenter->showView();
     }, 'get');

    $router->route();

    /**
     * Save session changes made by the presenter or views
     */
    Session::save();

    function showIndexView() {
        $presenter = new IndexPresenter(Session::get()->getLang());
        $presenter->showView();
    }

    function handleLangChange() {
        $key = strtolower($_POST["key"]);
        $lang = strtolower($_POST["lang"]);
        if (Session::get()->getCsrfToken()->check($_POST["csrf_token"]) && $key == "change_lang" && in_array($lang, SUPPORTED_LANGUAGES, true)) {
           Session::get()->setLang($lang);
           Session::save();
        }
    }

    function handleContactFormRequest() {
        $presenter = new Jip\Presenter\ContactPresenter(Session::get()->getLang());
        if (Session::get()->getCsrfToken()->check($_POST["csrf_token"]) && $presenter->canHandleRequest()) {
            $presenter->handleRequest();
        }
    }
?>