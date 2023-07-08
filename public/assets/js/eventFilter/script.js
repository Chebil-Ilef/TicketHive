document.querySelector(".dropdown-menu").addEventListener('click',(event)=>{
    const newGenre = event.target.textContent;
    document.querySelector(".btn").textContent = newGenre
})

const inputF =document.querySelector("#inputField");
inputF.addEventListener('keyup',e => {
    e.preventDefault();
    if (e.keyCode == 13){
        console.log(inputF.value);
        window.location.href = "http://localhost:8000/event/Search/Keywords/"+inputF.value;
    }
})

//dropdown for user to update , addevent and logout

const button_profile = document.getElementById('userprofile')
const updateli = document.querySelector('#update')
const addeventli = document.querySelector('#addevent')
const logoutli = document.querySelector('#logout')


updateli.addEventListener('click',()=>{
    window.location.href="http://localhost:8000/update";
})

button_profile.addEventListener('click',()=>{
  document.querySelector('.dropdown-user').style.opacity = 1-document.querySelector('.dropdown-user').style.opacity
})


logoutli.addEventListener('click',()=>{
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'http://localhost:8000/delete', true);
    //xhr.open("POST","{{path('delete_session')}}",true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = ()=>{
      location.reload();
    }
    xhr.send();
    //console.log(sessionStorage);
    //sessionStorage.removeItem('username');
    //location.reload();
})

//go to addevent page

addeventli.addEventListener('click',()=>{
  window.location.href = "http://localhost:8000/addEvent";
})
