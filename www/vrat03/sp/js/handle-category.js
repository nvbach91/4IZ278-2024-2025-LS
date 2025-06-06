import Validator from './validator.js';

window.addEventListener('DOMContentLoaded', function() {   
    const fields = [
        {inputId: 'name', errorId: 'alertName', validate: () => validator.validateRequiredField('name', validator.inputs['nameInput'].value)},
    ]

    const validator = new Validator(fields);
        
});
