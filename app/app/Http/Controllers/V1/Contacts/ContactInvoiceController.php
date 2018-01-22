<?php

namespace App\Http\Controllers\V1\Contacts;

use App\Http\Controllers\Traits\Pageable;
use App\Http\Controllers\V1\Controller;
use App\Repositories\ContactRepository;
use App\Repositories\InvoiceRepository;
use Illuminate\Http\Request;

class ContactInvoiceController extends Controller
{
    use Pageable;

    protected $invoiceRepository;
    protected $contactRepository;

    public function __construct(InvoiceRepository $invoiceRepository, ContactRepository $contactRepository)
    {
        $this->middleware('jwt.auth');
        $this->middleware('subscription.check');

        $this->invoiceRepository = $invoiceRepository;
        $this->contactRepository = $contactRepository;
    }

    public function index(Request $request, string $id)
    {
        // models per page
        $perPage = $request->input('perPage', 30);
        // current page
        $page = $request->input('page', 1);
        // status
        $status = $request->input('status', 'all');
        // type
        $type = $request->input('type', 'acc_rec');

        $items = $this->invoiceRepository->contactUnpaid($id, $type, $status);

        return $this->paginate($items['data'], $perPage, []);
    }
}