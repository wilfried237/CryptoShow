<head>
    <link rel="stylesheet" href="./pages/login/login.css">
</head>
<?php require("components/Navbar/Navbar.php") ?>

<div class="container">
    <h2>Login Form</h2>
    <form method="POST" id="loginForm">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

        <label>Password</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Login</button>
    </form>

</div>