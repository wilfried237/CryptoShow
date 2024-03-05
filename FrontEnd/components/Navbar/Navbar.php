<?php require('components/Header/header.php')

?>
<link rel="stylesheet" href="/style/navbar">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" >
  

<header id="header">
      <h1> CryptoShow </h1>
      <nav>
        <a href="/">Home</a>
        <a href="/contact">Contact</a>
        <a href="/about">About us</a>
        <a href="/threads">Event</a>
        <a href="#">Services</a>
        <a href="/personalAccount" id="header-profile-1" class="header-profile">F</a>
        <div id="header-auth-btn" style="display: flex; flex-direction:column;">
          <button> <a href="/login"> Signin </a> </button>
          <button> <a href="/register"> Signup </a></button>
        </div>
      </nav>
      <div id="header-auth-btns" class="header-auth-btns">
        <button> <a href="/login"> Signin </a> </button>
        <button> <a href="/register"> Signup </a></button>
      </div>
      <a href="/personalAccount" id="header-profile" class="header-profile">F</a>
      <input id="toggler" type="checkbox">     
      <label class="toggler" aria-label="menu" for="toggler">
        <span></span>
        <span></span>
        <span></span>
      </label>
</header>
<script src="/javascript/navbar"></script>