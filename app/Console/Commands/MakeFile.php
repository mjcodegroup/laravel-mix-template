<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use InvalidArgumentException;
use Symfony\Component\Console\Input\InputOption;

class MakeFile extends GeneratorCommand
{
    const REPOSITORY = 'r';
    const ACTION = 'a';

    const CONTROLLER = 'c';
    protected $signature = 'make:file {--type=} {name} {--m=}';

    protected $description = 'Create file';

    protected $type = 'File';

    protected function getNameInput()
    {
        return str_replace('.', '/', trim($this->argument('name')));
    }
    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $stub = parent::buildClass($name);

        $model = $this->option('m');

        return $model ? $this->replaceModel($stub, $model) : $stub;
    }

    /**
     * Replace the model for the given stub.
     *
     * @param  string  $stub
     * @param  string  $model
     * @return string
     */
    protected function replaceModel($stub, $model)
    {
        $modelClass = $this->parseModel($model);

        $replace = [
            '{{ namespacedModel }}' => $modelClass,
            '{{ model }}' => class_basename($modelClass),
            '{{ modelVariable }}' => lcfirst(class_basename($modelClass)),
            '{{ modelAction }}' => class_basename($modelClass . "Action"),
            '{{ modelActionVariable }}' => lcfirst(class_basename($modelClass . "Action")),
            '{{ modelRepository }}' => class_basename($modelClass . "Repository"),
            '{{ modelRepositoryVariable }}' => lcfirst(class_basename($modelClass . "Repository")),
        ];

        return str_replace(
            array_keys($replace), array_values($replace), $stub
        );
    }

    /**
     * Get the fully-qualified model class name.
     *
     * @param  string  $model
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    protected function parseModel($model)
    {
        if (preg_match('([^A-Za-z0-9_/\\\\])', $model)) {
            throw new InvalidArgumentException('Model name contains invalid characters.');
        }

        return $this->qualifyModel($model);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        $fileType = $this->option('type');

        if (!in_array($fileType, [self::REPOSITORY, self::ACTION, self::CONTROLLER])) {
            throw new InvalidArgumentException("File type must be 'a' for Action  or 'r' for Repository");
        }

        if ($fileType == self::ACTION) {
            return app_path() . '/Console/Commands/Stubs/action.stub';
        } elseif ($fileType == self::REPOSITORY) {
            return app_path() . '/Console/Commands/Stubs/repository.stub';
        } else {
            return app_path() . '/Console/Commands/Stubs/controller.stub';
        }
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        $fileType = $this->option('type');

        if (!in_array($fileType, [self::REPOSITORY, self::ACTION, self::CONTROLLER])) {
            throw new InvalidArgumentException("File type must be 'a' for Action, 'r' for Repository or 'c' for Controller  ");
        }

        if ($fileType == self::ACTION) {
            return $rootNamespace . '\Actions';
        } elseif ($fileType == self::REPOSITORY) {
            return $rootNamespace . '\Repositories';
        } else {
            return $rootNamespace . '\Http\Controllers';
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['model', 'm', InputOption::VALUE_OPTIONAL, 'Model'],
        ];
    }
}
