# Usa una imagen base de Python
FROM python:3.9

# Establece el directorio de trabajo dentro del contenedor
WORKDIR /app

# Copia el archivo de requisitos y la aplicación al contenedor
COPY requirements.txt requirements.txt

# Instala las dependencias de Python
RUN pip install -r requirements.txt

# Copia el resto de la aplicación al contenedor
COPY . .

# Establece la variable de entorno para desactivar el modo de depuración
ENV FLASK_ENV=production

# Expone el puerto en el que Flask se ejecutará
EXPOSE 5000
# Comando para ejecutar la aplicación
CMD ["python", "app.py"]
