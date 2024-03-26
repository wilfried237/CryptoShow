// function declaration

function getAllThreads(){
    fetch(`${backendConn}/threads/`, {
        method: 'POST'
    }).then(response => {
        if (response.ok) {
            return response.json(); // Parse the response as JSON
        } else {
            throw new Error('Network response was not ok.');
        }
    })
    .then(data => {
        if (data.status === 'success') { // Assuming the response contains a 'status' property
            localStorage.setItem("thread",JSON.stringify(data.Threads));
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function calculatePublicationDuration(publicationDate) {
    const currentDate = new Date();
    const diffInMilliseconds = currentDate - new Date(publicationDate);

    // Calculate duration in days
    const days = Math.floor(diffInMilliseconds / (1000 * 60 * 60 * 24));

    // Calculate duration in minutes
    const minutes = Math.floor(diffInMilliseconds / (1000 * 60));

    const seconds = Math.floor(diffInMilliseconds / 1000);

    // Calculate duration in years
    const years = currentDate.getFullYear() - new Date(publicationDate).getFullYear();

    return { seconds, days, minutes, years };
}

async function setthreadOnPage() {
    getAllThreads();

    const threadSection = document.getElementById("threads-section");
    const thread = JSON.parse(localStorage.getItem("thread"));
    const monthAcronyms = {
        1: 'Jan',
        2: 'Feb',
        3: 'Mar',
        4: 'Apr',
        5: 'May',
        6: 'Jun',
        7: 'Jul',
        8: 'Aug',
        9: 'Sep',
        10: 'Oct',
        11: 'Nov',
        12: 'Dec'
    };
    if (thread) {
        let articles = "";

        Object.values(thread).forEach(async (element, index) => {
            const threadProfileID = element.Member_id;
            try {
                let memberData = await getMember(threadProfileID);
                const dateArray = element.Thread_date.split("-");
                const img = await getRandomImage();
                const publicationDate = element.Created_at;
                const { seconds, days, minutes, years } = calculatePublicationDuration(publicationDate);
                articles += `
                    <article class="threads-article">
                        ${element.Thread_image == null ? `<img src="${img}" class="thread-image">` : `<img src="${element.Thread_image}" class="thread-image">`}
                        <!-- <p class="threads-places">3 places</p> -->
                        <div class="threads-info">
                            <div class="threads-date-location">
                                <div class="thread-date">
                                    <p class="date">${dateArray[2]}</p>
                                    <p class="month">${monthAcronyms[dateArray[1]]}</p>
                                </div>
                                <div class="thread-location">
                                    <p class="title">${element.Thread_name}</p>
                                    <p class="location">${element.Venue}</p>
                                </div>
                            </div>
                            <div class="thread-book">
                                <div class="thread-profile-username">
                                    <a style="background-color:${memberData.Colour};" class="threads-userProfile">${memberData.Firstname[0].toUpperCase() + memberData.Lastname[0].toUpperCase()}</a>
                                    <p class="thread-username">${memberData.Lastname + " " + memberData.Firstname}</p>
                                </div>
                                <button onclick="moveToPage(${element.Thread_id})" >See more</button>
                            </div>
                            <p class="thread-created-date">${years > 0 ? years + " year" : days > 0 ? days + " day" : minutes > 60 ? Math.floor(minutes / 60) + " Hour" : seconds > 60 ? seconds + " Seconds" : minutes + " Minute"} </p>
                        </div>
                    </article>
                `;
            } catch (error) {
                console.error('Error fetching member data:', error);
            }
        });
        

        threadSection.innerHTML = articles; // Display all articles at once
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

async function setthreadOnPage() {
    getAllThreads();

    const threadSection = document.getElementById("threads-section");
    const thread = JSON.parse(localStorage.getItem("thread"));
    const monthAcronyms = {
        1: 'Jan',
        2: 'Feb',
        3: 'Mar',
        4: 'Apr',
        5: 'May',
        6: 'Jun',
        7: 'Jul',
        8: 'Aug',
        9: 'Sep',
        10: 'Oct',
        11: 'Nov',
        12: 'Dec'
    };

    if (thread) {
        let articles = await Promise.all(Object.values(thread).map(async (element, index) => {
            const threadProfileID = element.Member_id;
            try {
                let memberData = await getMember(threadProfileID);
                const dateArray = element.Thread_date.split("-");
                const img = await getRandomImage();
                const publicationDate = element.Created_at;
                const { seconds, days, minutes, years } = calculatePublicationDuration(publicationDate);
                
                return `
                    <article class="threads-article">
                        ${element.Thread_image == null ? `<img src="${img}" class="thread-image">` : `<img src="${element.Thread_image}" class="thread-image">`}
                        <!-- <p class="threads-places">3 places</p> -->
                        <div class="threads-info">
                            <div class="threads-date-location">
                                <div class="thread-date">
                                    <p class="date">${dateArray[2]}</p>
                                    <p class="month">${monthAcronyms[dateArray[1]]}</p>
                                </div>
                                <div class="thread-location">
                                    <p class="title">${element.Thread_name}</p>
                                    <p class="location">${element.Venue}</p>
                                </div>
                            </div>
                            <div class="thread-book">
                                <div class="thread-profile-username">
                                    <a style="background-color:${memberData.Colour};" class="threads-userProfile">${memberData.Firstname[0].toUpperCase() + memberData.Lastname[0].toUpperCase()}</a>
                                    <p class="thread-username">${memberData.Lastname + " " + memberData.Firstname}</p>
                                </div>
                                <button onclick="moveToPage(${index+1})" >See more</button>
                            </div>
                            <p class="thread-created-date">${years > 0 ? years + " year" : days > 0 ? days + " day" : minutes > 60 ? Math.floor(minutes / 60) + " Hour" : seconds > 60 ? seconds + " Seconds" : minutes + " Minute"} </p>
                        </div>
                    </article>
                `;
            } catch (error) {
                console.error('Error fetching member data:', error);
            }
        }));

        threadSection.innerHTML = articles.join(''); // Display all articles at once
    }
}

function getRandomImage(){
    
    const img = {
        0: "https://www.eventsindustryforum.co.uk/images/articles/about_the_eif.jpg",
        1: "https://cdn.pixabay.com/photo/2023/08/04/07/22/people-8168554_1280.jpg",
        2: "https://cdn.pixabay.com/photo/2018/05/10/11/34/concert-3387324_1280.jpg",
        3: "https://cdn.pixabay.com/photo/2016/11/29/13/20/balloons-1869790_1280.jpg",
        4: "https://cdn.pixabay.com/photo/2020/01/15/17/38/fireworks-4768501_1280.jpg",
        5: "https://cdn.pixabay.com/photo/2015/11/22/19/04/crowd-1056764_1280.jpg",
        6: "https://cdn.pixabay.com/photo/2020/03/08/16/55/abstract-4913016_1280.png",
        7: "https://cdn.pixabay.com/photo/2019/07/15/21/05/fantasy-4340432_640.jpg",
        8: "https://cdn.pixabay.com/photo/2016/12/28/20/30/wedding-1937022_640.jpg",
        9: "https://cdn.pixabay.com/photo/2024/02/20/19/50/ai-generated-8586140_640.png",
        10:"https://cdn.pixabay.com/photo/2024/02/19/06/55/ai-generated-8582678_640.jpg"
    }
    const randomNumber = Math.floor(Math.random()*Object.keys(img).length);
    return img[randomNumber];
}

function moveToPage(id){
    const thread = JSON.parse(localStorage.getItem("thread"));
    const threadInfo = thread[id];
    localStorage.setItem("threadInfo", JSON.stringify(threadInfo));
    window.location.href = "/threadInfo";
}





//-------------------------------------------


setthreadOnPage();