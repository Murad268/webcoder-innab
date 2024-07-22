<?php

namespace App\Services;

use Modules\Lang\Repositories\ModelRepository as LangRepository;
use App\Services\SimpleCrudService;
use App\Services\StatusService;
use App\Services\RemoveService;
use App\Services\ImageService;

class ServiceContainer
{
    public function __construct(
        public SimpleCrudService $crudService,
        public LangRepository $langRepository,
        public StatusService $statusService,
        public RemoveService $removeService,
        public ImageService $imageService,
        public PinService $pinRepository,
        public GeneralService $generalService
    ) {}
}

