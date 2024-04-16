<?php require('./components/Header/header.php')

?>
<link rel="stylesheet" 
      href="/style/navbar">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
      rel="stylesheet" 
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
      crossorigin="anonymous">
<link 
    rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" >

<header id="header" class="container d-flex my-3">
      <p class="p-0 m-0 fs-2"> CryptoShow </p>
      <nav>
        <a href="/">Home</a>
        <a href="/contact">Contact</a>
        <a href="/about">About us</a>
        <a href="/threads">Event</a>
        <a href="/CreateEvent" id="CreateEvents">Create Event</a>
        <a href="/admin" id="admin-link">Dashboard</a>
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
<div id="toaster" style="width: max-content !important;" class="toast position-fixed bottom-0 end-0 m-3 z-3 shadow-lg bg-light border border-0 d-inline-flex" role="alert" aria-live="assertive" aria-atomic="true">

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="/javascript/navbar"></script>
