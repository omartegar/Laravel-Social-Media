@extends('layouts.app')

@vite(['resources/css/chatpage.css'])

@section('content')
    <h3>Chatting as: {{ $mine->name }}</h3>
    <button id='GoBack_button' onclick='window.history.back()'>GO BACK</button>

    <div class='chat_container'>
        <main id='messages_screen'>
            @foreach ($chat_with_users as $chat)
                @if ($chat->sender_id === $mine->id)
                    <div id='message_from_me'>
                        {{-- Right Side (Me) --}}
                        <p id='message_sent'>{{ $chat->message_content }}</p>
                        <p id='date_sent'>{{ $chat->created_at }}</p>
                    </div>
                @else
                    <div id="message_from_other">
                        {{-- Left Side --}}
                        <p id='sender_info'>
                            <img id='sender_image' src="{{ 'storage/' . $chat->sender->image_url }}" alt="profile_picture">
                            <span id='sender_name'>{{ $chat->sender->name }}</span>
                        </p>
                        <p id='message_sent'>{{ $chat->message_content }}</p>
                        <p id='date_sent'>{{ $chat->created_at }}</p>
                    </div>
                @endif
            @endforeach



        </main>
        <footer>
            <textarea id='message_content' type="text" placeholder="Type your message.."></textarea>
            <button id='send_button' onclick='sendMessage()'>Send</button>
        </footer>
    </div>



    <script>
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let sendButton = document.querySelector('button[id="send_button"]');
        let message_content = document.querySelector('textarea[id="message_content"]');

        autoScrolling()

        function autoScrolling() {
            let messages_screen = document.querySelector('main[id="messages_screen"]');

            messages_screen.scrollTop = messages_screen.scrollHeight;
        }

        async function sendMessage() {
            const response = await fetch('/send', {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({
                    receiver_id: {{ session('receiver_id') }},
                    message_content: message_content.value
                })
            });
            message_content.value = "Sending...";
            message_content.disabled = true;

            const data = await response.json();
            if (data.status === 'success') {
                message_content.value = "";
                autoScrolling()
                window.location.reload();
            } else {
                message_content.value = "";
                console.log(data);
            }
        }

        async function check_new_messages() {
            const response = await fetch('/chat_index_messages');
            const data = await response.json();
            lastCount = {{ count($chat_with_users) }};


            if (data.status === "success") {
                if (data.chat_with_users.length !== lastCount) {
                    console.log("New message");
                    window.location.reload();
                }

            } else {
                console.error(data);
            }

        }

        setInterval(check_new_messages, 2500);
    </script>
@endsection
