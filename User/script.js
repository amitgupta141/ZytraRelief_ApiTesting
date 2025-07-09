const email_address = document.getElementById('userEmail');
const emailRegex = /^[a-zA-Z0-9._%+-]+@(?:[a-zA-Z0-9-]+\.)+[a-zA-Z]{2,}$/;
if(!emailRegex.test(email_address)){
    e.preventDefault();
    alert('Sorry! Wrong Email address');
}
else{

}

const phone_number = document.getElementById('userPhone');
const phoneRegex = /^[+][0-9+][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]$/;