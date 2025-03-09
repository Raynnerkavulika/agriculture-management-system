let navbar = document.querySelector('.header .flex .navbar');

document.querySelector('#menu-btn').onclick = () =>{
  navbar.classList.toggle('active');
}

let profile = document.querySelector('.header .flex .profile');

document.querySelector('#user-btn').onclick = () =>{
  profile.classList.toggle('active');
  navbar.classList.toggle('active');
}

windows.onscroll = () =>{
    profile.classList.remove('active');
    navbar.classList.remove('active');
}