window.onload = () => {
    const e = document.querySelector('#flash-message-cancel');
    e.addEventListener('click', () => {
        $('#flash-message').slideUp()
    });
};

window.setTimeout(() => {
    $('#flash-message').slideUp()
}, 7000);

