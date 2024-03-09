FROM php:8.1-fpm-alpine

USER root

# Install dependencies
RUN apk --no-cache add wget unzip libaio libnsl

# Download and install Oracle Instant Client and SDK
RUN mkdir /opt/oracle \
    && wget https://download.oracle.com/otn_software/linux/instantclient/213000/instantclient-basiclite-linux.x64-21.3.0.0.0.zip -O /opt/oracle/instantclient.zip \
    && wget https://download.oracle.com/otn_software/linux/instantclient/213000/instantclient-sdk-linux.x64-21.3.0.0.0.zip -O /opt/oracle/instantclient-sdk.zip \
    && unzip /opt/oracle/instantclient.zip -d /opt/oracle \
    && unzip /opt/oracle/instantclient-sdk.zip -d /opt/oracle \
    && rm /opt/oracle/instantclient.zip /opt/oracle/instantclient-sdk.zip \
    && ln -s /opt/oracle/instantclient_21_3 /opt/oracle/instantclient \
    && ln -s /opt/oracle/instantclient/sdk/include/*.h /usr/include

# Add Oracle Instant Client path to environment
ENV LD_LIBRARY_PATH /opt/oracle/instantclient

# Install the Oracle extension
RUN docker-php-ext-configure oci8 --with-oci8=instantclient,/opt/oracle/instantclient \
    && docker-php-ext-install oci8


RUN set -ex \
  && apk --no-cache add \
    postgresql-dev \

RUN docker-php-ext-install pdo pdo_pgsql
    
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Clean up
RUN apk del wget unzip

# Your additional configurations and application setup go here...

# Expose port 9000 and start php-fpm server
EXPOSE 9000

