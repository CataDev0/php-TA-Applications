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
                    <form id="editProfileForm" name="user.editProfile" class="mt-4" action={{ route("user.editProfile")}} method="post">
                        @csrf
                        {{--  We could include avatar here if we just save an image URL  --}}
                        {{--  <img src="$user->avatar">  --}}
                        {{--  <input type="text" name="avatar" value="{{$user->avatar}}">  --}}

                        <p class="text-lg text-blue-900 mt-1"><label for="firstname">Firstname</label></p>
                        <input class="p-1 rounded-md bg-gray-200" type="text" name="firstname"
                               value="{{$user->firstname}}">

                        <p class="text-lg text-blue-900 mt-1"><label for="lastname">Lastname</label></p>
                        <input class="p-1 rounded-md bg-gray-200" type="text" name="lastname"
                               value="{{$user->lastname}}">

                        <p class="text-lg text-blue-900 mt-1"><label for="username">Username</label></p>
                        <input class="p-1 rounded-md bg-gray-200" type="text" name="username"
                               value="{{$user->username}}">

                        <p class="text-lg text-blue-900 mt-1"><label for="email">Email</label></p>
                        <input class="p-1 rounded-md bg-gray-200" type="email" name="email" value="{{$user->email}}">

                        <p class="text-lg text-blue-900 mt-1"><label for="phone">Phone</label></p>
                        <input class="p-1 rounded-md bg-gray-200" type="tel" name="phone" value="{{$user->phone}}">

                        <p class="text-lg text-blue-900 mt-1"><label for="password">New Password</label></p>
                        <input class="p-1 rounded-md bg-gray-200" type="password" name="password"
                               value="">
                        <p class="text-lg text-blue-900 mt-1"><label for="password_confirmation">Confirm Password</label></p>
                        <input class="p-1 rounded-md bg-gray-200" type="password" name="password_confirmation"
                               value="">
                    </form>
                    {{--  Only display the role, don't edit it  --}}
                    <p class="text-lg text-blue-900">Role</p>
                    <p class="">{{$user->getRoleName()}}</p>

                    <button form="editProfileForm"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md mt-4"
                            type="submit">Save
                    </button>
                    @if ($errors->any())
                        <div class="text-red-500">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
