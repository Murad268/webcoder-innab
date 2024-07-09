<?php
namespace App\Services;

class SimleCrudService {
    public function create($model, $request)
    {
        $model::create($request->all());
    }

    public function update($model, $request)
    {
        $model->update($request->all());
    }
}
