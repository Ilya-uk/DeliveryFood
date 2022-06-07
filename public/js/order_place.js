let nameBtn = document.querySelector('.nameBtn'),
    name = document.querySelector('#name'),
    textName = document.querySelector('.textName');

phoneBtn = document.querySelector('.phoneBtn'),
    phone = document.querySelector('#phone'),
    textPhone = document.querySelector('.textPhone');

emailBtn = document.querySelector('.emailBtn'),
    email = document.querySelector('#email'),
    textEmail = document.querySelector('.textEmail');


nameBtn.onclick = nameChange;
phoneBtn.onclick = phoneChange;
emailBtn.onclick = emailChange;

function nameChange() {
    if (nameBtn.click) {
        textName.hidden = true;
        name.hidden = false;
        nameBtn.hidden = true;
    }
}

function phoneChange() {
    if (phoneBtn.click) {
        textPhone.hidden = true;
        phone.hidden = false;
        phoneBtn.hidden = true;
    }
}

function emailChange() {
    if (emailBtn.click) {
        textEmail.hidden = true;
        email.hidden = false;
        emailBtn.hidden = true;
    }
}


