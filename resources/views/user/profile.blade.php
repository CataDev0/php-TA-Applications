@extends('layouts.app')

@section('content')
    <div class="max-w-fit mx-auto">
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
    </div>
    <div class="flex justify-center gap-4">
        <div class="max-w-fit">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6 p-4">
                        <h1 class="text-2xl">Edit your profile</h1>
                        <h2 class="text-xl">{{$user->fullname()}}</h2>
                        <form id="editProfileForm" name="user.editProfile" class="mt-4 form-class-dom"
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
                            <input class="p-1 rounded-md bg-gray-200" type="email" name="email"
                                   value="{{$user->email}}">
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
        <div class="max-w-fit">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6 p-4">
                        <h2 class="text-2xl">About me</h2>
                        {{-- This is the form for the About Me field --}}
                        <form id="aboutMeForm" name="aboutMeForm" class="mt-4 form-class-dom" action="/profile/about"
                              method="post">
                            @csrf
                            <textarea class="bg-gray-200 rounded-2xl p-1" name="aboutme" id="aboutme" cols="30"
                                      rows="10"
                                      placeholder="Write something about yourself">{{$user->about}}</textarea>
                            <br>
                            <button form="aboutMeForm"
                                    id="aboutSaveButton"
                                    disabled
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md mt-4 opacity-50 cursor-not-allowed"
                                    type="submit">Save
                            </button>
                        </form>

                        {{-- CVs and Documents --}}
                        <h2 class="text-2xl mt-10">Documents</h2>
                        <h4 class="text-sm mt-2 text-gray-600">Upload relevant documents</h4>

                        <form id="documentUploadForm" action="{{ route('user.uploadDocument') }}" method="POST"
                              enctype="multipart/form-data" class="mt-4 form-class-dom">
                            @csrf

                            <label for="title" class="block text-lg text-blue-900 mb-1">Document Title</label>
                            <input type="text" name="title" id="title"
                                   placeholder="CV, Previous experience, Grade, Transcript, Certificate"
                                   class="w-full p-2 rounded-md bg-gray-200 mb-4">

                            <label for="file" class="block text-lg text-blue-900 mb-1">Choose File</label>
                            <input type="file" name="file" id="file"
                                   accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                   class="w-full p-2 rounded-md bg-gray-200">

                            <button type="submit"
                                    class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md mt-4">
                                Upload Document
                            </button>

                            @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            @error('file')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </form>

                        {{-- Display all documents --}}
                        {{-- Using mostly raw PHP here, only to showcase that it works --}}
                        <h3 class="text-lg mt-10">Uploaded Documents</h3>
                        <br>
                            <?php foreach ($files as $document): ?>
                        <form action="<?= route('user.deleteDocument', ['name' => $document['name']]) ?>"
                              method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this document?');">
                                <?= csrf_field() ?>
                                <?= method_field('DELETE') ?>
                                <?= htmlspecialchars($document['name']) ?>
                            <a class="text-blue-500"
                               href="<?= htmlspecialchars($document['url']) ?>">Download</a>
                            <button type="submit" class="text-red-600 font-semibold hover:underline">Delete
                            </button>
                        </form>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        // Create a listener for a form, toggle the save button on changes
        // Input relevant string variables buttonId, formId
        function createChangesListener(buttonId, formId) {
            document.addEventListener("DOMContentLoaded", () => {
                const form = document.getElementById(formId);
                const button = document.getElementById(buttonId);

                // Store the original values in a dictionary
                const originalValues = {};
                Array.from(form.elements).forEach(element => {
                    if (element.name) {
                        originalValues[element.name] = element.value;
                    }
                });

                // Toggles each save button if changes are detected in the form
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
                        button.disabled = false;
                        button.classList.remove('opacity-50', 'cursor-not-allowed');
                    } else {
                        button.disabled = true;
                        button.classList.add('opacity-50', 'cursor-not-allowed');
                    }
                }

                // Listen for changes on all inputs
                form.addEventListener('input', checkForChanges);
            });
        }

        // Create listeners for each form, monitor changes
        createChangesListener("saveButton", "editProfileForm");
        createChangesListener("aboutSaveButton", "aboutMeForm");

    </script>
@endsection
