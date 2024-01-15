      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="<?= base_url(); ?>" class="brand-link">
            <?php 
                $brand = $this->session->userdata('app_icon');
                if (!empty($brand) && file_exists('./assets/img/' . $brand)) {
                  $logo = base_url('assets/img/' . $brand);
                } else {
                  $logo = base_url('assets/img/letter-p.png');
                }
            ?>
          <img src="<?= $logo; ?>" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light"><?= $this->session->userdata('app_name'); ?></span>
        </a>
        <div class="sidebar">
          <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
            <div class="image">
            <?php 
                $pr_img = $this->session->userdata('profile_img');
                if (!empty($pr_img) && file_exists('./assets/img/' . $pr_img)) {
                  $prof_img = base_url('assets/img/' . $pr_img);
                } else {
                  $prof_img = base_url('assets/img/letter-p.png');
                }
            ?>
              <img src="<?= $prof_img; ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
              <a href="<?= base_url('my-account'); ?>" class="d-block">
                <?= ucwords($this->session->userdata('firstname')." ".$this->session->userdata('lastname')); ?>
              </a>
              <div class="text-designation"><?= ucfirst($this->session->userdata('type')); ?></div>
            </div>
          </div>
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <li class="nav-item">
                <a href="<?= base_url('dashboard'); ?>" class="nav-link">
                  <i class="nav-icon fas fa-th"></i>
                  <p> Dashboard </p>
                </a>
              </li>
              <?php if ($this->session->userdata('type') == 'admin') { ?>
              <li class="nav-item"> 
                <a href="<?= base_url('business-units'); ?>" class="nav-link">
                  <i class="nav-icon fas fa-building"></i>
                  <p> Business Units</p>
                  <i class="fas fa-angle-left right"></i>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?= base_url('business-units'); ?>" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Companies</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('business-units/managers'); ?>" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Managers</p>
                        </a>
                    </li>
                </ul>
              </li>
              <?php } ?>
              <?php if ( $this->session->userdata('type') != 'candidate' && $this->session->userdata('type') != 'client') { ?>
              <li class="nav-item">
                <a href="<?= base_url('qr-codes'); ?>" class="nav-link">
                  <i class="nav-icon fas fa-qrcode"></i>
                  <p> QR Codes</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('clients'); ?>" class="nav-link">
                  <i class="nav-icon fas fa-user-cog"></i>
                  <p> Clients</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('candidates'); ?>" class="nav-link">
                  <i class="nav-icon fas fa-chalkboard-teacher"></i>
                  <p> Candidates </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-question"></i>
                    <p>
                        Question Bank
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?= base_url('question-bank/categories'); ?>" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Categories</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('question-bank'); ?>" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Questions</p>
                        </a>
                    </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('exams'); ?>" class="nav-link">
                  <i class="nav-icon fas fa-file-alt"></i>
                  <p> Exams </p>
                </a>
              </li>
              <?php } else if ($this->session->userdata('type') == 'client') {?>
              <li class="nav-item">
                <a href="<?= base_url('exams'); ?>" class="nav-link">
                  <i class="nav-icon fas fa-file-alt"></i>
                  <p> Exams </p>
                </a>
              </li> 
              <?php } else { ?>
              <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-question"></i>
                    <p>
                        Exams
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?= base_url('exams/upcoming'); ?>" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Upcoming</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('exams/completed'); ?>" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Completed</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('exams/ongoing'); ?>" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Ongoing</p>
                        </a>
                    </li>
                </ul>
              </li>
              <?php } ?>
              <?php if ($this->session->userdata('type') == 'admin') { ?>
              <li class="nav-item"> 
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-paper-plane"></i>
                  <p> Delivery Report</p>
                  <i class="fas fa-angle-left right"></i>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?= base_url('delivery-report?type=sms'); ?>" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>SMS</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('delivery-report?type=email'); ?>" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Email</p>
                        </a>
                    </li>
                </ul>
              </li>
              <?php } ?>
              <li class="nav-item">
                <a href="<?= base_url('settings'); ?>" class="nav-link">
                  <i class="nav-icon fas fa-cogs"></i>
                  <p> Settings </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('logout'); ?>" class="nav-link">
                  <i class="nav-icon fas fas fa-sign-out-alt"></i>
                  <p> Logout </p>
                </a>
              </li>
            </ul>
          </nav>
        </div>
      </aside>