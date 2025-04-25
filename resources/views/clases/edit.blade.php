<h2>Editar Clase: {{ $clase->nombre }}</h2>

<form method="POST" action="{{ route('entrenador.clases.update', $clase) }}">
    @csrf
    @method('PUT')
    <input name="nombre" value="{{ $clase->nombre }}" />
    <textarea name="descripcion">{{ $clase->descripcion }}</textarea>
    <button type="submit">Actualizar</button>
</form>

<h3>Usuarios inscritos</h3>
<ul>
    @foreach ($usuarios as $user)
        <li>
            {{ $user->name }}
            <form method="POST" action="{{ route('entrenador.clases.eliminarUsuario', [$clase, $user]) }}">
                @csrf
                @method('DELETE')
                <button type="submit">Eliminar</button>
            </form>
        </li>
    @endforeach
</ul>

<h3>Agregar Usuario</h3>
<form method="POST" action="{{ route('entrenador.clases.agregarUsuario', $clase) }}">
    @csrf
    <select name="id_usuario">
        @foreach ($todosLosUsuarios as $usuario)
            <option value="{{ $usuario->id }}">{{ $usuario->name }} ({{ $usuario->email }})</option>
        @endforeach
    </select>
    <button type="submit">Agregar</button>
</form>
