from flask import Flask, render_template, request, redirect, url_for

app = Flask(__name__)

# Clase Producto
class Producto:
    def __init__(self, nombre, precio):
        self.nombre = nombre
        self.precio = precio

# Clase Carrito
class Carrito:
    def __init__(self):
        self.productos = []

    def agregar_producto(self, producto):
        self.productos.append(producto)

    def eliminar_producto(self, indice):
        if 0 <= indice < len(self.productos):
            del self.productos[indice]

    def actualizar_producto(self, indice, nombre, precio):
        if 0 <= indice < len(self.productos):
            self.productos[indice].nombre = nombre
            self.productos[indice].precio = precio

    def calcular_total(self):
        return sum(producto.precio for producto in self.productos)

    def aplicar_descuento(self, porcentaje_descuento):
        total = self.calcular_total()
        descuento = total * (porcentaje_descuento / 100)
        return total - descuento

# Instancia del carrito
carrito = Carrito()

# Ruta para la página principal (Leer)
@app.route('/')
def index():
    return render_template('index.html', carrito=carrito)

# Ruta para agregar producto (Crear)
@app.route('/agregar', methods=['POST'])
def agregar():
    nombre = request.form['nombre']
    precio = float(request.form['precio'])
    producto = Producto(nombre, precio)
    carrito.agregar_producto(producto)
    return redirect(url_for('index'))

# Ruta para eliminar producto (Eliminar)
@app.route('/eliminar/<int:indice>', methods=['POST'])
def eliminar(indice):
    carrito.eliminar_producto(indice)
    return redirect(url_for('index'))

# Ruta para mostrar el formulario de edición (Leer)
@app.route('/editar/<int:indice>')
def editar(indice):
    producto = carrito.productos[indice]
    return render_template('editar.html', indice=indice, producto=producto)

# Ruta para actualizar el producto (Actualizar)
@app.route('/actualizar/<int:indice>', methods=['POST'])
def actualizar(indice):
    nombre = request.form['nombre']
    precio = float(request.form['precio'])
    carrito.actualizar_producto(indice, nombre, precio)
    return redirect(url_for('index'))

# Ruta para calcular el total del carrito
@app.route('/total')
def total():
    total = carrito.calcular_total()
    return f"Total sin descuento: {total}€"

# Ruta para aplicar un descuento al total
@app.route('/descuento/<int:porcentaje>')
def descuento(porcentaje):
    total_con_descuento = carrito.aplicar_descuento(porcentaje)
    return f"Total con descuento del {porcentaje}%: {total_con_descuento}€"

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)