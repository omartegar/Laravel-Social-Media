@extends('layouts.app')

@vite(['resources/css/loginpage.css'])


@section('content')
    <h1>Login page</h1>
    <form id='login_form'>
        <div>
            <label for="email">Email</label>
            <input type="email" placeholder="email" id='email'>
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" id="password" placeholder="Password">
        </div>

        <div>
            <strong style="color:red;font-size:1.2rem" id='error_message'>
                @if (isset($logout_message))
                    {{ $logout_message }}
                @endif
            </strong>
        </div>

        <div>
            <button type='submit'>Login</button>
        </div>
        <div>
            <p>Don't have an account? <a href="/signup">Create Account</a></p>
        </div>
    </form>

    <script>
        let token = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");
        let form = document.querySelector('form[id="login_form"]');
        let email = document.querySelector('input[id="email"]');
        let password = document.querySelector('input[id="password"]');
        let error_message = document.querySelector('strong[id="error_message"]');

        form.onsubmit = async (e) => {
            e.preventDefault();

            const response = await fetch("/login", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": token,
                },
                body: JSON.stringify({
                    email: email.value,
                    password: password.value,
                }),
            });
            const data = await response.json();

            if (data.status === "success") {
                window.location.href = "/home";
            } else {
                console.log(data);
                error_message.innerHTML = data.message;
            }
        };
    </script>
@endsection
