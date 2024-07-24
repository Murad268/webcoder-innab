<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeApiCommand extends Command
{
    protected $signature = 'app:make-api {model}';
    protected $description = 'Create API Controller and routes for a given model';

    public function handle()
    {
        $model = $this->argument('model');
        $modelLower = strtolower($model);
        $modelPlural = \Str::plural($model);

        // Define the paths
        $controllerPath = base_path("Modules/{$modelPlural}/Http/Controllers/{$model}ApiController.php");
        $routesPath = base_path("Modules/{$modelPlural}/Routes/api.php");

        // Create directories if they don't exist
        $this->createDirectoryIfNotExists(base_path("Modules/{$modelPlural}/Http/Controllers"));
        $this->createDirectoryIfNotExists(base_path("Modules/{$modelPlural}/Routes"));

        // Create the controller
        $controllerContent = $this->getControllerContent($model, $modelPlural);
        File::put($controllerPath, $controllerContent);
        $this->info("Created controller: {$controllerPath}");

        // Append to routes file
        $routeContent = $this->getRouteContent($model);
        File::append($routesPath, $routeContent);
        $this->info("Appended routes to: {$routesPath}");
    }

    protected function createDirectoryIfNotExists($path)
    {
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }
    }

    protected function getControllerContent($model, $modelPlural)
    {
        return <<<EOD
<?php

namespace Modules\\{$modelPlural}\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\\{$modelPlural}\Repositories\ModelRepository;

class {$model}ApiController extends Controller
{
    public function __construct(private ModelRepository \$repository)
    {
    }

    public function get_{$modelLower}s(Request \$request): JsonResponse
    {
        \$items = \$this->repository->all_activeWith(['image']);
        \$lang = \$request->locale;

        if (\$lang) {
            app()->setLocale(\$lang);
        }

        if (\$items->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No data found'], 404);
        }

        \$arr = \$items->map(function (\$item) {
            return [
                'image' => \$item->image ? config('app.url') . '/' . \$item->image['url'] : null,
            ];
        });

        return response()->json(['success' => true, 'data' => \$arr]);
    }
}
EOD;
    }

    protected function getRouteContent($model)
    {
        $modelLower = strtolower($model);
        return <<<EOD

Route::prefix('{locale}')->group(function () {
    Route::get('/get_{$modelLower}s', [Modules\\{$model}\Http\Controllers\\{$model}ApiController::class, 'get_{$modelLower}s'])->name('{$modelLower}.get_{$modelLower}s');
});
EOD;
    }
}
