window.addEventListener('DOMContentLoaded',()=>{
    const userInfo = JSON.parse(localStorage.getItem('userInfo'));
    if(userInfo.Member_id==1){

    }
    else{
        alert('Not eligible to this page');
    }
});