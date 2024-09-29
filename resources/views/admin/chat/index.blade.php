@component('admin.component')
@slot('title') Chat @endslot
@slot('subTitle') Chat list @endslot
@slot('content')
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
    .admin-chat-container {
        width: 1020px;
        height: 600px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        display: flex;
        overflow: hidden;
    }
    .user-list {
        width: 250px;
        background-color: #007bff;
        color: #fff;
        padding: 20px;
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
    }
    .user {
        padding: 10px;
        margin-bottom: 10px;
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 5px;
        cursor: pointer;
    }
    .user:hover {
        background-color: rgba(255, 255, 255, 0.2);
    }
    .user h3 {
        margin: 0;
        font-size: 18px;
    }
    .user p {
        margin: 0;
        font-size: 14px;
        color: #ddd;
    }
    .chat-section {
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .chat-header {
        background-color: #007bff;
        color: #fff;
        padding: 20px;
        font-size: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .chat-header .settings {
        cursor: pointer;
    }
    .chat-messages {
        flex: 1;
        padding: 20px;
        overflow-y: auto;
        background-color: #f9f9f9;
    }
    .message {
        margin-bottom: 15px;
    }
    .message p {
        margin: 0;
        padding: 10px;
        border-radius: 5px;
        max-width: 70%;
        word-wrap: break-word;
    }
    .message.user p {
        background-color: #007bff;
        color: #fff;
        margin-left: auto;
    }
    .message.admin p {
        background-color: #eee;
        color: #333;
    }
    .chat-input {
        padding: 20px;
        border-top: 1px solid #ccc;
        background-color: #fff;
        display: flex;
    }
    .chat-input input {
        flex: 1;
        padding: 15px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }
    .chat-input button {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 15px;
        border-radius: 5px;
        margin-left: 10px;
        cursor: pointer;
    }
</style>

<div class="admin-chat-container">
    <div class="user-list">
        <h2>Users</h2>
        <div id="userShow"></div>
        <!-- Add more users here -->
    </div>
    <div class="chat-section">
        <div class="chat-header">
            <span id="username"></span>
        </div>
        <div class="chat-messages" id="chat-messages">

            <!-- More messages here -->
        </div>
        <div class="chat-input chatBox">
            <input type="text" id="chatMsg" id="message-input" placeholder="Type a message..." />
            <button id="chatUser">Send</button>
        </div>
    </div>
</div>

@endslot
@slot('script')
   <script src="https://cdn.socket.io/4.0.0/socket.io.min.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

<script>
    $(document).ready(function(){
        $.ajax({
            url: "{{ route('admin.chatUsers') }}",
            method: 'get',
            data: { "_token" : "{{csrf_token()}}"},
            success: function(data){
                console.log(data)
                $.each(data.users, function(index, value) {
                    console.log(value.last_chat)
                    var user = '<div class="user " onclick = clickUser() data-id='+value.id+'>'+
                                '<input type="hidden" name="user_id" id="user_id" value="'+value.id+'">'+
                                '<h3>'+value.name+'</h3>'+
                                '<p>'+value.last_chat.message+'</p>'+
                            '</div>'

                    $('#userShow').append(user);
                })

            }
        });
    })

    $('.chatBox').hide();
    var clickUserID;
    // $('.clickUser').click(function(){
    function clickUser (){
        var id = $('#user_id').val();
        clickUserID = id;
        $.ajax({
            url: "{{ route('admin.chat.getchat') }}",
            method: 'post',
            data: { "_token" : "{{csrf_token()}}", 'id': id },
            success: function(data){
                console.log(data)
                $('#chat-messages').empty();
                $('#username').text('Chat with '+data.usersAndChat.name);
                $.each(data.usersAndChat.chats, function(index, value) {

                    if(value.message_type == 'user'){
                        var chat =  '<div class="message admin">'+
                                    '<p>'+value.message+'</p>'+
                                    '</div>'

                    }else if(value.message_type == 'admin'){
                        var chat = '<div class="message user">'+
                                    '<p>'+value.message+'</p>'+
                                    '</div>'
                    }

                    $('#chat-messages').append(chat);

                })
                $('.chatBox').show();

            }
        });
    }



    $('#chatUser').click(function(){
        var chatMsg = $('#chatMsg').val();
        var user_id = $('#user_id').val();

            $.ajax({
                url: "{{ route('eventfire') }}",
                method: 'post',
                data: { "_token" : "{{csrf_token()}}", 'chatMsg': chatMsg , "user_id" : user_id},
                success: function(data){
                    console.log(data)
                    $('#chatMsg').val(' ');
                }
            });

    });


    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('71624133ab7ae26dbec1', {
        cluster: 'ap2',
        forceTLS: true
    });

    var channel = pusher.subscribe('webchat');

    channel.bind('chat', function(e) {

            if(e.chat.message_type == 'user'){
                var userdatasend = '<div class="message admin">'+
                                '<p>'+e.chat.message+'</p>'+
                                '</div>'
            }else if(e.chat.message_type == 'admin'){
                var userdatasend = '<div class="message user">'+
                                '<p>'+e.chat.message+'</p>'+
                                '</div>'
            }
            $.ajax({
                url: "{{ route('admin.chatUsers') }}",
                method: 'get',
                data: { "_token" : "{{csrf_token()}}"},
                success: function(data){
                    $('#userShow').empty();
                    $.each(data.users, function(index, value) {
                        console.log(yes)
                        console.log(value)
                        var user = '<div class="user " onclick = clickUser()  data-id='+value.id+'>'+
                                    '<input type="hidden" name="user_id" id="user_id" value="'+value.id+'">'+
                                    '<h3>'+value.name+'</h3>'+
                                    '<p>'+value.last_chat.message+'</p>'+
                                '</div>'

                        $('#userShow').append(user);
                    })

                }
            });
            if(e.chat.message_type == 'admin' || clickUserID){
                $('#chat-messages').append(userdatasend);
            }
            
    });

   
</script>
@endslot
@endcomponent

