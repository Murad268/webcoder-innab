<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class CreateModule extends Command
{
    /**
     * Komandanın imzası və adı.
     *
     * @var string
     */
    protected $signature = 'app:make {name}';

    /**
     * Komandanın təsviri.
     *
     * @var string
     */
    protected $description = 'Yeni bir modul yaradın';

    /**
     * Komandanı icra edin.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $loweredName = strtolower($name);

        // Artisan komandasını çağır, argumenti array kimi təqdim et
        Artisan::call("module:make", [
            'name' => [$name]
        ]);
        Artisan::call("module:make-model {$name} {$name} -m");

        // File paths
        $modelFilePath = "Modules/{$name}/app/Models/{$name}.php";
        $repositoryFilePath = "Modules/{$name}/app/Repositories/ModelRepository.php";
        $controllerFilePath = "Modules/{$name}/app/Http/Controllers/{$name}Controller.php";
        $apiRoutesPath = "Modules/{$name}/routes/api.php";
        $webRoutesPath = "Modules/{$name}/routes/web.php";
        $createViewPath = "Modules/{$name}/resources/views/create.blade.php";
        $editViewPath = "Modules/{$name}/resources/views/edit.blade.php";
        $indexViewPath = "Modules/{$name}/resources/views/index.blade.php";

        // Ensure directories exist
        $this->ensureDirectory(dirname($modelFilePath));
        $this->ensureDirectory(dirname($repositoryFilePath));
        $this->ensureDirectory(dirname($controllerFilePath));
        $this->ensureDirectory(dirname($apiRoutesPath));
        $this->ensureDirectory(dirname($webRoutesPath));
        $this->ensureDirectory(dirname($createViewPath));
        $this->ensureDirectory(dirname($editViewPath));
        $this->ensureDirectory(dirname($indexViewPath));

        // Create model file
        $this->createFile($modelFilePath, $this->getModelContent($name));

        // Create repository file
        $this->createFile($repositoryFilePath, $this->getRepositoryContent($name));

        // Create controller file
        $this->createFile($controllerFilePath, $this->getControllerContent($name, $loweredName));

        // Create API routes file
        $this->createFile($apiRoutesPath, $this->getApiRoutesContent($loweredName, $loweredName));

        // Create Web routes file
        $this->createFile($webRoutesPath, $this->getWebRoutesContent($name, $loweredName));

        // Create view files
        $this->createFile($createViewPath, $this->getCreateViewContent());
        $this->createFile($editViewPath, $this->getEditViewContent());
        $this->createFile($indexViewPath, $this->getIndexViewContent($loweredName));

        $this->info('Artisan command executed: make:module ' . $name);
    }

    /**
     * Ensure the directory exists.
     */
    protected function ensureDirectory($path)
    {
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }
    }

    /**
     * Create file with specified content.
     */
    protected function createFile($filePath, $content)
    {
        $file = fopen($filePath, "w");
        if ($file) {
            fwrite($file, $content);
            fclose($file);
            $this->info("File created successfully at {$filePath}");
        } else {
            $this->error("Failed to open the file at {$filePath}");
        }
    }

    /**
     * Get content for the model file.
     */
    protected function getModelContent($name)
    {
        return "<?php

namespace Modules\\$name\\Models;

use App\Models\SystemFiles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\\$name\\Database\\Factories\\{$name}Factory;
use Spatie\Translatable\HasTranslations;

class $name extends Model
{
    use HasFactory, HasTranslations;

    /**
     * The attributes that are mass assignable.
     */
    protected \$guarded = [];
    public \$translatable = ['title', 'slug', 'page_title', 'text','short_description', 'seo_title', 'seo_keywords', 'seo_description'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (\$model) {
            \$maxOrder = self::max('order');
            \$model->order = \$maxOrder !== null ? \$maxOrder + 1 : 1;
        });
    }

    public function images()
    {
        return \$this->hasMany(SystemFiles::class, 'relation_id')->where('model_type', 'news')->where('file_type', 'image');
    }

    protected static function newFactory(): {$name}Factory
    {
        //return {$name}Factory::new();
    }
}
";
    }

    /**
     * Get content for the repository file.
     */
    protected function getRepositoryContent($name)
    {
        return "<?php

namespace Modules\\$name\\Repositories;

use Modules\\$name\\Models\\$name;

class ModelRepository
{
    protected \$modelClass = $name::class;

    public function all_active()
    {
        return \$this->modelClass::orderBy('order')->where('status', 1)->get();
    }

    public function all(\$limit = 1)
    {
        return \$this->modelClass::orderBy('order')->paginate(\$limit);
    }

    public function search(\$query, \$limit = 1)
    {
        return \$this->modelClass::where('title->' . app()->getLocale(), 'like', \"%{\$query}%\")
            ->orWhere('short_description->' . app()->getLocale(), 'like', \"%{\$query}%\")
            ->paginate(\$limit);
    }

    public function find(\$id)
    {
        return \$this->modelClass::findOrFail(\$id);
    }

    public function findWhereInGet(array \$data)
    {
        return \$this->modelClass::whereIn('id', \$data)->get();
    }

    public function getModel()
    {
        return \$this->modelClass;
    }

    public function widthOrder(\$order)
    {
        return \$this->modelClass::where('order', \$order)->first();
    }

    public function where(\$key, \$value)
    {
        return \$this->modelClass::where(\$key, \$value);
    }
}
";
    }

    /**
     * Get content for the controller file.
     */
    protected function getControllerContent($name, $loweredName)
    {
        return "<?php

namespace Modules\\$name\\Http\\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ImageService;
use App\Services\RemoveService;
use App\Services\SimpleCrudService;
use App\Services\StatusService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\\$name\\Repositories\ModelRepository;
use Modules\\Lang\\Repositories\\ModelRepository as LangRepository;
use Modules\\$name\\Models\\$name;

class {$name}Controller extends Controller
{
    public function __construct(public ModelRepository \$repository, public SimpleCrudService \$crudService, public LangRepository \$langRepository, public StatusService \$statusService, public RemoveService \$removeService, public ImageService \$imageService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request \$request)
    {
        \$q = \$request->q;
        \$activeItemsCount = \$this->repository->all_active()->count();
        if (\$q) {
            \$items = \$this->repository->search(\$q, 80);
        } else {
            \$items = \$this->repository->all(80);
        }
        return view('{$loweredName}::index', compact('items', 'q', 'activeItemsCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        \$languages = \$this->langRepository->all_active();
        return view('{$loweredName}::create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request \$request): RedirectResponse
    {
        return \$this->executeSafely(function () use (\$request) {
            \$this->crudService->create(new $name(), \$request, '{$loweredName}');
            return redirect()->route('{$loweredName}.index')->with('status', '{$loweredName} uğurla əlavə edildi');
        }, '{$loweredName}.index');
    }

    /**
     * Show the specified resource.
     */
    public function show(\$id)
    {
        return view('{$loweredName}::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(\$id)
    {
        return \$this->executeSafely(function () use (\$id) {
            \$model = \$this->repository->find(\$id);
            \$languages = \$this->langRepository->all_active();
            return view('{$loweredName}::edit', compact('languages', 'model'));
        }, '{$loweredName}.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request \$request, \$id): RedirectResponse
    {
        return \$this->executeSafely(function () use (\$request, \$id) {
            \$model = \$this->repository->find(\$id);
            \$this->crudService->update(\$model, \$request, '{$loweredName}');
            return redirect()->route('{$loweredName}.index')->with('status', '{$loweredName} uğurla yeniləndi');
        }, '{$loweredName}.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(\$id)
    {
        //
    }

    public function changeStatusTrue(\$id)
    {
        return \$this->executeSafely(function () use (\$id) {
            \$model = \$this->repository->find(\$id);
            \$this->statusService->changeStatusTrue(\$model, new $name());
            return redirect()->route('{$loweredName}.index')->with('status', '{$loweredName} statusu uğurla yeniləndi');
        }, '{$loweredName}.index');
    }

    public function changeStatusFalse(\$id)
    {
        return \$this->executeSafely(function () use (\$id) {
            \$model = \$this->repository->find(\$id);
            \$this->statusService->changeStatusFalse(\$model, new $name());
            return redirect()->route('{$loweredName}.index')->with('status', '{$loweredName} statusu uğurla yeniləndi');
        }, '{$loweredName}.index');
    }

    public function delete_selected_items(Request \$request)
    {
        return \$this->executeSafely(function () use (\$request) {
            \$models = \$this->repository->findWhereInGet(\$request->ids);
            \$this->removeService->removeAll(\$models);
            return response()->json(['success' => \$models, 'message' => \"məlumatlar uğurla silindilər\"]);
        }, '{$loweredName}.index', true);
    }

    public function deleteFile(\$id)
    {
        return \$this->executeSafely(function () use (\$id) {
            \$this->imageService->deleteImage(\$id);
            return redirect()->back()->with('success', 'şəkil uğurla silindi');
        }, '{$loweredName}.index', true);
    }
}
";
    }

    /**
     * Get content for the API routes file.
     */
    protected function getApiRoutesContent($name, $loweredName)
    {
        return "<?php

use Illuminate\Support\Facades\Route;
use Modules\\$name\\Http\\Controllers\\{$name}Controller;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('$loweredName', {$name}Controller::class)->names('$loweredName');
});
Route::post('$loweredName/delete_selected_items', [{$name}Controller::class, 'delete_selected_items'])->name('$loweredName.delete_selected_items');
";
    }

    /**
     * Get content for the Web routes file.
     */
    protected function getWebRoutesContent($name, $loweredName)
    {
        return "<?php

use Illuminate\Support\Facades\Route;
use Modules\\$name\\Http\\Controllers\\{$name}Controller;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the \"web\" middleware group. Now create something great!
|
*/

Route::group(['prefix' => \"admin\"], function () {
    Route::resource('$loweredName', {$name}Controller::class)->names('$loweredName');
    Route::get('/$loweredName/changeStatusFalse/{id}', [{$name}Controller::class, 'changeStatusFalse'])->name('$loweredName.changeStatusFalse');
    Route::get('/$loweredName/changeStatusTrue/{id}', [{$name}Controller::class, 'changeStatusTrue'])->name('$loweredName.changeStatusTrue');
    Route::get('/$loweredName/deleteFile/{id}', [{$name}Controller::class, 'deleteFile'])->name('$loweredName.deleteFile');
});
";
    }

    /**
     * Get content for the create view file.
     */
    protected function getCreateViewContent()
    {
        return "hello create";
    }

    /**
     * Get content for the edit view file.
     */
    protected function getEditViewContent()
    {
        return "hello edit";
    }

    /**
     * Get content for the index view file.
     */
    protected function getIndexViewContent($loweredName)
    {
        return "@extends('layouts.app')

@section('content')
<div class=\"group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]\">
    <div class=\"container-fluid group-data-[content=boxed]:max-w-boxed mx-auto\">

        <div class=\"flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden\">
            <div class=\"grow\">
                <h5 class=\"text-16\"> Bloqlar </h5>
            </div>

        </div>

        <div class=\"card\">
            <div class=\"card-body\">
                <div id=\"alternativePagination_wrapper\" class=\"dataTables_wrapper dt-tailwindcss\">
                    <div class=\"grid grid-cols-12 lg:grid-cols-12 gap-3\">
                        <div class=\"self-center col-span-12 lg:col-span-6\">
                            <div style=\"display: flex; column-gap: 10px\" class=\"dataTables_length\" id=\"alternativePagination_length\">
                                <a href=\"{{route('$loweredName.create')}}\" style=\"display: flex; justify-content: center; align-items: center; cursor: pointer\" class=\"text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20\">əlavə et</a>
                                <a data-link=\"{{route('api.$loweredName.delete_selected_items')}}\" style=\"cursor: pointer\" type=\"button\" class=\"delete-all px-4 py-3 text-sm text-purple-500 border border-purple-200 rounded-md bg-purple-50 dark:bg-purple-400/20 dark:border-purple-500/50\">
                                    seçilənləri sil
                                </a>
                                <label> @if (session('status'))
                                    <div style=\"width: max-content\" class=\"px-4 py-3 text-sm text-green-500 bg-white border border-green-300 rounded-md dark:bg-zink-700 dark:border-green-500\" role=\"alert\">{{ session('status') }}</div>
                                    @endif

                                    @if (session('error'))
                                    <div style=\"width: max-content\" class=\"px-4 py-3 text-sm text-red-500 bg-white border border-red-300 rounded-md dark:bg-zink-700 dark:border-red-500\" role=\"alert\">{{ session('error') }}</div>
                                    @endif
                                </label>
                            </div>
                        </div>
                        <div class=\"self-center col-span-12 lg:col-span-6 lg:place-self-end\">
                            <div id=\"alternativePagination_filter\" class=\"dataTables_filter\">

                                <form action=\"\">
                                    <label>axtar
                                        :

                                    </label>
                                    <input name=\"q\" type=\"search\" value=\"{{\$q}}\" class=\"form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 inline-block w-auto ml-2\" placeholder=\"\" aria-controls=\"alternativePagination\">
                                </form>
                            </div>
                        </div>
                        <div class=\"my-2 col-span-12 overflow-x-auto lg:col-span-12\">
                            <table id=\"alternativePagination\" class=\"display dataTable w-full text-sm align-middle whitespace-nowrap\" style=\"width:100%\" aria-describedby=\"alternativePagination_info\">
                                <thead class=\"border-b border-slate-200 dark:border-zink-500\">
                                    <tr>
                                        <th class=\"p-3 group-[.bordered]:border group-[.bordered]:border-slate-200 group-[.bordered]:dark:border-zink-500 sorting px-3 py-4 text-slate-900 bg-slate-200/50 font-semibold text-left dark:text-zink-50 dark:bg-zink-600 dark:group-[.bordered]:border-zink-500 sorting_asc\" tabindex=\"0\" aria-controls=\"alternativePagination\" rowspan=\"1\" colspan=\"1\" style=\"width: 270.867px;\" aria-sort=\"ascending\" aria-label=\"Name: activate to sort column descending\">seç
                                        </th>
                                        <th class=\"p-3 group-[.bordered]:border group-[.bordered]:border-slate-200 group-[.bordered]:dark:border-zink-500 sorting px-3 py-4 text-slate-900 bg-slate-200/50 font-semibold text-left dark:text-zink-50 dark:bg-zink-600 dark:group-[.bordered]:border-zink-500\" tabindex=\"0\" aria-controls=\"alternativePagination\" rowspan=\"1\" colspan=\"1\" style=\"width: 415.15px;\" aria-label=\"Position: activate to sort column ascending\">başlıq
                                        </th>

                                        <th class=\"p-3 group-[.bordered]:border group-[.bordered]:border-slate-200 group-[.bordered]:dark:border-zink-500 sorting px-3 py-4 text-slate-900 bg-slate-200/50 font-semibold text-left dark:text-zink-50 dark:bg-zink-600 dark:group-[.bordered]:border-zink-500\" tabindex=\"0\" aria-controls=\"alternativePagination\" rowspan=\"1\" colspan=\"1\" style=\"width: 165.517px;\" aria-label=\"Salary: activate to sort column ascending\">status
                                        </th>
                                        <th class=\"p-3 group-[.bordered]:border group-[.bordered]:border-slate-200 group-[.bordered]:dark:border-zink-500 sorting px-3 py-4 text-slate-900 bg-slate-200/50 font-semibold text-left dark:text-zink-50 dark:bg-zink-600 dark:group-[.bordered]:border-zink-500\" tabindex=\"0\" aria-controls=\"alternativePagination\" rowspan=\"1\" colspan=\"1\" style=\"width: 165.517px;\" aria-label=\"Salary: activate to sort column ascending\">əməliyyatlar
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(\$items as \$item)
                                    <tr class=\"group-[.stripe]:even:bg-slate-50 group-[.stripe]:dark:even:bg-zink-600 transition-all duration-150 ease-linear group-[.hover]:hover:bg-slate-50 dark:group-[.hover]:hover:bg-zink-600 [&amp;.selected]:bg-custom-500 dark:[&amp;.selected]:bg-custom-500 [&amp;.selected]:text-custom-50 dark:[&amp;.selected]:text-custom-50\">

                                        <td class=\"p-3 group-[.bordered]:border group-[.bordered]:border-slate-200 group-[.bordered]:dark:border-zink-500 sorting_1\">
                                            <input data-id='{{\$item->id}}' id=\"checkboxCircle2\" class=\"select-lang border rounded-full appearance-none cursor-pointer size-4 bg-slate-100 border-slate-200 dark:bg-zink-600 dark:border-zink-500 checked:bg-green-500 checked:border-green-500 dark:checked:bg-green-500 dark:checked:border-green-500 checked:disabled:bg-green-400 checked:disabled:border-green-400\" type=\"checkbox\" value=\"\">
                                        </td>



                                        <td class=\" p-3 group-[.bordered]:border group-[.bordered]:border-slate-200 group-[.bordered]:dark:border-zink-500\">
                                            {{\$item->name}}
                                        </td>


                                        <td class=\" p-3 group-[.bordered]:border group-[.bordered]:border-slate-200 group-[.bordered]:dark:border-zink-500\">
                                            @if(\$item->status)
                                            <div class=\"px-4 py-3 text-sm text-green-500 border border-transparent rounded-md bg-green-50 dark:bg-green-400/20\">
                                                aktiv
                                            </div>
                                            @else
                                            <div class=\"px-4 py-3 text-sm text-red-500 border border-transparent rounded-md bg-red-50 dark:bg-red-400/20\">
                                                passiv
                                            </div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class=\"d-flex\">
                                                <a href=\"{{route('$loweredName.edit', \$item->id)}}\" class=\"btn btn-phoenix-success me-1 mb-1\" type=\"button\">
                                                    <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\" class=\"lucide lucide-square-pen\">
                                                        <path d=\"M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7\" />
                                                        <path d=\"M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z\" />
                                                    </svg>
                                                </a>

                                                @if(\$item->status)
                                                @if(\$activeItemsCount < 2 or \$items->count() < 2) <a style=\"cursor: none\" class=\"btn btn-phoenix-danger me-1 mb-1\" type=\"link\">
                                                        <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\" class=\"lucide lucide-info\">
                                                            <circle cx=\"12\" cy=\"12\" r=\"10\" />
                                                            <path d=\"M12 16v-4\" />
                                                            <path d=\"M12 8h.01\" />
                                                        </svg>
                                                        </a>
                                                        @else
                                                        <a href=\"{{route('$loweredName.changeStatusFalse',\$item->id)}}\" class=\"btn btn-phoenix-secondary me-1 mb-1 change_status_false\" type=\"link\">
                                                            <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\" class=\"lucide lucide-trending-down\">
                                                                <polyline points=\"22 17 13.5 8.5 8.5 13.5 2 7\" />
                                                                <polyline points=\"16 17 22 17 22 11\" />
                                                            </svg>
                                                        </a>
                                                        @endif

                                                        @else
                                                        <a href=\"{{route('$loweredName.changeStatusTrue',\$item->id)}}\" class=\"btn btn-phoenix-secondary me-1 mb-1 change_status_true\" type=\"button\">
                                                            <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\" class=\"lucide lucide-trending-up\">
                                                                <polyline points=\"22 7 13.5 15.5 8.5 10.5 2 17\" />
                                                                <polyline points=\"16 7 22 7 22 13\" />
                                                            </svg>
                                                        </a>
                                                        @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>

                            </table>
                            <div style=\"margin:0 auto; width: max-content; margin-top: 30px\" class=\"pagination\">
                                {{\$items->appends(['q' => request()->input('q')])->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--end card-->
    </div>
    <!-- container-fluid -->
</div>
@endsection
@push('scripts')
<script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11\"></script>

<script>
    document.querySelectorAll('.change_status_false, .change_status_true, .set_default_lang').forEach(link => {
        link.addEventListener('click', (e) => {
            if (e.target.matches('.change_status_false *')) {
                e.preventDefault();
                if (e.target.closest('a').getAttribute(\"href\")) {
                    Swal.fire({
                        title: \"Statusu dəyişmək istədiyinizdən əminsiniz?\",
                        showCancelButton: true,
                        confirmButtonText: \"bəli\",
                        cancelButtonText: \"xeyr\",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire(\"status yeniləndi\", \"\", \"success\")
                            window.location.href = e.target.closest('a').getAttribute(\"href\");
                        } else if (result.isDenied) {
                            Swal.fire(\"yenilənmə zamanı xəta\", \"\", \"info\");
                        }
                    });
                }
            } else if (e.target.matches('.change_status_true *')) {
                e.preventDefault();
                if (e.target.closest('a').getAttribute(\"href\")) {
                    Swal.fire({
                        title: \"Statusu dəyişmək istədiyinizdən əminsiniz?\",
                        showCancelButton: true,
                        confirmButtonText: \"bəli\",
                        cancelButtonText: \"xeyr\",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire(\"status yeniləndi\", \"\", \"success\")
                            window.location.href = e.target.closest('a').getAttribute(\"href\");
                        } else if (result.isDenied) {
                            Swal.fire(\"yenilənmə zamanı xəta\", \"\", \"info\");
                        }
                    });
                }
            } else if (e.target.matches('.set_default_lang *')) {
                e.preventDefault();
                if (e.target.closest('a').getAttribute(\"href\")) {
                    Swal.fire({
                        title: \"dili default tərin etmək istədiyinizdən əminsiniz?\",
                        showCancelButton: true,
                        confirmButtonText: \"bəli\",
                        cancelButtonText: \"xeyr\",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire(\"uğurlu əməliyyat\", \"\", \"success\")
                            window.location.href = e.target.closest('a').getAttribute(\"href\");
                        } else if (result.isDenied) {
                            Swal.fire(\"əməliyyat zamanı xəta\", \"\", \"info\");
                        }
                    });
                }
            }
        });
    });

    let selectedLangs = [];
    document.querySelectorAll('.select-lang').forEach(checkbox => {
        checkbox.addEventListener('change', (e) => {
            const id = e.target.getAttribute('data-id');
            if (e.target.checked) {
                if (!selectedLangs.includes(id)) {
                    selectedLangs.push(id);
                }
            } else {
                const index = selectedLangs.indexOf(id);
                if (index > -1) {
                    selectedLangs.splice(index, 1);
                }
            }
        });
    });

    document.querySelector('.delete-all').addEventListener('click', (e) => {
        e.preventDefault();
        const url = e.target.getAttribute('data-link');
        if (selectedLangs.length > 0) {
            Swal.fire({
                title: \"seçilmiş məlumatların silinməsini istədiyinizdən əminsiniz?\",
                showCancelButton: true,
                confirmButtonText: \"bəli\",
                cancelButtonText: \"xeyr\",
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                ids: selectedLangs
                            })
                        }).then(response => response.json())
                        .then(data => {
                            console.log(data);
                            Swal.fire(data.message, \"\", \"success\").then(() => {
                                location.reload();
                            });
                        }).catch(error => {
                            console.error('Error:', error);
                            Swal.fire('Error', \"\", \"error\");
                        });
                }
            });
        } else {
            Swal.fire(\"heç bir data seçilməyib\", \"\", \"info\");
        }
    });
</script>

@endpush";
    }
}
