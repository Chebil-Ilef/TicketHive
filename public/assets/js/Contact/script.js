const boutton = document.getElementById('bouton')

boutton.addEventListener('click',()=>{
  //console.log(document.getElementById('message').value);
  //console.log("hello world");
  const message = "https://api.whatsapp.com/send?phone=27357209&text=My Name is : "+document.getElementById('fullname').value+","+document.getElementById('message').value;
  // if (document.getElementById('message').value.trim().length != 0 ){
  //   const message = "https://api.whatsapp.com/send?phone=27357209&text= Hello,"+document.getElementById('message').value.trim;
  // }
  // else {
  //   alert('your message is empty');
  // }
  window.open(message);
})