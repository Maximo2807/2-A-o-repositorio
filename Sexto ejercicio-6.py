faltante = {'papa', 'zapallo', 'zanahoria', 'rabano', 'lechuga', 'tomate'}
comprados = set()

while True:
    item = input("Ingrese un elemento comprado (o 'stop' para finalizar): ")
    if item.lower() == 'stop':
        break
    comprados.add(item)

print(f"a) Longitud de faltante: {len(faltante)}")
print(f"   Longitud de comprados: {len(comprados)}")
print(f"b) ¿'arveja' está en faltante?: {'SI' if 'arveja' in faltante else 'NO'}")
print(f"c) ¿'tomate' está en comprados?: {'SI' if 'tomate' in comprados else 'NO'}")
print(f"d) Elementos en faltante pero no en comprados: {faltante - comprados}")
print(f"e) Elementos en ambos conjuntos: {faltante & comprados}")
print(f"f) Elementos en faltante o comprados, pero no en ambos: {faltante ^ comprados}")