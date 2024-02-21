<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8" />
    <title>TIMW Employee Assessment</title>

    <!-- Site favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url() ?>vendors/images/logo-timw1.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url() ?>vendors/images/logo-timw1.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url() ?>vendors/images/logo-timw1.png" />

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>vendors/styles/core.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>vendors/styles/icon-font.min.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>vendors/styles/style.css" />

    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() {
            dataLayer.push(arguments);
        }
        gtag("js", new Date());

        gtag("config", "G-GBZ3SGGX85");
    </script>
</head>

<body class="login-page">
    <div class="login-header box-shadow">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="brand-logo">
                <a>
                    <img src="<?= base_url() ?>vendors/images/logo-timw1.png" alt="">
                    <h2 class="text-center text-black">Assessment</h2>
                </a>
            </div>
        </div>
    </div>
    <div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 col-lg-7">
                    <img src="<?= base_url() ?>vendors/images/login-gambar.png" alt="" />
                </div>
                <div class="col-md-6 col-lg-5">
                    <div class="login-box bg-white box-shadow border-radius-10">
                        <div class="login-title">
                            <h2 class="text-center text-black">Login To Employee Assessment</h2>
                        </div>
                        <form>
                            <div class="input-group custom">
                                <input type="text" class="form-control form-control-lg" id="email" placeholder="Email" />
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                                </div>
                            </div>
                            <div class="input-group custom">
                                <input type="password" class="form-control form-control-lg" id="password" placeholder="Password" />
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                                </div>
                            </div>
                            <div class="row pb-30">
                                <div class="col-6">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck1" />
                                        <label class="custom-control-label" for="customCheck1">Remember</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="input-group mb-0">
                                        <a class="btn btn-primary btn-lg btn-block"
                                            id="btn-login">Sign In</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- js -->
    <script src="<?= base_url() ?>vendors/scripts/core.js"></script>
    <script src="<?= base_url() ?>vendors/scripts/script.min.js"></script>
    <script src="<?= base_url() ?>vendors/scripts/process.js"></script>
    <script src="<?= base_url() ?>vendors/scripts/layout-settings.js"></script>
    <script src="<?= base_url() ?>vendors/sweet/sweet2.js"></script>

    <script src="<?= base_url() ?>assessmentJs/login_view.js"></script>
</body>

</html>