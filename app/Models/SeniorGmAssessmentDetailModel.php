<?php

namespace App\Models;

use CodeIgniter\Model;

class SeniorGmAssessmentDetailModel extends Model
{
    protected $table = 'senior_gm_assessment_detail';
    protected $primaryKey = 'id';
    protected $allowedFields = ['year', 'status', 'status_detail', 'employee_id',  'value'];

}