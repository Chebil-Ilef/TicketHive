const boutton = document.getElementById('download');
const input_value = document.getElementById('dow');

boutton.addEventListener('click',()=>{
  window.location.href="http://localhost:8000/generated/"+input_value.value;
})