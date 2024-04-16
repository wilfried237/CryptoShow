<?php require("components/Navbar/Navbar.php") ?>
<link rel="stylesheet" href="/style/threadInfo">
</head>
<style>
.containers{
    box-shadow: rgba(17, 12, 46, 0.15) 0px 48px 100px 0px;
    padding: 2rem;
}
.dialog {
  display: none;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0,0,0,0.4);
}

.dialog-content {
  background-color: #fefefe;
  margin: 15% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}

</style>
<div id="dialog" class="dialog">
            <div class="dialog-content rounded ">
                <span class="close">&times;</span>
                <div class="p-5">
                    <div class="d-flex justify-content-between align-items-center ">
                        <p class="fs-4">Add Device</p>
                        <a onClick="addDeviceElement()" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                        </svg></a>
                    </div>
                    
                    <div id="formEvent">

                    </div>

                    <button id="formEventBook" class="btn btn-primary"> book </buttoni>
                </div>
            </div>
</div>
<div class="containers">
    <div id="product-container" class="product-container">
    </div>
</div>
<script src="/javascript/threadInfo" ></script>