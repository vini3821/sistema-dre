<x-app-layout>
    <div class="min-h-screen flex flex-col bg-gray-100">
        <!-- Logo Prime2B no topo -->
        <div class="mt-4">
            <div class="flex justify-center">
                <img src="{{ asset('images/prime2b-logo.jfif') }}" 
                     alt="Prime2B Logo" 
                     class="w-40 h-40 object-contain">
            </div>
        </div>

        <!-- Container principal centralizado -->
        <div class="flex-1 flex items-center justify-center -mt-48">
            <div class="w-full sm:max-w-md px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg mx-4">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" 
                                     class="block mt-1 w-full" 
                                     type="email" 
                                     name="email" 
                                     :value="old('email')" 
                                     required 
                                     autofocus 
                                     autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" 
                                     class="block mt-1 w-full"
                                     type="password"
                                     name="password"
                                     required 
                                     autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="block mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" 
                                   type="checkbox" 
                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" 
                                   name="remember">
                            <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" 
                           href="{{ route('register') }}">
                            {{ __('Register') }}
                        </a>

                        <x-primary-button class="ms-3">
                            {{ __('Log in') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
