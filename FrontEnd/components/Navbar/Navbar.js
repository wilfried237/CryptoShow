/**
 * @author Wilfried Kamdoum <kamdoumwilfried8@gmail.com>
 * 
 * @param {*} title 
 * @param {*} message 
 * 
 * @returns {*} Toast
 */
function displayToast(title="Show message",type="danger"){
  const toast =new bootstrap.Toast('.toast');
  const toaster = document.getElementById('toaster');
  // const toastTitle = document.getElementById("toastTitle");
  switch(type){
    case'success':
      toaster.innerHTML=`
      <div class="d-flex gap-2 p-3">
      <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi text-success bi-check2" viewBox="0 0 16 16">
        <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0"/>
      </svg>
        <strong class="me-auto text-success" id="toastTitle">${title}</strong>
      </div>
      `;
    break;
    case'warning':
      toaster.innerHTML=`
      <div class="d-flex gap-2 p-3">
      <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi text-warning bi-exclamation-circle" viewBox="0 0 16 16">
      <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
      <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z"/>
    </svg>
        <strong class="me-auto text-warning" id="toastTitle">${title}</strong>
      </div>
      `;
    break;
    case 'error' || 'danger':
      toaster.innerHTML=`
      <div class="d-flex gap-2 p-3">
      <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-x-lg text-danger" viewBox="0 0 16 16">
      <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
      </svg>

        <strong class="me-auto text-danger" id="toastTitle ">${title}</strong>
      </div>
      `;
    break;
    default:
    break;
  }
  return toast.show();
}

// displayToast();
//------------------------------------------------------------------
const headerbtns = document.getElementById("header-auth-btns");
const headerbtn = document.getElementById("header-auth-btn");
const link1 = document.getElementById("header-profile");
const link2 = document.getElementById("header-profile-1");
const link4 = document.getElementById("admin-link");
const userInfo =JSON.parse(localStorage.getItem("userInfo"));
const header = document.getElementById("header");
const link3 = document.getElementById("CreateEvents");
link3.style.display = "none";
const backendConn = "http://localhost:8000";
const toaster = document.getElementById('toaster');


if(userInfo){

  userInfo.Surface===2? link3.style.display = "block":link3.style.display = "none";
  userInfo.Surface===1? link4.style.display = "block":link4.style.display = "none";
  headerbtns.style.display="none";
  headerbtn.style.display="none";

  link1.style.backgroundColor =userInfo.Colour;
  link2.style.backgroundColor =userInfo.Colour;
  link1.innerText = userInfo.Firstname[0].toUpperCase() + userInfo.Lastname[0].toUpperCase();
  link2.innerText = userInfo.Firstname[0].toUpperCase() + userInfo.Lastname[0].toUpperCase();

}
else{
  link1.style.display= "none";
  link2.style.display= "none";
  link3.style.display= "none";
  link4.style.display= "none";
}