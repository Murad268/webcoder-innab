<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeApiCommand extends Command
{
    protected $signature = 'app:make-api {name}';
    protected $description = 'Create a new API controller and route';

    public function handle()
    {
        $name = $this->argument('name');
        $lowered = strtolower($name);
        $controllerName = ucfirst($name) . 'ApiController';
        $methodName = 'get_' . strtolower($name);
        $modulePath = base_path("Modules/$name");
        $controllerPath = "$modulePath/app/Http/Controllers/$controllerName.php";
        $routePath = "$modulePath/Routes/api.php";

        // Create directories if they don't exist
        if (!File::isDirectory(dirname($controllerPath))) {
            File::makeDirectory(dirname($controllerPath), 0755, true);
        }

        // Create controller file
        $controllerContent = <<<PHP
        <?php

        namespace Modules\\$name\\Http\\Controllers;

        use App\Http\Controllers\Controller;
        use Illuminate\Http\JsonResponse;
        use Illuminate\Http\Request;
        use Modules\\$name\\Repositories\\ModelRepository;

        class $controllerName extends Controller
        {
            public function __construct(private ModelRepository \$repository)
            {
            }

            public function $methodName(Request \$request): JsonResponse
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
        PHP;

        File::put($controllerPath, $controllerContent);

        // Add route to api.php
        $routeContent = <<<PHP


        use Modules\\$name\\Http\\Controllers\\$controllerName;

        Route::prefix('{locale}')->group(function () {
            Route::get('/get_$lowered', [$controllerName::class, '$methodName'])->name('$lowered.get_name');
        });
        PHP;

        if (!File::exists($routePath)) {
            File::put($routePath, $routeContent);
        } else {
            File::append($routePath, "\n" . trim($routeContent));
        }

        $this->info("API Controller and routes for $name created successfully.");
    }
}
