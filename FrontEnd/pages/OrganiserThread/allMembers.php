<?php require("components/Navbar/Navbar.php") ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<main class="container mt-5">
    <div class="mb-5">
        <p id="username" class="fs-4 fw-bold">wa ls.Thread</p>
    </div>
    <section>
        <div class=" container shadow-lg rounded-3 p-4">
            <table class="table ">
                <thead>
                    <tr>
                        <th scope="col">Profile</th>
                        <th scope="col">FirstName</th>
                        <th scope="col">LastName</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Device</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody id="tableBodyS">
                    <tr>
                        <th scope="row"><p class="bg-secondary m-0 rounded-5" style="width: 50px; height: 50px;"> </p></th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        <td>12</td>
                        <td>moto</td>
                        <td>
                            <svg class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                                <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3"/>
                            </svg>
                            <ul class="dropdown-menu">
                                <li><a class="text-danger dropdown-item" href="#">Remove Member</a></li>
                            </ul>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</main>

<script src="/javascript/allMembers"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>