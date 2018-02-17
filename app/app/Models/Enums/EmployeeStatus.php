<?php

namespace App\Models\Enums;

use MabeEnum\Enum;

class EmployeeStatus extends Enum
{
	const ACTIVE = 'active';
	const TERMINATED = 'terminated';
}