<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

trait Pageable
{
    /**
     * @param array $data
     * data to be paginated
     * @param integer $total
     * count of items in $data
     * @param integer $page
     * current page
     * @param integer $perPage
     * item per per page
     * @access public
     * @return LengthAwarePaginator
     */
    public function paginate(array $data, int $perPage, array $options)
    {
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $collection = collect($data);

        $currrentPageData = $collection->forPage($currentPage, $perPage)->values();

        \Log::info('collection', [$currentPage]);

        return new LengthAwarePaginator($currrentPageData, $collection->count(), $perPage, $currentPage);
    }
}