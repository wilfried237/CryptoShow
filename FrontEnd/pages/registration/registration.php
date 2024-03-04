<head>
    <link rel="stylesheet" href="/style/register">
</head>
<?php require("components/Navbar/Navbar.php") ?>

<main>
    <div class="row">
        <h2>Registration Form</h2>
        <form method="POST" id="registrationForm">
            <input type="text" id="firstname" name="firstname" required>
            <input type="text" id="lastname" name="lastname" required>
            <input type="password" id="password" name="password" required>
            <input type="tel" id="phone" name="phone" required>
            <input type="email" id="email" name="email" required> 
            <button type="submit">Register</button>
        </form>
    </div>
</main>
<script src="/javascript/registration"></script>