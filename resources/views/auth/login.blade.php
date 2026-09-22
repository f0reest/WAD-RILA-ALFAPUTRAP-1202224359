<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="auth-header">
        <p class="auth-eyebrow">Welcome</p>
        <h2 class="auth-title">Sign in</h2>
    </div>

    <form id="login-form" method="POST" action="{{ route('login') }}" class="auth-form">
        @csrf

        <div>
            <label for="email" class="auth-label">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="auth-input" />
            @error('email')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="auth-label">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" class="auth-input" />
            @error('password')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="auth-meta-row">
            <label for="remember_me" class="auth-remember">
                <input id="remember_me" type="checkbox" class="auth-check" name="remember">
                <span>Remember me</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="auth-link">
                    Forgot password?
                </a>
            @endif
        </div>

        <div class="auth-actions">
            <button type="button" id="demo-admin" class="raw-button secondary demo-button">Use demo admin</button>
            <button type="submit" class="raw-button">Log in</button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('login-form');
            const demoButton = document.getElementById('demo-admin');

            if (form && demoButton) {
                demoButton.addEventListener('click', function () {
                    const emailInput = form.querySelector('input[name="email"]');
                    const passwordInput = form.querySelector('input[name="password"]');

                    if (emailInput && passwordInput) {
                        emailInput.value = 'admin@maintenance-app.test';
                        passwordInput.value = 'admin123';
                        form.submit();
                    }
                });
            }
        });
    </script>
</x-guest-layout>
