<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'AssessmentController::index');
$routes->get('/Em/(:any)', 'AssessmentController::employe/$1');

// User account management
$routes->post('/login-user', 'AssessmentController::login');
$routes->get('/logout-user', 'AssessmentController::logout');
$routes->post('/edit-password', 'AssessmentController::editPassword');

// Employee Data Management
$routes->get('/data-tabel-employee', 'AssessmentController::dataTabelEmployee');
$routes->post('/add-employee', 'AssessmentController::addDataEmployee');
$routes->post('/edit-employee', 'AssessmentController::editDataEmployee');
$routes->post('/delete-employee', 'AssessmentController::deleteDataEmployee');
$routes->post('/import-excel-employee', 'AssessmentController::importExcelEmployee');
// Doneee

// Account Data Management
$routes->get('/data-tabel-account', 'AssessmentController::dataTabelAccount');
$routes->post('/add-user', 'AssessmentController::addDataUser');
$routes->post('/edit-user', 'AssessmentController::editDataUser');
$routes->post('/delete-user', 'AssessmentController::deleteDataUser');
$routes->post('/import-excel-user', 'AssessmentController::importExcelUser');
// Doneee

// Assessment Category Data Management
$routes->get('/data-tabel-category', 'AssessmentController::dataTabelCategory');
$routes->post('/add-assessment-category', 'AssessmentController::addAssessmentCategoryData');
$routes->post('/edit-assessment-category', 'AssessmentController::editAssessmentCategoryData');
$routes->post('/delete-assessment-category', 'AssessmentController::deleteAssessmentCategoryData');
// Doneee

// Assessment Parameters Data Management
$routes->get('/data-tabel-parameter', 'AssessmentController::dataTabelParameter');
$routes->post('/add-assessment-parameter', 'AssessmentController::addAssessmentParameterData');
$routes->post('/edit-assessment-parameter', 'AssessmentController::editAssessmentParameterData');
$routes->post('/delete-assessment-parameter', 'AssessmentController::deleteAssessmentParameterData');
// Doneee

// Assessment Department Target Data Management
$routes->get('/data-tabel-department-target', 'AssessmentController::dataTabelDepartmentTarget');
$routes->post('/add-assessment-department-target', 'AssessmentController::addAssessmentDepartmentTarget');
$routes->post('/edit-assessment-department-target', 'AssessmentController::editAssessmentDepartmentTarget');
$routes->post('/delete-assessment-department-target', 'AssessmentController::deleteAssessmentDepartmentTarget');
$routes->post('/import-assessment-department-target', 'AssessmentController::importAllDataDepartmentTarget');
// Doneee

// SA Result Data Management
$routes->get('/data-tabel-sa-result', 'AssessmentController::dataTabelSaResult');

// LA Result Data Management
$routes->get('/data-tabel-la-result', 'AssessmentController::dataTabelLaResult');

// Senior GM A Result Data Management
$routes->get('/data-tabel-senior-gma-result', 'AssessmentController::dataTabelSeniorGmAResult');

// Score Proportion Data Management
$routes->get('/data-tabel-score-proportion', 'AssessmentController::dataTabelScoreProportion');
$routes->post('/add-score-proportion', 'AssessmentController::addScoreProportion');
$routes->post('/edit-score-proportion', 'AssessmentController::editScoreProportion');
$routes->post('/delete-score-proportion', 'AssessmentController::deleteScoreProportion');

// Final Result Data Management
$routes->get('/detail-final-result', 'AssessmentController::detailFinalResult');
$routes->get('/data-tabel-final-result', 'AssessmentController::dataTabelFinalResult');

// Leader
$routes->get('/data-tabel-subordinate', 'AssessmentController::dataTabelSubordinate');
$routes->get('/detailSubordinate', 'AssessmentController::detailSubordinate');
$routes->get('/data-subordinate-target', 'AssessmentController::dataTabelSubordinateTarget');
$routes->post('/import-department-target-sub', 'AssessmentController::importDataDepartmentTargetSub');


// Assessment Self Assessment
$routes->get('/data-tabel-self-assessment', 'AssessmentController::dataTabelSelfAssessment');
$routes->post('/cek-id-self-result', 'AssessmentController::cekIdSelfResult');
$routes->post('/add-self-result', 'AssessmentController::addSelfResult');

// Assessment Leader Assessment
$routes->get('/data-tabel-subordinate-assess', 'AssessmentController::dataTabelSubordinateAssessment');
$routes->get('/detail-subordinate-assess', 'AssessmentController::detailSubordinateAssessment');
$routes->get('/data-tabel-leader-assessment', 'AssessmentController::dataTabelLeaderAssessment');
$routes->post('/cek-id-leader-result', 'AssessmentController::cekIdLeaderResult');
$routes->post('/add-leader-result', 'AssessmentController::addLeaderResult');

// Assessment Senior GM Assessment
$routes->get('/data-tabel-senior-assess', 'AssessmentController::dataTabelSeniorAssessment');
$routes->get('/detail-senior-assess', 'AssessmentController::detailSeniorAssessment');
$routes->get('/data-tabel-senior-assessment', 'AssessmentController::dataTabelSeniorGmAssessment');
$routes->post('/cek-id-senior-result', 'AssessmentController::cekIdSeniorResult');
$routes->post('/add-senior-result', 'AssessmentController::addSeniorResult');



// Report Self Assessment
$routes->get('/data-tabel-report-self', 'AssessmentController::dataTabelReportSelf');

// Report Leader Assessment
$routes->get('/data-tabel-report-leader', 'AssessmentController::dataTabelReportLeader');
$routes->get('/data-tabel-report-leader-detail', 'AssessmentController::dataReportLeaderDetail');

// Report Senior Assessment
$routes->get('/data-tabel-report-senior', 'AssessmentController::dataTabelReportSenior');
$routes->get('/data-tabel-report-senior-detail', 'AssessmentController::dataReportSeniorDetail');

// Final Result
$routes->get('/export-data-result', 'AssessmentController::exportDataFinalResult');