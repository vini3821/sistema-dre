<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Setor</title>
</head>
<body>
    <h1>Editar Setor: {{ $sector->name }}</h1>

    <form action="{{ route('dre.update', $sector->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="name">Nome do Setor</label>
        <input type="text" name="name" value="{{ $sector->name }}" required><br>

        <label for="monthly_budget">Orçamento Mensal</label>
        <input type="number" name="monthly_budget" value="{{ $sector->monthly_budget }}" required><br>

        <label for="actual_spending">Gasto Real</label>
        <input type="number" name="actual_spending" value="{{ $sector->actual_spending }}" required><br>

        <button type="submit">Atualizar Setor</button>
    </form>
</body>
</html>
