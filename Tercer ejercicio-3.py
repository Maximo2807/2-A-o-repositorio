lado1 = float(input("Ingrese el valor del primer lado: "))
lado2 = float(input("Ingrese el valor del segundo lado: "))
lado3 = float(input("Ingrese el valor del tercer lado: "))

if lado1 == lado2 == lado3:
    print("El triángulo es equilátero.")
elif lado1 == lado2 or lado1 == lado3 or lado2 == lado3:
    print("El triángulo es isósceles.")
else:
    print("El triángulo es escaleno.")