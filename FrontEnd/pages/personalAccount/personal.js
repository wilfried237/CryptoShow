// function declaration
async function hasRegistered(Member_id){
    const data = new URLSearchParams();
    data.append('Member_id', Member_id);
    try {
        const response = await fetch(`${backendConn}/members/hasRequested`, {
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
        return responseData.member_count;
    } catch (error) {
        console.error('Error fetching member data:', error);
        return null;
    }
}

async function requestLevelUp(Member_id){
    const data = new URLSearchParams();
    data.append('Member_id', Member_id);
    try {
        const response = await fetch(`${backendConn}/members/request_level_up`, {
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
            displayToast(responseData.message, responseData.status);
            setTimeout(()=>{},3000);
        }
        else{
            displayToast(responseData.message, responseData.status);
            setTimeout(()=>{},3000);
        }
    } catch (error) {
        console.error('Error fetching member data:', error);
        return null;
    }
}

function signOut(){
    localStorage.clear();
}

function updateUser(formData){
    fetch(`${backendConn}/members/update`, {
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
            alert(data.message);
            localStorage.setItem("userInfo", JSON.stringify(data.user));
            setInputValue(data.user);
            window.location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function setInputValue(userInfo){
    const user_firstname = document.getElementById("Firstname");
    const user_lastname = document.getElementById("Lastname");
    const user_email = document.getElementById("Email");
    const user_phone = document.getElementById("Phone");
    user_firstname.value = userInfo.Firstname;
    user_lastname.value = userInfo.Lastname;
    user_email.value = userInfo.Email;
    user_phone.value = userInfo.Phone;
}

async function printResult() {
    const result = await hasRegistered(userInfo.Member_id);
    if(result<1){
        await requestLevelUp(userInfo.Member_id);
    }else{
        displayToast("Have already requested", "warning");
        setTimeout(()=>{},3000);
    }
}

//----------------------------------

const Organizer_btn = document.getElementById('Organizer_Request_btn');
Organizer_btn.addEventListener('click',()=>{
    printResult();
});

if(userInfo){
    // variable declaration 
    const profilePP = document.getElementById("personal-profile");
    const personal_FNLN = document.getElementById("personal-FNLN");
    const personal_form = document.getElementById("personal-submit");
    const logOutBtn = document.getElementById("logOutBtn");
    const OrganizerDiv = document.getElementById("Organizer_Request_Div");
    userInfo.Surface==2? OrganizerDiv.innerHTML="": null;
    userInfo.Surface==1? OrganizerDiv.innerHTML="": null;
    personal_FNLN.innerHTML = userInfo.Firstname +" "+ userInfo.Lastname;
    profilePP.style.backgroundColor= userInfo.Colour;
    profilePP.innerText = userInfo.Firstname[0].toUpperCase() + userInfo.Lastname[0].toUpperCase();
    
    setInputValue(userInfo);
    

    personal_form.addEventListener("submit",(event)=>{
        event.preventDefault();
        var formData = new FormData(personal_form);
        formData.append("member_id", userInfo.Member_id);
        updateUser(formData);
    })
    
    logOutBtn.addEventListener("click", ()=>{
        signOut();
        window.location.href = "/";
    });
}
else{
    window.location.href="/";
    alert("need to signin or signup");
    
}

