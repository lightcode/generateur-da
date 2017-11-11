FROM lightcode/nginx-php7

COPY . /var/www

RUN set -ex; \
    apk add --no-cache php7-mbstring; \
    chown -R nobody: /var/www

VOLUME ["/var/www/save"]
