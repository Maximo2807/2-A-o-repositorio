numero = int(input("Ingrese un número de 4 cifras: "))
while numero > 1:
    numero = numero // 2
    print(f"Resultado: {numero}")
    if numero != 0 and numero % 3 == 0:
        print("Este resultado es divisible por 3.")