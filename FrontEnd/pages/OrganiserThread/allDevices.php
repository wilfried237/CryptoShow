<?php require("components/Navbar/Navbar.php") ?>
<main class="container mt-5">
    <div class="mb-5">
        <p id="username" class="fs-4 fw-bold"></p>
    </div>

    <section>
        <div class=" container shadow-lg rounded-3 p-4">
            <table class="table ">
                <thead>
                    <tr>
                        <th scope="col">Image</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Created_at</th>
                        <th scope="col">Updated_at</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody id="tableBodyS">
                    
                </tbody>
            </table>
        </div>
    </section>
</main>
<script src="/javascript/allDevice"></script>