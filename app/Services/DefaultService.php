<?php
namespace App\Services;

class DefaultService {
    public function changeDefault($model, $modelAll) {
        $modelAll::query()->update(['is_default' =>  false]);
        $model->update(['is_default' =>  true]);
    }
}
