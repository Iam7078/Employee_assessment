<?php

namespace App\Models;

use CodeIgniter\Model;

class LeaderAssessmentDetailModel extends Model
{
    protected $table = 'leader_assessment_detail';
    protected $primaryKey = 'id';
    protected $allowedFields = ['year', 'status', 'status_detail', 'employee_id',  'value'];

}