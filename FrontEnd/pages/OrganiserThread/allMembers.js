// function declaration

function setElementTable(){
    if (userInfo && userInfo.Surface == 2) {
        const tableBody = document.getElementById("tableBodyS");
        
    }
    else{
        alert("unauthorized to this page");
        window.location.href= "/";
    }
}




//------------------------------------------------------



setElementTable();