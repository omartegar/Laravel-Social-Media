@extends('layouts.app')

@vite(['resources/css/public-chat.css'])

@section('content')
    <h3>Public Chat as: {{ $mine->name }}</h3>
    <button class='goback_button' onclick='window.history.back()'>Go back</button>

    <div class='public_chat_container'>
        <div id='messages_container'>
            @foreach ($data as $message)
                @if ($message->user->id === session('user_id'))
                    <div id='message_from_you'>
                        <span id='user_message'>{{ $message->message_text }}</span>
                        <span id='message_date'>{{ $message->created_at }}</span>
                    </div>
                @else
                    <div id='message_from_other'>
                        <div id='title_container'>
                            <img src="{{ 'storage/' . $message->user->image_url }}" alt="profile_picture">
                            <span id='user_name'>{{ $message->user->name }}</span>
                        </div>
                        <span id='user_message'>{{ $message->message_text }}</span>
                        <span id='message_date'>{{ $message->created_at }}</span>
                    </div>
                @endif
            @endforeach
        </div>

        <footer id='send_container'>
            <textarea type="text" id="message_text" placeholder="Type your message here.."></textarea>
            <button id='send_message' onclick='sendMessage()'>Send</button>
        </footer>
    </div>



    <script>
        let token = document.querySelector('meta[name="csrf-token"]').content;
        let textarea_message = document.querySelector('textarea[id="message_text"]');
        let messages_screen = document.querySelector('div[id="messages_container"]');



        function AutoScrollMessages() {
            messages_screen.scrollTop = messages_screen.scrollHeight;
        }
        AutoScrollMessages();

        async function sendMessage() {
            const response = await fetch('/public_chat', {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({
                    message: textarea_message.value
                })
            });

            textarea_message.value = "Sending...";
            textarea_message.disabled = true;

            const data = await response.json();
            if (data.status === 'success') {
                textarea_message.value = "";
                textarea_message.value = false;
                window.location.reload();
            } else {
                textarea_message.value = "Failed to send";
                textarea_message.value = false;
                console.log(data);
            }
        }

        let lastCount = {{ count($data) }};
        async function CheckNew_messages() {
            let response = await fetch('/public_chat_index_messages');
            let new_messages = await response.json();

            // console.log(lastCount);
            // console.log(new_messages.data.length);

            if (lastCount !== new_messages.data.length) {
                console.log('new message update');
                window.location.reload();
            }

        }
        setInterval(CheckNew_messages, 2500);
    </script>
@endsection
