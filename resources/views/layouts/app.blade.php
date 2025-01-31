<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Inclua aqui seus estilos ou links de CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <!-- Navbar -->
        <header class="bg-blue-600 text-white p-4">
            <div class="container mx-auto flex justify-between items-center">
                <h1 class="text-xl font-bold"><a href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</a></h1>
                <nav>
                    @auth
                        <a href="{{ route('logout') }}"
                           class="px-3 py-2 rounded bg-red-500 hover:bg-red-600"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="px-3 py-2 rounded bg-green-500 hover:bg-green-600">Login</a>
                        <a href="{{ route('register') }}" class="px-3 py-2 rounded bg-yellow-500 hover:bg-yellow-600">Registro</a>
                    @endauth
                </nav>
            </div>
        </header>

        <!-- Conteúdo -->
        <main class="flex-grow container mx-auto py-8">
            @yield('content')
        </main>

        <!-- Rodapé -->
        <footer class="bg-gray-800 text-white p-4 text-center">
            <p>&copy; {{ date('Y') }} - Todos os direitos reservados.</p>
        </footer>
    </div>
</body>
</html>
