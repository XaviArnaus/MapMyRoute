<?php

class RenderMap {

    private $config;
    private $markers;
    private $templates;
    private $choosen_template;
    private $draw_lines = true;

    public function __construct(Config $config) {
        $this->config = $config;
        $this->choosen_template = $config->getParam("display_template", "light");
        $this->templates = [
            "styles"            => "templates/" . $this->choosen_template . "/styles.css",
            "script"            => "templates/js/script.js",
            "layout"            => "templates/common/layout.html"
        ];
    }

    public function setMarkersToDisplay(array $markers) {
        $this->markers = $markers;
    }

    public function setDrawLines($should_draw_lines = true) {
        $this->draw_lines = $should_draw_lines;
    }

    public function show() {

        $content = $this->renderTemplate(
            "layout",
            [
                "{%-STYLES-%}" => $this->renderTemplate("styles"),
                "{%-SCRIPT-%}" => $this->renderTemplate("script"),
                "{%-EVENT_NAME-%}" => $this->config->getParam("current_event_name"),
                "{%-INITIAL_ZOOM-%}" => $this->config->getParam("initial_zoom", 5),
                "{%-DRAW_LINES-%}" => $this->draw_lines ? "true" : "false",
                "{%-STROKE_COLOR-%}" => $this->config->getParam("stroke_color"),
                "{%-STROKE_OPACITY-%}" => $this->config->getParam("stroke_opacity"),
                "{%-STROKE_WEIGHT-%}" => $this->config->getParam("stroke_weight"),
                "{%-ARRAY_MARKERS-%}" => "[" . join(", ",
                    array_map(
                        function (Marker $marker){
                            return $marker->toString();
                        },
                        $this->markers
                    )
                ) . "]",
                "{%-API_KEY-%}" => $this->config->getParam("google_maps_api_key")
            ]
        );

        print $content;
    }

    private function renderTemplate($template_name, $parameters = []) {
        $content = $this->getTemplateContent($template_name);
        foreach ($parameters as $key => $value) {
            $content = str_replace($key,$value,$content);
        }
        return $content;
    }

    private function getTemplateContent($template_name) {
        return file_get_contents($this->templates[$template_name]);
    }
}
