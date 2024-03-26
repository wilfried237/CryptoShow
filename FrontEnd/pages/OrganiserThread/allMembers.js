// function declaration
async function getMember(id) {
    const data = new URLSearchParams();
    data.append('Member_id', id);

    try {
        const response = await fetch("http://localhost:8000/members/get_by_id", {
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

async function setElementTable(){
    if (userInfo && userInfo.Surface == 2) {
        const tableBody = document.getElementById("tableBodyS");
        const ThreadsParticipants = JSON.parse(localStorage.getItem("ThreadsParticipants"));
        const allParticipants = ThreadsParticipants.threadsPart;
        let tableRow = Promise.all(Object.values(allParticipants).map(async (element)=>{
            const userDetails = await getMember(element.Member_id);
            console.log(userDetails);
            return `
            <tr>
                <th scope="row"> <p style="background-color:${userDetails.Colour} ;" class=" rounded-5 m-0 d-inline-block p-2 text-light"> ${userDetails.Lastname[0].toUpperCase()+userDetails.Firstname[0].toUpperCase()}</p></th>
                <td>${userDetails.Firstname}</td>
                <td>${userDetails.Lastname}</td>
                <td>${userDetails.Email}</td>
                <td>${userDetails.Phone}</td>
                <td>NAN</td>
                <td>
                    <svg class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                        <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3"/>
                    </svg>
                    <ul class="dropdown-menu">
                        <li><a class="text-danger dropdown-item" href="#">Delete Members</a></li>
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