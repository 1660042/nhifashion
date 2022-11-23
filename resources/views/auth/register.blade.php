<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="ten" :value="__('Họ và tên')" />

                <x-input id="ten" class="block mt-1 w-full" type="text" name="ten" placeholder="Nhập họ và tên"
                    :value="old('ten')" required autofocus />
            </div>

            {{-- Phone number --}}
            <div>
                <x-label for="sdt" :value="__('Số điện thoại')" />

                <x-input id="sdt" class="block mt-1 w-full" type="text" name="sdt" placeholder="Nhập số điện thoại"
                    :value="old('sdt')" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Địa chỉ email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" placeholder="Nhập địa chỉ email"
                    :value="old('email')" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Mật khẩu')" />

                <x-input id="password" class="block mt-1 w-full" type="password" name="password"
                    placeholder="Nhập mật khẩu" required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Nhập lại mật khẩu')" />

                <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" placeholder="Nhập lại mật khẩu" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Đăng nhập') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Đăng ký') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
