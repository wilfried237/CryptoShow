// function declaration
async function bookEvent(threadID , memberId){
    
    const data = new URLSearchParams();
    data.append('Member_id', memberId);
    data.append('threads_id', threadID)

    try 
    {
        const response = await fetch("http://localhost:8000/threads/book", {
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
            alert(responseData.message);
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


const threadInfo = JSON.parse(localStorage.getItem("threadInfo"));
if(threadInfo && userInfo){
    const productContainer = document.getElementById("product-container");

    productContainer.innerHTML=`
        <div class="product-image">
        <img src="${threadInfo.Thread_image}" alt="Product Image">
        </div>
        <div class="product-info">
            <h1>${threadInfo.Thread_name}</h1>
            <p> ${threadInfo.Thread_description?Thread_description: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos eos, est vel perspiciatis, deserunt officia, omnis illo in aspernatur magnam aut tempore laborum repudiandae ullam dolorem sit quasi animi? Eum."} </p>
            <div class="thread-profile-username">
            <a class="threads-userProfile">WK</a>
            <p class="thread-username">Wilfried Kamdoum</p>
            </div>
            <button onclick="bookEvent(${threadInfo.Thread_id}, ${userInfo.Member_id})">Book</button>
        </div>
    `;

}
else{
    alert("you need to be authenticated");
    window.location.href= "/threads";
}
