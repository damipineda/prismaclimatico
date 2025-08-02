# Imagen base oficial de PHP con Apache
FROM php:8.0-apache

# Copia todo el código fuente al directorio raíz de Apache
COPY . /var/www/html

# Da permisos correctos a los archivos (opcional pero recomendado)
RUN chown -R www-data:www-data /var/www/html

# Habilita mod_rewrite para URLs amigables (opcional)
RUN a2enmod rewrite

# Expone el puerto 80
EXPOSE 80

# Comando por defecto para iniciar Apache
CMD ["apache2-foreground"]
