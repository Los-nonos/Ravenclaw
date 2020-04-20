<?php
declare(strict_types=1);

namespace Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileExistsException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Composer;

class MaryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:usecase {action : The name of the use case}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generator of architectural bases that a use case needs';

    private Filesystem $fileSystem;
    private Composer $composer;

    public function __construct(
        Filesystem $fileSystem,
        Composer $composer
    ) {
        parent::__construct();

        $this->fileSystem = $fileSystem;
        $this->composer = $composer;
    }

    /**
     * Execute the console command.
     * @throws FileExistsException
     */
    public function handle()
    {
        $attributes = $this->ask('What attributes do you need? Format: name-type (Ex.: name-string,userId-int,age-?int)');
        $grouping = $this->ask('If you have a specific grouping, write it down (Ex.: /Grouping/Example)');
        $withResult = $this->confirm('Do you need a result?');
        $withPresenter = $this->confirm('Do you need a presenter?');
        $action = trim($this->argument('action'));

        $actionFilePath = $this->buildActionFilePath($action, $grouping);
        $adapterFilePath = $this->buildAdapterFilePath($action, $grouping);
        $commandFilePath = $this->buildCommandFilePath($action, $grouping);
        $handlerFilePath = $this->buildHandlerFilePath($action, $grouping);
        $resultFilePath = $this->buildResultFilePath($action, $grouping);
        $presenterFilePath = $this->buildPresenterFilePath($action, $grouping);

        $this->info("\n1. File paths was built!\n");

        $actionClass = $this->buildActionClass($action, $withPresenter, $grouping);
        $adapterClass = $this->buildAdapterClass($action, $grouping);
        $commandClass = $this->buildCommandClass($action, $attributes, $grouping);
        $handlerClass = $this->buildHandlerClass($action, $withResult, $grouping);
        $resultClass = $this->buildResultClass($action, $grouping);
        $presenterClass = $this->buildPresenterClass($action, $withResult, $grouping);

        $this->info("2. Classes was built!\n");

        $this->makeDirectory($actionFilePath);
        $this->makeDirectory($adapterFilePath);
        $this->makeDirectory($commandFilePath);
        $this->makeDirectory($handlerFilePath);
        $this->makeDirectory($resultFilePath);
        $this->makeDirectory($presenterFilePath);

        $this->info("3. Directories was checked!\n");

        $this->fileSystem->put($actionFilePath, $actionClass);
        $this->comment(' >>> File "' . $actionFilePath . '" was created');
        $this->fileSystem->put($adapterFilePath, $adapterClass);
        $this->comment(' >>> File "' . $adapterFilePath . '" was created');
        $this->fileSystem->put($commandFilePath, $commandClass);
        $this->comment(' >>> File "' . $commandFilePath . '" was created');
        $this->fileSystem->put($handlerFilePath, $handlerClass);
        $this->comment(' >>> File "' . $handlerFilePath . '" was created');
        $this->fileSystem->put($resultFilePath, $resultClass);
        $this->comment(' >>> File "' . $resultFilePath . '" was created');
        $this->fileSystem->put($presenterFilePath, $presenterClass);
        $this->comment(' >>> File "' . $presenterFilePath . '" was created');

        $this->info("4. Files was created!\n");

        $this->composer->dumpAutoloads();

        $this->info("5. Composer autoloader files was regenerated!\n");
    }

    private function makeDirectory(string $path): void
    {
        if (!$this->fileSystem->isDirectory(dirname($path))) {
            $this->fileSystem->makeDirectory(dirname($path), 0755, true);

            $this->comment(' >>> Directory "'.dirname($path).'" was created');
        }
    }

    private function buildActionFilePath(string $action, ?string $grouping = null): string
    {
        $path = str_replace(
            ['{{action}}', '{{grouping}}'],
            [$action, $grouping],
            base_path() . '/presentation/Http/Actions{{grouping}}/{{action}}Action.php'
        );

        if ($this->fileSystem->exists($path)) {
            throw new FileExistsException($path);
        }

        return $path;
    }

    private function buildActionClass(string $action, bool $withPresenter = false, ?string $grouping = null): string
    {
        $replacements = [
            '{{action}}'   => $action,
            '{{grouping}}' => $grouping ? str_replace('/', "\\", $grouping) : null,
        ];

        $stub = $withPresenter ?
            resource_path('/stubs/ActionWithPresenter.stub') :
            resource_path('/stubs/Action.stub');

        return str_replace(
            array_keys($replacements),
            array_values($replacements),
            file_get_contents($stub)
        );
    }

    private function buildAdapterFilePath(string $action, ?string $grouping = null): string
    {
        $path = str_replace(
            ['{{action}}', '{{grouping}}'],
            [$action, $grouping],
            base_path() . '/presentation/Http/Adapters{{grouping}}/{{action}}Adapter.php'
        );

        if ($this->fileSystem->exists($path)) {
            throw new FileExistsException($path);
        }

        return $path;
    }

    private function buildAdapterClass(string $action, ?string $grouping = null): string
    {
        $replacements = [
            '{{action}}'   => $action,
            '{{grouping}}' => $grouping ? str_replace('/', "\\", $grouping) : null,
        ];

        return str_replace(
            array_keys($replacements),
            array_values($replacements),
            file_get_contents(resource_path('/stubs/Adapter.stub'))
        );
    }

    private function buildCommandFilePath(string $action, ?string $grouping = null): string
    {
        $path = str_replace(
            ['{{action}}', '{{grouping}}'],
            [$action, $grouping],
            base_path() . '/application/Commands{{grouping}}/{{action}}Command.php'
        );

        if ($this->fileSystem->exists($path)) {
            throw new FileExistsException($path);
        }

        return $path;
    }

    private function buildCommandClass(string $action, ?string $attributes = null, ?string $grouping = null): string
    {
        $attributes = $attributes ? explode(',', trim($attributes)) : [];

        $classAttributes = '';

        $constructorParameters = '';
        $constructorAssignment = '';

        $getMethods = '';

        foreach ($attributes as $index => $attribute) {
            list($name, $type) = explode('-', trim($attribute));

            $classAttributes .= '    private ' . $type . ' $' . $name .
                ($this->isNullable($type) ? ' = null' : '') . ";\n";

            $constructorParameters .= '        ' . $type . ' $' . $name .
                ($this->isNullable($type) ? ' = null' : '') .
                ($this->isLastElement($index, $attributes) ? '' : ",\n");
            $constructorAssignment .= '        $this->' . $name . ' = $' . $name .
                ($this->isLastElement($index, $attributes) ? ';' : ";\n");

            $getMethods .= ($this->isFirstElement($index) ? "\n" : "\n\n");
            $getMethods .= '    public function get' . ucfirst($name) . '(): ' . $type . "\n";
            $getMethods .= '    {' . "\n";
            $getMethods .= '        return $this->' . $name . ";\n";
            $getMethods .= '    }';
        }

        $replacements = [
            '{{action}}'   => $action,
            '{{grouping}}' => $grouping ? str_replace('/', "\\", $grouping) : null,
            '{{class_attributes}}' => $classAttributes,
            '{{constructor_parameters}}'  => $constructorParameters,
            '{{constructor_assignments}}' => $constructorAssignment,
            '{{get_methods}}' => $getMethods,
        ];

        return str_replace(
            array_keys($replacements),
            array_values($replacements),
            file_get_contents(resource_path('/stubs/Command.stub'))
        );
    }

    private function buildHandlerFilePath(string $action, ?string $grouping = null): string
    {
        $path = str_replace(
            ['{{action}}', '{{grouping}}'],
            [$action, $grouping],
            base_path() . '/application/Handlers{{grouping}}/{{action}}Handler.php'
        );

        if ($this->fileSystem->exists($path)) {
            throw new FileExistsException($path);
        }

        return $path;
    }

    private function buildHandlerClass(string $action, bool $withResult = false, ?string $grouping = null): string
    {
        $replacements = [
            '{{action}}'   => $action,
            '{{grouping}}' => $grouping ? str_replace('/', "\\", $grouping) : null,
        ];

        $stub = $withResult ?
            resource_path('/stubs/QueryHandler.stub') :
            resource_path('/stubs/CommandHandler.stub');

        return str_replace(
            array_keys($replacements),
            array_values($replacements),
            file_get_contents($stub)
        );
    }

    private function buildResultFilePath(string $action, ?string $grouping = null): string
    {
        $path = str_replace(
            ['{{action}}', '{{grouping}}'],
            [$action, $grouping],
            base_path() . '/application/Results{{grouping}}/{{action}}Result.php'
        );

        if ($this->fileSystem->exists($path)) {
            throw new FileExistsException($path);
        }

        return $path;
    }

    private function buildResultClass(string $action, ?string $grouping = null): string
    {
        $replacements = [
            '{{action}}'   => $action,
            '{{grouping}}' => $grouping ? str_replace('/', "\\", $grouping) : null,
        ];

        return str_replace(
            array_keys($replacements),
            array_values($replacements),
            file_get_contents(resource_path('/stubs/Result.stub'))
        );
    }

    private function buildPresenterFilePath(string $action, ?string $grouping = null): string
    {
        $path = str_replace(
            ['{{action}}', '{{grouping}}'],
            [$action, $grouping],
            base_path() . '/presentation/Http/Presenters{{grouping}}/{{action}}Presenter.php'
        );

        if ($this->fileSystem->exists($path)) {
            throw new FileExistsException($path);
        }

        return $path;
    }

    private function buildPresenterClass(string $action, bool $withResult = false, ?string $grouping = null): string
    {
        $replacements = [
            '{{action}}'   => $action,
            '{{grouping}}' => $grouping ? str_replace('/', "\\", $grouping) : null,
        ];

        $stub = $withResult ?
            resource_path('/stubs/PresenterFromResult.stub') :
            resource_path('/stubs/Presenter.stub');

        return str_replace(
            array_keys($replacements),
            array_values($replacements),
            file_get_contents($stub)
        );
    }

    private function isNullable(string $type): bool
    {
        return (strpos($type, '?') !== false);
    }

    private function isFirstElement(int $index): bool
    {
        return ($index === 0);
    }

    private function isLastElement(int $index, array $elements): bool
    {
        return ((count($elements) - 1) === $index);
    }
}
