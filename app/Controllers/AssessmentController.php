<?php

namespace App\Controllers;

use App\Models\AccountModel;
use App\Models\AssessmentCategoryModel;
use App\Models\AssessmentDepartmentTargetModel;
use App\Models\AssessmentParametersModel;
use App\Models\EmployeeModel;

use App\Models\LeaderAssessmentDetailModel;
use App\Models\LeaderAssessmentModel;
use App\Models\ScoreProportionModel;
use App\Models\SelfAssessmentDetailModel;
use App\Models\SelfAssessmentModel;
use App\Models\SeniorGmAssessmentDetailModel;
use App\Models\SeniorGmAssessmentModel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AssessmentController extends BaseController
{
    public function index(): string
    {
        return view('auth/login');
    }

    // View management
    public function checkAccess($segment)
    {
        if ($segment === 'home') {
            if (session('isLoggedIn')) {
                return $this->getDataDash();
            }
            return view('auth/login');
        } elseif ($segment === 'dash') {
            return $this->getDataDash();
        } elseif ($segment === 'profil') {
            return $this->getDataProfil();
        } elseif ($segment === 'dEm') {
            return view('data_employee');
        } elseif ($segment === 'dAcc') {
            return view('data_account');
        } elseif ($segment === 'dCat') {
            return view('data_category');
        } elseif ($segment === 'dPar') {
            return $this->getDataParameter();
        } elseif ($segment === 'dTar') {
            return view('data_department_targets');
        } elseif ($segment === 'dTarLe') {
            return view('data_department_leader');
        } elseif ($segment === 'dReSel') {
            return view('data_result_self');
        } elseif ($segment === 'dReLea') {
            return view('data_result_leader');
        } elseif ($segment === 'dReSen') {
            return view('data_result_senior_gm');
        } elseif ($segment === 'dScPr') {
            return view('data_score_proportion');
        } elseif ($segment === 'dFinRe') {
            return view('data_result_final');
        } elseif ($segment === 'aSel') {
            return $this->getDataSelfAssessment();
        } elseif ($segment === 'aLea') {
            return view('assess_leader_assessment');
        } elseif ($segment === 'aSen') {
            return view('assess_senior_gm_assessment');
        } elseif ($segment === 'rSel') {
            return $this->getDataAllReportSelf();
        } elseif ($segment === 'rSelDe') {
            return $this->getDataReportSelf();
        } elseif ($segment === 'rLea') {
            return $this->getDataAllReportLeader();
        } elseif ($segment === 'rLeaTa') {
            return $this->getDataReportLeader();
        } elseif ($segment === 'rLeaDe') {
            return $this->getDataReportLeaderDetail();
        } elseif ($segment === 'rSen') {
            return $this->getDataAllReportSenior();
        } elseif ($segment === 'rSenTa') {
            return $this->getDataReportSenior();
        } elseif ($segment === 'rSenDe') {
            return $this->getDataReportSeniorDetail();
        }
    }
    public function employe()
    {
        $segment = $this->request->uri->getSegment(2);

        if (!session('isLoggedIn')) {
            return view('auth/login');
        }

        return $this->checkAccess($segment);
    }
    // End of view management


    // Login User
    public function login()
    {
        if ($this->request->isAJAX()) {
            $jsonData = $this->request->getJSON();
            $email = $jsonData->email;
            $password = $jsonData->password;
            $model = new AccountModel();
            $user = $model->where('email', $email)->first();

            if ($user && $password === $user['password']) {
                session()->set([
                    'isLoggedIn' => true,
                    'userKey' => $user['id'],
                    'userId' => $user['user_id'],
                    'userRole' => $user['role'],
                    'userName' => $user['user_name'],
                    'userEmail' => $user['email'],
                    'userPassword' => $user['password'],
                ]);

                $response = [
                    'status' => 'success',
                    'message' => 'Login berhasil',
                    'redirect' => '/Em/dash'
                ];
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Email and password are invalid'
                ];
            }

            return $this->response->setJSON($response);
        }
    }


    public function logout()
    {
        // Hapus semua data sesi
        session()->destroy();

        return view('auth/login');
    }


    // Dashboard
    public function getDataDash()
    {
        $currentYear = date('Y');

        $employeeModel = new EmployeeModel();
        $selfAssess = new SelfAssessmentModel();
        $leaderAssess = new LeaderAssessmentModel();
        $seniorGmAssess = new SeniorGmAssessmentModel();

        $totalDataCount = $employeeModel->getTotalDataCount();
        $totalDataSelf = $selfAssess->getTotalDataSelf($currentYear);
        $totalDataLeader = $leaderAssess->getTotalDataLeader($currentYear);
        $totalDataSeniorGm = $seniorGmAssess->getTotalDataSenior($currentYear);

        $data['year'] = $currentYear;
        $data['totalEmployee'] = $totalDataCount;
        $data['totalSelf'] = $totalDataSelf;
        $data['totalLeader'] = $totalDataLeader;
        $data['totalSenior'] = $totalDataSeniorGm;

        return view('dashboard', $data);
    }
    // Doneee


    // Profil
    public function getDataProfil()
    {
        $year = date('Y');
        $employeeModel = new EmployeeModel();
        $categoryModel = new AssessmentCategoryModel();
        $departmentModel = new AssessmentDepartmentTargetModel();

        $statusCek = $categoryModel->getNomorStatus($year);
        $data['detail'] = $employeeModel->where('employee_id', session('userId'))->first();
        $data['target'] = $departmentModel->where('status', $statusCek)->where('employee_id', session('userId'))->findAll();

        return view('profil', $data);
    }
    public function editPassword()
    {
        $request = $this->request->getJSON();
        $itemModel = new AccountModel();
        $cekPass = $itemModel->where('id', $request->id)->first();
        $passNow = $cekPass['password'];

        if ($passNow !== $request->old_password) {
            return $this->response->setJSON(['success' => false, 'message' => 'Passwords are not the same']);
        }

        $data = [
            'password' => $request->password
        ];

        $updated = $itemModel->update($request->id, $data);

        if ($updated) {
            return $this->response->setJSON(['success' => true, 'message' => 'Data changed successfully']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Data changed failed']);
        }
    }


    // Employee Data Management
    public function dataTabelEmployee()
    {
        $employeeModel = new EmployeeModel();

        $dataEmployee = $employeeModel->findAll();

        $data = [];
        $dataEmployee = array_reverse($dataEmployee);
        foreach ($dataEmployee as $item) {
            $data[] = [
                'id' => $item['id'],
                'employee_name' => $item['employee_name'],
                'employee_id' => $item['employee_id'],
                'department' => $item['department'],
                'unit' => $item['unit'],
                'direct_leader' => $item['direct_leader']
            ];
        }
        return $this->response->setJSON(['data' => $data]);
    }

    public function addDataEmployee()
    {
        $request = $this->request->getJSON();
        $itemModel = new EmployeeModel();

        $existingEmployee = $itemModel->where('employee_id', $request->employee_id)->first();
        if ($existingEmployee) {
            return $this->response->setJSON(['success' => false, 'message' => 'Data with this employee_id already exists']);
        }

        $data = [
            'employee_name' => $request->employee_name,
            'employee_id' => $request->employee_id,
            'department' => $request->department,
            'unit' => $request->unit,
            'direct_leader' => $request->direct_leader,
        ];

        if ($itemModel->insert($data)) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to save data']);
        }
    }
    public function editDataEmployee()
    {
        $request = $this->request->getJSON();
        $itemModel = new EmployeeModel();
        $data = [
            'employee_name' => $request->employee_name,
            'employee_id' => $request->employee_id,
            'department' => $request->department,
            'unit' => $request->unit,
            'direct_leader' => $request->direct_leader,
        ];

        $updated = $itemModel->update($request->id, $data);

        if ($updated) {
            return $this->response->setJSON(['success' => true, 'message' => 'Data changed successfully']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Data changed failed']);
        }
    }

    public function deleteDataEmployee()
    {
        $request = $this->request->getJSON();

        $itemModel = new EmployeeModel();
        $deleted = $itemModel->delete($request->id_item);

        if ($deleted) {
            return $this->response->setJSON(['success' => true, 'message' => 'Data deleted successfully']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Data failed to delete']);
        }
    }

    public function importExcelEmployee()
    {
        $data = [];

        $file = $this->request->getFile('excelFile');

        if ($file->isValid() && $file->getExtension() == 'xlsx') {
            try {
                $spreadsheet = IOFactory::load($file->getPathname());
                $worksheet = $spreadsheet->getActiveSheet();

                $itemModel = new EmployeeModel();

                foreach ($worksheet->getRowIterator(2) as $row) {
                    $cellIterator = $row->getCellIterator();

                    $employee_name = $cellIterator->seek('B')->current()->getValue();
                    $employee_id = $cellIterator->seek('C')->current()->getValue();
                    $department = $cellIterator->seek('D')->current()->getValue();
                    $unit = $cellIterator->seek('E')->current()->getValue();
                    $direct_leader = $cellIterator->seek('F')->current()->getValue();

                    if (empty($employee_id) && empty($employee_name) && empty($department) && empty($unit) && empty($direct_leader)) {
                        continue;
                    }

                    if ($itemModel->isDuplicate($employee_id)) {
                        $errorMessage = "Duplicate data was found for Employee Name: $employee_name, Employe Id: $employee_id.";
                        return $this->response->setJSON(['success' => false, 'error' => $errorMessage])->setStatusCode(400);
                    }

                    $rowData = [
                        'employee_name' => $employee_name,
                        'employee_id' => $employee_id,
                        'department' => $department,
                        'unit' => $unit,
                        'direct_leader' => $direct_leader
                    ];

                    $itemModel->insert($rowData);

                    $data['messages'][] = "Data imported successfully";
                }
                $data['success'] = true;
            } catch (\Throwable $th) {
                $data['error'] = $th->getMessage();
                $data['success'] = false;
            }
        } else {
            $data['error'] = 'Invalid Excel file';
            $data['success'] = false;
        }
        return $this->response->setJSON($data);
    }
    // Doneee



    // Account Data Management
    public function dataTabelAccount()
    {
        $accountModel = new AccountModel();

        $dataAccount = $accountModel->findAll();

        $data = [];
        $dataAccount = array_reverse($dataAccount);
        foreach ($dataAccount as $item) {
            $data[] = [
                'id' => $item['id'],
                'user_name' => $item['user_name'],
                'user_id' => $item['user_id'],
                'role' => $item['role'],
                'email' => $item['email'],
                'password' => $item['password']
            ];
        }
        return $this->response->setJSON(['data' => $data]);
    }

    public function addDataUser()
    {
        $request = $this->request->getJSON();
        $itemModel = new AccountModel();

        $existingEmployee = $itemModel->where('user_id', $request->user_id)->first();
        if ($existingEmployee) {
            return $this->response->setJSON(['success' => false, 'message' => 'Data with this user_id already exists']);
        }

        $data = [
            'user_name' => $request->user_name,
            'user_id' => $request->user_id,
            'role' => $request->role,
            'email' => $request->email,
            'password' => $request->password,
        ];

        if ($itemModel->insert($data)) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to save data']);
        }
    }

    public function editDataUser()
    {
        $request = $this->request->getJSON();
        $itemModel = new AccountModel();
        $data = [
            'user_name' => $request->user_name,
            'user_id' => $request->user_id,
            'role' => $request->role,
            'email' => $request->email,
            'password' => $request->password,
        ];

        $updated = $itemModel->update($request->id, $data);

        if ($updated) {
            return $this->response->setJSON(['success' => true, 'message' => 'Data changed successfully']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Data changed failed']);
        }
    }

    public function deleteDataUser()
    {
        $request = $this->request->getJSON();

        $itemModel = new AccountModel();
        $deleted = $itemModel->delete($request->id_item);

        if ($deleted) {
            return $this->response->setJSON(['success' => true, 'message' => 'Data deleted successfully']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Data failed to delete']);
        }
    }

    public function importExcelUser()
    {
        $data = [];

        $file = $this->request->getFile('excelFile');

        if ($file->isValid() && $file->getExtension() == 'xlsx') {
            try {
                $spreadsheet = IOFactory::load($file->getPathname());
                $worksheet = $spreadsheet->getActiveSheet();

                $itemModel = new AccountModel();

                foreach ($worksheet->getRowIterator(2) as $row) {
                    $cellIterator = $row->getCellIterator();

                    $user_name = $cellIterator->seek('B')->current()->getValue();
                    $user_id = $cellIterator->seek('C')->current()->getValue();
                    $role = $cellIterator->seek('D')->current()->getValue();
                    $email = $cellIterator->seek('E')->current()->getValue();
                    $password = $cellIterator->seek('F')->current()->getValue();

                    if (empty($user_id) && empty($user_name) && empty($role) && empty($email) && empty($password)) {
                        continue;
                    }

                    if ($itemModel->isDuplicate($user_id)) {
                        $errorMessage = "Duplicate data was found for User Name: $user_name, User Id: $user_id.";
                        return $this->response->setJSON(['success' => false, 'error' => $errorMessage])->setStatusCode(400);
                    }

                    $rowData = [
                        'user_name' => $user_name,
                        'user_id' => $user_id,
                        'role' => $role,
                        'email' => $email,
                        'password' => $password
                    ];

                    $itemModel->insert($rowData);

                    $data['messages'][] = "Data imported successfully";
                }
                $data['success'] = true;
            } catch (\Throwable $th) {
                $data['error'] = $th->getMessage();
                $data['success'] = false;
            }
        } else {
            $data['error'] = 'Invalid Excel file';
            $data['success'] = false;
        }
        return $this->response->setJSON($data);
    }



    // Assessment Category Data Management
    public function dataTabelCategory()
    {
        $categoryModel = new AssessmentCategoryModel();

        $dataCategory = $categoryModel->findAll();

        $data = [];
        $dataCategory = array_reverse($dataCategory);
        foreach ($dataCategory as $item) {
            $data[] = [
                'id' => $item['id'],
                'year' => $item['year'],
                'status' => $item['status'],
                'category' => $item['category'],
                'weight' => $item['weight']
            ];
        }
        return $this->response->setJSON(['data' => $data]);
    }
    public function addAssessmentCategoryData()
    {
        $year = date('Y');
        $request = $this->request->getJSON();
        $categoryModel = new AssessmentCategoryModel();

        $totalWeight = $categoryModel->cekTotalWeight($year);
        $sisaBobot = 100 - $totalWeight;
        if (($totalWeight + $request->weight) > 100) {
            $errorMessage = "Weight exceeds target in $year, Remaining weight : $sisaBobot";
            return $this->response->setJSON(['success' => false, 'message' => $errorMessage]);
        }

        $statusCek = $categoryModel->getNomorStatus($year);

        $data = [
            'status' => ($statusCek + 1),
            'category' => $request->category,
            'weight' => $request->weight
        ];

        if ($categoryModel->insert($data)) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to save data']);
        }
    }
    public function editAssessmentCategoryData()
    {
        $request = $this->request->getJSON();
        $categoryModel = new AssessmentCategoryModel();
        $year = $request->year;

        $totalWeight = $categoryModel->cekTotalWeight($year);
        $sisaBobot = 100 - ($totalWeight - $request->weight_awal);
        if ($request->weight > $sisaBobot) {
            $errorMessage = "Weight exceeds target in $year, Remaining weight : $sisaBobot";
            return $this->response->setJSON(['success' => false, 'message' => $errorMessage]);
        }

        $data = [
            'category' => $request->category,
            'weight' => $request->weight
        ];

        $updated = $categoryModel->update($request->id, $data);

        if ($updated) {
            return $this->response->setJSON(['success' => true, 'message' => 'Data changed successfully']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Data changed failed']);
        }
    }
    public function deleteAssessmentCategoryData()
    {
        $request = $this->request->getJSON();

        $categoryModel = new AssessmentCategoryModel();
        $deleted = $categoryModel->delete($request->id_item);

        if ($deleted) {
            return $this->response->setJSON(['success' => true, 'message' => 'Data deleted successfully']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Data failed to delete']);
        }
    }
    // Doneee



    // Assessment Parameters Data Management
    public function getDataParameter()
    {
        $year = date('Y');
        $categoryModel = new AssessmentCategoryModel();
        $data['category'] = $categoryModel->where('year', $year)->findAll();

        return view('data_parameter', $data);
    }
    public function dataTabelParameter()
    {
        $year = date('Y');
        $categoryModel = new AssessmentCategoryModel();
        $parameterModel = new AssessmentParametersModel();

        $dataParameter = $parameterModel->where('year', $year)->findAll();

        $data = [];
        foreach ($dataParameter as $item) {
            $dataCategory = $categoryModel->where('year', $item['year'])->where('status', $item['status'])->first();
            $data[] = [
                'id' => $item['id'],
                'year' => $item['year'],
                'status' => $item['status'],
                'status_detail' => $item['status_detail'],
                'parameter' => $item['parameter'],
                'remark' => $item['remark'],
                'weight' => $item['weight'],
                'category' => $dataCategory['category'],
                'weight_category' => $dataCategory['weight']
            ];
        }
        return $this->response->setJSON(['data' => $data]);
    }
    public function addAssessmentParameterData()
    {
        $year = date('Y');
        $request = $this->request->getJSON();
        $parameterModel = new AssessmentParametersModel();
        $status = $request->status;
        $maxWeight = $request->max_weight;

        $totalWeight = $parameterModel->cekTotalWeight($year, $status);
        $remainingWeight = $maxWeight - $totalWeight;
        if ($request->weight > $remainingWeight) {
            $errorMessage = "Weight exceeds target in $year, Remaining weight : $remainingWeight";
            return $this->response->setJSON(['success' => false, 'message' => $errorMessage]);
        }

        $statusCek = $parameterModel->getNomorStatus($year, $status);

        $data = [
            'status' => $status,
            'status_detail' => ($statusCek + 1),
            'parameter' => $request->parameter,
            'remark' => $request->remark,
            'weight' => $request->weight
        ];

        if ($parameterModel->insert($data)) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to save data']);
        }
    }
    public function editAssessmentParameterData()
    {
        $request = $this->request->getJSON();
        $year = $request->year;
        $status = $request->status;
        $initialWeight = $request->initial_weight;

        $categoryModel = new AssessmentCategoryModel();
        $parameterModel = new AssessmentParametersModel();

        $dataCategory = $categoryModel->where('year', $year)->where('status', $status)->first();
        $maxWeight = $dataCategory['weight'];

        $totalWeight = $parameterModel->cekTotalWeight($year, $status);
        $sisaBobot = $maxWeight - ($totalWeight - $initialWeight);
        if ($request->weight > $sisaBobot) {
            $errorMessage = "Weight exceeds target in $year, Remaining weight : $sisaBobot";
            return $this->response->setJSON(['success' => false, 'message' => $errorMessage]);
        }

        $data = [
            'parameter' => $request->parameter,
            'remark' => $request->remark,
            'weight' => $request->weight
        ];

        $updated = $parameterModel->update($request->id, $data);

        if ($updated) {
            return $this->response->setJSON(['success' => true, 'message' => 'Data changed successfully']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Data changed failed']);
        }
    }
    public function deleteAssessmentParameterData()
    {
        $request = $this->request->getJSON();

        $parameterModel = new AssessmentParametersModel();
        $deleted = $parameterModel->delete($request->id_item);

        if ($deleted) {
            return $this->response->setJSON(['success' => true, 'message' => 'Data deleted successfully']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Data failed to delete']);
        }
    }
    // Doneee



    // Department Target Management Data
    public function dataTabelDepartmentTarget()
    {
        $employeeModel = new EmployeeModel();
        $departmentTargetModel = new AssessmentDepartmentTargetModel();

        $dataDepartmentTarget = $departmentTargetModel->findAll();

        $data = [];
        $dataDepartmentTarget = array_reverse($dataDepartmentTarget);
        foreach ($dataDepartmentTarget as $item) {
            $dataEmployee = $employeeModel->where('employee_id', $item['employee_id'])->first();
            $data[] = [
                'id' => $item['id'],
                'year' => $item['year'],
                'status' => $item['status'],
                'status_detail' => $item['status_detail'],
                'employee_name' => $dataEmployee['employee_name'],
                'employee_id' => $item['employee_id'],
                'parameter' => $item['parameter'],
                'remark' => $item['remark'],
                'weight' => $item['weight']
            ];
        }
        return $this->response->setJSON(['data' => $data]);
    }
    public function addAssessmentDepartmentTarget()
    {
        $year = date('Y');
        $request = $this->request->getJSON();
        $employeeModel = new EmployeeModel();
        $categoryModel = new AssessmentCategoryModel();
        $departmentTargetModel = new AssessmentDepartmentTargetModel();
        $employee_id = $request->employee_id;

        $cekDataEmployee = $employeeModel->where('employee_id', $employee_id)->first();
        if (!$cekDataEmployee) {
            $errorMessage = "Employee data with ID : $employee_id, not found";
            return $this->response->setJSON(['success' => false, 'message' => $errorMessage]);
        }

        $totalWeight = $departmentTargetModel->cekTotalWeight($year, $employee_id);
        $status = $categoryModel->getNomorStatus($year);

        $maxWidth = $categoryModel->getWeightByLastStatus($year);
        $remainingWeight = $maxWidth - $totalWeight;

        if ($request->weight > $remainingWeight) {
            $errorMessage = "Weight exceeds target in ID : $employee_id, Remaining weight : $remainingWeight";
            return $this->response->setJSON(['success' => false, 'message' => $errorMessage]);
        }

        $statusCek = $departmentTargetModel->getNomorStatus($year, $employee_id);

        $data = [
            'status' => $status,
            'status_detail' => ($statusCek + 1),
            'employee_id' => $employee_id,
            'parameter' => $request->parameter,
            'remark' => $request->remark,
            'weight' => $request->weight
        ];

        if ($departmentTargetModel->insert($data)) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to save data']);
        }
    }
    public function editAssessmentDepartmentTarget()
    {
        $request = $this->request->getJSON();
        $year = $request->year;
        $employee_id = $request->employee_id;
        $initialWeight = $request->initial_weight;

        $categoryModel = new AssessmentCategoryModel();

        $departmentModel = new AssessmentDepartmentTargetModel();

        $maxWeight = $categoryModel->getWeightByLastStatus($year);

        $totalWeight = $departmentModel->cekTotalWeight($year, $employee_id);
        $sisaBobot = $maxWeight - ($totalWeight - $initialWeight);
        if ($request->weight > $sisaBobot) {
            $errorMessage = "Weight exceeds target in $year, Remaining weight : $sisaBobot";
            return $this->response->setJSON(['success' => false, 'message' => $errorMessage]);
        }

        $data = [
            'parameter' => $request->parameter,
            'remark' => $request->remark,
            'weight' => $request->weight
        ];

        $updated = $departmentModel->update($request->id, $data);

        if ($updated) {
            return $this->response->setJSON(['success' => true, 'message' => 'Data changed successfully']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Data changed failed']);
        }
    }
    public function deleteAssessmentDepartmentTarget()
    {
        $request = $this->request->getJSON();

        $departmentModel = new AssessmentDepartmentTargetModel();
        $deleted = $departmentModel->delete($request->id);

        if ($deleted) {
            return $this->response->setJSON(['success' => true, 'message' => 'Data deleted successfully']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Data failed to delete']);
        }
    }

    public function importAllDataDepartmentTarget()
    {
        $data = [];

        $file = $this->request->getFile('excelFile');

        if ($file->isValid() && $file->getExtension() == 'xlsx') {
            try {
                $spreadsheet = IOFactory::load($file->getPathname());
                $worksheet = $spreadsheet->getActiveSheet();

                $year = date('Y');
                $employeeModel = new EmployeeModel();
                $categoryModel = new AssessmentCategoryModel();
                $departmentTargetModel = new AssessmentDepartmentTargetModel();

                foreach ($worksheet->getRowIterator(2) as $row) {
                    $cellIterator = $row->getCellIterator();

                    $employee_id = $cellIterator->seek('B')->current()->getValue();
                    $parameter = $cellIterator->seek('C')->current()->getValue();
                    $remark = $cellIterator->seek('D')->current()->getValue();
                    $weight = (int) $cellIterator->seek('E')->current()->getValue();

                    if (empty($employee_id) || empty($parameter) || empty($remark) || empty($weight)) {
                        continue;
                    }

                    $cekDataEmployee = $employeeModel->where('employee_id', $employee_id)->first();
                    if (!$cekDataEmployee) {
                        $errorMessage = "Employee data with ID : $employee_id, not found";
                        return $this->response->setJSON(['success' => false, 'error' => $errorMessage]);
                    }

                    if ($departmentTargetModel->isDuplicate($employee_id, $parameter, $remark, $weight)) {
                        $errorMessage = "Duplicate data was found for employee_id: $employee_id, parameter: $parameter, remark : $remark, weight: $weight.";
                        return $this->response->setJSON(['success' => false, 'error' => $errorMessage])->setStatusCode(400);
                    }

                    $totalWeight = $departmentTargetModel->cekTotalWeight($year, $employee_id);
                    $status = $categoryModel->getNomorStatus($year);

                    $maxWidth = $categoryModel->getWeightByLastStatus($year);
                    $remainingWeight = $maxWidth - $totalWeight;

                    if ($weight > $remainingWeight) {
                        $errorMessage = "Weight exceeds target in ID : $employee_id, Remaining weight : $remainingWeight";
                        return $this->response->setJSON(['success' => false, 'error' => $errorMessage])->setStatusCode(400);
                    }

                    $statusCek = $departmentTargetModel->getNomorStatus($year, $employee_id);

                    $rowData = [
                        'status' => $status,
                        'status_detail' => ($statusCek + 1),
                        'employee_id' => $employee_id,
                        'parameter' => $parameter,
                        'remark' => $remark,
                        'weight' => $weight
                    ];

                    $departmentTargetModel->insert($rowData);

                    $data['messages'][] = "Data imported successfully";
                }
                $data['success'] = true;
            } catch (\Throwable $th) {
                $data['error'] = $th->getMessage();
                $data['success'] = false;
            }
        } else {
            $data['error'] = 'Invalid Excel file';
            $data['success'] = false;
        }
        return $this->response->setJSON($data);
    }


    // SA Result Management Data
    public function dataTabelSaResult()
    {
        $year = date('Y');
        $employeeModel = new EmployeeModel();
        $selfResultModel = new SelfAssessmentModel();

        $dataEmployee = $employeeModel->findAll();

        $data = [];
        $dataEmployee = array_reverse($dataEmployee);
        foreach ($dataEmployee as $item) {
            $dataNilai = $selfResultModel->where('year', $year)->where('employee_id', $item['employee_id'])->first();
            $finalGrades = isset($dataNilai['final_grades']) ? $dataNilai['final_grades'] : 0;
            $data[] = [
                'id' => $item['id'],
                'employee_name' => $item['employee_name'],
                'employee_id' => $item['employee_id'],
                'department' => $item['department'],
                'unit' => $item['unit'],
                'direct_leader' => $item['direct_leader'],
                'final_grades' => $finalGrades
            ];
        }
        return $this->response->setJSON(['data' => $data]);
    }

    // LA Result Management Data
    public function dataTabelLaResult()
    {
        $year = date('Y');
        $employeeModel = new EmployeeModel();
        $leaderResultModel = new LeaderAssessmentModel();

        $dataEmployee = $employeeModel->findAll();

        $data = [];
        $dataEmployee = array_reverse($dataEmployee);
        foreach ($dataEmployee as $item) {
            $dataNilai = $leaderResultModel->where('year', $year)->where('employee_id', $item['employee_id'])->first();
            $finalGrades = isset($dataNilai['final_grades']) ? $dataNilai['final_grades'] : 0;
            $data[] = [
                'id' => $item['id'],
                'employee_name' => $item['employee_name'],
                'employee_id' => $item['employee_id'],
                'department' => $item['department'],
                'unit' => $item['unit'],
                'direct_leader' => $item['direct_leader'],
                'final_grades' => $finalGrades
            ];
        }
        return $this->response->setJSON(['data' => $data]);
    }

    // Senior GM A Result Management Data
    public function dataTabelSeniorGmAResult()
    {
        $year = date('Y');
        $employeeModel = new EmployeeModel();
        $seniorGmResultModel = new SeniorGmAssessmentModel();

        $dataEmployee = $employeeModel->findAll();

        $data = [];
        $dataEmployee = array_reverse($dataEmployee);
        foreach ($dataEmployee as $item) {
            $dataNilai = $seniorGmResultModel->where('year', $year)->where('employee_id', $item['employee_id'])->first();
            $finalGrades = isset($dataNilai['final_grades']) ? $dataNilai['final_grades'] : 0;
            $data[] = [
                'id' => $item['id'],
                'employee_name' => $item['employee_name'],
                'employee_id' => $item['employee_id'],
                'department' => $item['department'],
                'unit' => $item['unit'],
                'direct_leader' => $item['direct_leader'],
                'final_grades' => $finalGrades
            ];
        }
        return $this->response->setJSON(['data' => $data]);
    }


    // Leader
    public function dataTabelSubordinate()
    {
        $year = date('Y');
        $employeeModel = new EmployeeModel();
        $categoryModel = new AssessmentCategoryModel();
        $departmentModel = new AssessmentDepartmentTargetModel();

        $maxWeight = $categoryModel->getWeightByLastStatus($year);

        $dataEmployee = $employeeModel->where('direct_leader', session('userName'))->findAll();

        $data = [];
        $dataEmployee = array_reverse($dataEmployee);
        foreach ($dataEmployee as $item) {
            $totalWeight = $departmentModel->cekTotalWeight($year, $item['employee_id']);
            $userStatusCol = 'red';
            $userStatusText = 'Not yet';

            if ($maxWeight == $totalWeight) {
                $userStatusCol = 'green';
                $userStatusText = 'Already';
            }

            $data[] = [
                'id' => $item['id'],
                'employee_name' => $item['employee_name'],
                'employee_id' => $item['employee_id'],
                'department' => $item['department'],
                'unit' => $item['unit'],
                'status_color' => $userStatusCol,
                'status_text' => $userStatusText
            ];
        }
        return $this->response->setJSON(['data' => $data]);
    }
    public function detailSubordinate()
    {
        $employee_id = $this->request->getGet('employee_id');

        $year = date('Y');
        $employeeModel = new EmployeeModel();
        $categoryModel = new AssessmentCategoryModel();
        $dataLastStatus = $categoryModel->getNomorStatus($year);

        $data['category'] = $categoryModel->where('year', $year)->where('status', $dataLastStatus)->first();
        $data['employee'] = $employeeModel->where('employee_id', $employee_id)->first();

        return view('data_department_subordinate', $data);
    }
    public function dataTabelSubordinateTarget()
    {
        $year = date('Y');
        $employee_id = $this->request->getGet('employee_id');
        $departmentModel = new AssessmentDepartmentTargetModel();

        $dataDepartment = $departmentModel->where('year', $year)->where('employee_id', $employee_id)->findAll();

        $data = [];
        foreach ($dataDepartment as $item) {
            $data[] = [
                'id' => $item['id'],
                'year' => $item['year'],
                'parameter' => $item['parameter'],
                'remark' => $item['remark'],
                'weight' => $item['weight']
            ];
        }
        return $this->response->setJSON(['data' => $data]);
    }
    public function importDataDepartmentTargetSub()
    {
        $data = [];

        $file = $this->request->getFile('excelFile');

        if ($file->isValid() && $file->getExtension() == 'xlsx') {
            try {
                $spreadsheet = IOFactory::load($file->getPathname());
                $worksheet = $spreadsheet->getActiveSheet();

                $year = date('Y');
                $employeeModel = new EmployeeModel();
                $categoryModel = new AssessmentCategoryModel();
                $departmentTargetModel = new AssessmentDepartmentTargetModel();

                foreach ($worksheet->getRowIterator(2) as $row) {
                    $cellIterator = $row->getCellIterator();

                    $employee_id = $cellIterator->seek('B')->current()->getValue();
                    $parameter = $cellIterator->seek('C')->current()->getValue();
                    $remark = $cellIterator->seek('D')->current()->getValue();
                    $weight = (int) $cellIterator->seek('E')->current()->getValue();

                    if (empty($employee_id) || empty($parameter) || empty($remark) || empty($weight)) {
                        continue;
                    }

                    $cekDataEmployee = $employeeModel->where('employee_id', $employee_id)->first();
                    if (!$cekDataEmployee) {
                        $errorMessage = "Employee data with ID : $employee_id, not found";
                        return $this->response->setJSON(['success' => false, 'message' => $errorMessage]);
                    }

                    $cekSubordinate = $employeeModel->where('direct_leader', session('userName'))->where('employee_id', $employee_id)->first();
                    if (!$cekSubordinate) {
                        $errorMessage = "Employee with Id : $employee_id, not your subordinate.";
                        return $this->response->setJSON(['success' => false, 'error' => $errorMessage])->setStatusCode(400);
                    }

                    if ($departmentTargetModel->isDuplicate($employee_id, $parameter, $remark, $weight)) {
                        $errorMessage = "Duplicate data was found for employee_id: $employee_id, parameter: $parameter, remark : $remark, weight: $weight.";
                        return $this->response->setJSON(['success' => false, 'error' => $errorMessage])->setStatusCode(400);
                    }

                    $totalWeight = $departmentTargetModel->cekTotalWeight($year, $employee_id);
                    $status = $categoryModel->getNomorStatus($year);

                    $maxWidth = $categoryModel->getWeightByLastStatus($year);
                    $remainingWeight = $maxWidth - $totalWeight;

                    if ($weight > $remainingWeight) {
                        $errorMessage = "Weight exceeds target in ID : $employee_id, Remaining weight : $remainingWeight";
                        return $this->response->setJSON(['success' => false, 'error' => $errorMessage])->setStatusCode(400);
                    }

                    $statusCek = $departmentTargetModel->getNomorStatus($year, $employee_id);

                    $rowData = [
                        'status' => $status,
                        'status_detail' => ($statusCek + 1),
                        'employee_id' => $employee_id,
                        'parameter' => $parameter,
                        'remark' => $remark,
                        'weight' => $weight
                    ];

                    $departmentTargetModel->insert($rowData);

                    $data['messages'][] = "Data imported successfully";
                }
                $data['success'] = true;
            } catch (\Throwable $th) {
                $data['error'] = $th->getMessage();
                $data['success'] = false;
            }
        } else {
            $data['error'] = 'Invalid Excel file';
            $data['success'] = false;
        }
        return $this->response->setJSON($data);
    }



    // Self Assessment
    public function getDataSelfAssessment()
    {
        $year = date('Y');
        $categoryModel = new AssessmentCategoryModel();
        $data['year'] = $year;
        $data['category'] = $categoryModel->where('year', $year)->findAll();

        return view('assess_self_assessment', $data);
    }
    public function dataTabelSelfAssessment()
    {
        $year = date('Y');
        $parameterModel = new AssessmentParametersModel();
        $departmentTargetModel = new AssessmentDepartmentTargetModel();

        $dataParameter = $parameterModel->where('year', $year)->findAll();
        $dataDepartment = $departmentTargetModel->where('year', $year)->where('employee_id', session('userId'))->findAll();

        $data = [];
        foreach ($dataParameter as $item) {
            $data[] = [
                'id' => $item['id'],
                'year' => $item['year'],
                'status' => $item['status'],
                'status_detail' => $item['status_detail'],
                'parameter' => $item['parameter'],
                'remark' => $item['remark'],
                'weight' => $item['weight']
            ];
        }
        foreach ($dataDepartment as $item) {
            $data[] = [
                'id' => $item['id'],
                'year' => $item['year'],
                'status' => $item['status'],
                'status_detail' => $item['status_detail'],
                'parameter' => $item['parameter'],
                'remark' => $item['remark'],
                'weight' => $item['weight']
            ];
        }
        return $this->response->setJSON(['data' => $data]);
    }
    public function cekIdSelfResult()
    {
        $year = date('Y');
        $request = $this->request->getJSON();
        $idEmployee = $request->employee_id;

        $selfAssessmentModel = new SelfAssessmentModel();
        $categoryModel = new AssessmentCategoryModel();
        $departmentTargetModel = new AssessmentDepartmentTargetModel();

        $totalWeight = $departmentTargetModel->cekTotalWeight($year, $idEmployee);
        $maxWidth = $categoryModel->getWeightByLastStatus($year);

        $cekId = $selfAssessmentModel->where('employee_id', $idEmployee)->first();

        if ($cekId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Employees Have Been Assessed This Year']);
        }

        if ($totalWeight == $maxWidth) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Department targets have not been met']);
        }
    }

    public function addSelfResult()
    {
        $request = $this->request->getJSON();

        $selfAssessmentModel = new SelfAssessmentModel();
        $selfAssessmentDetailModel = new SelfAssessmentDetailModel();

        $data = [
            'employee_id' => $request->employee_id,
            'final_grades' => $request->hasil_akhir
        ];

        $addData = $selfAssessmentModel->insert($data);

        if ($addData) {
            foreach ($request as $key => $value) {
                if (preg_match('/^\d+_\d+$/', $key)) {
                    $parts = explode('_', $key);
                    $status = $parts[0];
                    $status_detail = $parts[1];

                    $detailData = [
                        'employee_id' => $request->employee_id,
                        'status' => $status,
                        'status_detail' => $status_detail,
                        'value' => $value
                    ];

                    $addDetailData = $selfAssessmentDetailModel->insert($detailData);

                    if (!$addDetailData) {
                    }
                }
            }

            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to assess']);
        }
    }


    // Leader Assessment
    public function dataTabelSubordinateAssessment()
    {
        $year = date('Y');
        $employeeModel = new EmployeeModel();
        $categoryModel = new AssessmentCategoryModel();
        $departmentModel = new AssessmentDepartmentTargetModel();
        $leaderAssessmentModel = new LeaderAssessmentModel();


        $maxWeight = $categoryModel->getWeightByLastStatus($year);

        $dataEmployee = $employeeModel->where('direct_leader', session('userName'))->findAll();

        $data = [];
        $dataEmployee = array_reverse($dataEmployee);
        foreach ($dataEmployee as $item) {
            $totalWeight = $departmentModel->cekTotalWeight($year, $item['employee_id']);
            $cekLeaderAssess = $leaderAssessmentModel->where('year', $year)->where('employee_id', $item['employee_id'])->first();

            $userStatusCol = 'red';
            $userStatusText = 'Unassessed';

            if ($maxWeight == $totalWeight) {
                $userStatusCol = 'blue';
                $userStatusText = 'Already';
            }

            if ($cekLeaderAssess) {
                $userStatusCol = 'green';
                $userStatusText = 'Assessed';
            }

            $data[] = [
                'id' => $item['id'],
                'employee_name' => $item['employee_name'],
                'employee_id' => $item['employee_id'],
                'department' => $item['department'],
                'unit' => $item['unit'],
                'status_color' => $userStatusCol,
                'status_text' => $userStatusText
            ];
        }
        return $this->response->setJSON(['data' => $data]);
    }

    public function detailSubordinateAssessment()
    {
        $employee_id = $this->request->getGet('employee_id');

        $year = date('Y');
        $employeeModel = new EmployeeModel();
        $categoryModel = new AssessmentCategoryModel();

        $data['year'] = $year;
        $data['category'] = $categoryModel->where('year', $year)->findAll();
        $data['employee'] = $employeeModel->where('employee_id', $employee_id)->first();

        return view('assess_leader_assessment_detail', $data);
    }
    public function dataTabelLeaderAssessment()
    {
        $year = date('Y');
        $employee_id = $this->request->getGet('employee_id');
        $parameterModel = new AssessmentParametersModel();
        $departmentTargetModel = new AssessmentDepartmentTargetModel();

        $dataParameter = $parameterModel->where('year', $year)->findAll();
        $dataDepartment = $departmentTargetModel->where('year', $year)->where('employee_id', $employee_id)->findAll();

        $data = [];
        foreach ($dataParameter as $item) {
            $data[] = [
                'id' => $item['id'],
                'year' => $item['year'],
                'status' => $item['status'],
                'status_detail' => $item['status_detail'],
                'parameter' => $item['parameter'],
                'remark' => $item['remark'],
                'weight' => $item['weight']
            ];
        }
        foreach ($dataDepartment as $item) {
            $data[] = [
                'id' => $item['id'],
                'year' => $item['year'],
                'status' => $item['status'],
                'status_detail' => $item['status_detail'],
                'parameter' => $item['parameter'],
                'remark' => $item['remark'],
                'weight' => $item['weight']
            ];
        }
        return $this->response->setJSON(['data' => $data]);
    }
    public function cekIdLeaderResult()
    {
        $year = date('Y');
        $request = $this->request->getJSON();
        $idEmployee = $request->employee_id;

        $leaderAssessmentModel = new LeaderAssessmentModel();
        $categoryModel = new AssessmentCategoryModel();
        $departmentTargetModel = new AssessmentDepartmentTargetModel();

        $totalWeight = $departmentTargetModel->cekTotalWeight($year, $idEmployee);
        $maxWidth = $categoryModel->getWeightByLastStatus($year);

        $cekId = $leaderAssessmentModel->where('employee_id', $idEmployee)->first();

        if ($cekId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Employees Have Been Assessed This Year']);
        }

        if ($totalWeight == $maxWidth) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Department targets have not been met']);
        }
    }

    public function addLeaderResult()
    {
        $request = $this->request->getJSON();

        $leaderAssessmentModel = new LeaderAssessmentModel();
        $leaderAssessmentDetailModel = new LeaderAssessmentDetailModel();

        $data = [
            'employee_id' => $request->employee_id,
            'final_grades' => $request->hasil_akhir
        ];

        $addData = $leaderAssessmentModel->insert($data);

        if ($addData) {
            foreach ($request as $key => $value) {
                if (preg_match('/^\d+_\d+$/', $key)) {
                    $parts = explode('_', $key);
                    $status = $parts[0];
                    $status_detail = $parts[1];

                    $detailData = [
                        'employee_id' => $request->employee_id,
                        'status' => $status,
                        'status_detail' => $status_detail,
                        'value' => $value
                    ];

                    $addDetailData = $leaderAssessmentDetailModel->insert($detailData);

                    if (!$addDetailData) {
                    }
                }
            }

            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to assess']);
        }
    }


    // Senior GM Assessment
    public function dataTabelSeniorAssessment()
    {
        $year = date('Y');
        $employeeModel = new EmployeeModel();
        $categoryModel = new AssessmentCategoryModel();
        $departmentModel = new AssessmentDepartmentTargetModel();
        $seniorGmAssessmentModel = new SeniorGmAssessmentModel();

        $maxWeight = $categoryModel->getWeightByLastStatus($year);

        $dataEmployee = $employeeModel->findAll();

        $data = [];
        $dataEmployee = array_reverse($dataEmployee);
        foreach ($dataEmployee as $item) {
            $totalWeight = $departmentModel->cekTotalWeight($year, $item['employee_id']);
            $cekLeaderAssess = $seniorGmAssessmentModel->where('year', $year)->where('employee_id', $item['employee_id'])->first();

            $userStatusCol = 'red';
            $userStatusText = 'Unassessed';

            if ($maxWeight == $totalWeight) {
                $userStatusCol = 'blue';
                $userStatusText = 'Already';
            }

            if ($cekLeaderAssess) {
                $userStatusCol = 'green';
                $userStatusText = 'Assessed';
            }

            $data[] = [
                'id' => $item['id'],
                'employee_name' => $item['employee_name'],
                'employee_id' => $item['employee_id'],
                'department' => $item['department'],
                'unit' => $item['unit'],
                'status_color' => $userStatusCol,
                'status_text' => $userStatusText
            ];
        }
        return $this->response->setJSON(['data' => $data]);
    }
    public function detailSeniorAssessment()
    {
        $employee_id = $this->request->getGet('employee_id');

        $year = date('Y');
        $employeeModel = new EmployeeModel();
        $categoryModel = new AssessmentCategoryModel();

        $data['year'] = $year;
        $data['category'] = $categoryModel->where('year', $year)->findAll();
        $data['employee'] = $employeeModel->where('employee_id', $employee_id)->first();

        return view('assess_senior_gm_assessment_detail', $data);
    }
    public function dataTabelSeniorGmAssessment()
    {
        $year = date('Y');
        $employee_id = $this->request->getGet('employee_id');
        $parameterModel = new AssessmentParametersModel();
        $departmentTargetModel = new AssessmentDepartmentTargetModel();

        $dataParameter = $parameterModel->where('year', $year)->findAll();
        $dataDepartment = $departmentTargetModel->where('year', $year)->where('employee_id', $employee_id)->findAll();

        $data = [];
        foreach ($dataParameter as $item) {
            $data[] = [
                'id' => $item['id'],
                'year' => $item['year'],
                'status' => $item['status'],
                'status_detail' => $item['status_detail'],
                'parameter' => $item['parameter'],
                'remark' => $item['remark'],
                'weight' => $item['weight']
            ];
        }
        foreach ($dataDepartment as $item) {
            $data[] = [
                'id' => $item['id'],
                'year' => $item['year'],
                'status' => $item['status'],
                'status_detail' => $item['status_detail'],
                'parameter' => $item['parameter'],
                'remark' => $item['remark'],
                'weight' => $item['weight']
            ];
        }
        return $this->response->setJSON(['data' => $data]);
    }
    public function cekIdSeniorResult()
    {
        $year = date('Y');
        $request = $this->request->getJSON();
        $idEmployee = $request->employee_id;

        $seniorGmAssessmentModel = new SeniorGmAssessmentModel();
        $categoryModel = new AssessmentCategoryModel();
        $departmentTargetModel = new AssessmentDepartmentTargetModel();

        $totalWeight = $departmentTargetModel->cekTotalWeight($year, $idEmployee);
        $maxWidth = $categoryModel->getWeightByLastStatus($year);

        $cekId = $seniorGmAssessmentModel->where('employee_id', $idEmployee)->first();

        if ($cekId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Employees Have Been Assessed This Year']);
        }

        if ($totalWeight == $maxWidth) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Department targets have not been met']);
        }
    }

    public function addSeniorResult()
    {
        $request = $this->request->getJSON();

        $seniorGmAssessmentModel = new SeniorGmAssessmentModel();
        $seniorGmAssessmentDetailModel = new SeniorGmAssessmentDetailModel();

        $data = [
            'employee_id' => $request->employee_id,
            'final_grades' => $request->hasil_akhir
        ];

        $addData = $seniorGmAssessmentModel->insert($data);

        if ($addData) {
            foreach ($request as $key => $value) {
                if (preg_match('/^\d+_\d+$/', $key)) {
                    $parts = explode('_', $key);
                    $status = $parts[0];
                    $status_detail = $parts[1];

                    $detailData = [
                        'employee_id' => $request->employee_id,
                        'status' => $status,
                        'status_detail' => $status_detail,
                        'value' => $value
                    ];

                    $addDetailData = $seniorGmAssessmentDetailModel->insert($detailData);

                    if (!$addDetailData) {
                    }
                }
            }

            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to assess']);
        }
    }


    // Score Proportion Management Data
    public function dataTabelScoreProportion()
    {
        $scoreProportionModel = new ScoreProportionModel();

        $dataScoreProportion = $scoreProportionModel->findAll();

        $data = [];
        $dataScoreProportion = array_reverse($dataScoreProportion);
        foreach ($dataScoreProportion as $item) {
            $data[] = [
                'id' => $item['id'],
                'year' => $item['year'],
                'self' => $item['self'],
                'leader' => $item['leader'],
                'senior_gm' => $item['senior_gm']
            ];
        }
        return $this->response->setJSON(['data' => $data]);
    }
    public function addScoreProportion()
    {
        $year = date('Y');
        $request = $this->request->getJSON();
        $scoreProportionModel = new ScoreProportionModel();

        $cekDataScore = $scoreProportionModel->where('year', $year)->first();

        if ($cekDataScore) {
            $errorMessage = "Proportion of Year score : $year, existing";
            return $this->response->setJSON(['success' => false, 'message' => $errorMessage]);
        }

        $data = [
            'self' => $request->self,
            'leader' => $request->leader,
            'senior_gm' => $request->senior_gm
        ];

        if ($scoreProportionModel->insert($data)) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to save data']);
        }
    }
    public function editScoreProportion()
    {
        $request = $this->request->getJSON();
        $scoreProportionModel = new ScoreProportionModel();

        $data = [
            'self' => $request->self,
            'leader' => $request->leader,
            'senior_gm' => $request->senior_gm
        ];

        $updated = $scoreProportionModel->update($request->id, $data);

        if ($updated) {
            return $this->response->setJSON(['success' => true, 'message' => 'Data changed successfully']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Data changed failed']);
        }
    }
    public function deleteScoreProportion()
    {
        $request = $this->request->getJSON();

        $scoreProportionModel = new ScoreProportionModel();
        $deleted = $scoreProportionModel->delete($request->id);

        if ($deleted) {
            return $this->response->setJSON(['success' => true, 'message' => 'Data deleted successfully']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Data failed to delete']);
        }
    }


    // Final Result Management Data
    public function detailFinalResult()
    {
        $year = $this->request->getGet('year');

        $data['year'] = $year;

        return view('data_result_final_detail', $data);
    }
    public function dataTabelFinalResult()
    {
        $year = $this->request->getGet('year');
        $employeeModel = new EmployeeModel();
        $selfResultModel = new SelfAssessmentModel();
        $leaderResultModel = new LeaderAssessmentModel();
        $seniorResultModel = new SeniorGmAssessmentModel();
        $scoreProportionModel = new ScoreProportionModel();

        $dataEmployee = $employeeModel->findAll();
        $dataScore = $scoreProportionModel->where('year', $year)->first();

        $data = [];
        $dataEmployee = array_reverse($dataEmployee);
        foreach ($dataEmployee as $item) {
            $cekSelf = $selfResultModel->where('year', $year)->where('employee_id', $item['employee_id'])->first();
            $cekLeader = $leaderResultModel->where('year', $year)->where('employee_id', $item['employee_id'])->first();
            $cekSenior = $seniorResultModel->where('year', $year)->where('employee_id', $item['employee_id'])->first();

            $resultSelf = isset($cekSelf['final_grades']) ? $cekSelf['final_grades'] : 0;
            $resultLeader = isset($cekLeader['final_grades']) ? $cekLeader['final_grades'] : 0;
            $resultSenior = isset($cekSenior['final_grades']) ? $cekSenior['final_grades'] : 0;

            $finalResult = ((($resultSelf * $dataScore['self']) / 100) + (($resultLeader * $dataScore['leader']) / 100) + (($resultSenior * $dataScore['senior_gm']) / 100));

            $finalResult = number_format($finalResult, 2);

            $grade = '-';

            if ($finalResult) {
                if ($finalResult >= 81 && $finalResult <= 100) {
                    $grade = 'A';
                } elseif ($finalResult >= 61 && $finalResult <= 80) {
                    $grade = 'B';
                } elseif ($finalResult >= 41 && $finalResult <= 60) {
                    $grade = 'C';
                } elseif ($finalResult >= 21 && $finalResult <= 40) {
                    $grade = 'D';
                } elseif ($finalResult >= 0 && $finalResult <= 20) {
                    $grade = 'E';
                }
            }

            $data[] = [
                'employee_name' => $item['employee_name'],
                'employee_id' => $item['employee_id'],
                'department' => $item['department'],
                'unit' => $item['unit'],
                'direct_leader' => $item['direct_leader'],
                'self' => $resultSelf,
                'leader' => $resultLeader,
                'senior_gm' => $resultSenior,
                'final_result' => $finalResult,
                'grades' => $grade
            ];
        }
        return $this->response->setJSON(['data' => $data]);
    }




    // Report Self
    public function getDataAllReportSelf()
    {
        $selfModel = new ScoreProportionModel();

        $data['value'] = $selfModel->findAll();

        return view('report_self_assessment', $data);
    }
    public function getDataReportSelf()
    {
        $year = $this->request->getGet('year');
        $categoryModel = new AssessmentCategoryModel();
        $employeeModel = new EmployeeModel();
        $selfModel = new SelfAssessmentModel();

        $data['year'] = $year;
        $data['category'] = $categoryModel->where('year', $year)->findAll();
        $data['detail'] = $employeeModel->where('employee_id', session('userId'))->first();
        $data['self'] = $selfModel->where('year', $year)->where('employee_id', session('userId'))->first();

        return view('report_self_assessment_detail', $data);
    }
    public function dataTabelReportSelf()
    {
        $year = $this->request->getGet('year');
        $parameterModel = new AssessmentParametersModel();
        $departmentTargetModel = new AssessmentDepartmentTargetModel();
        $selfAssessmentModal = new SelfAssessmentModel();
        $selfAssessmentDetailModal = new SelfAssessmentDetailModel();

        $dataParameter = $parameterModel->where('year', $year)->findAll();
        $dataDepartment = $departmentTargetModel->where('year', $year)->where('employee_id', session('userId'))->findAll();

        $data = [];
        foreach ($dataParameter as $item) {
            $dataValue = $selfAssessmentDetailModal->where('year', $year)->where('employee_id', session('userId'))->where('status', $item['status'])->where('status_detail', $item['status_detail'])->first();
            $value = isset($dataValue['value']) ? $dataValue['value'] : 0;
            $data[] = [
                'status' => $item['status'],
                'status_detail' => $item['status_detail'],
                'parameter' => $item['parameter'],
                'remark' => $item['remark'],
                'weight' => $item['weight'],
                'value' => $value
            ];
        }
        foreach ($dataDepartment as $item) {
            $dataValue = $selfAssessmentDetailModal->where('year', $year)->where('employee_id', session('userId'))->where('status', $item['status'])->where('status_detail', $item['status_detail'])->first();
            $value = isset($dataValue['value']) ? $dataValue['value'] : 0;
            $data[] = [
                'status' => $item['status'],
                'status_detail' => $item['status_detail'],
                'parameter' => $item['parameter'],
                'remark' => $item['remark'],
                'weight' => $item['weight'],
                'value' => $value
            ];
        }
        return $this->response->setJSON(['data' => $data]);
    }

    // Report Subordinate
    public function getDataAllReportLeader()
    {
        $selfModel = new ScoreProportionModel();

        $data['value'] = $selfModel->findAll();

        return view('report_leader_assessment', $data);
    }
    public function getDataReportLeader()
    {
        $year = $this->request->getGet('year');

        $data['year'] = $year;

        return view('report_leader_assessment_year', $data);
    }
    public function dataTabelReportLeader()
    {
        $year = $this->request->getGet('year');
        $employeeModel = new EmployeeModel();
        $selfModel = new SelfAssessmentModel();
        $leaderModel = new LeaderAssessmentModel();

        $dataEmployee = $employeeModel->where('direct_leader', session('userName'))->findAll();

        $data = [];
        $dataEmployee = array_reverse($dataEmployee);
        foreach ($dataEmployee as $item) {
            $dataSelf = $selfModel->where('year', $year)->where('employee_id', $item['employee_id'])->first();
            $dataLeader = $leaderModel->where('year', $year)->where('employee_id', $item['employee_id'])->first();

            $valueSelf = isset($dataSelf['final_grades']) ? $dataSelf['final_grades'] : 0;
            $valueLeader = isset($dataLeader['final_grades']) ? $dataLeader['final_grades'] : 0;
            $data[] = [
                'id' => $item['id'],
                'employee_name' => $item['employee_name'],
                'employee_id' => $item['employee_id'],
                'department' => $item['department'],
                'unit' => $item['unit'],
                'self' => $valueSelf,
                'leader' => $valueLeader
            ];
        }
        return $this->response->setJSON(['data' => $data]);
    }
    public function getDataReportLeaderdetail()
    {
        $year = $this->request->getGet('year');
        $employee_id = $this->request->getGet('employee_id');
        $categoryModel = new AssessmentCategoryModel();
        $employeeModel = new EmployeeModel();
        $selfModel = new SelfAssessmentModel();
        $leaderModel = new LeaderAssessmentModel();

        $data['year'] = $year;
        $data['category'] = $categoryModel->where('year', $year)->findAll();
        $data['detail'] = $employeeModel->where('employee_id', $employee_id)->first();
        $data['self'] = $selfModel->where('year', $year)->where('employee_id', $employee_id)->first();
        $data['leader'] = $leaderModel->where('year', $year)->where('employee_id', $employee_id)->first();

        return view('report_leader_assessment_detail', $data);
    }
    public function dataReportLeaderDetail()
    {
        $year = $this->request->getGet('year');
        $employee_id = $this->request->getGet('employee_id');
        $parameterModel = new AssessmentParametersModel();
        $departmentTargetModel = new AssessmentDepartmentTargetModel();
        $selfAssessmentDetailModal = new SelfAssessmentDetailModel();
        $leaderAssessmentModal = new LeaderAssessmentDetailModel();

        $dataParameter = $parameterModel->where('year', $year)->findAll();
        $dataDepartment = $departmentTargetModel->where('year', $year)->where('employee_id', $employee_id)->findAll();

        $data = [];
        foreach ($dataParameter as $item) {
            $dataSelf = $selfAssessmentDetailModal->where('year', $year)->where('employee_id', $employee_id)->where('status', $item['status'])->where('status_detail', $item['status_detail'])->first();
            $valueSelf = isset($dataSelf['value']) ? $dataSelf['value'] : 0;
            $dataLeader = $leaderAssessmentModal->where('year', $year)->where('employee_id', $employee_id)->where('status', $item['status'])->where('status_detail', $item['status_detail'])->first();
            $valueLeader = isset($dataLeader['value']) ? $dataLeader['value'] : 0;
            $data[] = [
                'status' => $item['status'],
                'status_detail' => $item['status_detail'],
                'parameter' => $item['parameter'],
                'remark' => $item['remark'],
                'weight' => $item['weight'],
                'value' => $valueSelf,
                'leader' => $valueLeader
            ];
        }
        foreach ($dataDepartment as $item) {
            $dataSelf = $selfAssessmentDetailModal->where('year', $year)->where('employee_id', $employee_id)->where('status', $item['status'])->where('status_detail', $item['status_detail'])->first();
            $valueSelf = isset($dataSelf['value']) ? $dataSelf['value'] : 0;
            $dataLeader = $leaderAssessmentModal->where('year', $year)->where('employee_id', $employee_id)->where('status', $item['status'])->where('status_detail', $item['status_detail'])->first();
            $valueLeader = isset($dataLeader['value']) ? $dataLeader['value'] : 0;
            $data[] = [
                'status' => $item['status'],
                'status_detail' => $item['status_detail'],
                'parameter' => $item['parameter'],
                'remark' => $item['remark'],
                'weight' => $item['weight'],
                'value' => $valueSelf,
                'leader' => $valueLeader
            ];
        }
        return $this->response->setJSON(['data' => $data]);
    }


    // Report Senior GM Assessment
    public function getDataAllReportSenior()
    {
        $selfModel = new ScoreProportionModel();

        $data['value'] = $selfModel->findAll();

        return view('report_senior_gm_assessment', $data);
    }
    public function getDataReportSenior()
    {
        $year = $this->request->getGet('year');

        $data['year'] = $year;

        return view('report_senior_gm_assessment_year', $data);
    }
    public function dataTabelReportSenior()
    {
        $year = $this->request->getGet('year');
        $employeeModel = new EmployeeModel();
        $selfModel = new SelfAssessmentModel();
        $leaderModel = new LeaderAssessmentModel();
        $seniorModel = new SeniorGmAssessmentModel();
        $scoreProportionModel = new ScoreProportionModel();

        $dataEmployee = $employeeModel->findAll();
        $dataScore = $scoreProportionModel->where('year', $year)->first();

        $data = [];
        $dataEmployee = array_reverse($dataEmployee);
        foreach ($dataEmployee as $item) {
            $dataSelf = $selfModel->where('year', $year)->where('employee_id', $item['employee_id'])->first();
            $dataLeader = $leaderModel->where('year', $year)->where('employee_id', $item['employee_id'])->first();
            $dataSenior = $seniorModel->where('year', $year)->where('employee_id', $item['employee_id'])->first();

            $valueSelf = isset($dataSelf['final_grades']) ? $dataSelf['final_grades'] : 0;
            $valueLeader = isset($dataLeader['final_grades']) ? $dataLeader['final_grades'] : 0;
            $valueSenior = isset($dataSenior['final_grades']) ? $dataSenior['final_grades'] : 0;

            $finalResult = ((($valueSelf * $dataScore['self']) / 100) + (($valueLeader * $dataScore['leader']) / 100) + (($valueSenior * $dataScore['senior_gm']) / 100));

            $finalResult = number_format($finalResult, 2);

            $grade = '-';

            if ($finalResult) {
                if ($finalResult >= 81 && $finalResult <= 100) {
                    $grade = 'A';
                } elseif ($finalResult >= 61 && $finalResult <= 80) {
                    $grade = 'B';
                } elseif ($finalResult >= 41 && $finalResult <= 60) {
                    $grade = 'C';
                } elseif ($finalResult >= 21 && $finalResult <= 40) {
                    $grade = 'D';
                } elseif ($finalResult >= 0 && $finalResult <= 20) {
                    $grade = 'E';
                }
            }
            $data[] = [
                'id' => $item['id'],
                'employee_name' => $item['employee_name'],
                'employee_id' => $item['employee_id'],
                'department' => $item['department'],
                'unit' => $item['unit'],
                'self' => $valueSelf,
                'leader' => $valueLeader,
                'senior' => $valueSenior,
                'final' => $finalResult,
                'grade' => $grade
            ];
        }
        return $this->response->setJSON(['data' => $data]);
    }

    public function getDataReportSeniordetail()
    {
        $year = $this->request->getGet('year');
        $employee_id = $this->request->getGet('employee_id');
        $categoryModel = new AssessmentCategoryModel();
        $employeeModel = new EmployeeModel();
        $selfModel = new SelfAssessmentModel();
        $leaderModel = new LeaderAssessmentModel();
        $seniorModel = new SeniorGmAssessmentModel();

        $data['year'] = $year;
        $data['category'] = $categoryModel->where('year', $year)->findAll();
        $data['detail'] = $employeeModel->where('employee_id', $employee_id)->first();
        $data['self'] = $selfModel->where('year', $year)->where('employee_id', $employee_id)->first();
        $data['leader'] = $leaderModel->where('year', $year)->where('employee_id', $employee_id)->first();
        $data['senior'] = $seniorModel->where('year', $year)->where('employee_id', $employee_id)->first();

        return view('report_senior_gm_assessment_detail', $data);
    }
    public function dataReportSeniorDetail()
    {
        $year = $this->request->getGet('year');
        $employee_id = $this->request->getGet('employee_id');
        $parameterModel = new AssessmentParametersModel();
        $departmentTargetModel = new AssessmentDepartmentTargetModel();
        $selfAssessmentDetailModal = new SelfAssessmentDetailModel();
        $leaderAssessmentModal = new LeaderAssessmentDetailModel();
        $seniorAssessmentModal = new SeniorGmAssessmentDetailModel();

        $dataParameter = $parameterModel->where('year', $year)->findAll();
        $dataDepartment = $departmentTargetModel->where('year', $year)->where('employee_id', $employee_id)->findAll();

        $data = [];
        foreach ($dataParameter as $item) {
            $dataSelf = $selfAssessmentDetailModal->where('year', $year)->where('employee_id', $employee_id)->where('status', $item['status'])->where('status_detail', $item['status_detail'])->first();
            $valueSelf = isset($dataSelf['value']) ? $dataSelf['value'] : 0;
            $dataLeader = $leaderAssessmentModal->where('year', $year)->where('employee_id', $employee_id)->where('status', $item['status'])->where('status_detail', $item['status_detail'])->first();
            $valueLeader = isset($dataLeader['value']) ? $dataLeader['value'] : 0;
            $dataSenior = $seniorAssessmentModal->where('year', $year)->where('employee_id', $employee_id)->where('status', $item['status'])->where('status_detail', $item['status_detail'])->first();
            $valueSenior = isset($dataSenior['value']) ? $dataSenior['value'] : 0;
            $data[] = [
                'status' => $item['status'],
                'status_detail' => $item['status_detail'],
                'parameter' => $item['parameter'],
                'remark' => $item['remark'],
                'weight' => $item['weight'],
                'value' => $valueSelf,
                'leader' => $valueLeader,
                'senior' => $valueSenior
            ];
        }
        foreach ($dataDepartment as $item) {
            $dataSelf = $selfAssessmentDetailModal->where('year', $year)->where('employee_id', $employee_id)->where('status', $item['status'])->where('status_detail', $item['status_detail'])->first();
            $valueSelf = isset($dataSelf['value']) ? $dataSelf['value'] : 0;
            $dataLeader = $leaderAssessmentModal->where('year', $year)->where('employee_id', $employee_id)->where('status', $item['status'])->where('status_detail', $item['status_detail'])->first();
            $valueLeader = isset($dataLeader['value']) ? $dataLeader['value'] : 0;
            $dataSenior = $seniorAssessmentModal->where('year', $year)->where('employee_id', $employee_id)->where('status', $item['status'])->where('status_detail', $item['status_detail'])->first();
            $valueSenior = isset($dataSenior['value']) ? $dataSenior['value'] : 0;
            $data[] = [
                'status' => $item['status'],
                'status_detail' => $item['status_detail'],
                'parameter' => $item['parameter'],
                'remark' => $item['remark'],
                'weight' => $item['weight'],
                'value' => $valueSelf,
                'leader' => $valueLeader,
                'senior' => $valueSenior
            ];
        }
        return $this->response->setJSON(['data' => $data]);
    }


    // Export Final Result Data
    public function exportDataFinalResult()
    {
        $year = $this->request->getGet('year');
        $title = "TIMW EMPLOYEE FINAL ASSESSMENT RESULTS $year";

        $scoreModel = new ScoreProportionModel();
        $employeeModel = new EmployeeModel();
        $selfModel = new SelfAssessmentModel();
        $leaderModel = new LeaderAssessmentModel();
        $seniorModel = new SeniorGmAssessmentModel();

        $dataScore = $scoreModel->where('year', $year)->first();
        $self = $dataScore['self'];
        $selfTitle = "SELF $self%";
        $leader = $dataScore['leader'];
        $leaderTitle = "LEADER $leader%";
        $senior = $dataScore['senior_gm'];
        $seniorTitle = "SENIOR GM $senior%";

        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();
        $activeWorksheet->setCellValue('B2', $title);
        $activeWorksheet->setCellValue('B4', 'NO');
        $activeWorksheet->setCellValue('C4', 'EMPLOYEE NAME');
        $activeWorksheet->setCellValue('D4', 'EMPLOYEE ID');
        $activeWorksheet->setCellValue('E4', 'DEPARTMENT');
        $activeWorksheet->setCellValue('F4', 'UNIT');
        $activeWorksheet->setCellValue('G4', 'DIRECT LEADER');
        $activeWorksheet->setCellValue('H4', 'RESULT');
        $activeWorksheet->setCellValue('H5', $selfTitle);
        $activeWorksheet->setCellValue('I5', $leaderTitle);
        $activeWorksheet->setCellValue('J5', $seniorTitle);
        $activeWorksheet->setCellValue('K4', 'FINAL RESULT');
        $activeWorksheet->setCellValue('L4', 'GRADES');

        $alignHeader = 'B2:L5';
        $stylee = $activeWorksheet->getStyle($alignHeader);
        $stylee->getAlignment()->setVertical("middle");
        $stylee->getAlignment()->setHorizontal("center");

        $activeWorksheet->mergeCells('B2:L3');
        $activeWorksheet->mergeCells('B4:B5');
        $activeWorksheet->mergeCells('C4:C5');
        $activeWorksheet->mergeCells('D4:D5');
        $activeWorksheet->mergeCells('E4:E5');
        $activeWorksheet->mergeCells('F4:F5');
        $activeWorksheet->mergeCells('G4:G5');
        $activeWorksheet->mergeCells('H4:J4');
        $activeWorksheet->mergeCells('K4:K5');
        $activeWorksheet->mergeCells('L4:L5');

        $dataEmployee = $employeeModel->findAll();
        $no = 1;
        $column = 6;
        foreach ($dataEmployee as $key => $value) {
            $activeWorksheet->setCellValue('B' . $column, $no);
            $activeWorksheet->setCellValue('C' . $column, $value['employee_name']);
            $activeWorksheet->setCellValue('D' . $column, $value['employee_id']);
            $activeWorksheet->setCellValue('E' . $column, $value['department']);
            $activeWorksheet->setCellValue('F' . $column, $value['unit']);
            $activeWorksheet->setCellValue('G' . $column, $value['direct_leader']);

            $dataSelf = $selfModel->where('year', $year)->where('employee_id', $value['employee_id'])->first();
            $selfValue = isset($dataSelf['final_grades']) ? $dataSelf['final_grades'] : 0;

            $dataLeader = $leaderModel->where('year', $year)->where('employee_id', $value['employee_id'])->first();
            $leaderValue = isset($dataLeader['final_grades']) ? $dataLeader['final_grades'] : 0;

            $dataSenior = $seniorModel->where('year', $year)->where('employee_id', $value['employee_id'])->first();
            $seniorValue = isset($dataSenior['final_grades']) ? $dataSenior['final_grades'] : 0;

            $activeWorksheet->setCellValue('H' . $column, $selfValue);
            $activeWorksheet->setCellValue('I' . $column, $leaderValue);
            $activeWorksheet->setCellValue('J' . $column, $seniorValue);

            $finalResult = ((($selfValue * $self) / 100) + (($leaderValue * $leader) / 100) + (($selfValue * $senior) / 100));

            $finalResult = number_format($finalResult, 2);

            $grade = '-';

            if ($finalResult) {
                if ($finalResult >= 81 && $finalResult <= 100) {
                    $grade = 'A';
                } elseif ($finalResult >= 61 && $finalResult <= 80) {
                    $grade = 'B';
                } elseif ($finalResult >= 41 && $finalResult <= 60) {
                    $grade = 'C';
                } elseif ($finalResult >= 21 && $finalResult <= 40) {
                    $grade = 'D';
                } elseif ($finalResult >= 0 && $finalResult <= 20) {
                    $grade = 'E';
                }
            }

            $activeWorksheet->setCellValue('K' . $column, $finalResult);
            $activeWorksheet->setCellValue('L' . $column, $grade);

            $no++;
            $column++;
        }

        $columns = ['B', 'D', 'H', 'I', 'J', 'K', 'L'];
        foreach ($columns as $col) {
            $kolom = $col . '6:' . $col . $column;
            $style = $activeWorksheet->getStyle($kolom);
            $style->getAlignment()->setHorizontal("center");
        }


        $activeWorksheet->getStyle('B2:L5')->getFont()->setBold(true);

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];

        $activeWorksheet->getStyle('B2:L' . ($column - 1))->applyFromArray($styleArray);

        $activeWorksheet->getColumnDimension('B')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('C')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('D')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('E')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('F')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('G')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('H')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('I')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('J')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('K')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('L')->setAutoSize(true);

        $filename = "Final_Result_" . $year . ".xlsx";
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachnebt;filename=' . $filename);
        header('cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
    }

    // public function exportDataFinalResult()
    // {
    //     $year = $this->request->getGet('year');
    //     $title = "TIMW EMPLOYEE FINAL ASSESSMENT RESULTS $year";

    //     $categoryModel = new AssessmentCategoryModel();
    //     $parameterModel = new AssessmentParametersModel();
    //     $targetDepartmentModel = new AssessmentDepartmentTargetModel();

    //     $spreadsheet = new Spreadsheet();
    //     $activeWorksheet = $spreadsheet->getActiveSheet();
    //     $activeWorksheet->setCellValue('B2', $title);
    //     $activeWorksheet->setCellValue('B4', 'No');
    //     $activeWorksheet->setCellValue('C4', 'Employee Name');
    //     $activeWorksheet->setCellValue('D4', 'Employee ID');

    //     $dataCategory = $categoryModel->where('year', $year)->findAll();
    //     $totalCategories = count($dataCategory);

    //     $categoryColumn = 'E';
    //     $categoryColumns = [];
    //     foreach ($dataCategory as $index => $dataCategory) {
    //         $category = $dataCategory['category'];
    //         $categoryColumns[$category] = $categoryColumn;

    //         $statusDetails = $parameterModel->where('year', $year)
    //             ->where('status', $dataCategory['status'])
    //             ->findAll();

    //         $mergeLength = count($statusDetails);
    //         $lastColumn = chr(ord($categoryColumn) + $mergeLength - 1);
    //         $activeWorksheet->mergeCells($categoryColumn . '4:' . $lastColumn . '4');

    //         $categoryColumn = chr(ord($lastColumn) + 1);

    //         foreach ($statusDetails as $key => $statusDetail) {
    //             $activeWorksheet->setCellValue(chr(ord($categoryColumns[$category]) + $key) . '5', $statusDetail['status_detail']);
    //         }

    //         if ($index == $totalCategories - 2) {
    //             break;
    //         }
    //     }

    //     foreach ($categoryColumns as $category => $column) {
    //         $activeWorksheet->setCellValue($column . '4', $category);
    //     }

    //     $dataStatusTarget = $categoryModel->getNomorStatus($year);
    //     $dataTargetCategory = $categoryModel->where('year', $year)->where('status', $dataStatusTarget)->first();
    //     $categoryTarget = $dataTargetCategory['category'];
    //     $statusTarget = $dataTargetCategory['status'];
    //     $targetLong = $targetDepartmentModel->getMaxStatusDetail($year, $statusTarget);

    //     $activeWorksheet->setCellValue($categoryColumn . '4', $categoryTarget);
    //     $lastTargetColumn = chr(ord($categoryColumn) + $targetLong - 1);

    //     $activeWorksheet->mergeCells($categoryColumn . '4:' . $lastTargetColumn . '4');
    //     for ($i = 0; $i < $targetLong; $i++) {
    //         $activeWorksheet->setCellValue(chr(ord($categoryColumn) + $i) . '5', $i + 1);
    //     }

    //     $categoryColumn = chr(ord($lastTargetColumn) + 1);

    //     $activeWorksheet->setCellValue($categoryColumn . '4', 'Self');
    //     $activeWorksheet->mergeCells($categoryColumn . '4:' . $categoryColumn . '5');
    //     $categoryColumn = chr(ord($categoryColumn) + 1);

    //     $categoryLong = chr(ord($categoryColumn) - 1);

    //     $alignHeader = 'B2:' . $categoryLong . '5';
    //     $stylee = $activeWorksheet->getStyle($alignHeader);
    //     $stylee->getAlignment()->setVertical("middle");
    //     $stylee->getAlignment()->setHorizontal("center");

    //     $activeWorksheet->mergeCells('B2:' . $categoryLong . '3');
    //     $activeWorksheet->mergeCells('B4:B5');
    //     $activeWorksheet->mergeCells('C4:C5');
    //     $activeWorksheet->mergeCells('D4:D5');

    //     $column = 6;

    //     $activeWorksheet->getStyle('B2:' . $categoryLong . '4')->getFont()->setBold(true);

    //     $styleArray = [
    //         'borders' => [
    //             'allBorders' => [
    //                 'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    //                 'color' => ['argb' => 'FF000000'],
    //             ],
    //         ],
    //     ];

    //     $activeWorksheet->getStyle('B2:' . $categoryLong . ($column - 1))->applyFromArray($styleArray);

    //     $activeWorksheet->getColumnDimension('B')->setAutoSize(true);
    //     $activeWorksheet->getColumnDimension('C')->setAutoSize(true);
    //     $activeWorksheet->getColumnDimension('D')->setAutoSize(true);

    //     $filename = "Final_Result_" . $year . ".xlsx";
    //     $writer = new Xlsx($spreadsheet);
    //     header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //     header('Content-Disposition: attachnebt;filename=' . $filename);
    //     header('cache-Control: max-age=0');
    //     $writer->save('php://output');
    //     exit();
    // }

}