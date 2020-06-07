FROM httpd:latest

COPY ./httpd.conf /etc/apache2/httpd.conf
COPY ./envvars /etc/apache2/envvars
COPY ./ports.conf /etc/apache2/ports.conf
COPY ./sites-available/* /etc/apache2/sites-enabled/
COPY ./conf.d/credentials.conf /etc/apache2/conf-enabled/credentials.conf
COPY ./conf.d/wsites/* /etc/apache2/conf-enabled/passwd/
COPY ./ssl/wsites/* /etc/apache2/conf-enabled/certs/

RUN useradd -m -G root github
RUN groups github
RUN chmod -R 777 /etc
RUN chmod -R 777 /usr

