FROM httpd:latest

ENV HTTPD_PREFIX /usr/local/apache2/conf

COPY ./httpd.conf $HTTPD_PREFIX/httpd.conf
COPY ./extra/httpd-ssl.conf $HTTPD_PREFIX/extra/httpd-ssl.conf
COPY ./sites-available/* $HTTPD_PREFIX/sites-enabled/
COPY ./conf.d/credentials.conf $HTTPD_PREFIX/php-params/credentials.conf
COPY ./conf.d/wsites/* $HTTPD_PREFIX/passwd/
COPY ./ssl/wsites/* $HTTPD_PREFIX/certs/

RUN useradd -m -G root github
RUN groups github
RUN chmod -R 777 /usr

