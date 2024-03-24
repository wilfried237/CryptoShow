// function declaration

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


//----------------------------------


if(userInfo){
    // variable declaration 
    const profilePP = document.getElementById("personal-profile");
    const personal_FNLN = document.getElementById("personal-FNLN");
    const personal_form = document.getElementById("personal-submit");
    const logOutBtn = document.getElementById("logOutBtn");

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

