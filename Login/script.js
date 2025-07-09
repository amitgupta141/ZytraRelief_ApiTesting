
const themeBtn = document.getElementById('theme-button');
const loginContainer = document.querySelector('.login-container');
const highlight = document.querySelector('.highlight');
const toggleBtn = document.querySelectorAll('.toggle-buttons button');
const toggleActiveBtn = document.querySelectorAll('.toggle-buttons button .active');
const inputBtn = document.querySelectorAll('input');
const loginBtn = document.querySelector('.login-btn');
const forgotBtn = document.querySelector('.forgot');
const head2 = document.querySelector('h2');


themeBtn.addEventListener('click',()=>{
    if(themeBtn.classList.contains('dark-theme')){
        themeBtn.classList.add('light-theme');
        themeBtn.classList.remove('dark-theme');
        
        themeBtn.style.border = '1px solid black';
        themeBtn.style.position = 'absolute';
        themeBtn.style.top = '0';
        themeBtn.style.right = '0';
        themeBtn.style.filter = 'invert(0%)';
        themeBtn.style.borderRadius = '20%';
        themeBtn.style.width = '30px';
        themeBtn.style.height = '30px';
        themeBtn.style.marginTop = '20px';
        themeBtn.style.marginRight = '20px';
        themeBtn.style.padding = '5px';
        
        document.body.style.color = 'black';
        document.body.style.background = 'white';
        loginContainer.style.background = 'white';
        loginContainer.style.boxShadow = '0 0 15px cornflowerblue';
        head2.style.color = 'black';
        highlight.style.color = 'cornflowerblue';
        loginBtn.style.background = 'cornflowerblue';
        loginBtn.style.color = 'white';
        forgotBtn.color = 'white';
        inputBtn.forEach(element => {
            element.style.borderColor = 'cornflowerblue';
            element.style.background = 'white';
            element.style.color = 'grey';
        });
        toggleBtn.forEach(element => {
            element.style.borderColor= 'cornflowerblue';
            element.style.color='grey';
            element.style.background = 'white';
        })
        toggleActiveBtn.forEach(element => {
            element.background = 'cornflowerblue';
            element.color = 'white';
        })
        
        
    }
    else{
        themeBtn.classList.add('dark-theme');
        themeBtn.classList.remove('light-theme');
        themeBtn.style.border = '1px solid white';
        themeBtn.style.position = 'absolute';
        themeBtn.style.top = '0';
        themeBtn.style.right = '0';
        themeBtn.style.filter = 'invert(100%)';
        themeBtn.style.borderRadius = '20%';
        themeBtn.style.width = '30px';
        themeBtn.style.height = '30px';
        themeBtn.style.marginTop = '20px';
        themeBtn.style.marginRight = '20px';
        themeBtn.style.padding = '5px';
        
        document.body.style.color = 'black';
        document.body.style.background = 'black';
        
        
        loginContainer.style.background = '#121212';
        loginContainer.style.boxShadow = '0 0 15px #0f0';
        head2.style.color = 'white';
        highlight.style.color = '#00ff00';
        loginBtn.style.background = '#00ff00';
        loginBtn.style.color = 'black';
        forgotBtn.style.color = '#ccc';
        inputBtn.forEach(element => {
            element.style.borderColor = '#00ff00';
            element.style.background = '#1a1a1a';
            element.style.color = 'white';
        });
        toggleBtn.forEach(element => {
            element.style.borderColor= '#00ff00';
            element.style.color='white';
            element.style.background = '#1f1f1f';
        })
        toggleActiveBtn.forEach(element => {
            element.style.background = '#00ff00';
            element.style.color = 'black';
        })
    }
});



toggleBtn.forEach(element =>{
    if(element.classList.contains('active') && themeBtn.classList.contains('dark-theme')){
        element.style.background = '#00ff00';
        element.style.color = 'black';
    }
    else if(element.classList.contains('active') && !themeBtn.classList.contains('dark-theme')){
        element.style.background = 'cornflowerblue';
        element.style.color = 'white';
    }
    else if(!element.classList.contains('active') && themeBtn.classList.contains('dark-theme')){
        element.style.borderColor= '#00ff00';
        element.style.color='white';
        element.style.background = '#1f1f1f';
    }
    else{
        element.style.borderColor= 'cornflowerblue';
        element.style.color='black';
        element.style.background = 'white';
    }
});
        const userBtn = document.getElementById('userBtn');
        const partnerBtn = document.getElementById('partnerBtn');
        const studentFields = document.getElementById('studentFields');
        const facultyFields = document.getElementById('facultyFields');
        
        userBtn.addEventListener('click', () => {
          userBtn.classList.add('active');
          partnerBtn.classList.remove('active');
          studentFields.style.display = 'block';
          facultyFields.style.display = 'none';
          toggleBtn.forEach(element => {
  if (element.classList.contains('active')) {
    element.style.background = themeBtn.classList.contains('dark-theme') ? '#00ff00' : 'cornflowerblue';
    element.style.color = themeBtn.classList.contains('dark-theme') ? 'black' : 'white';
  } else {
    element.style.borderColor = themeBtn.classList.contains('dark-theme') ? '#00ff00' : 'cornflowerblue';
    element.style.color = themeBtn.classList.contains('dark-theme') ? 'white' : 'black';
    element.style.background = themeBtn.classList.contains('dark-theme') ? '#1f1f1f' : 'white';
  }
});
        });
        
        partnerBtn.addEventListener('click', () => {
          partnerBtn.classList.add('active');
          userBtn.classList.remove('active');
          facultyFields.style.display = 'block';
          studentFields.style.display = 'none';
          toggleBtn.forEach(element => {
  if (element.classList.contains('active')) {
    element.style.background = themeBtn.classList.contains('dark-theme') ? '#00ff00' : 'cornflowerblue';
    element.style.color = themeBtn.classList.contains('dark-theme') ? 'black' : 'white';
  } else {
    element.style.borderColor = themeBtn.classList.contains('dark-theme') ? '#00ff00' : 'cornflowerblue';
    element.style.color = themeBtn.classList.contains('dark-theme') ? 'white' : 'black';
    element.style.background = themeBtn.classList.contains('dark-theme') ? '#1f1f1f' : 'white';
  }
});
        });

document.getElementsByClassName('active')[0].style.background = "#00ff00";
document.getElementsByClassName('active')[0].style.color = 'black';

// In userBtn click
// document.querySelector('input[name="email"]').required = true;
// document.querySelector('input[name="partneremail"]').required = false;

// In partnerBtn click
// document.querySelector('input[name="email"]').required = false;
// document.querySelector('input[name="partneremail"]').required = true;

const loginForm = document.getElementById('loginForm');

userBtn.addEventListener('click', () => {
  setUserType('user');
});

partnerBtn.addEventListener('click', () => {
  setUserType('partner');
});

function setUserType(type) {
  let hidden = document.querySelector('input[name="user_type"]');
  if (!hidden) {
    hidden = document.createElement('input');
    hidden.type = 'hidden';
    hidden.name = 'user_type';
    loginForm.appendChild(hidden);
  }
  hidden.value = type;
}


// const userBtn = document.getElementById('userBtn');
// const partnerBtn = document.getElementById('partnerBtn');
const userEmailInput = document.querySelector('input[name="email"]');
const partnerEmailInput = document.querySelector('input[name="partneremail"]');
const userTypeInput = document.getElementById('userTypeInput');

userBtn.addEventListener('click', () => {
  userBtn.classList.add('active');
  partnerBtn.classList.remove('active');

  userEmailInput.required = true;
  userEmailInput.disabled = false;

  partnerEmailInput.required = false;
  partnerEmailInput.disabled = true;

  document.getElementById('studentFields').style.display = 'block';
  document.getElementById('facultyFields').style.display = 'none';

  userTypeInput.value = 'user';
});

partnerBtn.addEventListener('click', () => {
  partnerBtn.classList.add('active');
  userBtn.classList.remove('active');

  userEmailInput.required = false;
  userEmailInput.disabled = true;

  partnerEmailInput.required = true;
  partnerEmailInput.disabled = false;

  document.getElementById('studentFields').style.display = 'none';
  document.getElementById('facultyFields').style.display = 'block';

  userTypeInput.value = 'provider'; // Fix: should be "provider", not "partner"
});
