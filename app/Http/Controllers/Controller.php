<?php

namespace App\Http\Controllers;

use App\Traits\ExecuteSafely;
use Modules\Lang\Repositories\ModelRepository as LangRepository;
abstract class Controller
{



    use ExecuteSafely;
}
