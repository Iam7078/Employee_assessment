<?php

namespace App\Models;

use CodeIgniter\Model;

class EmployeeModel extends Model
{
    protected $table = 'employee_detail';
    protected $primaryKey = 'id';
    protected $allowedFields = ['employee_name', 'employee_id', 'department', 'unit', 'direct_leader'];

    public function isDuplicate($employee_id)
    {
        $item = $this->where('employee_id', $employee_id)
            ->first();

        return $item !== null;
    }

    public function getTotalDataCount()
    {
        $count = $this->countAllResults();

        return $count;
    }
}