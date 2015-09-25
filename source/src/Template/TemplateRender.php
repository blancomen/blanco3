<?php
namespace Template;


use Exception;

class TemplateRender {
    /**
     * @var string
     */
    protected $templatesRoot = PATH_VIEW;

    /**
     * @var string
     */
    protected $templateExt = '.php';

    /**
     * @param string $template
     * @param array $data
     * @return string
     * @throws Exception
     */
    public function render($template, array $data = []) {
        if (!$this->isTemplateExists($template)) {
            $path = $this->getTemplatePath($template);
            throw new Exception("Template {$template} not found in {$path}");
        }

        foreach ($data as $key => $value) {
            $$key = $value;
        }

        $path = $this->getTemplatePath($template);
        ob_start();
        include $path;
        return ob_get_clean();
    }

    /**
     * @param string $template
     */
    protected function includeTemplate($template) {

    }

    /**
     * @param string $template
     * @return bool
     */
    protected function isTemplateExists($template) {
        $path = $this->getTemplatePath($template);
        return file_exists($path);
    }

    /**
     * @param string $template
     * @return string
     */
    protected function getTemplatePath($template) {
        return $this->getTemplatesRoot() . DIRECTORY_SEPARATOR . $template . $this->getTemplateExt();
    }

    /**
     * @return string
     */
    protected function getTemplatesRoot() {
        return $this->templatesRoot;
    }

    /**
     * @return string
     */
    protected function getTemplateExt() {
        return $this->templateExt;
    }
}