import Validator from './validator.js';

window.addEventListener('DOMContentLoaded', function() {   
    const fields = [
        {inputId: 'name', errorId: 'alertName', validate: () => validator.validateRequiredField('name', validator.inputs['nameInput'].value)},
        {inputId: 'price', errorId: 'alertPrice', validate: () => validator.validateNumberField('price', validator.inputs['priceInput'].value)},
        {inputId: 'imgURL', errorId: 'alertImgURL', validate: () => validator.validateURL('imgURL', validator.inputs['imgURLInput'].value)},
        {inputId: 'imgThumbURL', errorId: 'alertImgThumbURL', validate: () => validator.validateURL('imgThumbUrl', validator.inputs['imgThumbUrlInput'].value)},
        {inputId: 'quantity', errorId: 'alertQuantity', validate: () => validator.validateNumberField('quantity', validator.inputs['quantityInput'].value)},
        {inputId: 'minPlayers', errorId: 'alertMinPlayers', validate: () => validator.validateNumberField('minPlayers', validator.inputs['minPlayersInput'].value)},
        {inputId: 'maxPlayers', errorId: 'alertMaxPlayers', validate: () => validator.validateNumberField('maxPlayers', validator.inputs['maxPlayersInput'].value)},
        {inputId: 'playtime', errorId: 'alertPlaytime', validate: () => validator.validateNumberField('playtime', validator.inputs['playtimeInput'].value)},
    ];

    const validator = new Validator(fields);
    
    validator.addCheckbox('categoryDropdown', 'categories');
});
