<?php

namespace App\Models;

use CodeIgniter\Model;

class SeniorGmAssessmentModel extends Model
{
    protected $table = 'senior_gm_assessment';
    protected $primaryKey = 'id';
    protected $allowedFields = ['year', 'employee_id',  'final_grades'];

    public function getTotalDataSenior($currentYear)
    {
        $count = $this->where('year', $currentYear)->countAllResults();

        return $count;
    }

}