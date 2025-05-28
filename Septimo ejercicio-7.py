libros = {}
while True:
    clave = input("Ingrese la clave del libro (o 'stop' para finalizar): ")
    if clave.lower() == 'stop':
        break
    descripcion = input("Ingrese el nombre o descripción del libro: ")
    libros[clave] = descripcion

for clave, descripcion in libros.items():
    print(f"El libro {descripcion} tiene la clave {clave}.")