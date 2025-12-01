@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center min-h-[80vh]">
        <div class="w-full max-w-md">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="bg-gray-100 py-4 px-6">
                    <h2 class="text-2xl font-bold text-gray-700">Register</h2>
                </div>

                <form method="POST" action="{{ route('register') }}" class="p-6 space-y-4">
                    @csrf

                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div>
                        <label for="firstname" class="block text-sm font-semibold text-gray-700 mb-2">
                            First name
                        </label>
                        <input
                            type="firstname"
                            name="firstname"
                            id="firstname"
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            placeholder="Enter your first name"
                            value="{{ old('firstname') }}"
                        />
                    </div>

                    <div>
                        <label for="lastname" class="block text-sm font-semibold text-gray-700 mb-2">
                            Last name
                        </label>
                        <input
                            type="lastname"
                            name="lastname"
                            id="lastname"
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            placeholder="Enter your last name"
                            value="{{ old('lastname') }}"
                        />
                    </div>

                    <div>
                        <label for="username" class="block text-sm font-semibold text-gray-700 mb-2">
                            Username
                        </label>
                        <input
                            type="text"
                            name="username"
                            id="username"
                            value="{{ old('username') }}"
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            placeholder="Enter your username"
                        />
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Email
                        </label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            placeholder="Enter your email"
                            value="{{ old('email') }}"
                        />
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                            Phone
                        </label>
                        <input
                            type="phone"
                            name="phone"
                            id="phone"
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            placeholder="Enter your phone number"
                            value="{{ old('phone') }}"
                        />
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            Password
                        </label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            placeholder="Enter your password"
                        />
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                            Confirm Password
                        </label>
                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            placeholder="Confirm your password"
                        />
                    </div>

                    <div>
                        <label for="role" class="block text-sm font-semibold text-gray-700 mb-2">
                            User Role
                        </label>
                        <select
                            type="role"
                            name="role"
                            id="role"
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                <option value="ta">Teacher Assistant</option>
                                <option value="teacher">Teacher</option>
                        </select>
                    </div>

                    <div class="pt-2">
                        <button
                            type="submit"
                            class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition"
                        >
                            Login
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
