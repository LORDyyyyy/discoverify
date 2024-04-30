<?php

declare(strict_types=1);

namespace Framework;

use Exception;

class TemplateEngine
{
    private string $basePath;
    private array $globalTemplateData = [];

    public function __construct(string $basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * Render a template for a controller
     *
     * @param string $template the template file path
     * @param array $data the data to pass to the template
     * @return string the rendered template
     */
    public function render(string $template, array $data = []): string
    {
        // foreach ($data as $key => &$value) {
        //     $data[$key] = esc($value);
        // }
        extract($data, EXTR_SKIP);
        extract($this->globalTemplateData, EXTR_SKIP);

        ob_start();

        $templatePath = $this->resolve($template);

        if (!file_exists($templatePath)) {
            throw new Exception("Template {$template} was not found");
        }

        include $templatePath;

        $output = ob_get_contents();

        ob_end_clean();

        return $output;
    }

    /**
     * Resolve the path of the template
     *
     * @param string $path the path of the template
     * @return string the resolved path
     */
    public function resolve(string $path): string
    {
        return "{$this->basePath}/{$path}";
    }

    /**
     * Add a global variable to the template
     *
     * @param string $key the key of the variable
     * @param mixed $value the value of the variable
     * @return void
     */
    public function addGlobal(string $key, mixed $value): void
    {
        $this->globalTemplateData[$key] = $value;
    }
}
