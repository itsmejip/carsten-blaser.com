<?php
namespace Jip\Library\Ajax;

use Jip\Model\PortfolioModel;
use Jip\Library\Session;

class AjaxPortfolioResponse extends AjaxResponse {

    const KEY_REQUEST_PORTFOLIO_DETAILS = "get_portfolio_details";
    const KEY_REQUEST_PORTFOLIO_TEXT = "get_portfolio_text";

    public function displayOutput()  {
        $lang = Session::get()->getLang();

        if ($this->getKey() == self::KEY_REQUEST_PORTFOLIO_DETAILS) {
            header('Content-Type: application/json');
            $model = new PortfolioModel(DATA_FILE_PORTFOLIO);
            $data = $model->getAll();
            $foundPortfolio = null;
            foreach ($data as $portfolio) {
                if ($portfolio["id"] == $this->parameter["id"] && (is_null($portfolio["active"]) || $portfolio["active"])) {
                    $foundPortfolio = $portfolio;
                }
            }

            if (is_null($foundPortfolio)) {
                \http_response_code(400);
                echo AjaxRequestHandler::createJsonError("NOT_FOUND");
                return;
            }

            unset($foundPortfolio["text"]);

            $foundPortfolio["title"] = $foundPortfolio["title"][$lang];
            $foundPortfolio["subtitle"] = $foundPortfolio["subtitle"][$lang];
            $foundPortfolio["cover"]["url"] = $foundPortfolio["cover"]["url"][$lang];
            $foundPortfolio["cover"]["alt"] = $foundPortfolio["cover"]["alt"][$lang];

            for($i=0;$i < sizeof($foundPortfolio["dev"]);$i++) {
                $foundPortfolio["dev"][$i] = $foundPortfolio["dev"][$i][$lang];
            }

            for($i=0;$i < sizeof($foundPortfolio["tools"]);$i++) {
                $foundPortfolio["tools"][$i] = $foundPortfolio["tools"][$i][$lang];
            }

            for($i=0;$i < sizeof($foundPortfolio["link"]);$i++) {
                $foundPortfolio["link"][$i]["caption"] = $foundPortfolio["link"][$i]["caption"][$lang];
            }

            for($i=0;$i < sizeof($foundPortfolio["media"]);$i++) {
                $foundPortfolio["media"][$i]["caption"] = $foundPortfolio["media"][$i]["caption"][$lang];
            }
            echo json_encode($foundPortfolio);
        } elseif ($this->getKey() == self::KEY_REQUEST_PORTFOLIO_TEXT) {
            $id = $this->parameter["id"];
            $model = new PortfolioModel(DATA_FILE_PORTFOLIO);
            $data = $model->getAll();
            $foundPortfolio = null;
            foreach ($data as $portfolio) {
                if ($portfolio["id"] == $id && (is_null($portfolio["active"]) || $portfolio["active"])) {
                    $foundPortfolio = $portfolio;
                }
            }

            $transModule = new \Jip\Library\FileTransModule(LANG_PATH . $lang . DIRECTORY_SEPARATOR . 'ajax.response.portfolio.json');

            $file = RESOURCES_DATA_PATH . "portfolio/$id.$lang.detail.php";

            if (is_null($foundPortfolio) || !ctype_digit($id) ) {
                \http_response_code(404);
                echo $transModule->replace("<h2><@trans.wrongid@></h2>");
                return;
            }

            if(!file_exists($file)) {
                \http_response_code(404);
                echo $transModule->replace("<h3 class=\"text-center\"><@trans.textnotfoundtitle@></h3><h4 class=\"text-center\"><@trans.textnotfoundtext@></h4>");
                return;
            }

            header('Content-Type: text/html; charset=utf-8');
            INCLUDE_ONCE $file;
        }
    }
}