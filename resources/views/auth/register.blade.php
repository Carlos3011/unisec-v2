<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div class="space-y-2">
            <x-input-label for="name" :value="__('Nombre completo')" class="text-white/90" />
            <x-text-input id="name" class="block w-full bg-white/10 border-white/20 focus:border-primary focus:ring-primary text-white" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="space-y-2">
            <x-input-label for="email" :value="__('Correo electrónico')" class="text-white/90" />
            <x-text-input id="email" class="block w-full bg-white/10 border-white/20 focus:border-primary focus:ring-primary text-white" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="space-y-2">
            <x-input-label for="password" :value="__('Contraseña')" class="text-white/90" />
            <x-text-input id="password" class="block w-full bg-white/10 border-white/20 focus:border-primary focus:ring-primary text-white"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="space-y-2">
            <x-input-label for="password_confirmation" :value="__('Confirmar contraseña')" class="text-white/90" />
            <x-text-input id="password_confirmation" class="block w-full bg-white/10 border-white/20 focus:border-primary focus:ring-primary text-white"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex flex-col space-y-4 sm:flex-row sm:items-center sm:justify-between sm:space-y-0 mt-6">
            <a class="text-sm text-white/90 hover:text-primary transition-colors duration-300" href="{{ route('login') }}">
                {{ __('Ya te encuentras registrado?') }}
            </a>

            <x-primary-button class="w-full sm:w-auto justify-center py-3 bg-primary/10 hover:bg-primary/20 text-primary transition-all duration-300 rounded-xl">
                {{ __('Registrar') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
