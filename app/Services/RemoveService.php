<?php

namespace App\Services;

class RemoveService
{
    public function removeAll($models) {
        foreach ($models as $model) {
            $model->delete();
        }
    }
}
