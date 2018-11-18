<div class="sidebar" data-color="white" data-active-color="danger">
  <div class="logo">
    <a href="<?php echo site_url('manage') ?>">
      <div class="text-center">
        <img src="<?php echo media_url('img/v2.png') ?>" style="height: 50px">
      </div>
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="<?php echo ($this->uri->segment(2) == 'dashboard' OR $this->uri->segment(2) == NULL) ? 'active' : '' ?>">
        <a href="<?php echo site_url('manage') ?>">
          <i class="nc-icon nc-bank"></i>
          <p>Dashboard</p>
        </a>
      </li>
      <li class="<?php echo ($this->uri->segment(2) == 'merchant') ? 'active' : '' ?>">
        <a href="<?php echo site_url('manage/merchant') ?>">
          <i class="nc-icon nc-shop"></i>
          <p>Merchant</p>
        </a>
      </li>
      <li class="<?php echo ($this->uri->segment(2) == 'payment') ? 'active' : '' ?>">
        <a href="<?php echo site_url('manage/payment') ?>">
          <i class="nc-icon nc-money-coins"></i>
          <p>Payment</p>
        </a>
      </li>
      <li class="<?php echo ($this->uri->segment(2) == 'register') ? 'active' : '' ?>">
        <a href="<?php echo site_url('manage/register') ?>">
          <i class="nc-icon nc-settings-gear-65"></i>
          <p>Machine</p>
        </a>
      </li>
      <li class="<?php echo ($this->uri->segment(2) == 'users') ? 'active' : '' ?>">
        <a href="<?php echo site_url('manage/users') ?>">
          <i class="nc-icon nc-single-02"></i>
          <p>Users</p>
        </a>
      </li>
      <li class="<?php echo ($this->uri->segment(2) == 'bank' OR $this->uri->segment(2) == 'rent') ? 'active' : '' ?>">
        <a data-toggle="collapse" href="#settingSide"  aria-expanded="false">
          <i class="nc-icon nc-settings"></i>
          <p>Setting<b class="caret"></b></p>
        </a>
        <div class="collapse <?php echo ($this->uri->segment(2) == 'bank' OR $this->uri->segment(2) == 'rent') ? 'show' : '' ?>" id="settingSide">
          <ul class="nav">
            <li class="<?php echo ($this->uri->segment(2) == 'bank') ? 'active' : '' ?>">
              <a href="<?php echo site_url('manage/bank') ?>">
                <span class="sidebar-mini-icon">B</span>
                <span class="sidebar-normal"> Bank </span>
              </a>
            </li>
            <li class="<?php echo ($this->uri->segment(2) == 'rent') ? 'active' : '' ?>">
              <a href="<?php echo site_url('manage/rent') ?>">
                <span class="sidebar-mini-icon">R</span>
                <span class="sidebar-normal"> Type Product </span>
              </a>
            </li>
          </ul>
        </div>
      </li>
    </ul>
  </div>
</div>