@extends('layouts.app')

@vite(['resources/css/signupPage.css'])

@section('content')
    <h1>SignUp page</h1>
    <form class='register_form'>
        <div>
            <label for="name">Name</label>
            <input type="text" id='name' placeholder="Name">
        </div>
        <div>
            <label for="email">Email</label>
            <input type="email" placeholder="email" id='email'>
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" id="password" placeholder="Password">
        </div>
        <div>
            <label for="confirmpassword">Confirm Password</label>
            <input type="password" id="confirmpassword" placeholder="Confirm Password">
        </div>

        <div>
            <label for="phone">Phone number</label>
            <input type="text" id='phone' placeholder="Phone number">
        </div>

        <div>
            <label for="age">Age</label>
            <select id="age">
                {{ $count = 18 }}
                @while ($count <= 100)
                    <option value="{{ $count }}">{{ $count }}</option>
                    {{ $count++ }}
                @endwhile
            </select>
        </div>

        <div>
            <label for="image">Profile Picture</label>
            <input type="file" name="image" accept="image/*" id="image">
        </div>

        <div>
            <strong id='error_message' style="color:red;font-size:1.2rem"></strong>
        </div>
        <div>
            <button type='submit'>Create Account</button>
        </div>
        <div>
            <p>Already have an account? <a href="/login">Login Instead</a></p>
        </div>
    </form>


    <script>
        let token = document.querySelector('meta[name="csrf-token"]').content;
        let name = document.querySelector('input[id="name"]');
        let email = document.querySelector('input[id="email"]');
        let password = document.querySelector('input[id="password"]');
        let confirmpassword = document.querySelector('input[id="confirmpassword"]');
        let age = document.querySelector('select[id="age"]');
        let profile_picture = document.querySelector('input[id="image"]');
        let form = document.querySelector(".register_form");
        let phone_number = document.querySelector('input[id="phone"]');
        let error_message = document.querySelector('strong[id="error_message"]');

        const formData = new FormData();

        form.onsubmit = async (e) => {
            e.preventDefault();

            formData.append("name", name.value);
            formData.append("email", email.value);
            formData.append("password", password.value);
            formData.append("confirmpassword", confirmpassword.value);
            formData.append("age", age.value);
            formData.append("profile_picture", profile_picture.files[0]);
            formData.append("phone_number", phone_number.value);

            const response = await fetch("/signup", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": token,
                },
                body: formData,
            });
            const data = await response.json();

            if (data.status === "success") {
                error_message.innerHTML = "";
                window.location.href = "/login";
            } else {
                console.log(data);
                error_message.innerHTML = data.message;
            }
        };
    </script>
@endsection
