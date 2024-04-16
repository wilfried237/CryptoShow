<head>
  
  <link rel="stylesheet" href='/style/admin_nav'>
  <!-- include fontawesome -->
  <link 
    rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" >


</head>

<body>
  <section id="menu">
    <div class="logo">
      <h2>CryptoShow</h2>
    </div>

    <div class="search">
    <i class="fa-solid fa-magnifying-glass"></i>
    <span className=" material-symbols-outlined search-icon"></span>
        <input type="text" class="searchInput" placeholder="Search" />
    </div>
    <div class="items">
    <li><i class="fa-solid fa-table-columns"></i><a href='/admin'>Dashboard</a></li>
      <li><i class="fa-solid fa-laptop"></i><a href="/adminDevices">Device</a></li>
      <li><i class="fa-regular fa-user"></i><a href='/memberAdmin'>Member</a></li>
      <li><i class="fa-solid fa-calendar-days"></i><a href='/adminEvent'>Event</a></li>
      <!-- <li><i class="fa-solid fa-right-from-bracket"></i><a href=''>Logout</a></li> -->
      <div class="footer">
      <li><i class="fa-solid fa-right-from-bracket"></i><a href=''>Logout</a></li>

      </div>
      
    </div>
  </section>
</body>