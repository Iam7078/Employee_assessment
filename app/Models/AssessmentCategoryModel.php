<?php

namespace App\Models;

use CodeIgniter\Model;

class AssessmentCategoryModel extends Model
{
    protected $table = 'assessment_category';
    protected $primaryKey = 'id';
    protected $allowedFields = ['year', 'status', 'category', 'weight'];

    public function getNomorStatus($year)
    {
        $query = $this->select('status')->where('year', $year)->orderBy('id', 'DESC')->limit(1)->get()->getRow();

        if ($query && is_numeric($query->status)) {
            return (int) $query->status;
        } else {
            return null;
        }
    }

    public function cekTotalWeight($year)
    {
        $query = $this->selectSum('weight')
            ->where('year', $year)
            ->get();

        $result = $query->getRowArray();

        return isset($result['weight']) ? (int) $result['weight'] : 0;
    }

    public function getWeightByLastStatus($year)
    {
        $query = $this->select('weight')
            ->where('year', $year)
            ->orderBy('id', 'DESC')
            ->orderBy('status', 'DESC')
            ->limit(1)
            ->get()
            ->getRow();

        if ($query && is_numeric($query->weight)) {
            return (float) $query->weight;
        } else {
            return null;
        }
    }

}