<?php require('components/Header/header.php')?>
<link rel="stylesheet" href="/style/navbar">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" >
  

<header>
      <h1> CryptoShow </h1>
      <nav>
        <a href="/">Home</a>
        <a href="/contact">Contact</a>
        <a href="/threads">About us</a>
        <a href="/about">Event</a>
        <a href="#">Services</a>
        <button> <a href="/login"> Signin </a> </button>
        <button> <a href="/register"> Signup </a></button>
      </nav>
      <div class="header-auth-btns">
        <button> <a href="/login"> Signin </a> </button>
        <button> <a href="/register"> Signup </a></button>
      </div>
      <input id="toggler" type="checkbox">     
      <label class="toggler" aria-label="menu" for="toggler">
        <span></span>
        <span></span>
        <span></span>
      </label>
</header>