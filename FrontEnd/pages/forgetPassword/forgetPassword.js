const FormEvent = document.getElementById('forgetPassword');
const password = document.getElementById('password');
const confirmPassword = document.getElementById('ConfirmPassword');
const email = document.getElementById('email');
FormEvent.addEventListener('submit', async (event)=>{
    event.preventDefault();
    if(password.value == confirmPassword.value){
        const data = new URLSearchParams();
        data.append('password', password.value);
        data.append('email', email.value);
        try {
            const response = await fetch(`${backendConn}/members/updatePassword`, {
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
                setTimeout(()=>{ window.location.href="/login";},3000);
            }
            else{
                displayToast(responseData.message,responseData.status);
            }
           
        } catch (error) {
            console.error('Error fetching member data:', error);
            return null;
        }
    }
    else{
        displayToast("No match between new password and confirm password", "error");
    }
});
