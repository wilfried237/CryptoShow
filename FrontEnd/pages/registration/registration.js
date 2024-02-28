const rgsF = document.getElementById("registrationForm");

rgsF.addEventListener('submit', (event) => {
    event.preventDefault();
    alert("hello");
    var formData = new FormData(rgsF);

    fetch('http://localhost:8000/members/register', {
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
        } else {
            alert('Registration unsuccessful. Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
