<?php

namespace App\Models;

use CodeIgniter\Model;

class ScoreProportionModel extends Model
{
    protected $table = 'score_proportion';
    protected $primaryKey = 'id';
    protected $allowedFields = ['year', 'self', 'leader', 'senior_gm'];

}