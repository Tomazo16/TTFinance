<?php 

namespace App\Service;

use App\Config\TemplateConfig;

class TemplateRender
{
    private string $basePath;
    private ?string $layout;
    private ?string $stylesPath;
    private ?string $jsPath;
    
    public function __construct()
    {
        $this->basePath = TemplateConfig::getBasePath();
        $this->layout = TemplateConfig::getLayout();
        $this->stylesPath = TemplateConfig::getStylesPath();
        $this->jsPath = TemplateConfig::getJsPath();
    }

    /**
     * Renders a template with data and wraps it with a layout, if set.
     *
     * @param string $template files name (np. 'index.html.php')
     * @param array $data Data available in the template as variables
     * @return string Ready HTML
     */
    public function render(string $template, array $data = [], array $css = [], array $js = []): string
    {
        //setting default paths
        $templatePath = "{$this->basePath}/{$template}";
        $css = array_map(fn($style) => $this->stylesPath . '/' . $style , $css);
        $js = array_map(fn($script) => $this->jsPath . '/' . $script , $js);

        foreach ($css as $style) {
            if(!file_exists($style)) {
                throw new \RuntimeException("Style {$style} does not exist");
            }
        }
        foreach($js as $script) {
            if (!file_exists($script)) {
                throw new \RuntimeException("Script {$script} does not exist");
            }
        }

        if(!file_exists($templatePath)) {
            throw new \RuntimeException("Template does not exist: {$templatePath}");
        }

        extract($data, EXTR_SKIP);

        ob_start();
        include $templatePath;
        $content = ob_get_clean();

        if($this->layout) {
            $layoutPath = "{$this->layout}";
            if(!file_exists($layoutPath)) {
                throw new \RuntimeException("Base Layout does not exist: {$layoutPath}");
            }

            ob_start();
            include $layoutPath;
            $output = ob_get_clean();
        } else {
            $output = $content;
        }

        return $output;
    }
}