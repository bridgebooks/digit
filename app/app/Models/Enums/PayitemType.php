<?php

namespace App\Models\Enums;

use MabeEnum\Enum;

class PayitemType extends Enum
{
    const WAGES = 'wage';
    const ALLOWANCE = 'allowance';
    const DEDUCTION = 'deduction';
    const REIMBURSEMENT = 'reimbursement';
    const TAX = 'tax';
}