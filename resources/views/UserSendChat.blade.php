<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Chat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
            margin: 0;
        }
        .chat-container {
            width: 400px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        .chat-header {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            text-align: center;
            font-size: 20px;
        }
        .chat-messages {
            flex: 1;
            padding: 10px;
            overflow-y: auto;
        }
        .message {
            margin-bottom: 10px;
        }
        .message.user {
            text-align: right;
        }
        .message p {
            display: inline-block;
            padding: 10px;
            border-radius: 10px;
            max-width: 80%;
            word-wrap: break-word;
        }
        .message.user p {
            background-color: #007bff;
            color: #fff;
            margin-left: auto;
            text-align:right;
        }
        .message.admin p {
            background-color: #eee;
            color: #333;
        }


        .chat-input {
            display: flex;
            padding: 10px;
            border-top: 1px solid #ccc;
        }
        .chat-input input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .chat-input button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            margin-left: 10px;
            cursor: pointer;
        }

        .chat-messages {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>

<div class="chat-container">
    <div class="chat-header">
        Help Chat
    </div>
    <div class="chat-messages" id="chat-messages">
        @foreach($chats as $chat)
            @if($chat->message_type == 'user')

                <div class="message user">
                    <p>{{$chat->message}}</p>
                </div>
            @elseif($chat->message_type == 'admin')
                <div class="message admin">
                    <p>{{$chat->message}}</p>
                </div>

            @endif
        @endforeach
        <!-- Chat messages will be appended here -->
    </div>
    <div class="chat-input">
        <input type="text" id="chatMsg" placeholder="Type a message..." />
        <button id="chatUser">Send</button>
    </div>
</div>

<script>
    {!! Vite::content('resources/js/app.js') !!}
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    $('#chatUser').click(function(){
        var chatMsg = $('#chatMsg').val();
            $.ajax({
                url: "{{ route('eventfire') }}",
                method: 'post',
                data: { "_token" : "{{csrf_token()}}", 'chatMsg': chatMsg },
                success: function(data){
                    console.log(data)
                    $('#chatMsg').val(' ');
                }
            });
    })


    Echo.channel(`webchat`)
    .listen('webappchat', (e) => {
        console.log(e);
        if(e.data.message_type == 'user'){
            var userdatasend = '<div class="message user">'+
                            '<p>'+e.data.message+'</p>'+
                            '</div>'
        }else if(e.data.message_type == 'admin'){
            var userdatasend = '<div class="message admin">'+
                            '<p>'+e.data.message+'</p>'+
                            '</div>'
        }


        $('#chat-messages').append(userdatasend);
    });
</script>

</body>
</html>
