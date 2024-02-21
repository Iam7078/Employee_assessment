<?php

namespace App\Models;

use CodeIgniter\Model;

class SelfAssessmentDetailModel extends Model
{
    protected $table = 'self_assessment_detail';
    protected $primaryKey = 'id';
    protected $allowedFields = ['year', 'status', 'status_detail', 'employee_id',  'value'];

}