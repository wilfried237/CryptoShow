<?php
require("./BackEnd/function/authentication.php");
if (!is_admin()) {
  // Redirect to the homepage or display an error message
  header("Location: ..Frontend/index.php");
  exit();
}
?>
<head>
  
  <link rel="stylesheet" href='/style/admin'>
  <!-- include fontawesome -->
  <link 
    rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" >


</head>

<body>
  <div class="containers">

      <nav id="menu">
        <div class="logo">
          <h2>CryptoShow</h2>
        </div>

        <div class="items">
          <li><i class="fa-solid fa-table-columns"></i><a href="#">Dashboard</a></li>
          <li><i class="fa-solid fa-gear"></i><a href="#">Settings</a></li>
          <li><i class="fa-solid fa-laptop"></i><a href="#">Device</a></li>
          <li><i class="fa-regular fa-user"></i><a href="#">Member</a></li>
        </div>
      </nav>
   

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