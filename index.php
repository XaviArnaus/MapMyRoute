<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "classes/Config.php";
require_once "classes/Parser.php";
require_once "classes/Reader.php";
require_once "classes/RenderMap.php";
require_once "classes/VisitorsLogging.php";

require_once "objects/Marker.php";
require_once "objects/Visit.php";

class Main {
    private $config;
    private $reader;
    private $render;
    private $visit_logger;

    public function init() {
        $this->config = new Config();
        $this->reader = new Reader($this->config, new Parser($this->config));
        $this->render = new RenderMap($this->config);
        $this->visit_logger = new VisitorsLogging($this->config);
    }

    public function run() {
        try{
            $get_params = $this->getQuerystringParams();

            $current_event_markers = $this->reader->getCurrentEvent(
                $this->config->getParam("current_event_name", "example")
            );

            $this->render->setMarkersToDisplay($current_event_markers);
            $this->render->show();

            $this->visit_logger->log($get_params['origin']);
            
        } catch (Exception $e) {
            var_dump($e);
        }
    }

    private function getQuerystringParams() {
        $safeGet = filter_input_array(INPUT_GET, [
            "origin" => FILTER_SANITIZE_STRING
        ]);

        $get = [
            'origin' => 'default'
        ];
        if(isset($safeGet["origin"]) && !empty($safeGet["origin"]) && isset($this->config->getParam("visitors_origin")[$safeGet["origin"]])) {
            $get["origin"] = $safeGet["origin"];
        }

        return $get;
    }
}

$app = new Main();
$app->init();
$app->run();

?>