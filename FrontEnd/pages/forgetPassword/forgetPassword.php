<head>
    <link rel="stylesheet" href="/style/forgetPassword">
</head>
<?php require("components/Navbar/Navbar.php") ?>
<main>
    <div class="row">
            <p>Forget Password Form</p>
            <form method="POST" id="forgetPassword">
                <input placeholder="Email" type="email" id="email" name="email" required>
                <input placeholder="New Password" type="password" id="password" name="password" required>
                <input placeholder="Confirm Password" type="password" id="ConfirmPassword" required>
                <button type="submit">Change</button>
            </form>
    </div>
</main>

<script src="/javascript/forgetPassword"></script>
<?php require("components/Footer/Footer.php") ?>