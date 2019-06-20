<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "classes/Config.php";
require_once "classes/Reader.php";
require_once "classes/RenderMap.php";
require_once "classes/VisitorsLogging.php";

require_once "objects/Marker.php";
require_once "objects/Visit.php";

class Main {
    private $config;
    private $render;
    private $visit_logger;

    public function init() {
        $this->config = new Config();
        $this->render = new RenderMap($this->config);
        $this->visit_logger = new VisitorsLogging($this->config);
    }

    public function run() {
        try{
            $current_visitors = $this->visit_logger->getCurrentEventLogs();

            $current_event_markers = array_map(
                function(Visit $visit) {
                    $marker = new Marker($visit->latitude, $visit->longitude, $visit->timestamp);
                    $marker->name = sprintf(
                        "%s, %s, %s",
                        $visit->city,
                        $visit->region_name,
                        $visit->country_name
                    );
                    return $marker;
                },
                $current_visitors
            );

            $this->render->setMarkersToDisplay($current_event_markers);
            $this->render->setDrawLines(false);
            $this->render->show();
            
        } catch (Exception $e) {
            var_dump($e);
        }
    }
}

$app = new Main();
$app->init();
$app->run();

?>