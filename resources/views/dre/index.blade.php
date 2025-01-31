<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard DRE</title>
</head>
<body>
    <h1>Dashboard DRE</h1>
    <table>
        <thead>
            <tr>
                <th>Setor</th>
                <th>Orçamento Mensal</th>
                <th>Gasto Real</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sectors as $sector)
                <tr>
                    <td>{{ $sector->name }}</td>
                    <td>{{ $sector->monthly_budget }}</td>
                    <td>{{ $sector->actual_spending }}</td>
                    <td>
                        <a href="{{ route('dre.edit', $sector->id) }}">Editar</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
