<body>
    <div class="pre-loader">
        <div class="pre-loader-box">
            <div class="loader-logo">
                <img src="<?= base_url() ?>vendors/images/logo-timw1.png" alt="" />
            </div>
            <div class="loader-progress" id="progress_div">
                <div class="bar" id="bar1"></div>
            </div>
            <div class="percent" id="percent1">0%</div>
            <div class="loading-text">Loading...</div>
        </div>
    </div>

    <div class="header">
        <div class="header-left">
            <div class="menu-icon bi bi-list"></div>
        </div>
        <div class="header-right">
            <div class="user-info-dropdown">
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                        <span class="user-icon">
                            <img src="<?= base_url() ?>vendors/images/profil-y.png" alt="">
                        </span>
                        <span class="user-name">
                            <?php echo session('userName'); ?>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                        <a class="dropdown-item" href="/Em/prof"><i class="dw dw-user1"></i> Profile</a>
                        <a class="dropdown-item" href="/logout-user"><i class="dw dw-logout"></i> Log Out</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="left-side-bar">
        <div class="brand-logo">
            <a>
                <img src="<?= base_url() ?>vendors/images/logo-timw1.png" width="100" height="50">
                <h6 class="text-white font-20">Assessment</h6>
            </a>
            <div class="close-sidebar" data-toggle="left-sidebar-close">
                <i class="ion-close-round"></i>
            </div>
        </div>
        <div class="menu-block customscroll">
            <div class="sidebar-menu">
                <ul id="accordion-menu">
                    <?php if (session('userRole') === 'admin'): ?>
                        <li>
                            <a href="/Em/dash" class="dropdown-toggle no-arrow DA">
                                <span class="micon bi bi-house"></span><span class="mtext">Dashboard</span>
                            </a>
                        </li>
                        <li class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle">
                                <span class="micon bi bi-hdd-stack"></span><span class="mtext">Data Management</span>
                            </a>
                            <ul class="submenu">
                                <li><a class="DEM" href="/Em/dEm">Employee</a></li>
                                <li><a class="DAC" href="/Em/dAcc">Account</a></li>
                                <li><a class="DCA" href="/Em/dCat">Category</a></li>
                                <li><a class="DAP" href="/Em/dPar">Assessment Parameter</a></li>
                                <li><a class="DDT" href="/Em/dTar">Department Targets</a></li>
                                <li><a class="DSA" href="/Em/dReSel">Self Assessment Result</a></li>
                                <li><a class="DLA" href="/Em/dReLea">Leader Assessment Result</a></li>
                                <li><a class="DGM" href="/Em/dReSen">Senior GM Assessment Result</a></li>
                                <li><a class="DSP" href="/Em/dScPr">Score Proportion</a></li>
                                <li><a class="DFA" href="/Em/dFinRe">Final Assessment Result</a></li>
                            </ul>
                        </li>
                    <?php elseif (session('userRole') === 'seniorGm'): ?>
                        <li>
                            <a href="/Em/dash" class="dropdown-toggle no-arrow DA">
                                <span class="micon bi bi-house"></span><span class="mtext">Dashboard</span>
                            </a>
                        </li>
                        <li class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle">
                                <span class="micon bi bi-clipboard2-check"></span><span class="mtext">Assessment</span>
                            </a>
                            <ul class="submenu">
                                <li><a class="ASG" href="/Em/aSen">Senior GM Assessment</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle">
                                <span class="micon bi bi-file-earmark-text"></span><span class="mtext">Report</span>
                            </a>
                            <ul class="submenu">
                                <li><a class="RSG" href="/Em/rSen">Senior GM Assessment</a></li>
                            </ul>
                        </li>

                    <?php elseif (session('userRole') === 'leader'): ?>
                        <li>
                            <a href="/Em/dash" class="dropdown-toggle no-arrow DA">
                                <span class="micon bi bi-house"></span><span class="mtext">Dashboard</span>
                            </a>
                        </li>
                        <li class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle">
                                <span class="micon bi bi-hdd-stack"></span><span class="mtext">Data Management</span>
                            </a>
                            <ul class="submenu">
                                <li><a class="DDTL" href="/Em/dTarLe">Assessment Parameters</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle">
                                <span class="micon bi bi-clipboard2-check"></span><span class="mtext">Assessment</span>
                            </a>
                            <ul class="submenu">
                                <li><a class="ASA" href="/Em/aSel">Self Assessment</a></li>
                                <li><a class="ASB" href="/Em/aLea">Subordinate Assessment</a></li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle">
                                <span class="micon bi bi-file-earmark-text"></span><span class="mtext">Report</span>
                            </a>
                            <ul class="submenu">
                                <li><a class="RSA" href="/Em/rSel">Self Assessment</a></li>
                                <li><a class="RSB" href="/Em/rLea">Subordinate Assessment</a></li>
                            </ul>
                        </li>

                    <?php else: ?>
                        <li>
                            <a href="/Em/dash" class="dropdown-toggle no-arrow DA">
                                <span class="micon bi bi-house"></span><span class="mtext">Dashboard</span>
                            </a>
                        </li>
                        <li class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle">
                                <span class="micon bi bi-clipboard2-check"></span><span class="mtext">Assessment</span>
                            </a>
                            <ul class="submenu">
                                <li><a class="ASA" href="/Em/aSel">Self Assessment</a></li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle">
                                <span class="micon bi bi-file-earmark-text"></span><span class="mtext">Report</span>
                            </a>
                            <ul class="submenu">
                                <li><a class="RSA" href="/Em/rSel">Self Assessment</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="mobile-menu-overlay"></div>