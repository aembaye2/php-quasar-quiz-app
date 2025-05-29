FROM mcr.microsoft.com/devcontainers/php:0-8.2

RUN apt-get update && apt-get install -y apache2 libapache2-mod-php     && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - &&     apt-get install -y nodejs && npm install -g @quasar/cli

EXPOSE 80
CMD ["apache2ctl", "-D", "FOREGROUND"]
