
async function getMemberDevice(Organizer_id, Member_id, thread_id){
    const data = new URLSearchParams();
    data.append('Organizer_id', Organizer_id);
    data.append('Member_id', Member_id);
    data.append('thread_id', thread_id);
    try {
        const response = await fetch(`${backendConn}/organisers/get_member_Devices`, {
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
        
        return responseData.devices;
    } catch (error) {
        console.error('Error fetching member data:', error);
        return null;
    }
}

async function deleteDevice(organizer_id, thread_id, device_id){
    
    const data = new URLSearchParams();
    data.append('Organizer_id', organizer_id);
    data.append('device_id', device_id);
    data.append('thread_id', thread_id);

    try {
        const response = await fetch(`${backendConn}/device/delete_device`, {
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
            displayToast(responseData.message,responseData.status);
            setTimeout(()=>{ window.location.href="/allMembers";},3000);
        }
        else{
            displayToast(responseData.message,responseData.status);
        }
       
    } catch (error) {
        console.error('Error fetching member data:', error);
        return null;
    }
}

async function launcher(){
    const tableBody = document.getElementById('tableBodyS');
    const threadParticipant = JSON.parse(localStorage.getItem('ThreadsParticipants'));
    const member_device_id = JSON.parse(localStorage.getItem('member_device_id'));
    const allParticipants = threadParticipant.threadsPart[userInfo.Member_id];
    const devices = await getMemberDevice(userInfo.Member_id,member_device_id, allParticipants.Thread_id);
    console.log(allParticipants);
    let tableRow = Promise.all(devices.map(async (element)=>{
        return `
        <tr>
            <th scope="row"> <img class="rounded-5 m-0 d-inline-block" height="45" width="45" src="${element.Device_image}"></th>
            <td>${element.Device_name}</td>
            <td>${element.Device_description}</td>
            <td>${element.Created_at}</td>
            <td>${element.Updated_at}</td>
            <td>
                <svg class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                    <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3"/>
                </svg>
                <ul class="dropdown-menu">
                    <li><a class="text-danger dropdown-item" onClick="deleteDevice(${userInfo.Member_id},${element.Thread_id},${element.Device_id})" href="#">Delete Device</a></li>
                </ul>
            </td>
        </tr>`;
    }));
    let awaitedROw = await tableRow;
    tableBody.innerHTML= awaitedROw.join("");
}

window.addEventListener('DOMContentLoaded', async ()=>{
    if(userInfo && userInfo.Surface == 2){
        await launcher();
    }
    else{
        alert("unauthorized to this page");
        window.location.href= "/";
    }
});