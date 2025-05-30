FROM mcr.microsoft.com/devcontainers/php:8.2

# Node.js for Quasar
RUN apt-get update && apt-get install -y curl sqlite3 \
  && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
  && apt-get install -y nodejs

# Quasar CLI
RUN npm install -g @quasar/cli
