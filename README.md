# Birdboard

![](docs/01-intro/img/01.png)

[![CI](https://github.com/poymanov/laracasts-birdboard/actions/workflows/ci.yml/badge.svg)](https://github.com/poymanov/laracasts-birdboard/actions/workflows/ci.yml)
![](https://img.shields.io/badge/Code-PHP-informational?style=flat&color=informational&logo=php)
![](https://img.shields.io/badge/Code-Laravel-informational?style=flat&color=informational&logo=laravel)
![](https://img.shields.io/badge/tool-Pest-informational?style=flat&color=informational&logo=pest)
![](https://img.shields.io/badge/code-Javascript-informational?style=flat&color=informational&logo=javascript)
![](https://img.shields.io/badge/Code-Vue-informational?style=flat&color=informational&logo=vue.js)
![](https://img.shields.io/badge/Tool-Docker-informational?style=flat&color=warning&logo=docker)


Приложение для управления проектами и задачами (таск-менеджер).

### Функционал

- Пользователи могут регистрироваться и аутентифицироваться;
- Добавление проектов;
- Добавление задач в проекты;
- Приглашение других пользователей в проекты для совместной работы;
- Лента событий по проекту.

Подробности в [документации](docs/README.md).

### Предварительные требования

Для запуска приложения требуется **Docker** и **Docker Compose**.

### Основные команды

| Команда             | Описание                 |
|:--------------------|:-------------------------|
| `make init`         | Инициализация приложения |
| `make up`           | Запуск приложения        |
| `make down`         | Остановка приложения     |
| `make backend-test` | Запуск тестов            |

### Интерфейсы

Приложение - http://localhost:8080

Почта (MailHog) - http://localhost:8025

---

Код написан в образовательных целях в рамках курса [Build A Laravel App With TDD](https://laracasts.com/series/build-a-laravel-app-with-tdd).
