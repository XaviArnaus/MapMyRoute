<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "classes/Config.php";
require_once "classes/Parser.php";
require_once "classes/Reader.php";
require_once "objects/Marker.php";
require_once "classes/RenderForm.php";
require_once "classes/Writer.php";

class Main {
    const VERSION = 1;
    private $config;
    private $reader;
    private $render;
    private $writer;

    public function init() {
        $this->config = new Config();
        $this->reader = new Reader($this->config, new Parser());
        $this->render = new RenderForm($this->config);
        $this->writer = new Writer($this->config);
    }

    public function run() {
        try{
            $post = $this->getPost();
            if ($post !== false) {
                $event_markers = $this->reader->getCurrentEvent(
                    $this->config->getParam("current_event_name", "example")
                );
                $new_marker = new Marker(
                    floatval($post["lat"]),
                    floatval($post["lng"])
                );
                if (isset($post["name"])) {
                    $new_marker->name = $post["name"];
                }
                $new_marker->applyTimezoneCorrection($this->config);
                $event_markers[] = $new_marker;
                $this->writer->writeResults($event_markers);

                header("Location: /");
            } else {
                $this->render->show();
            }
            
        } catch (Exception $e) {
            var_dump($e);
        }
    }

    private function getPost() {
        $post = [];
        if(isset($_POST["latitude"]) && !empty($_POST["latitude"])) {
            $post["lat"] = $_POST["latitude"];
        }
        if(isset($_POST["longitude"]) && !empty($_POST["longitude"])) {
            $post["lng"] = $_POST["longitude"];
        }
        if(isset($_POST["name"]) && !empty($_POST["name"])) {
            $post["name"] = $_POST["name"];
        }

        if (count($post) > 0) {
            return $post;
        } else {
            return false;
        }
    }
}

$app = new Main();
$app->init();
$app->run();

?>