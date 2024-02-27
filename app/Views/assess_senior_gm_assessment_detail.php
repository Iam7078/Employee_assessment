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
                                    <a>Assessment</a>
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
                <div class="clearfix mb-30 align-items-center text-center">
                    <h4 class="text-black h3">TIMW Employee Senior General Manager Assessment
                        <?= $year; ?>
                    </h4>
                </div>

                <div class="row">
                    <div class="col-md-5 col-sm-10">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <td>NAME</td>
                                    <td>
                                        <?= $employee['employee_name']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>ID</td>
                                    <td id="id">
                                        <?= $employee['employee_id']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>DEPARTMENT</td>
                                    <td>
                                        <?= $employee['department']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>UNIT</td>
                                    <td>
                                        <?= $employee['unit']; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mb-10 d-flex justify-content-end">
                    <div class="nilai-box" id="hasil-akhir">00</div>
                </div>

                <?php
                $statusClasses = ['danger', 'danger', 'warning', 'info', 'success', 'secondary', 'dark'];
                $totalCategories = count($category);
                foreach ($category as $index => $categor):
                    $statusClass = isset($statusClasses[$categor['status']]) ? $statusClasses[$categor['status']] : 'dark';
                    ?>
                    <div class="clearfix mb-10 d-flex justify-content-between align-items-center">
                        <h4 class="text-<?= $statusClass; ?> h4">
                            <?= $categor['status']; ?>.
                            <?= $categor['category']; ?> (
                            <?= $categor['weight']; ?>%)
                        </h4>
                    </div>
                    <div class="mb-30">
                        <table class="table table-bordered tabel-assessment">
                            <thead>
                                <tr>
                                    <th>Assessment Parameters</th>
                                    <th>Remark</th>
                                    <th>Weight</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
                            <tbody id="table-body<?= $categor['status']; ?>">
                            </tbody>
                        </table>
                    </div>
                    <?php
                endforeach;
                ?>
                <div class="d-flex justify-content-end">
                    <button id="submitBtn" type="button" class="btn btn-primary"
                        data-count="<?= $totalCategories; ?>"><i class="icon-copy fa fa-check-square"></i>
                        Check</button>
                    <button id="submitBtn3" type="button" class="btn btn-danger mr-1"><i
                            class="icon-copy fa fa-minus-square"></i> Cancel</button>
                    <button id="submitBtn2" type="button" class="btn btn-info"><i
                            class="icon-copy fa fa-check-square-o"></i> Submit</button>
                </div>


            </div>
        </div>
    </div>
</div>

<script>
    function toggleClasses() {
        var iaElements = document.querySelectorAll('.ASG');
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

<script src="<?= base_url() ?>assessmentJs/assess_senior_gm_assessment_detail_view.js"></script>

</body>

</html>