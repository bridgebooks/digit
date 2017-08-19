<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Pagination\LengthAwarePaginator;

trait Pageable
{
    /**
     * @param Array $data
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
    public function paginate(Array $data, $total, int $page, int $perPage, Array $options)
    {
        //calculate offset
        $offset = ($page * $perPage) - $perPage;
        //process data
        $processedData = array_slice($data, $offset, $perPage, true);
        //return paginated items
        return new LengthAwarePaginator($processedData, $total, $perPage, $page, $options);
    }
}