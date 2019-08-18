<?php
namespace Jip\Presenter;

use Jip\Model\IModel;
use Jip\View\IView;

abstract class Dto {

    protected $model;

    protected $view;

    public function __construct($model, $view) {
        $this->view = $view;
        $this->model = $model;
    }

    public function showView() {
        $this->prepareView();
        $this->view->show();
    }

    public abstract function canHandleRequest();

    public abstract function handleRequest();

    protected abstract function prepareView();



}

?>