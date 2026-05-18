<?php

// ==========================================
// 1. INTERFACE Y TRAIT
// ==========================================
interface Autenticable {
    public function login(string $email, string $password): bool;
}

trait Trazable {
    public function registrarActividad(string $actividad): void {
        // Imprime un log en pantalla para ver la actividad
        echo "<p style='color: gray;'><em>[LOG] - " . $actividad . "</em></p>";
    }
}

// ==========================================
// 2. CLASE ABSTRACTA (Padre)
// ==========================================
abstract class Usuario implements Autenticable {
    use Trazable;

    // Cambiamos a protected para que los hijos (Alumno, Instructor) puedan acceder
    protected string $nombre;
    protected string $email;
    protected string $estado = 'activo'; // Por defecto activo

    public function setNombre(string $nombre): void { $this->nombre = $nombre; }
    public function getNombre(): string { return $this->nombre; }
    
    public function setEmail(string $email): void { $this->email = $email; }
    public function getEmail(): string { return $this->email; }
    
    public function setEstado(string $estado): void { $this->estado = $estado; }
    public function getEstado(): string { return $this->estado; }

    public function login(string $email, string $password): bool {
        // Simulamos que el login siempre es exitoso
        $this->registrarActividad("El usuario {$this->nombre} ha iniciado sesión en la plataforma.");
        return true;
    }
}

// ==========================================
// 3. CLASES HIJAS Y CURSO
// ==========================================
class Administrador extends Usuario {
    public function __construct(string $nombre, string $email) {
        $this->nombre = $nombre;
        $this->email = $email;
    }

    // Recibimos el objeto Usuario completo para poder cambiarle el estado
    public function banearUsuario(Usuario $usuario): void {
        $usuario->setEstado('baneado');
        $this->registrarActividad("El administrador {$this->nombre} ha baneado al usuario {$usuario->getNombre()}.");
    }
}

class Instructor extends Usuario {
    private int $cursosPublicados = 0;
    private array $cursos = [];

    public function __construct(string $nombre, string $email, int $cursosPublicados = 0) {
        $this->nombre = $nombre;
        $this->email = $email;
        $this->cursosPublicados = $cursosPublicados;
    }

    public function getCursosPublicados(): int { return $this->cursosPublicados; }
    public function setCursosPublicados(int $cantidad): void { $this->cursosPublicados = $cantidad; }

    public function crearCurso(Curso $curso): Curso {
        $this->cursos[] = $curso;
        $this->cursosPublicados++;
        $curso->setInstructor($this); // Vinculamos el instructor al curso
        $this->registrarActividad("El instructor {$this->nombre} ha creado el curso: {$curso->getTitulo()}.");
        return $curso;
    }

    public function getCursos(): array { return $this->cursos; }
}

class Alumno extends Usuario {
    private int $cursosInscritos = 0;
    private array $cursos = [];

    public function __construct(string $nombre, string $email, int $cursosInscritos = 0) {
        $this->nombre = $nombre;
        $this->email = $email;
        $this->cursosInscritos = $cursosInscritos;
    }

    public function getCursosInscritos(): int { return $this->cursosInscritos; }
    public function setCursosInscritos(int $cantidad): void { $this->cursosInscritos = $cantidad; }

    public function inscribirseCurso(Curso $curso): void {
        $this->cursos[] = $curso;
        $this->cursosInscritos++;
        $curso->agregarAlumno($this); // Vinculamos el alumno al curso
        $this->registrarActividad("El alumno {$this->nombre} se ha inscripto al curso: {$curso->getTitulo()}.");
    }

    public function getCursos(): array { return $this->cursos; }
}

class Curso {
    private string $titulo;
    private string $descripcion;
    private array $alumnos = []; // tieneAlumnos
    private ?Instructor $instructor = null; // dictadoPor

    public function __construct(string $titulo, string $descripcion) {
        $this->titulo = $titulo;
        $this->descripcion = $descripcion;
    }

    public function getTitulo(): string { return $this->titulo; }
    public function setTitulo(string $titulo): void { $this->titulo = $titulo; }
    
    public function getDescripcion(): string { return $this->descripcion; }
    public function setDescripcion(string $descripcion): void { $this->descripcion = $descripcion; }

    public function agregarAlumno(Alumno $alumno): void {
        $this->alumnos[] = $alumno;
    }

    public function getAlumnos(): array { return $this->alumnos; }

    // Métodos extra para manejar la relación con Instructor
    public function setInstructor(Instructor $instructor): void {
        $this->instructor = $instructor;
    }

    public function getInstructor(): ?Instructor {
        return $this->instructor;
    }
}

// ==========================================
// 4. EJECUCIÓN DE PRUEBA (Lo que pide el PDF)
// ==========================================
echo "<h2>Ejecución del Sistema - TP Unidad 2</h2>";

// Paso A: Crear un administrador e iniciar sesión
$admin = new Administrador("Maxi Admin", "admin@instituto.com");
$admin->login("admin@instituto.com", "1234");

// Paso B: Crear un curso y un instructor
$cursoPOO = new Curso("PHP Avanzado y POO", "Curso intensivo de objetos");
$instructor = new Instructor("Prof. Juan Carlos", "juan@instituto.com");
$instructor->login("juan@instituto.com", "1234");
$instructor->crearCurso($cursoPOO); // Acá se vinculan y se registra la actividad

// Paso C: Crear 3 alumnos, inician sesión y se inscriben
$alumno1 = new Alumno("Marcos Diaz", "marcos@mail.com");
$alumno1->login("marcos@mail.com", "1234");
$alumno1->inscribirseCurso($cursoPOO);

$alumno2 = new Alumno("Sofia Luna", "sofia@mail.com");
$alumno2->login("sofia@mail.com", "1234");
$alumno2->inscribirseCurso($cursoPOO);

$alumno3 = new Alumno("Pedro Gomez", "pedro@mail.com");
$alumno3->login("pedro@mail.com", "1234");
$alumno3->inscribirseCurso($cursoPOO);

// Paso D: Simular un baneo por parte del admin
$admin->banearUsuario($alumno3);

echo "<hr>";

// ==========================================
// 5. SALIDA FINAL (Usando solo el objeto Curso)
// ==========================================
echo "<h3>Resumen del Curso (Obtenido desde el objeto Curso)</h3>";

echo "<strong>Nombre del Curso:</strong> " . $cursoPOO->getTitulo() . "<br>";

// Obtenemos el instructor desde el curso
$profe = $cursoPOO->getInstructor();
echo "<strong>Dictado por (Instructor):</strong> " . ($profe ? $profe->getNombre() : "Sin asignar") . "<br>";

echo "<strong>Alumnos Inscriptos:</strong><ul>";
// Recorremos los alumnos desde el curso
foreach ($cursoPOO->getAlumnos() as $alum) {
    echo "<li>" . $alum->getNombre() . " (Estado: " . $alum->getEstado() . ")</li>";
}
echo "</ul>";

?>