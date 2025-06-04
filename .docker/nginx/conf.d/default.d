#  Redirection de HTTP vers HTTPS
server {
    listen 80 default_server;
    listen [::]:80 default_server;
    server_name ciel-broceliande.myasustor.com; 

    # # Redirection permanente vers HTTPS
    return 301 https://$host$request_uri;

   root   /var/www/php;
   index  index.php;

    location ~* \.php$ {
        fastcgi_pass   php:9000;
        include        fastcgi_params;
        fastcgi_param  SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param  SCRIPT_NAME     $fastcgi_script_name;
    }
}

# Activation du HTTPS
server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name ciel-broceliande.myasustor.com;

    #  Chemins des certificats Let's Encrypt
    ssl_certificate /etc/letsencrypt/live/ciel-broceliande.myasustor.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/ciel-broceliande.myasustor.com/privkey.pem;

    #  Sécurisation SSL
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;
    ssl_prefer_server_ciphers on;

    #  Racine du site
    root /var/www/php;
    index index.php;




    #  Configuration PHP
    location ~* \.php$ {
        fastcgi_pass php:9000;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param SCRIPT_NAME $fastcgi_script_name;
    }

    #  Sécurisation des métriques Nginx
    location /nginx_status {
        stub_status;
        allow 127.0.0.1;  # Restriction d'accès
        deny all;
    }
}

