<?php include('templates/header.php'); ?>
<?php include('templates/sidebar.php'); ?>

<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="title">
                            <h4>Profile</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a>Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Profile
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
                    <div class="pd-20 card-box height-100-p">
                        <div class="profile-photo">
                            <img src="<?= base_url() ?>vendors/images/login-gambar.png" alt="" class="avatar-photo" />
                        </div>
                        <h5 class="text-center h5 mb-0">
                            <?php echo session('userName'); ?>
                        </h5>
                        <p class="text-center text-muted font-14">
                            <?php echo session('userId'); ?>
                        </p>
                        <div class="profile-info">
                            <h5 class="mb-20 h5 text-primary">Employee Information</h5>
                            <ul class="mb-30">
                                <li>
                                    <span class="text-primary">Department:</span>
                                    <?= isset($detail['department']) ? $detail['department'] : '-'; ?>
                                </li>
                                <li>
                                    <span class="text-primary">Unit:</span>
                                    <?= isset($detail['unit']) ? $detail['unit'] : '-'; ?>
                                </li>
                                <li>
                                    <span class="text-primary">Direct Leader:</span>
                                    <?= isset($detail['direct_leader']) ? $detail['direct_leader'] : '-'; ?>
                                </li>
                            </ul>
                            <h5 class="mb-20 h5 text-primary">Contact Information</h5>
                            <ul>
                                <li>
                                    <span class="text-primary">Email Address:</span>
                                    <?php echo session('userEmail'); ?>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30">
                    <div class="card-box height-100-p overflow-hidden">
                        <div class="profile-tab height-100-p">
                            <div class="tab height-100-p">
                                <ul class="nav nav-tabs customtab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#tasks" role="tab">Tasks</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#setting" role="tab">Settings</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <!-- Tasks Tab start -->
                                    <div class="tab-pane fade show active" id="tasks" role="tabpanel">
                                        <div class="pd-20 profile-task-wrap">
                                            <div class="container pd-0">
                                                <!-- Open Task start -->
                                                <div class="task-title row align-items-center">
                                                    <div class="col-md-8 col-sm-12">
                                                        <h5>Target Department</h5>
                                                    </div>
                                                </div>
                                                <div class="profile-task-list pb-30">
                                                    <ul>
                                                        <?php foreach ($target as $target): ?>
                                                            <li>
                                                                <div class="task-type">
                                                                    <?= $target['parameter']; ?>
                                                                </div>
                                                                <?= $target['remark']; ?>
                                                                <div class="task-assign">Bobot : <div class="due-date">
                                                                        <?= $target['weight']; ?>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </div>
                                                <!-- Open Task End -->
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Tasks Tab End -->
                                    <!-- Setting Tab start -->
                                    <div class="tab-pane fade height-100-p" id="setting" role="tabpanel">
                                        <div class="profile-setting">
                                            <form>
                                                <ul class="profile-edit-list row">
                                                    <li class="weight-500 col-md-12">
                                                        <h4 class="text-blue h5">Edit Your Personal Setting</h4>
                                                    </li>
                                                    <li class="weight-500 col-md-6">
                                                        <div class="form-group">
                                                            <label>Last Password</label>
                                                            <input class="form-control form-control-lg" type="password"
                                                                id="pass1">
                                                        </div>
                                                    </li>
                                                    <li class="weight-500 col-md-6">
                                                        <div class="form-group">
                                                            <label>New Password</label>
                                                            <input class="form-control form-control-lg" type="password"
                                                                id="pass2">
                                                        </div>
                                                        <div class="form-group mb-0">
                                                            <button data-id="<?php echo session('userKey'); ?>"
                                                                type="button" class="btn btn-primary"
                                                                id="btn-update-pass">Save & Update</button>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- Setting Tab End -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<div id="password" data-password="<?php echo session('userPassword'); ?>"></div>

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

<script src="<?= base_url() ?>assessmentJs/profil_view.js"></script>
</body>

</html>