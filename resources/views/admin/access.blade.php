<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Predicciones</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('logo-liga_mx.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center">Acceso Administrador</h1>
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <form method="POST" action="{{ route('admin.validate') }}">
            @csrf
            <div class="mb-3">
                <label for="access_code" class="form-label">Código de Acceso</label>
                <input type="text" class="form-control" id="access_code" name="access_code" required>
            </div>
            <button type="submit" class="btn btn-primary">Ingresar</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html