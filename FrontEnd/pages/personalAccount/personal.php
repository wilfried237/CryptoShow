<head>
    <link rel="stylesheet" href="/style/personal">
</head>
<?php require("components/Navbar/Navbar.php") ?>
<main class="personal-main">
    <section>
        <div class="personal-pp-lgt">
            <div class="personal-pp">
                <p class="personal-profile" id="personal-profile">K</p>
                <div class="personal-FNLN-ud">
                    <p class="personal-FNLN" id="personal-FNLN">Kamdoumwilfried</p>
                    <p>Update your username and manage your account</p>
                </div>
            </div>
            <button id="logOutBtn">Logout</button>
        </div>
        <Form method="post" id="personal-submit">  
            <input type="text" id="Firstname" name="Firstname">
            <input type="text" id="Lastname" name="Lastname">
            <input type="email" id="Email" name="Email">
            <input type="tel" id="Phone" name="Phone">
            <input placeholder="new password" type="password" id="Password"name="Password">
            <input placeholder="confirm password" type="password" id="confirmPassword"name="confirmPassword">
            <button type="submit">SaveChanges</button>
        </Form>
    </section>
</main>
<script src="/javascript/personal"></script>

<?php require("components/Footer/Footer.php") ?>