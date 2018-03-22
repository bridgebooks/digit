<?php


namespace App\Models\Enums;


use MabeEnum\Enum;

class InvoicePaymentStatus extends Enum
{
    const PENDING = 'pending';
    const VERIFIED = 'verified';
    const FAILED = 'failed';
}