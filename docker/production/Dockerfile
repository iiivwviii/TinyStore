FROM docker.io/bitnami/minideb:bookworm

ARG WWWGROUP
ARG WWWUSER=1337
ENV SUPERVISOR_PHP_COMMAND="php -d variables_order=EGPCS /var/www/html/artisan serve --host=0.0.0.0 --port=80"
ENV SUPERVISOR_PHP_USER="sail"

WORKDIR /var/www/html
# Установка базовых пакетов
RUN install_packages \
    ca-certificates \
    curl \
    gnupg
# Добавление репозитория Sury для PHP 8.3
RUN curl -sSL https://packages.sury.org/php/apt.gpg | gpg --dearmor -o /usr/share/keyrings/php.gpg && \
    echo "deb [signed-by=/usr/share/keyrings/php.gpg] https://packages.sury.org/php/ bookworm main" > /etc/apt/sources.list.d/php.list
# Установка PHP и зависимостей
RUN apt-get update && \
    apt-get install -y --no-install-recommends \
    php8.3 \
    php8.3-cli \
    php8.3-common \
    php8.3-curl \
    php8.3-intl \
    php8.3-mbstring \
    php8.3-mysql \
    php8.3-opcache \
    php8.3-readline \
    php8.3-xml \
    php8.3-zip \
    supervisor && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
# Создание пользователя и группы
RUN groupadd --force -g ${WWWGROUP} sail && \
    useradd -ms /bin/bash --no-user-group -g ${WWWGROUP} -u ${WWWUSER} sail
# Копирование конфигурационных файлов
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY start-container /usr/local/bin/start-container
RUN chmod +x /usr/local/bin/start-container
# Настройка прав
RUN mkdir -p /.composer && \
    chmod -R ugo+rw /.composer && \
    chown -R sail:sail /var/www/html

EXPOSE 80
ENTRYPOINT ["start-container"]
