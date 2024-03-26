const rgsF = document.getElementById("registrationForm");
const password = document.getElementById("password");
const confirm_password = document.getElementById("confirm_password");

rgsF.addEventListener('submit', (event) => {
    event.preventDefault();
    if(password.value === confirm_password.value){
        var formData = new FormData(rgsF);
        fetch(`${backendConn}/members/register`, {
            method: 'POST',
            body: formData
        }).then(response => {
            if (response.ok) {
                return response.json(); // Parse the response as JSON
            } else {
                throw new Error('Network response was not ok.');
            }
        })
        .then(data => {
            if (data.status === 'success') { // Assuming the response contains a 'status' property
                alert('Registration successful. Welcome, ' + data.firstname);
                window.location.href = "/login";
            } else {
                alert('Registration unsuccessful. Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
    else{
        password.style.borderBottomColor="red";
        confirm_password.style.borderBottomColor="red";
    }


});
