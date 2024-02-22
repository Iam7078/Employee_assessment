<?php

namespace App\Models;

use CodeIgniter\Model;

class LeaderAssessmentModel extends Model
{
    protected $table = 'leader_assessment';
    protected $primaryKey = 'id';
    protected $allowedFields = ['year', 'employee_id',  'final_grades'];

    public function getTotalDataLeader($currentYear)
    {
        $count = $this->where('year', $currentYear)->countAllResults();

        return $count;
    }

}