<?php require("components/Navbar/Navbar.php") ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<style>
    .containers{
        box-shadow: rgba(17, 12, 46, 0.15) 0px 48px 100px 0px;
        padding: 2rem;
    }
</style>
<div class="container mt-5">
    <div class="d-flex justify-content-between">
        <p id="username" class="fs-4 fw-bold">wa ls</p>
        <div>
            <button class="btn btn-primary">Create</button>
        </div>
    </div>

</div>
<div class=" container containers mt-3 rounded-3">
    <table class="table">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Date</th>
            <th scope="col">Location</th>
            <th scope="col">Participants</th>
            <th scope="col">Limit</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody id="tableBodyS">
        <!-- <tr>
            <th scope="row">1</th>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
            <td>12</td>
            <td>3</td>
            <td>
                <svg class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                    <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3"/>
                </svg>
                <ul class="dropdown-menu">
                    <li><a class="text-Primary dropdown-item" href="#">View Members</a></li>
                    <li><a class="text-danger dropdown-item" href="#">Delete</a></li>
                </ul>
            </td>
        </tr>
        <tr>
            <th scope="row">1</th>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
            <td>12</td>
            <td>3</td>
            <td>
                <svg class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                    <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3"/>
                </svg>
                <ul class="dropdown-menu">
                    <li><a class="text-Primary dropdown-item" href="#">View Members</a></li>
                    <li><a class="text-danger dropdown-item" href="#">Delete</a></li>
                </ul>
            </td>
        </tr>
        <tr>
            <th scope="row">1</th>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
            <td>12</td>
            <td>3</td>
            <td>
                <svg class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                    <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3"/>
                </svg>
                <ul class="dropdown-menu">
                    <li><a class="text-Primary dropdown-item" href="#">View Members</a></li>
                    <li><a class="text-danger dropdown-item" href="#">Delete</a></li>
                </ul>
            </td>
        </tr> -->
    </tbody>
    </table>
</div>



<script src="/javascript/CreateEvent"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>