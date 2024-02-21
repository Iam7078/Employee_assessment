<?php

namespace App\Models;

use CodeIgniter\Model;

class AssessmentParametersModel extends Model
{
    protected $table = 'assessment_parameter';
    protected $primaryKey = 'id';
    protected $allowedFields = ['year', 'status', 'status_detail', 'parameter', 'remark', 'weight'];

    public function getNomorStatus($year, $status)
    {
        $query = $this->select('status_detail')->where('year', $year)->where('status', $status)->orderBy('id', 'DESC')->limit(1)->get()->getRow();

        if ($query && is_numeric($query->status_detail)) {
            return (int) $query->status_detail;
        } else {
            return null;
        }
    }

    public function cekTotalWeight($year, $status)
    {
        $query = $this->selectSum('weight')
            ->where('year', $year)
            ->where('status', $status)
            ->get();

        $result = $query->getRowArray();

        return isset($result['weight']) ? (int) $result['weight'] : 0;
    }
}