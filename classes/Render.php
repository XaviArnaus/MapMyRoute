<?php

class Render {

    private $config;
    private $markers;
    private $templates;
    private $choosen_template;

    public function __construct(Config $config) {
        $this->config = $config;
        $this->choosen_template = $config->getParam("display_template", "light");
        $this->templates = [
            "styles"            => "templates/" . $this->choosen_template . "/styles.css",
            "layout"            => "templates/" . $this->choosen_template . "/layout.html"
        ];
    }

    public function setMarkersToDisplay(array $markers) {
        $this->markers = $markers;
    }

    public function show() {

        $content = $this->renderTemplate(
            "layout",
            [
                "{%-STYLES-%}" => $this->renderTemplate("styles"),
                "{%-EVENT_NAME-%}" => $this->config->getParam("current_event_name"),
                "{%-INITIAL_ZOOM-%}" => $this->config->getParam("initial_zoom", 5),
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
