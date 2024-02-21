<?php

namespace App\Models;

use CodeIgniter\Model;

class AccountModel extends Model
{
    protected $table = 'employee_account';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_name', 'user_id', 'email', 'password', 'role'];

    public function isDuplicate($user_id)
    {
        $item = $this->where('user_id', $user_id)
            ->first();

        return $item !== null;
    }

}
