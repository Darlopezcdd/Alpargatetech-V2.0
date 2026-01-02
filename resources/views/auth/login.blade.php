<form method="POST" action="{{ route('login') }}">
    @csrf
    <div>
        <label>Correo Electrónico:</label>
        <input type="email" name="email" required>
    </div>
    <div>
        <label>Contraseña:</label>
        <input type="password" name="password" required>
    </div>
    <button type="submit">Entrar a AlpargateTech</button>
</form>
