<?php include('templates/header.php'); ?>
<?php include('templates/sidebar.php'); ?>

<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Senior GM Assessment</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a>Report</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Senior GM Assessment
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="pd-20 card-box mb-30">
                <div class="clearfix mb-30 text-center align-items-center">
                    <h4 class="text-black h3">TIMW Employee Senior General Manager Assessment Results <?= $year; ?>
                    </h4>
                </div>
                <div class="table-responsive">
                    <table class="data-table table table-sm stripe hover nowrap tabel-senior-report" id="dataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Employee Name</th>
                                <th>Department</th>
                                <th>Unit</th>
                                <th>Self</th>
                                <th>Leader</th>
                                <th>Senior GM</th>
                                <th>Final Result</th>
                                <th>Grades</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="year" data-year="<?= $year; ?>"></div>

<script>
    function toggleClasses() {
        var iaElements = document.querySelectorAll('.RSG');
        iaElements.forEach(function (element) {
            element.classList.toggle('active');
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        toggleClasses();
    });
</script>
<!-- js -->
<script src="<?= base_url() ?>vendors/scripts/core.js"></script>
<script src="<?= base_url() ?>vendors/scripts/script.min.js"></script>
<script src="<?= base_url() ?>vendors/scripts/process.js"></script>
<script src="<?= base_url() ?>vendors/scripts/layout-settings.js"></script>
<script src="<?= base_url() ?>src/plugins/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>src/plugins/datatables/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url() ?>src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>vendors/scripts/datatable-setting.js"></script>
<script src="<?= base_url() ?>vendors/sweet/sweet2.js"></script>

<script src="<?= base_url() ?>assessmentJs/report_senior_gm_assessment_year_view.js"></script>

</body>

</html>