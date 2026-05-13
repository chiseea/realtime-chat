import './echo';

function appendMessage(user, message, type)
{
    const chat =
    document.getElementById('chat');

    const wrapper =
    document.createElement('div');

    wrapper.className =
    `message ${type}`;

    wrapper.innerHTML = `

        <div class="name">
            ${user}
        </div>

        <div class="bubble">
            ${message}
        </div>

    `;

    chat.appendChild(wrapper);

    chat.scrollTop =
    chat.scrollHeight;
}

window.Echo.channel('chat-room')

.listen('.message.sent', (e) => {

    const currentUser =
    document.getElementById('user').value;

    appendMessage(
        e.user,
        e.message,
        e.user === currentUser
            ? 'self'
            : 'other'
    );
});
