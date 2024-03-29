<?php

namespace App\Models;

use CodeIgniter\Model;

class SelfAssessmentModel extends Model
{
    protected $table = 'self_assessment';
    protected $primaryKey = 'id';
    protected $allowedFields = ['year', 'employee_id',  'final_grades'];

    public function getTotalDataSelf($currentYear)
    {
        $count = $this->where('year', $currentYear)->countAllResults();

        return $count;
    }

}