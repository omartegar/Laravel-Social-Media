@extends('layouts.app')

@vite(['resources/css/home.css'])


@section('content')
    <header class="firstHeaderInPage">

        <div class='leftSide'>
            <img src="{{ 'storage/' . $mine->image_url }}" alt="profile photo">

        </div>
        <div class='rightSide'>
            <p>Welcome Back '{{ $mine->name }}'</p>
            <button id='logoutButton'>Log out</button>
        </div>

    </header>


    <main class="mainSections">
        <section id='postsSection'>
            <h3>Posts</h3>

            <button class='createPostButton'>Create Post</button>

            <div class='postsContainer'>
                <ul class='posts'>
                    @foreach ($posts as $post)
                        <li class='post'>
                            <header>
                                <div class='name'>
                                    <img src="{{ 'storage/' . $post->user->image_url }}" alt="profile_picture">
                                    <strong>{{ $post->user->name }}</strong>
                                    @if ($post->user_id === session('user_id'))
                                        <svg class="deletePostButton" onclick='handleDeletePost({{ $post->id }})'
                                            xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20px" height="20px"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M 10.806641 2 C 10.289641 2 9.7956875 2.2043125 9.4296875 2.5703125 L 9 3 L 4 3 A 1.0001 1.0001 0 1 0 4 5 L 20 5 A 1.0001 1.0001 0 1 0 20 3 L 15 3 L 14.570312 2.5703125 C 14.205312 2.2043125 13.710359 2 13.193359 2 L 10.806641 2 z M 4.3652344 7 L 5.8925781 20.263672 C 6.0245781 21.253672 6.877 22 7.875 22 L 16.123047 22 C 17.121047 22 17.974422 21.254859 18.107422 20.255859 L 19.634766 7 L 4.3652344 7 z">
                                            </path>
                                        </svg>
                                    @endif
                                </div>
                                <div class='date'>
                                    Posted on: {{ $post->created_at }}
                                </div>

                            </header>
                            <main class='postContent'>
                                <p>{{ $post->post_content }}</p>
                            </main>
                            <footer>
                                <div class='likesInfo'>
                                    <p>Anonymous likes</p>
                                </div>
                                <div class='likesButtons'>
                                    @php
                                        $liked = $likes_by_me->where('post_id', $post->id)->count() > 0;
                                    @endphp
                                    @if ($liked)
                                        <button
                                            onclick="destroyLike(this ,{{ session('user_id') }} ,  {{ $post->id }} );"
                                            class='like'>Liked</button>
                                    @else
                                        <button onclick="like(this ,{{ session('user_id') }} ,  {{ $post->id }} );"
                                            class='like'>Like</button>
                                    @endif


                                </div>
                            </footer>
                        </li>
                    @endforeach

                </ul>
            </div>

        </section>




        <section id='peopleSection'>
            <h3>People in application </h3>

            <div id='public_chat_container' onclick="window.location.href = '/public_chat'; ">
                <svg id='public_chat_icon' title="Go to public chat?" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 512 512"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                    <path
                        d="M256 0a64 64 0 1 1 0 128 64 64 0 1 1 0-128zm96 312c0 25-12.7 47-32 59.9l0 92.1c0 26.5-21.5 48-48 48l-32 0c-26.5 0-48-21.5-48-48l0-92.1C172.7 359 160 337 160 312l0-40c0-53 43-96 96-96s96 43 96 96l0 40zM96 32a56 56 0 1 1 0 112 56 56 0 1 1 0-112zm16 240l0 32c0 32.5 12.1 62.1 32 84.7l0 75.3c0 1.2 0 2.5 .1 3.7-8.5 7.6-19.7 12.3-32.1 12.3l-32 0c-26.5 0-48-21.5-48-48l0-56.6C12.9 364.4 0 343.7 0 320l0-32c0-53 43-96 96-96 12.7 0 24.8 2.5 35.9 6.9-12.6 21.4-19.9 46.4-19.9 73.1zM368 464l0-75.3c19.9-22.5 32-52.2 32-84.7l0-32c0-26.7-7.3-51.6-19.9-73.1 11.1-4.5 23.2-6.9 35.9-6.9 53 0 96 43 96 96l0 32c0 23.7-12.9 44.4-32 55.4l0 56.6c0 26.5-21.5 48-48 48l-32 0c-12.3 0-23.6-4.6-32.1-12.3 0-1.2 .1-2.5 .1-3.7zM416 32a56 56 0 1 1 0 112 56 56 0 1 1 0-112z" />

                </svg>
                <span>Public Chat</span>
            </div>


            <ul>
                @foreach ($users as $user)
                    @if ($user->id !== session('user_id'))
                        <li title='text me?' onclick='navigateToChat({{ $user->id }})'>
                            <img src="{{ 'storage/' . $user->image_url }}" alt="profilePicture">
                            <strong>{{ $user->name }}</strong>
                        </li>
                    @endif
                @endforeach
            </ul>
        </section>
    </main>







    <script>
        let token = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");
        let logoutButton = document.querySelector('button[id="logoutButton"]');
        let createPostButton = document.querySelector(
            'button[class="createPostButton"]'
        );

        createPostButton.onclick = () => {
            window.location.href = "/postcreate";
        };

        logoutButton.onclick = async () => {
            const response = await fetch("/logout", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": token,
                },
            });

            const data = await response.json();

            if (data.status === "success") {
                window.location.href = "/";
            } else {
                console.log(data);
            }
        };

        async function handleDeletePost(postId) {
            const response = await fetch("/postData", {
                method: "DELETE",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": token,
                },
                body: JSON.stringify({
                    postid: postId,
                }),
            });
            const data = await response.json();
            if (data.status === "success") {
                window.location.reload();
            } else {
                console.error(data);
            }
        }

        async function navigateToChat(receiver_id) {
            const response = await fetch("/chat", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": token,
                },
                body: JSON.stringify({
                    receiver_id: receiver_id,
                }),
            });
            const data = await response.json();
            if (data.status === "success") {
                window.location.href = "/chat";
            } else {
                console.log(data);
            }
        }



        async function like(e, user_id, post_id) {
            e.disabled = true;
            e.innerHTML = "Processing...";

            const response = await fetch('/like_post', {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": token
                },
                body: JSON.stringify({
                    user_id: user_id,
                    post_id: post_id
                })
            });
            const data = await response.json();
            if (data.status === "success") {
                e.setAttribute('onclick', `destroyLike(this, ${user_id}, ${post_id})`);
                e.innerHTML = "Liked";
                e.disabled = false;
            } else {
                console.log(data);
            }

        }

        async function destroyLike(e, user_id, post_id) {
            e.disabled = true;
            e.innerHTML = "Processing...";

            const response = await fetch('/dislike_post', {
                method: "DELETE",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": token
                },
                body: JSON.stringify({
                    user_id: user_id,
                    post_id: post_id
                })
            });
            const data = await response.json();

            if (data.status === 'success') {
                e.setAttribute("onclick", `like(this, ${user_id}, ${post_id})`);
                e.innerHTML = "Like";
                e.disabled = false;
            } else {
                console.log(data);
            }
        }
    </script>
@endsection
