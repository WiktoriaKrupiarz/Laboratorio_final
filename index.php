<!DOCTYPE html>
<html>

<head>
    <title>Formulario de Registro</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <div class="container">
        <h2>Formulario de Registro</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="name">Nombre:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="surname1">Primer apellido:</label>
                <input type="text" id="surname1" name="surname1" required>
            </div>
            <div class="form-group">
                <label for="surname2">Segundo apellido:</label>
                <input type="text" id="surname2" name="surname2" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="login">Login:</label>
                <input type="text" id="login" name="login" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" minlength="4" maxlength="8" required>
            </div>
            
            <div class="form-group">
                <input type="submit" name="btnEnviar" value="Enviar">
            </div>
            
            <?php
            if(isset($_POST["btnEnviar"])){
            // Obtener los datos del formulario
            $name = $_POST["name"];
            $surname1 = $_POST["surname1"];
            $surname2 = $_POST["surname2"];
            $email = $_POST["email"];
            $login = $_POST["login"];
            $password = $_POST["password"];

            // Establecer la conexión a la base de datos
            $host = "localhost";
            $username = "root";
            $password = "";
            $dbname = "curso_sql";

            $conx = new mysqli($host, $username, $password, $dbname);

            // Verificar la conexión
            if ($conx->connect_error) {
                die("Error en la conexión: " . $conx->connect_error);
            }

            // Validar el formato del correo electrónico
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                die("El email proporcionado no es válido. Por favor, inténtalo de nuevo.");
            } else {
                // Verificar duplicidad de correo electrónico
                $query = "SELECT * FROM users WHERE email = '$email'";
                $result = $conx->query($query);

                if ($result->num_rows > 0) {
                    // Correo electrónico duplicado, mostrar mensaje de error
                    die("El correo electrónico proporcionado ya está registrado. Por favor, utiliza otro correo electrónico.");
                } else {
                    // Insertar nuevo registro
                    $sql = "INSERT INTO users (per_name, first_surname, second_surname, email, user_name, psswd)
                            VALUES ('$name', '$surname1', '$surname2', '$email', '$login', '$password')";

                    if ($conx->query($sql) === TRUE) {
                        echo "Nuevo registro";
                    } else {
                        echo "Error " . $sql . "<br>" . $conx->error;
                    }
                }
            }

            //Cerramos la conexion
            $conx = null;
            header("Location: {$_SERVER['REQUEST_URI']}", true, 303);
            }
            ?>
            </form>

            <form action = "" method = "POST">

            <div class="form-group">
                <input type="submit" name="btnConsultar" value="Consultar">
            </div>

            <?php
            if (isset($_POST["btnConsultar"])) {
                $host = "localhost";
                $username = "root";
                $password = "";
                $dbname = "curso_sql";

                // Establecer conexión a la base de datos
                $conx = new mysqli($host, $username, $password, $dbname);

                // Verificar la conexión
                if ($conx->connect_error) {
                    die("Error en la conexión: " . $conx->connect_error);
                }

                // Consulta de registros
                $query = "SELECT * FROM users";
                $result = $conx->query($query);

                // Mostrar los registros
                if ($result->num_rows > 0) {
                    echo "<h2>Lista de usuarios registrados</h2>";
                    echo "<table>";
                    echo "<tr><th>Nombre</th><th>Apellidos</th><th> </th><th>Email</th><th>Login</th></tr>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>".$row['per_name']."</td>";
                        echo "<td>".$row['first_surname']."</td>";
                        echo "<td>".$row['second_surname']."</td>";
                        echo "<td>".$row['email']."</td>";
                        echo "<td>".$row['user_name']."</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "No hay usuarios registrados";
                }

                // Cerramos la conexión
                $conx->close();
                //header("Location: {$_SERVER['REQUEST_URI']}", true, 303);
            }
            ?>

        </form>
    </div>
</body>

</html>