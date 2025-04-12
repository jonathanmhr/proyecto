<form method="POST" action="{{ route('perfil.store') }}">
    @csrf
    <div>
        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
        <input type="date" name="fecha_nacimiento" required>
    </div>

    <div>
        <label for="peso">Peso:</label>
        <input type="number" name="peso" required>
    </div>

    <div>
        <label for="altura">Altura:</label>
        <input type="number" name="altura" required>
    </div>

    <div>
        <label for="objetivo">Objetivo:</label>
        <input type="text" name="objetivo" required>
    </div>

    <button type="submit">Guardar perfil</button>
</form>
