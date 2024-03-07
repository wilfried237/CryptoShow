<head>
    <link rel="stylesheet" href="/style/register">
</head>
<?php require("components/Navbar/Navbar.php") ?>

<main>
    <div class="row">
        <p>Registration Form</p>
        <form method="POST" id="registrationForm">
            <input placeholder="First Name" type="text" id="firstname" name="firstname" required>
            <input placeholder="Last Name" type="text" id="lastname" name="lastname" required>
            <input placeholder="Phone Number" type="tel" id="phone" name="phone" required>
            <input placeholder="Email" type="email" id="email" name="email" required> 
            <input placeholder="Password" type="password" id="password" name="password" required>
            <input placeholder="Confirm Password" type="password" id="confirm_password" name="confirm_password" required>
            
            <button type="submit">Register</button>
        </form>
    </div>
</main>
<script src="/javascript/registration"></script>

<?php require("components/Footer/Footer.php") ?>