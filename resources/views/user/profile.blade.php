@extends('layouts.app')

@section('content')
    <div class="max-w-fit mx-auto">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="mb-6 p-4">
                    <h1 class="text-2xl">Edit your profile</h1>
                    <h2 class="text-xl">{{$user->fullname()}}</h2>
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-800 rounded-md">
                            {{ session('error') }}
                        </div>
                    @endif
                    <form id="editProfileForm" name="user.editProfile" class="mt-4"
                          action="{{ route("user.editProfile")}}" method="post">
                        @csrf
                        {{--  We could include avatar here if we just save an image URL  --}}
                        {{--  <img src="$user->avatar">  --}}
                        {{--  <input type="text" name="avatar" value="{{$user->avatar}}">  --}}

                        <p class="text-lg text-blue-900 mt-1"><label for="firstname">Firstname</label></p>
                        <input class="p-1 rounded-md bg-gray-200" type="text" name="firstname"
                               value="{{$user->firstname}}">
                        @error('firstname')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="text-lg text-blue-900 mt-1"><label for="lastname">Lastname</label></p>
                        <input class="p-1 rounded-md bg-gray-200" type="text" name="lastname"
                               value="{{$user->lastname}}">
                        @error('lastname')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="text-lg text-blue-900 mt-1"><label for="username">Username</label></p>
                        <input class="p-1 rounded-md bg-gray-200" type="text" name="username"
                               value="{{$user->username}}">
                        @error('username')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="text-lg text-blue-900 mt-1"><label for="email">Email</label></p>
                        <input class="p-1 rounded-md bg-gray-200" type="email" name="email" value="{{$user->email}}">
                        @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="text-lg text-blue-900 mt-1"><label for="phone">Phone</label></p>
                        <input class="p-1 rounded-md bg-gray-200" type="tel" name="phone" value="{{$user->phone}}">
                        @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="text-lg text-blue-900 mt-1"><label for="password">New Password</label></p>
                        <input class="p-1 rounded-md bg-gray-200" type="password" name="password"
                               value="">
                        <p class="text-lg text-blue-900 mt-1"><label for="password_confirmation">Confirm
                                Password</label></p>
                        <input class="p-1 rounded-md bg-gray-200" type="password" name="password_confirmation"
                               value="">
                        @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </form>
                    {{--  Only display the role, don't edit it  --}}
                    <p class="text-lg text-blue-900">Role</p>
                    <p class="">{{$user->getRoleName()}}</p>

                    <button form="editProfileForm"
                            id="saveButton"
                            disabled
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md mt-4 opacity-50 cursor-not-allowed"
                            type="submit">Save
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
    console.log("Script is running");
    document.addEventListener("DOMContentLoaded", () => {
        const form = document.getElementById("editProfileForm");
        const saveButton = document.getElementById("saveButton");

        // Store the original values in a dictionary
        const originalValues = {};
        Array.from(form.elements).forEach(element => {
            if (element.name) {
                originalValues[element.name] = element.value;
            }
        });

        // Toggles save button if changes are detected in the form
        function checkForChanges() {
            let changed = false;

            Array.from(form.elements).forEach(element => {
                if (!element.name) return;

                // Password fields are empty by default
                if (element.type === "password" && element.value !== "") {
                    changed = true;
                } else if (element.value !== originalValues[element.name]) {
                    changed = true;
                }
            });

            // Toggle button
            if (changed) {
                saveButton.disabled = false;
                saveButton.classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                saveButton.disabled = true;
                saveButton.classList.add('opacity-50', 'cursor-not-allowed');
            }
        }

        // Listen for changes on all inputs
        form.addEventListener('input', checkForChanges);
    });
</script>
@endsection
