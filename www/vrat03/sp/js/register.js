import Validator from './validator.js';

window.addEventListener('DOMContentLoaded', function() {   
    const fields = [
        {inputId: 'name', errorId: 'alertName', validate: () => validator.validateRequiredField('name', validator.inputs['nameInput'].value)},
        {inputId: 'email', errorId: 'alertEmail', validate: () => validator.validateEmail('email', validator.inputs['emailInput'].value)},
        {inputId: 'phone', errorId: 'alertPhone', validate: () => validator.validatePhone('phone', validator.inputs['phoneInput'].value)},
        {inputId: 'address', errorId: 'alertAddress', validate: () => validator.validateRequiredField('address', validator.inputs['addressInput'].value)},
        {inputId: 'password', errorId: 'alertPassword', validate: () => validator.validatePassword('password', validator.inputs['passwordInput'].value, validator.inputs['password2Input'].value)},
        {inputId: 'password2', errorId: 'alertPassword2', validate: () => validator.validatePassword('password', validator.inputs['passwordInput'].value, validator.inputs['password2Input'].value)}
    ];

    const validator = new Validator(fields);
        
});
