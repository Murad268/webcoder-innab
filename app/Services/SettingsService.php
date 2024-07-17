<?php

namespace App\Services;

use Modules\SiteInfo\Repositories\ModelRepository;

class SettingsService
{

    public function __construct(protected ModelRepository $repository)
    {
    }

    public function getData()
    {
        return $this->repository->find(1);
    }
}
