<x-guest-layout>
    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Email Address -->
        <div class="space-y-2">
            <x-input-label for="email" :value="__('Correo electrónico')" class="text-white/90" />
            <x-text-input id="email" 
                class="block w-full bg-white/10 border-white/20 focus:border-primary focus:ring-primary text-white" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                autofocus 
                autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="space-y-2">
            <x-input-label for="password" :value="__('Contraseña')" class="text-white/90" />
            <x-text-input id="password" 
                class="block w-full bg-white/10 border-white/20 focus:border-primary focus:ring-primary text-white"
                type="password"
                name="password"
                required 
                autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />

            <!-- Remember Me -->
            <div class="flex flex-col space-y-4 sm:flex-row sm:items-center sm:justify-between sm:space-y-0 mt-6">
                <div class="flex items-center">
                    <input id="remember_me" 
                        type="checkbox" 
                        class="rounded-md border-white/20 bg-white/10 text-primary focus:ring-primary transition-all duration-300" 
                        name="remember">
                    <span class="ms-2 text-sm text-white/90 hover:text-primary transition-colors duration-300">{{ __('Recordar mi sesión') }}</span>
                </div>

                @if (Route::has('password.request'))
                    <a class="text-sm text-white/90 hover:text-primary transition-colors duration-300" 
                        href="{{ route('password.request') }}">
                        {{ __('Olvidaste tu contraseña?') }}
                    </a>
                @endif
            </div>

            <x-primary-button class="w-full justify-center py-3 bg-primary/10 hover:bg-primary/20 text-primary transition-all duration-300 rounded-xl">
                {{ __('Iniciar sesión') }}
            </x-primary-button>
        </form>
</x-guest-layout>
