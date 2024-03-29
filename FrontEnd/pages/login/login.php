<head>
    <link rel="stylesheet" href="/style/login">
</head>
<?php require("components/Navbar/Navbar.php") ?>
<main>
    <div class="row">
            <p>Login Form</p>
            <form method="POST" id="loginForm">
                <input placeholder="Email" type="email" id="email" name="email" required>
                <input placeholder="Password" type="password" id="password" name="password" required>
                <button type="submit">Login</button>
            </form>
    </div>
</main>
<script src="/javascript/login"></script>

<?php require("components/Footer/Footer.php") ?>
