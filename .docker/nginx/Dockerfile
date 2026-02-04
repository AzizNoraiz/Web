FROM nginx:1.27-alpine

# Copier la configuration Nginx
COPY nginx.conf /etc/nginx/
COPY templates /etc/nginx/templates/

# Définir l'upstream pour PHP
# Changement ici : nom du conteneur (casino_php) et port FPM standard (9000)
RUN echo "upstream php-upstream { server casino_php:9000; }" > /etc/nginx/conf.d/upstream.conf

# Exposer les ports nécessaires
EXPOSE 80
EXPOSE 443