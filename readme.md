# Развертывание Symfony приложения с использованием Docker Compose

Этот репозиторий содержит Symfony приложение, которое можно развернуть с использованием Docker Compose. В этом файле README вы найдете инструкции по развертыванию приложения.

## Требования

Для развертывания этого приложения вам понадобятся следующие инструменты:

- Docker: [Инструкции по установке Docker](https://docs.docker.com/get-docker/)
- Docker Compose: [Инструкции по установке Docker Compose](https://docs.docker.com/compose/install/)

## Шаги по развертыванию

1. Клонируйте репозиторий на свой локальный компьютер:

```bash
git clone https://github.com/ваш_пользователь/ваш_репозиторий.git
cd ваш_репозиторий
```bash

2. Создайте файл `.env` на основе `.env.dist` и настройте переменные окружения, если это необходимо.

```bash
# Пример команды для создания файла .env
cp .env.dist .env
```bash

3. Выполните следующую команду для развертывания вашего Symfony приложения с использованием Docker Compose:

```bash
docker-compose up -d
```bash

4. Примените миграции, чтобы создать базу данных и необходимые таблицы:

```bash
docker-compose exec app php bin/console doctrine:migrations:migrate
```bash

5. Ваше Symfony приложение теперь доступно по адресу [http://localhost:80](http://localhost:80).

## Остановка и удаление контейнеров

Если вам нужно остановить контейнеры и удалить их, выполните следующую команду:

```bash
docker-compose down