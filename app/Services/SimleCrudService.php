<?php
namespace App\Services;

class SimleCrudService {
    public function __construct(public SlugService $slugService) {

    }
    public function create($model, $request)
    {
        $data = $request->all();

        if($data['title']) {
            $data['slug'] = $this->slugService->sluggableArray($data['title']);
        }

        $model::create($request->all());
    }

    public function update($model, $request)
    {
        $model->update($request->all());
    }
}
