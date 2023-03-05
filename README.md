# Laracasts - Birdboard

[![CI](https://github.com/poymanov/laracasts-birdboard/actions/workflows/ci.yml/badge.svg)](https://github.com/poymanov/laracasts-birdboard/actions/workflows/ci.yml)

Приложение для управления проектами и задачами (таск-менеджер).

Зарегистрированные пользователи могут создавать проекты, наполнять их задачами и приглашать других пользователей для совместного достижения целей проектов.

Подробности в [документации](docs/README.md).

### Установка

Для запуска приложения требуется **Docker** и **Docker Compose**.

Для инициализации приложения выполнить команду:
```
make init
```

### Управление

Запуск:
```
make up
```

Остановка приложения:

```
make down
```

### Интерфейсы

Приложение - http://localhost:8080

Почта (MailHog) - http://localhost:8025

### Тесты

```
make backend-test
```

### Цель проекта

Код написан в образовательных целях в рамках курса [Build A Laravel App With TDD](https://laracasts.com/series/build-a-laravel-app-with-tdd).
