<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "classes/Config.php";
require_once "classes/Parser.php";
require_once "classes/Reader.php";
require_once "classes/RenderMap.php";

class Main {
    const VERSION = 1;
    private $config;
    private $reader;
    private $render;

    public function init() {
        $this->config = new Config();
        $this->reader = new Reader($this->config, new Parser());
        $this->render = new RenderMap($this->config);
    }

    public function run() {
        try{
            $current_event_markers = $this->reader->getCurrentEvent(
                $this->config->getParam("current_event_name", "example")
            );

            $this->render->setMarkersToDisplay($current_event_markers);
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