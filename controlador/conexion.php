<?php
class Conexion {
    // Definimos las propiedades
    private $host;
    private $db;
    private $user;
    private $pass;
    private $charset = "utf8mb4";

    public function __construct() {
        // Simulamos el comportamiento de: process.env.DB_HOST || "localhost"
        // Si existe la variable de entorno, la usa; si no, usa el valor por defecto.
        $this->host = getenv('DB_HOST') ?: "localhost";
        $this->db   = getenv('DB_NAME') ?: "zgas_bd";
        $this->user = getenv('DB_USER') ?: "root";
        $this->pass = getenv('DB_PASSWORD') ?: ""; // Contraseña vacía por defecto
    }

    public function conectar() {
        try {
            $connectionString = "mysql:host={$this->host};dbname={$this->db};charset={$this->charset}";
            
            // Opciones adicionales para seguridad y manejo de errores (similar al pool de JS)
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            $pdo = new PDO($connectionString, $this->user, $this->pass, $options);

            // ✅ ÉXITO: 
            // Usamos error_log en lugar de echo para no ensuciar la respuesta al navegador.
            // Esto aparecerá en los logs de error de tu servidor (Apache/XAMPP).
            // error_log("✅ Conexión exitosa a la base de datos MySQL (zgas_bd)");

            return $pdo;

        } catch (PDOException $e) {
            // ❌ ERROR:
            // Registramos el error en el log del servidor
            error_log("❌ Error al conectar con la base de datos: " . $e->getMessage());
            
            // Terminamos el script para no seguir ejecutando con una conexión rota
            die("Error crítico de conexión. Revise los logs del servidor.");
        }
    }
}
?>