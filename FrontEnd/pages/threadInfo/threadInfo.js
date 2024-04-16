// function declaration
async function bookEvent(threadID , memberId){
    
    const data = new URLSearchParams();
    data.append('Member_id', memberId);
    data.append('threads_id', threadID);
    try 
    {
        const response = await fetch(`${backendConn}/threads/book`, {
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
            setTimeout(()=>{},3000);
            return true;
        }
        else{
            displayToast(responseData.message, responseData.status);
            setTimeout(()=>{},3000);
            return false;
        }
    } 
    catch (error) 
    {
        console.error('Error fetching member data:', error);
        return null;
    }
}

async function registerDevices(threadID, MemberID, deviceName, deviceImage=null, deviceDesc=null){
    const data = new URLSearchParams();
    data.append('Member_id', MemberID);
    data.append('Thread_id', threadID);
    data.append('Device_name', deviceName);
    deviceImage!=null && data.append('Device_image', deviceImage);
    deviceDesc!= null && data.append('Device_description', deviceDesc);
    try 
    {
        const response = await fetch(`${backendConn}/device/register_device`, {
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
            setTimeout(()=>{},3000);
        }   
        else{
            displayToast(responseData.message, responseData.status);
            setTimeout(()=>{},3000);
        }
    } 
    catch (error) 
    {
        console.error('Error fetching member data:', error);
        return null;
    }
}

async function getUserInfo(memberID){
    const data = new URLSearchParams();
    data.append('Member_id', memberID);

    try 
    {
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
        if(responseData.status === "success"){
            return responseData.user;
        }
        else{
            alert(responseData.message);
        }
    } 
    catch (error) 
    {
        console.error('Error fetching member data:', error);
        return null;
    }
}

async function submitAllForms(threadID,memberID) {
    if(FormContainerArray.length > 0){
        if(await bookEvent(threadID, memberID)){
            
                for (let i = 0; i < FormContainerArray.length; i++) {
                        const formContainer = document.createElement('div');
                        formContainer.innerHTML = FormContainerArray[i].html;
                      //   const form = formContainer.querySelector(`#FormEvent${i}`); // Get the form element from the container
                    
                        // Access input values directly from the form
                        const deviceName = document.getElementById('deviceName' + FormContainerArray[i].id).value;
                        const imageLink =   document.getElementById(`ImageLink${FormContainerArray[i].id}`).value;
                        const description = document.querySelector(`#Description${FormContainerArray[i].id}`).value;
                        await registerDevices(threadID,memberID,deviceName,imageLink,description);
                    }

                
            deviceCount=0;
            FormContainerArray=[];
            updateFormUi();
            location.href="/threads";
        }
        else{
            return;
        }
    }
    else{
        bookEvent(threadID, memberID);
    }
}
  
function generateNewDeviceInputs() {
    deviceCount++; // Increment the device counter
    let inputNumber = deviceCount;
    let form =  `<div class="d-flex justify-content-between align-items-center">
          <h2>New Device</h2>
          <a onClick="deleteDeviceElement(${inputNumber})" href="#">
              <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-trash text-danger" viewBox="0 0 16 16">
                  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                  <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 1 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
              </svg>
          </a>
      </div>
      <div class="mb-3">
          <label for="deviceName${inputNumber}" class="form-label">Name</label>
          <input type="text" class="form-control" id="deviceName${inputNumber}" placeholder="deviceName">
      </div>
      <div class="mb-3">
          <label for="ImageLink${inputNumber}" class="form-label">Image</label>
          <input type="text" class="form-control" id="ImageLink${inputNumber}" placeholder="ImageLink">
      </div>
      <div class="mb-3">
          <label for="Description${inputNumber}" class="form-label">Description</label>
          <input type="text"  class="form-control" id="Description${inputNumber}" placeholder="Description">
      </div>
    `;

    FormContainerArray.push({
        id: inputNumber, // Assign the unique identifier to the form
        html: form
    });
    updateFormUi();
}

function addDeviceElement(){
    generateNewDeviceInputs();
}

function deleteDeviceElement(inputNumber){
    FormContainerArray = FormContainerArray.filter((element) => element.id !== inputNumber);
    updateFormUi();
}

function revealDeviceForm(){
    dialog.style.display = 'block';
}

function updateFormUi(){
    const form = document.getElementById('formEvent');
    form.innerHTML = "";
    FormContainerArray.forEach((element) => {
      form.innerHTML += element.html;
    });
}

async function launcher(){
    const threadInfo = JSON.parse(localStorage.getItem("threadInfo"));
    if(threadInfo && userInfo){
        const productContainer = document.getElementById("product-container");
        const userInfos =  await getUserInfo(threadInfo.Member_id);
        productContainer.innerHTML=`
            <div class="product-image">
            <img src="${threadInfo.Thread_image}" alt="Product Image">
            </div>
            <div class="product-info">
                <h1>${threadInfo.Thread_name}</h1>
                <p> ${threadInfo.Thread_description?Thread_description: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos eos, est vel perspiciatis, deserunt officia, omnis illo in aspernatur magnam aut tempore laborum repudiandae ullam dolorem sit quasi animi? Eum."} </p>
                <div class="thread-profile-username d-flex align-items-center">
                <a style="background-color: ${userInfos.Colour} " class="threads-userProfile">${userInfos.Firstname[0].toUpperCase() + userInfos.Lastname[0].toUpperCase()}</a>
                <p class="thread-username m-0">${userInfos.Firstname} ${userInfos.Lastname}</p>
                </div>
                <button id="openDialog" onClick="revealDeviceForm()" >Book</button>
            </div>
        `;
        
    }
    else{
        alert("you need to be authenticated");
        window.location.href= "/threads";
    }
}

//onclick="bookEvent(${threadInfo.Thread_id}, ${userInfo.Member_id})"
let FormContainerArray = [];
let deviceCount = 0; 

launcher();



const dialog = document.getElementById('dialog');
const closeDialog = document.querySelector('.close');
const bookDevice = document.getElementById('formEventBook');

bookDevice.addEventListener('click',()=>{
    const threadID = JSON.parse(localStorage.getItem("threadInfo"));
    submitAllForms( threadID.Thread_id, userInfo.Member_id);
})

closeDialog.addEventListener('click', function() {
    dialog.style.display = 'none';
    deviceCount=0;
    FormContainerArray=[];
    updateFormUi();
  });

window.addEventListener('click', function(event) {
    if (event.target === dialog) {
      dialog.style.display = 'none';
      deviceCount=0;
      FormContainerArray=[];
      updateFormUi();
    }
  });