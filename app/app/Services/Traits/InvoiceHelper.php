<?php

namespace App\Services\Traits;

use App\Models\Invoice;
use DB;
use Carbon\Carbon;

trait InvoiceHelper
{
    public function getContacts(string $id, string $type)
    {
        $data = DB::table('contacts')
            ->leftJoin('invoices', 'contacts.id','=','invoices.contact_id')
            ->where('invoices.org_id', $id)
            ->where('invoices.type', $type)
            ->whereNotIn('invoices.status', [ 'paid', 'voided', 'submitted', 'draft' ])
            ->get(['contacts.id', 'contacts.name'])
            ->unique('id')
            ->values();

        return $data;
    }

    public function getInvoices(string $id, string $type, Carbon $start, Carbon $end)
    {
        return DB::table('invoices')
            ->leftJoin('contacts', 'invoices.contact_id', '=', 'contacts.id')
            ->where('invoices.contact_id', $id)
            ->where('invoices.type', $type)
            ->whereNotIn('invoices.status', [ 'paid', 'voided', 'submitted', 'draft' ])
            ->whereBetween('invoices.raised_at', [
                $start->toDateTimeString(),
                $end->toDateTimeString()
            ])
            ->sum('invoices.total');
    }

    public function getAllInvoicesBetween(string $id, string $type, Carbon $start, Carbon $end)
    {
        return Invoice::where('org_id', $id)
            ->where('type', $type)
            ->whereBetween('raised_at', [
                $start->startOfDay()->toDateTimeString(),
                $end->endOfDay()->toDateTimeString()
            ])
            ->get();
    }
}