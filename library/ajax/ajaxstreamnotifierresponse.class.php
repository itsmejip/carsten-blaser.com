<?php
namespace Jip\Library\Ajax;

use Jip\Model\PortfolioModel;
use Jip\Library\Session;

class AjaxStreamNotifierResponse extends AjaxResponse {

    const KEY_CHECK_LIVESTREAM = "check_livestream";

    const MAX_LIFETIME_OF_DATA = 300;

    const HELIX_STREAM_DATA = "https://api.twitch.tv/helix/streams";
   
    public function displayOutput()  {
        $lang = Session::get()->getLang();

        if ($this->getKey() == self::KEY_CHECK_LIVESTREAM) {
            header('Content-Type: application/json');
            
            /**
             * If lock is there we leave
             */
            if (file_exists(RESOURCES_LOCKS_PATH . "streamerNotifier.lock")) {
                echo json_encode(array("islive" => false));
                return;
            }

            $apiData = json_decode(file_get_contents(RESOURCES_DATA_PATH . "streamNotifier.json"), true);

            if ($apiData["lastUpdate"] + self::MAX_LIFETIME_OF_DATA < time()) {
                
                file_put_contents(RESOURCES_LOCKS_PATH . "streamerNotifier.lock", "LOCK IT BABY");

                /**
                 * We want to know if stream is live from twitch api
                 */
                $ch = curl_init();
		        curl_setopt_array($ch, array(
                    CURLOPT_HTTPHEADER => array(
                            'Client-ID: ' . $apiData["clientId"]
                    ),
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_URL => self::HELIX_STREAM_DATA . "?user_login=" . $apiData["channel_name"]
		        ));
		
                $output = curl_exec($ch);
                curl_close($ch);
                $data = json_decode($output, true);

                $apiData["isLive"] = (is_array($output["data"]) && sizeof($output["data"]) == 1);
                $apiData["lastUpdate"] = time();
                $apiData["updated"] = true;
                file_put_contents(RESOURCES_DATA_PATH . "streamNotifier.json", json_encode($apiData));

                unlink(RESOURCES_LOCKS_PATH . "streamerNotifier.lock");               
            } 

            unset($apiData["clientId"]);
            unset($apiData["lastUpdate"]);
            
            echo json_encode($apiData);
            return;
        }
    }
}