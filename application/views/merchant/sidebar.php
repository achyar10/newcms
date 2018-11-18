<div class="sidebar" data-color="dark" data-active-color="success">
  <div class="logo">
    <a href="<?php echo site_url('merchant') ?>">
      <div class="text-center">
        <img src="<?php echo media_url('img/v2.png') ?>" style="height: 50px">
      </div>
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="<?php echo ($this->uri->segment(2) == 'dashboard' OR $this->uri->segment(2) == NULL) ? 'active' : '' ?>">
        <a href="<?php echo site_url('merchant') ?>">
          <i class="nc-icon nc-bank"></i>
          <p>Dashboard</p>
        </a>
      </li>
      <li class="<?php echo ($this->uri->segment(2) == 'branch') ? 'active' : '' ?>">
        <a href="<?php echo site_url('merchant/branch') ?>">
          <i class="nc-icon nc-shop"></i>
          <p>Branch</p>
        </a>
      </li>
      <li class="<?php echo ($this->uri->segment(2) == 'employee') ? 'active' : '' ?>">
        <a href="<?php echo site_url('merchant/employee') ?>">
          <i class="nc-icon nc-single-02"></i>
          <p>Employee</p>
        </a>
      </li>
      <li class="<?php echo ($this->uri->segment(2) == 'payment') ? 'active' : '' ?>">
        <a href="<?php echo site_url('merchant/payment') ?>">
          <i class="nc-icon nc-money-coins"></i>
          <p>Payment</p>
        </a>
      </li>
      <li class="<?php echo ($this->uri->segment(2) == 'register') ? 'active' : '' ?>">
        <a href="<?php echo site_url('merchant/register') ?>">
          <i class="nc-icon nc-tag-content"></i>
          <p>Lisence</p>
        </a>
      </li>
      
    </ul>
  </div>
</div>