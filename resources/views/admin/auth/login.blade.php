<!doctype html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  </head>
  <body>
    {{-- Tampilkan Error Jika Ada --}}
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('error'))
        <div>
            <p>{{ session('error') }}</p>
        </div>
    @endif

    @if (session('success'))
        <div>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.login.submit') }}">
        @csrf

        {{-- email --}}
        <label>
            <input type="email" name="email" required autofocus>
            <span>Email</span>
        </label>

        {{-- password --}}
        <label>
            <input type="password" name="password" required>
            <span>Password</span>
        </label>

        {{-- Tombol Login --}}
        <button type="submit">Login</button>
    </form>
  </body>
</html>