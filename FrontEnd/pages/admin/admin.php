
<head>
  
  <link rel="stylesheet" href='/style/admin'>

</head>

<body>
  <div class="containers">
    <?php require('components/AdminNav/adminNav.php') ?>
    <section id="interface">
      <div class="navigation">
        <h3>Dashboard</h3>
        <p>Crypto Show @ </p>
        <p>Dashboard</p>
      </div>
      <h3 id="stat-h">Statistics</h3>
      <div class="stats">
        <div class="con">
          <h4>Monthly Bandwidth</h4>
          <div class="separator">
            <p>0% used</p>
            <p>0 / 3000MB</p>
          </div>
          <div class="line"></div>
        </div>
        <div class="con">
          <h4>Data Usage</h4>
          <div class="separator">
            <p>0% used</p>
            <p>0 / 300 MB</p>
          </div>
          <div class="line"></div>
        </div>
        <div class="con">
          <h4>Inodes</h4>
          <div class="separator">
            <p>0% used</p>
            <p>4 / 10000</p>
          </div>
          <div class="line"></div>
        </div>
      </div>
      <h3 id="stat-h">Website</h3>
      <div class="stats">
        <div class="con1">
          <i class="fa-brands fa-wordpress"></i>
          <p>WordPress</p>
        </div>
        <div class="con1">
          <i class="fa-solid fa-circle-exclamation"></i>
          <p>Errors</p>
        </div>
        <div class="con1">
          <i class="fa-solid fa-desktop"></i>
          <p>Devices</p>
        </div>
      </div>

    </section>
  </div>
</body>

<?php require("components/Footer/Footer.php") ?>