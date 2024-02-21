<?php include('templates/header.php'); ?>
<?php include('templates/sidebar.php'); ?>

<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Target Data of Subordinate Departments</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a>Data Management</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a>Assessment Parameters</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Target Data of Subordinate Departments
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="pd-20 card-box mb-30">
                <div class="clearfix mb-30 align-items-center text-center">
                    <h4 class="text-black h3">Target Data of Subordinate Departments</h4>
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

                <div class="d-flex justify-content-between mb-30 mt-30">
                    <h5 class="card-title text-primary">
                        <?= $category['category']; ?> (
                        <?= $category['weight']; ?>%)
                    </h5>
                    <button data-toggle="modal" data-target="#modal-add" type="button" class="btn btn-danger"><i
                            class="mr-1 fa fa-plus"></i> Add</button>
                </div>
                <table class="table table-bordered tabel-parameter" id="tabel-target">
                    <thead>
                        <tr>
                            <th>Year</th>
                            <th>Assessment Parameters</th>
                            <th>Remark</th>
                            <th>Weight</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add Data -->
<div class="modal fade bs-example-modal-lg" id="modal-add" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Add Data</h4>
                <button type="button" class="close" data-dismiss="modal" id="close-add" aria-hidden="true">X</button>
            </div>
            <div class="modal-body">
                <form id="addItemForm">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label class="text-gray-800" for="user_name">Assessment Parameters</label>
                                <input type="text" class="form-control" id="addParameter">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="text-gray-800" for="email">Weight</label>
                                <input type="number" class="form-control" id="addWeight">
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="inputAddress5" class="form-label">Remark</label>
                            <textarea class="form-control" id="addRemark" style="height: 100px;"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="close-add2" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn-add-save">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Data -->
<div class="modal fade bs-example-modal-lg" id="modal-edit" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Edit Data</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
            </div>
            <div class="modal-body">
                <form id="editItemForm">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label class="text-gray-800" for="user_name">Assessment Parameters</label>
                                <input type="text" class="form-control" id="editParameter">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="text-gray-800" for="email">Weight</label>
                                <input type="number" class="form-control" id="editWeight">
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="inputAddress5" class="form-label">Remark</label>
                            <textarea class="form-control" id="editRemark" style="height: 100px;"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn-save-edit">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center font-18">
                <h4 class="padding-top-30 mb-30 weight-500">Are you sure you want to delete this data?</h4>
                <div class="padding-bottom-30 row" style="max-width: 170px; margin: 0 auto;">
                    <div class="col-6">
                        <button type="button" class="btn btn-secondary border-radius-100 btn-block confirmation-btn"
                            data-dismiss="modal"><i class="fa fa-times"></i></button>
                        NO
                    </div>
                    <div class="col-6">
                        <button type="button" class="btn btn-primary border-radius-100 btn-block confirmation-btn"
                            data-dismiss="modal" id="btn-save-delete"><i class="fa fa-check"></i></button>
                        YES
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleClasses() {
        var iaElements = document.querySelectorAll('.DDTL');
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

<script src="<?= base_url() ?>assessmentJs/data_department_subordinate_view.js"></script>

</body>

</html>