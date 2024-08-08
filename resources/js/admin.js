function scrollToBottom(){
    let chatContent = $('.chat-content');
    chatContent.scrollTop(chatContent.prop('scrollHeight'));
}

window.Echo.private('chat.'+loggedUserId)
    .listen('ChatEvent', (e)=>{
        console.log(e)
        if (e.senderId == $('#mychatbox').attr('data-inbox')){
            let html = `<div class="chat-item chat-left" style="">
                                <img src="${e.avatar}">
                                <div class="chat-details">
                                    <div class="chat-text">${e.message}</div>
                                    <div class="chat-time">sending...</div>
                                </div>
                            </div>`
            $('.chat-content').append(html);
            scrollToBottom();
        }
        // Show message notification
            $('.fp_chat_user').each(function (){
                let sender_id = $(this).data('user');
                if (e.senderId === sender_id){
                    let html = `<i class="beep"></i> New Message`;
                    $(this).find('.got_new_message').html(html);
                }
            });
        $('.message_envelope').addClass('beep');


    });
