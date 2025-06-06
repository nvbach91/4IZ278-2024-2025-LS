import Validator from './validator.js';

window.addEventListener('DOMContentLoaded', function() {   
    const fields = [
        {inputId: 'email', errorId: 'alertEmail', validate: () => validator.validateEmail('email', validator.inputs['emailInput'].value)},
    ];

    const validator = new Validator(fields);
        
});
