import Validator from './validator.js';

window.addEventListener('DOMContentLoaded', function() {   
    const fields = [
        {inputId: 'name', errorId: 'alertName', validate: () => validator.validateRequiredField('name', validator.inputs['nameInput'].value)},
        {inputId: 'phone', errorId: 'alertPhone', validate: () => validator.validatePhone('phone', validator.inputs['phoneInput'].value)},
        {inputId: 'address', errorId: 'alertAddress', validate: () => validator.validateRequiredField('address', validator.inputs['addressInput'].value)},
    ];

    const validator = new Validator(fields);
        
});
