<?php require("components/Navbar/Navbar.php") ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<style>
.containers{
    box-shadow: rgba(17, 12, 46, 0.15) 0px 48px 100px 0px;
    padding: 2rem;
}
.dialog {
  display: none;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0,0,0,0.4);
}

.dialog-content {
  background-color: #fefefe;
  margin: 15% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}

</style>

<div class="container mt-5">
    <div class="d-flex justify-content-between">
        <p id="username" class="fs-4 fw-bold">wa ls</p>
        <div>
            <button id="openDialog" class="btn btn-primary">Create</button>
        </div>
    </div>
</div>

<div id="dialog" class="dialog">
        <div class="dialog-content rounded">
            <span class="close">&times;</span>
            <div class="p-5">
                <form id="formEvent" method="POST">
                    <div class="mb-3">
                        <label for="NameInput" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="NameInput" placeholder="Event Name">
                    </div>
                    <div class="mb-3">
                        <label for="DateInput" class="form-label">Date</label>
                        <input type="date" name="date" class="form-control" id="DateInput1">
                    </div>
                    <div class="mb-3">
                        <label for="LocationInput" class="form-label">Location</label>
                        <input type="text" name="location" class="form-control" id="LocationInput" placeholder="Location">
                    </div>
                    <div class="mb-3">
                        <label for="ImageInput" class="form-label">ImageURl</label>
                        <input type="text" name="image" class="form-control" id="ImageInput" placeholder="Image Link">
                    </div>
                    <div class="mb-3">
                        <label for="LimitInput" class="form-label">Limit Participants</label>
                        <input type="number" name="limit" class="form-control" id="LimitInput" placeholder="Limit people">
                    </div>
                    <div class="mb-3">
                        <label for="DescriptionTextarea" class="form-label">Description</label>
                        <textarea name="description" class="form-control" id="DescriptionTextarea" rows="3"></textarea>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
</div>

<div class=" container shadow-lg p-5 mt-3 rounded-3">
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
    </tbody>
    </table>
</div>

<script src="/javascript/CreateEvent"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>