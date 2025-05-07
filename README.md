# php_project_anti_plag
# Система Анти_плагиата

Веб-приложение для проверки текстов на плагиат. Система предоставляет удобный интерфейс для авторизации пользователей и проверки документов на оригинальность.

## Функциональность

- Авторизация пользователей
- Безопасное хранение паролей
- Проверка текстов на плагиат
- Генерация отчетов о проверке

## Технологии

- PHP
- HTML5
- CSS3
- JavaScript
- MySQL

anti_plag\
├── assets/
│   ├── css/
│   │   ├── login.css
│   │   └── style.css
│   ├── js/
│   │   └── scripts.js
│   └── images/
├── config/
│   └── database.php
├── includes/
│   ├── header.php
│   ├── footer.php
│   └── functions.php
├── classes/
│   ├── User.php
│   ├── Database.php
│   └── PlagiarismChecker.php
├── uploads/
│   └── documents/
├── vendor/
├── index.php
├── login.php
├── register.php
├── dashboard.php
├── check.php
├── results.php
└── README.md


Описание основных директорий и файлов:

1. assets/ - статические файлы
   
   - css/ - стили
   - js/ - скрипты
   - images/ - изображения
2. config/ - конфигурационные файлы
   
   - database.php - настройки базы данных
3. includes/ - повторно используемые компоненты
   
   - header.php - шапка сайта
   - footer.php - подвал сайта
   - functions.php - общие функции
4. classes/ - классы PHP
   
   - User.php - работа с пользователями
   - Database.php - работа с БД
   - PlagiarismChecker.php - проверка на плагиат
5. uploads/ - загружаемые файлы
   
   - documents/ - документы для проверки
6. vendor/ - зависимости composer
7. Основные файлы:
   
   - index.php - главная страница
   - login.php - обработка входа
   - register.php - регистрация
   - dashboard.php - личный кабинет
   - check.php - страница проверки
   - results.php - результаты проверки

## Установка
1. Клонируйте репозиторий:
```bash
git clone https://github.com/ваш-username/anti_plag.git

2. Настройте веб-сервер (Apache/OpenServer) для работы с проектом
3. Импортируйте базу данных из файла database.sql
4. Настройте параметры подключения к базе данных


## Использование
1. Откройте приложение в браузере
2. Войдите в систему, используя свои учетные данные
3. Загрузите текст для проверки
4. Получите отчет о проверке
## Требования
- PHP 7.4 или выше
- MySQL 5.7 или выше
- Веб-сервер Apache/Nginx
## Разработка
Проект находится в активной разработке. Для участия в разработке:

1. Создайте форк репозитория
2. Создайте ветку для новой функции ( git checkout -b feature/НоваяФункция )
3. Зафиксируйте изменения ( git commit -m 'Добавлена новая функция' )
4. Отправьте изменения в репозиторий ( git push origin feature/НоваяФункция )
5. Создайте Pull Request





