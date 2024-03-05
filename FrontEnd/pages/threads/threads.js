// function declaration

function getAllThreads(){
    fetch('http://localhost:8000/threads/', {
        method: 'POST'
    }).then(response => {
        if (response.ok) {
            return response.json(); // Parse the response as JSON
        } else {
            throw new Error('Network response was not ok.');
        }
    })
    .then(data => {
        if (data.status === 'success') { // Assuming the response contains a 'status' property
            console.log(data);
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}


//-------------------------------------------

getAllThreads();