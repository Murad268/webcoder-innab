<?php

namespace App\Services;

use Illuminate\Http\Request;

class GeneralService
{
    public function handleIndex(Request $request, $repository, $itemsPerPage, $filterKey = 'category_id')
    {
        $q = $request->q;
        $selectedItems = $request->input('selectedItems', []);
        
        if ($q) {
            $items = $repository->search($q, $itemsPerPage);
        } else {
            $items = $repository->all($itemsPerPage);
        }

        if ($selectedItems) {
            $items = $repository->findWhereInGetPaginate($selectedItems, $itemsPerPage, $filterKey);
        }

        return [
            'items' => $items,
            'q' => $q,
            'selectedItems' => $selectedItems,
        ];
    }
}
