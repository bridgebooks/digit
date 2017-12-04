<?php

namespace App\Models\Enums;

use MabeEnum\Enum;

class PayitemType extends Enum
{
    const WAGES = 'wages';
    const ALLOWANCE = 'allowance';
    const DEDUCTION = 'deductions';
    const REIMBURSEMENT = 'reimbursement';
    const TAX = 'tax';
}