lista_compras = []
while True:
    item = input("Ingrese un elemento para la lista de compras (o 'stop' para finalizar): ")
    if item.lower() == "stop":
        break
    lista_compras.append(item)

print("Lista de compras:", lista_compras)
lista_compras.sort()
print("Lista ordenada:", lista_compras)

buscar = input("Ingrese el elemento a buscar en la lista: ")
if buscar in lista_compras:
    print("SI")
else:
    print("NO")