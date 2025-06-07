const button = document.querySelector('#emoji-button');
const input = document.querySelector('#emoji-input');

const picker = new EmojiButton();

picker.on('emoji', emoji => {
    input.value = emoji;
});

button.addEventListener('click', () => {
    picker.togglePicker(button);
});