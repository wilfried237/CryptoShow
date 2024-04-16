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

async function getThreadInfo(member_id,thread_id){
    const data = new URLSearchParams();
    data.append('thread_id', thread_id);
    data.append('Member_id', member_id);

    try {
        const response = await fetch(`${backendConn}/threads/get_thread_info`, {
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
    let y = { "threadsPart": threadsParticipants.threadParticipants}
    localStorage.setItem("ThreadsParticipants", JSON.stringify(y));
    location.href = "/allMembers";
}

async function DeleteEvent(ThreadsID,MemberId){
    const data = new URLSearchParams();
    data.append('Member_id', MemberId);
    data.append('thread_id',ThreadsID);
    try {
        const response = await fetch(`${backendConn}/organisers/delete_thread`, {
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
            displayToast(responseData.message,responseData.status)
            setTimeout(()=>{ window.location.href = "/CreateEvent" },3000);

        }
        else{
            alert("error");
        }
       
    } catch (error) {
        console.error('Error fetching member data:', error);
        return null;
    }

}

function setInputValue(threadInfo){
    const name = document.getElementById('NameInput2');
    const date = document.getElementById('DateInput2');
    const location = document.getElementById('LocationInput2');
    const image = document.getElementById('ImageInput2');
    const limit = document.getElementById('LimitInput2');
    const description = document.getElementById('DescriptionTextarea2');
    name.value = threadInfo.Thread_name;
    date.value = threadInfo.Thread_date;
    location.value = threadInfo.Venue;
    image.value = threadInfo.Thread_image;
    limit.value = threadInfo.Limit;
    description.value = threadInfo.Thread_description;
}

async function modifyThread(thread_id, Organizer_id){
    const threadInfo = await getThreadInfo(Organizer_id,thread_id);    
    const dialog2 = document.getElementById('dialog2');
    dialog2.style.display = "block";
    setInputValue(threadInfo.threadInfo);
    localStorage.setItem("thread_info_Id", thread_id);
}

async function setElementTable(){
    if (userInfo && userInfo.Surface == 2) {
        const tableBody = document.getElementById("tableBodyS");
        const username  = document.getElementById("username");
        username.innerText = `${userInfo.Lastname}  ${userInfo.Firstname}`;
        const threadsCollection = await getAllThreadMember(userInfo.Member_id);
        let tableRow = Promise.all(Object.values(threadsCollection).map( async (element,index) => {
            const threadsParticipants = await getParticipants(element.Thread_id, userInfo.Member_id);
            console.log(element);
            return `
            <tr>
                <th scope="row">${index+1}</th>
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
                        <li><a class="text-danger dropdown-item" href="#" Onclick="DeleteEvent(${element.Thread_id},${userInfo.Member_id})">Delete Event</a></li>
                        <li><a class="text-warning dropdown-item" href="#" Onclick="modifyThread(${element.Thread_id},${userInfo.Member_id})">Edit Event</a></li>
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
const dialog2 = document.getElementById('dialog2');
const closeDialog2 = document.querySelector('.close2');

openDialogButton.addEventListener('click', function() {
  dialog.style.display = 'block';
});

closeDialog.addEventListener('click', function() {
  dialog.style.display = 'none';
});

closeDialog2.addEventListener('click', function() {
    dialog2.style.display = 'none';
    localStorage.removeItem('thread_info_Id');
  });

window.addEventListener('click', function(event) {
    if (event.target === dialog2) {
      dialog2.style.display = 'none';
        localStorage.removeItem('thread_info_Id');
    }
  });

window.addEventListener('click', function(event) {
  if (event.target === dialog) {
    dialog.style.display = 'none';
  }
});

const FormEvent = document.getElementById("formEvent");
const FormEvent2 = document.getElementById("formEvent2");

FormEvent2.addEventListener('submit' , (event)=>{
    event.preventDefault();

    const formEvent = new FormData(FormEvent2);
    formEvent.append("Member_id",userInfo.Member_id);
    formEvent.append("thread_id",localStorage.getItem("thread_info_Id"));
    fetch(`${backendConn}/organisers/update_thread`, {
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
            displayToast(data.message,data.status);
            localStorage.removeItem('thread_info_Id');
            setTimeout(()=>{ window.location.href = "/CreateEvent" },3000)
        } else {
            displayToast(data.message,data.status);
            localStorage.removeItem('thread_info_Id');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        localStorage.removeItem('thread_info_Id');
    });
});

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
            displayToast(data.message,data.status);
            setTimeout(()=>{ window.location.href = "/CreateEvent" },3000)
        } else {
            displayToast(data.message,data.status);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});