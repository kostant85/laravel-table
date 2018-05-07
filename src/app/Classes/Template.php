<?php

namespace Kostant\Table\Classes;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Kostant\Table\Classes\Template\Validator;
use Kostant\Table\Exceptions\TemplateException;
use Kostant\Table\Template\Builder;

class Template
{
    private $template;

    public function __construct(string $template)
    {
        $this->set($template);
    }

    public function get()
    {
        if ($this->needsValidation()) {
            (new Validator($this->template))->run();
        }

        (new Builder($this->template))->run();

        return ['template' => $this->template];
    }

    private function set(string $template)
    {
        try {
            $this->template = json_decode(\File::get($template));
        } catch (FileNotFoundException $exception) {
            throw new TemplateException(__('Specified template file was not found'));
        }

        if (!$this->template) {
            throw new TemplateException(__('Template is not readable'));
        }
    }

    private function needsValidation()
    {
        return config('app.env') === 'local';
    }
}
