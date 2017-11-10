<?php

namespace App\Models\Enums;

use MabeEnum\Enum;

class InvoiceStatus extends Enum
{
	const DRAFT = 'draft';
	const SUBMITTED = 'submitted';
	const AUTHORIZED = 'authorized';
	const SENT = 'sent';
	const PAID = 'paid';
	const VOIDED = 'voided';
}