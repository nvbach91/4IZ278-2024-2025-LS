import Validator from './validator.js';

window.addEventListener('DOMContentLoaded', function() {   
    const fields = [
        {inputId: 'newPassword', errorId: 'alertNewPassword', validate: () => validator.validatePassword('newPassword', validator.inputs['newPasswordInput'].value, validator.inputs['newPassword2Input'].value)},
        {inputId: 'newPassword2', errorId: 'alertNewPassword2', validate: () => validator.validatePassword('newPassword', validator.inputs['newPasswordInput'].value, validator.inputs['newPassword2Input'].value)},
    ];
    
    const validator = new Validator(fields);
});
