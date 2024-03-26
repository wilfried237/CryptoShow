// function declaration 

async function getAllThreadMember(MemberId){
    const data = new URLSearchParams();
    data.append('Member_id', MemberId);

    try {
        const response = await fetch(`${backendConn}/organisers/Show_thread`, {
            method: "POST",
            mode: "cors",
            cache: "no-cache",
            credentials: "same-origin",
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded', // Set content type to form-urlencoded
            },
            redirect: "follow",
            referrerPolicy: "no-referrer",
            body: data, // Use the form-encoded data
        });

        if (!response.ok) {
            throw new Error(`Network response was not ok. Status: ${response.status} - ${response.statusText}`);
        }

        const responseData = await response.json();
        
        if(responseData.status === "success"){
            // console.log(responseData.threads);
            return responseData.threads;

        }
        else{
            alert("error");
        }
       
    } catch (error) {
        console.error('Error fetching member data:', error);
        return null;
    }
}

// async function createThread(){
    
// }

async function getParticipants(ThreadsID, OrganizerID){
    const data = new URLSearchParams();
    data.append('Organizer_id', OrganizerID);
    data.append('Thread_id', ThreadsID);

    try {
        const response = await fetch(`${backendConn}/threads/getParticipants`, {
            method: "POST",
            mode: "cors",
            cache: "no-cache",
            credentials: "same-origin",
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded', // Set content type to form-urlencoded
            },
            redirect: "follow",
            referrerPolicy: "no-referrer",
            body: data, // Use the form-encoded data
        });

        
        if (!response.ok) {
            throw new Error(`Network response was not ok. Status: ${response.status} - ${response.statusText}`);
        }

        const responseData = await response.json();
        
        if(responseData.status === "success"){
            // console.log(responseData.threads);
            return responseData;

        }
        else{
            alert("error");
        }
       
    } catch (error) {
        console.error('Error fetching member data:', error);
        return null;
    }
}

async function OnclickViewMember(ThreadsID, OrganizerID){
    const threadsParticipants = await getParticipants(ThreadsID,OrganizerID);
    let y = { "threadsPart": threadsParticipants.threadParticipants,}
    localStorage.setItem("ThreadsParticipants", JSON.stringify(y));
    location.href = "/allMembers";
}

async function setElementTable(){
    if (userInfo && userInfo.Surface == 2) {
        const tableBody = document.getElementById("tableBodyS");
        const username  = document.getElementById("username");
        username.innerText = `${userInfo.Lastname}  ${userInfo.Firstname}`;
        const threadsCollection = await getAllThreadMember(userInfo.Member_id);
        let tableRow = Promise.all(Object.values(threadsCollection).map( async (element) => {
            const threadsParticipants = await getParticipants(element.Thread_id, userInfo.Member_id);

            return `
            <tr>
                <th scope="row">${element.Thread_id}</th>
                <td>${element.Thread_name}</td>
                <td>${element.Thread_date}</td>
                <td>${element.Venue}</td>
                <td>${threadsParticipants.Participants}</td>
                <td>${element.Limit}</td>
                <td>
                    <svg class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                        <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3"/>
                    </svg>
                    <ul class="dropdown-menu">
                        <li><a class="text-Primary dropdown-item" href="#" Onclick="OnclickViewMember(${element.Thread_id},${userInfo.Member_id})">View Members</a></li>
                        <li><a class="text-danger dropdown-item" href="#">Delete</a></li>
                    </ul>
                </td>
            </tr>`;
        }));
        let awaitedROw = await tableRow;
        tableBody.innerHTML= awaitedROw.join("");
    }
    
    else{
        alert("unauthorized to this page");
        window.location.href= "/";
    }
}




//---------------------------------------------


setElementTable();

const openDialogButton = document.getElementById('openDialog');
const dialog = document.getElementById('dialog');
const closeDialog = document.querySelector('.close');

openDialogButton.addEventListener('click', function() {
  dialog.style.display = 'block';
});

closeDialog.addEventListener('click', function() {
  dialog.style.display = 'none';
});

window.addEventListener('click', function(event) {
  if (event.target === dialog) {
    dialog.style.display = 'none';
  }
});

const FormEvent = document.getElementById("formEvent");

FormEvent.addEventListener('submit' , (event)=>{
    event.preventDefault();

    const formEvent = new FormData(FormEvent);
    formEvent.append("Member_id",userInfo.Member_id);
    fetch(`${backendConn}/organisers/create`, {
        method: 'POST',
        body: formEvent
    }).then(response => {
        if (response.ok) {
            return response.json(); // Parse the response as JSON
        } else {
            throw new Error('Network response was not ok.');
        }
    })
    .then(data => {
        if (data.status === 'success') { // Assuming the response contains a 'status' property
            alert(data.message);
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
