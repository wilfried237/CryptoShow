const headerbtns = document.getElementById("header-auth-btns");
const headerbtn = document.getElementById("header-auth-btn");
const link1 = document.getElementById("header-profile");
const link2 = document.getElementById("header-profile-1");
const userInfo =JSON.parse(localStorage.getItem("userInfo"));
const header = document.getElementById("header");

if(userInfo){
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
}