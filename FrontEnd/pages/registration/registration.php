<head>
    <link rel="stylesheet" href="./pages/registration/registration.css">
</head>
<?php require("components/Navbar/Navbar.php") ?>
<body>
<div class="container">
    <h2>Registration Form</h2>
    <form method="POST" id="registrationForm">
        <label for="firstname">First Name:</label>
        <input type="text" id="firstname" name="firstname" required>
        
        <label for="lastname">Last Name:</label>
        <input type="text" id="lastname" name="lastname" required>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        
        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" name="phone" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <button type="submit">Register</button>
    </form>
</div>
</body>
<script src="./pages/registration/registration.js"></script>