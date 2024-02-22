<?php

namespace App\Controllers;

use App\Models\AccountModel;
use App\Models\AssessmentCategoryModel;
use App\Models\AssessmentDepartmentTargetModel;
use App\Models\AssessmentParametersModel;
use App\Models\EmployeeModel;

use App\Models\LeaderAssessmentDetailModel;
use App\Models\LeaderAssessmentModel;
use App\Models\SelfAssessmentDetailModel;
use App\Models\SelfAssessmentModel;
use PhpOffice\PhpSpreadsheet\IOFactory;

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
        } elseif ($segment === 'aSel') {
            return $this->getDataSelfAssessment();
        } elseif ($segment === 'aLea') {
            return view('assess_leader_assessment');
        } elseif ($segment === 'rSel') {
            return $this->getDataReportSelf();
        }


        //elseif ($segment === 'dPar') {
        //     return $this->getDataParameter($data);
        // } elseif ($segment === 'dTar') {
        //     return $this->getDataTargetParameter($data);
        // } elseif ($segment === 'dSelAs') {
        //     return $this->getDataSelfAsse($data);
        // } elseif ($segment === 'dSubAs') {
        //     return $this->getDataSubAsse($data);
        // } elseif ($segment === 'dSenAs') {
        //     return $this->getDataSenAsse($data);
        // } elseif ($segment === 'dFinRe') {
        //     return $this->getDataFinalAsse($data);
        // } elseif ($segment === 'dFinReDe') {
        //     return $this->getDataFinalAsseDet($data);
        // } elseif ($segment === 'dValCal') {
        //     return $this->getDataValueCalculation($data);
        // } elseif ($segment === 'dCat') {
        //     return $this->getDataCategory($data);
        // } elseif ($segment === 'aSel') {
        //     return $this->getDataSelfAssessment($data);
        // } elseif ($segment === 'aSub') {
        //     return $this->getDataSubordinate($data);
        // } elseif ($segment === 'aSubAss') {
        //     return $this->getDataSubordinateAssessment($data);
        // } elseif ($segment === 'aEmp') {
        //     return $this->getDataEmployeeAssessment($data);
        // } elseif ($segment === 'aEmpAss') {
        //     return $this->getDataEmployeeAssessmentDetail($data);
        // } elseif ($segment === 'rSel') {
        //     return $this->getReportDataSelfAssessment($data);
        // } elseif ($segment === 'rSelDet') {
        //     return $this->getReportDataSelfAssessmentDet($data);
        // } elseif ($segment === 'rSub') {
        //     return $this->getDataReportSubordinate($data);
        // } elseif ($segment === 'rSubTah') {
        //     return $this->getDataReportSubordinateTahun($data);
        // } elseif ($segment === 'rSubDet') {
        //     return $this->getDataReportSubordinateDetail($data);
        // } elseif ($segment === 'rEmp') {
        //     return $this->getDataReportEmployee($data);
        // } elseif ($segment === 'rSenPri') {
        //     return $this->getDataReportEmployeePrint($data);
        // } elseif ($segment === 'rEmpDe') {
        //     return $this->getDataReportEmployeeDe($data);
        // } elseif ($segment === 'rEmpDet') {
        //     return $this->getDataReportEmployeeDetail($data);
        // } elseif ($segment == 'prof') {
        //     return $this->getDataProfile($data);
        // }

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
        // $seniorGmAssess = new AssessmentSeniorGmResultModel();

        $totalDataCount = $employeeModel->getTotalDataCount();
        $totalDataSelf = $selfAssess->getTotalDataSelf($currentYear);
        $totalDataLeader = $leaderAssess->getTotalDataLeader($currentYear);
        // $totalDataSeniorGm = $seniorGmAssess->getTotalDataCount($currentYear);

        $data['totalEmployee'] = $totalDataCount;
        $data['totalSelf'] = $totalDataSelf;
        $data['totalLeader'] = $totalDataLeader;
        // $data['totalSenior'] = $totalDataSeniorGm;

        return view('dashboard', $data);
    }
    // Doneee



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
                        return $this->response->setJSON(['success' => false, 'message' => $errorMessage]);
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




    // Report
    public function getDataReportSelf()
    {
        $year = date('Y');
        $categoryModel = new AssessmentCategoryModel();
        $data['year'] = $year;
        $data['category'] = $categoryModel->where('year', $year)->findAll();

        return view('report_self_assessment', $data);
    }

}