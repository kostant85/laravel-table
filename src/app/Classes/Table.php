<?php

namespace Kostant\Table\Classes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Kostant\Table\Classes\Table\Builder;
use Kostant\Table\Helpers\Obj;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Kostant\Table\Classes\Template\Validator;
use Kostant\Table\Exceptions\TemplateException;

abstract class Table
{
    protected $request;
    protected $templatePath = '';
    protected $template;

    public function __construct(array $request = [])
    {
        $this->request = new Obj($request);

        $this->setTemplate();
    }

    abstract public function query();

    public function init()
    {
        return (new Template($this->template))
            ->get();
    }

    /**
     * Data
     *
     * @return Collection
     */
    public function data()
    {
        return $this->transform($this->builder()->data());
    }

    /**
     * Excel
     *
     * @return array
     */
    public function excel()
    {
        return $this->builder()
            ->excel();
    }

    /**
     * Set Template
     *
     * @throws TemplateException
     */
    private function setTemplate()
    {
        try {
            $this->template = json_decode(\File::get($this->templatePath));
        } catch (FileNotFoundException $exception) {
            throw new TemplateException(__('Specified template file was not found'));
        }

        if (!$this->template) {
            throw new TemplateException(__('Template is not readable'));
        }

        if ($this->needsValidation()) {
            (new Validator($this->template))->run();
        }
    }

    /**
     * Needs Validation
     *
     * @return bool
     */
    private function needsValidation()
    {
//        return config('app.env') === 'local';
        return false;
    }

    /**
     * Transform the results
     *
     * @param Collection $items
     *
     * @return Collection
     */
    public function transform(Collection $items): Collection
    {
        $entities = $items->get('data');

        return $items->put('data', $entities->map(function (Model $entity) {
            $columns = [];
            foreach ($this->template->columns as $column) {
                if (method_exists($this, $method = camel_case($column->name) . 'Column')) {
                    $columns[$column->name] = call_user_func([$this, $method], $entity);
                } else {
                    $columns[$column->name] = $entity->{$column->data};
                }
            }

            return $columns;
        })->values());
    }

    /**
     * Builder
     *
     * @return Builder
     */
    private function builder()
    {
        return (new Builder($this->request, $this->query()));
    }
}
