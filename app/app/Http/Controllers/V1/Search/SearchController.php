<?php

namespace App\Http\Controllers\V1\Search;

use App\Http\Controllers\V1\Controller;
use App\Repositories\ContactRepository;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    protected $contactRepository;

    public function __construct(ContactRepository $contacts)
    {
        $this->contactRepository = $contacts;
    }

    public function find(Request $request)
    {
        return $this->contactRepository->search($request->search);
    }
}