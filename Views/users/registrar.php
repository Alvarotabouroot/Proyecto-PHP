<article class="formularioAdmi">
            <h2>Registro nuevo administrador</h2>
            <form action="<?=$_ENV['BASE_URL']?>users/registrar" method="POST" class="registroAdmi">
                <label for="nombre">Nombre</label>
                <input type="text" name="data[nombre]">
                
                <label for="email">Email</label>
                <input type="email" name="data[email]">
                
                <label for="password">Contraseña</label>
                <input type="password" name="data[password]">
                <br>
                <input type="submit" value="Registrar Usuario">
            </form>
        </article>