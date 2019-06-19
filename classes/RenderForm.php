<?php

class RenderForm {

    private $config;
    private $templates;
    private $choosen_template;

    public function __construct(Config $config) {
        $this->config = $config;
        $this->choosen_template = $config->getParam("display_template", "light");
        $this->templates = [
            "styles"            => "templates/" . $this->choosen_template . "/styles.css",
//            "script"            => "templates/js/script.js",
            "layout"            => "templates/" . $this->choosen_template . "/layout_form.html"
        ];
    }

    public function show() {

        $content = $this->renderTemplate(
            "layout",
            [
                "{%-STYLES-%}" => $this->renderTemplate("styles"),
//                "{%-SCRIPT-%}" => $this->renderTemplate("script"),
                "{%-EVENT_NAME-%}" => $this->config->getParam("current_event_name")
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
