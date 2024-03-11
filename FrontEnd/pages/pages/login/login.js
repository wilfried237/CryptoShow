const loginForm = document.getElementById("loginForm");

loginForm.addEventListener('submit', (event)=>{
    event.preventDefault();

    var formData = new FormData(loginForm);
    fetch('http://localhost:8000/members/login', {
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
            alert(data.status);
            console.log(data.user);
            window.localStorage.setItem("userInfo",JSON.stringify(data.user));
            window.location.href = "/";
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
    
});