<?php
namespace orm;

use entidad\RegistroAsistente;
use PDO;

class ORMRegistro {
    private const TABLA = 'registro_asistente';
    private const PK = 'id';

    // sobra la i 
    protected const DSN = 'mysql:host=192.168.12.71;dbname=examen;charset=utf8mb4';
    protected static array $OPTIONS = [
        PDO::ATTR_CASE                 => PDO::CASE_LOWER,
        PDO::ATTR_EMULATE_PREPARES     => false,
        PDO::ATTR_ERRMODE              => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE   => PDO::FETCH_ASSOC
    ];

    protected PDO $pdo;

    public function __construct(){
        $this->pdo = new PDO(self::DSN, 'examen', 'usuario', self::$OPTIONS);
    }

    public function insertar(RegistroAsistente $registro){
        $sql = "INSERT INTO " . self::TABLA . ' (email, fecha_inscripcion, actividad)';
        $sql .= "VALUES(:email, :fecha_inscripcion, :actividad)";

        $stmt = $this->pdo->prepare($sql);

        $params = [
            ':email' => $registro->email,
            ':fecha_inscripcion' => $registro->fecha_inscripcion->format(RegistroAsistente::FORMATO_FECHA_MYSQL),
            ':actividad' => $registro->actividad
        ];

        if( $stmt->execute($params) && $stmt->rowCount() == 1 ){
            return true;
        }

        return false;
    }

    public function listar(string $email){
        $sql = 'SELECT * FROM ' . self::TABLA . ' ';
        $sql .= "WHERE email = :email;";

        $stmt = $this->pdo->prepare($sql);

        $params = [':email' => $email];

        if ($stmt->execute($params) && $stmt->rowCount() >= 1) {
            $array_registros = [];
            while( $fila = $stmt->fetch() ){
                $registro = new RegistroAsistente($fila);
                $array_registros[] = $registro;
            }
            return $array_registros;
        }
        return [];
    }
}
?>