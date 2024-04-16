const loginForm = document.getElementById("loginForm");

loginForm.addEventListener('submit', (event)=>{
    event.preventDefault();

    var formData = new FormData(loginForm);
    fetch(`${backendConn}/members/login`, {
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
            
            window.localStorage.setItem("userInfo",JSON.stringify(data.user));
            displayToast(data.message,data.status);
            setTimeout(() => {window.location.href = "/"; }, 3000);
            
            
        } else {
            displayToast(data.message,data.status);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
    
});