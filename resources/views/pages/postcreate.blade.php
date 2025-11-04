@extends('layouts.app')


@vite(['resources/css/postcreate.css'])

@section('content')
    <h1>Create new post</h1>


    <form class='postCreateForm'>
        @csrf
        <div>

            <button class='goBackButton'>Go back</button>
            <label for='post'>Type your post below:</label>
            <textarea type="text" id='post' placeholder="Type your text here.."></textarea>
        </div>

        <div>
            <strong id='createPost_error_message' style="color:red;font-size:1.2rem"></strong>
        </div>
        <div>
            <button type='submit'>Create Post</button>
        </div>
    </form>

    <script>
        let token = document.querySelector('meta[name="csrf-token"]').content;
        let form = document.querySelector('form[class="postCreateForm"]');
        let createPost_error_message = document.querySelector('strong[id="createPost_error_message"]');
        let goBackButton = document.querySelector('button[class="goBackButton"]');

        goBackButton.onclick = () => {
            window.history.back();
        }

        form.onsubmit = async (e) => {
            e.preventDefault();

            const response = await fetch('/postData', {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": token
                },
                body: JSON.stringify({
                    textarea: document.querySelector('textarea[id="post"]').value
                })
            });
            const data = await response.json();
            if (data.status === "success") {
                createPost_error_message.innerHTML = "";
                window.location.href = "/home";
            } else {
                console.log(data);
                createPost_error_message.innerHTML = data.message;
            }
        }
    </script>
@endsection
