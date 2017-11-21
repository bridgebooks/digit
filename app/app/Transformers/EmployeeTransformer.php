<?php

namespace App\Transformers;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use App\Models\Employee;

/**
 * Class EmployeeTransformer
 * @package namespace App\Transformers;
 */
class EmployeeTransformer extends TransformerAbstract
{

    /**
     * @param string $dob
     * @return int|null
     */
    private function getAge(string $dob)
    {
        if (is_null($dob)) {
            return NULL;
        }

        $now = new Carbon();
        $past = new Carbon($dob);

        return $now->diffInYears($past);
    }

    /**
     * Transform the \Employee entity
     * @param \Employee $model
     *
     * @return array
     */
    public function transform(Employee $model)
    {
        return [
            'id' => $model->id,
            'org_id' => $model->org_id,
            'user_id' => $model->user_id,
            'first_name' => $model->first_name,
            'last_name' => $model->last_name,
            'gender' => $model->gender,
            'date_of_birth' => $model->date_of_birth->getTimestamp() * 1000,
            'age' => $this->getAge($model->date_of_birth),
            'role' => $model->role,
            'email' => $model->email,
            'phone' => $model->phone,
            'address_line_1' => $model->address_line_1,
            'address_line_2' => $model->address_line_2,
            'city_town' => $model->city_town,
            'state_region' => $model->state_region,
            'postal_zip' => $model->postal_zip,
            'country' => $model->country,
            'start_date' => $model->start_date->getTimestamp() * 1000,
            'termination_date' => $model->status == 'terminated' ? $model->termination_date->getTimestamp() * 1000 : NULL,
            'status' => $model->status,
            'created_at' => $model->created_at->getTimestamp() * 1000,
            'updated_at' => $model->updated_at
        ];
    }
}
