<?php

namespace App\Models;

use CodeIgniter\Model;

class AssessmentDepartmentTargetModel extends Model
{
    protected $table = 'assessment_department_target';
    protected $primaryKey = 'id';
    protected $allowedFields = ['year', 'status', 'status_detail', 'employee_id',  'parameter', 'remark', 'weight'];

    public function getNomorStatus($year, $employee_id)
    {
        $query = $this->select('status_detail')->where('year', $year)->where('employee_id', $employee_id)->orderBy('id', 'DESC')->limit(1)->get()->getRow();

        if ($query && is_numeric($query->status_detail)) {
            return (int) $query->status_detail;
        } else {
            return null;
        }
    }

    public function cekTotalWeight($year, $employee_id)
    {
        $query = $this->selectSum('weight')
            ->where('year', $year)
            ->where('employee_id', $employee_id)
            ->get();

        $result = $query->getRowArray();

        return isset($result['weight']) ? (int) $result['weight'] : 0;
    }

    public function isDuplicate($employee_id, $parameter, $remark, $wight)
    {
        $item = $this->where('employee_id', $employee_id)
            ->where('parameter', $parameter)
            ->where('remark', $remark)
            ->where('weight', $wight)
            ->first();

        return $item !== null;
    }

    public function getMaxStatusDetail($year, $status)
    {
        $result = $this->where('year', $year)
                    ->where('status', $status)
                    ->selectMax('status_detail')
                    ->first();
        
        return $result ? $result['status_detail'] : null;
    }
}