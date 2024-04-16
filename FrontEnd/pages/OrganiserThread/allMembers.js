// function declaration

async function Get_number_devices(organizer_id, Member_id, thread_id){
    const data = new URLSearchParams();
    data.append('Organizer_id', organizer_id);
    data.append('Member_id', Member_id);
    data.append('thread_id', thread_id);

    try {
        const response = await fetch(`${backendConn}/organisers/get_number_Devices`, {
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
        return responseData.device_count;
    } catch (error) {
        console.error('Error fetching member data:', error);
        return null;
    }
}

async function getMember(id) {
    const data = new URLSearchParams();
    data.append('Member_id', id);

    try {
        const response = await fetch(`${backendConn}/members/get_by_id`, {
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
        // console.log('Response data:', responseData.user);
        return responseData.user;
    } catch (error) {
        console.error('Error fetching member data:', error);
        return null;
    }
}

async function deleteMember(member_id, Organizer_id,thread_id){

    const data = new URLSearchParams();
    data.append('Organizer_id', Organizer_id);
    data.append('Member_id', member_id);
    data.append('thread_id', thread_id);

    try {
        const response = await fetch(`${backendConn}/organisers/delete_member_thread`, {
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
            setTimeout(()=>{ window.location.href="/CreateEvent";},3000);
        }
        else{
            alert("error");
        }
       
    } catch (error) {
        console.error('Error fetching member data:', error);
        return null;
    }
}
function getDevices(memberID){
    localStorage.setItem('member_device_id',memberID);
}
async function setElementTable(){
    if (userInfo && userInfo.Surface == 2) {
        const tableBody = document.getElementById("tableBodyS");
        const UserName = document.getElementById("username");
        UserName.innerText =userInfo.Lastname + " " +userInfo.Firstname;
        const ThreadsParticipants = JSON.parse(localStorage.getItem("ThreadsParticipants"));
        const allParticipants = ThreadsParticipants.threadsPart;
        let tableRow = Promise.all(Object.values(allParticipants).map(async (element)=>{
            const userDetails = await getMember(element.Member_id);
            const Numberdevices = await Get_number_devices(userInfo.Member_id,element.Member_id,element.Thread_id);
            return `
            <tr>
                <th scope="row"> <p style="background-color:${userDetails.Colour} ;" class="rounded-5 m-0 d-inline-block p-2 text-light"> ${userDetails.Firstname[0].toUpperCase()+userDetails.Lastname[0].toUpperCase()}</p></th>
                <td>${userDetails.Firstname}</td>
                <td>${userDetails.Lastname}</td>
                <td>${userDetails.Email}</td>
                <td>${userDetails.Phone}</td>
                <td>${Numberdevices}</td>
                <td>
                    <svg class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                        <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3"/>
                    </svg>
                    <ul class="dropdown-menu">
                        ${Numberdevices>0 ? `<li><a class="text-primary dropdown-item" onClick="getDevices(${userDetails.Member_id})" href="/allDevice">View devices</a></li>`: ''}
                        <li><a class="text-danger dropdown-item" onClick="deleteMember(${userDetails.Member_id}, ${userInfo.Member_id}, ${element.Thread_id})" href="#">Delete Member</a></li>
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

//------------------------------------------------------

setElementTable();