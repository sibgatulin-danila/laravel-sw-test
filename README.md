# laravel-sw-test
laravel-sw-test

# Разворачивание проекта

### 1. copy './.env.example -> .env'; 
### 2. copy '.docker/.env.example -> .docker/.env';
### 3. В файле ./cronrc.txt сменить доменное имя на имя сервера
### 4. cd .docker, run terminal command 'docker-compose up -d --build'

## Войти в консоль ubuntu docker контейнера:

### Получить ID контейнера через 'docker ps'

### Перейти в контейнер 'docker exec -it <container_id> bash'

## Команды в контейнере

### 1. composer install
### 2. php artisan key:generate
### 3. php artisan migrate 

## Проект развернут!

# Комментарии к Api

## Пользователь admin@mail.ru:admin

# api-doc

## api/user

### Атрибуты
1. role_id: роль(0 - школьник, 1 - обычный сотрудник, 2 - завуч, 3 - директор, 4 - админ)
2. name: ФИО
3. sex: пол(male - мужской, female - женский)
4. birthday: дата рождения(формат ('Y-m-d H:i:s'))
5. email: емэил
6. password: пароль
7. enrollment_date: Дата зачисления ученика в школе 
8. dismissal_date: дата увольнения сотрудника школы
9. hire_date: Дата принятия на работу
10. school_class_id: id-класса

### get / - список пользователей
### post /create - регистрация пользователя
Обязательные данные (остальные по желанию):
{
    email: 'email',
    password: 'not-null',
}

### post /login - получение bearer и refresh токенов
Обязательные данные:
{
    email: 'email',
    password: 'not-null',
}

### post /refresh - обновление bearer токена
Обязательные данные:
{
    refresh_token: 'not-null'
}

### get /{id} - пользователь
### post /{id}/update - Обновление данных о пользователе
Данные все из перечисленного выше списка атрибутов
### post /{id}/delete - Удаление пользователя

## api/school

### Только по предъявлению Bearer токена!!!

### Атрибуты
1. name: Название школы
2. address: адрес
3. foundation_date: дата основания(формат 'Y-m-d H:i:s')
4. closing_date: дата закрытия(формат 'Y-m-d H:i:s')

### get / - список школ
### post /create - добавление школы
Обязательные данные (остальные по желанию):
{
    name: 'not-null',
}

### get /{id} - школа
### post /{id}/update - Обновление данных о школе
Данные все из перечисленного выше списка атрибутов
### post /{id}/delete - Удаление школы

## api/employee

### Атрибуты
Те же что и у user'a

### get / - список сотрудников
### post /create - добавление сотрудника
Обязательные данные (остальные по желанию):
{
    email: 'email',
    password: 'not-null'
}

### get /{id} - сотрудник
### post /{id}/update - Обновление данных о сотруднике
Данные все из перечисленного выше списка атрибутов
### post /{id}/delete - Удаление сотрудинка

## api/student

### Атрибуты
Те же что и у user'a

### get / - список школьников
### post /create - добавление школьника
Обязательные данные (остальные по желанию):
{
    email: 'email',
    password: 'not-null'
}

### get /{id} - школьник
### post /{id}/update - Обновление данных о школьнике
Данные все из перечисленного выше списка атрибутов
### post /{id}/delete - Удаление школьника

## api/class

### Атрибуты
1. number: Номер класса
2. symbol: буква класса
3. school_id: id школы

### get / - список классов
### post /create - добавление класса
Обязательные данные (остальные по желанию):
{
    number,
    school_id,
}

### get /{id} - класс
### post /{id}/update - Обновление данных о классе
Данные все из перечисленного выше списка атрибутов
### post /{id}/delete - Удаление класса

## api/subject

### Только по предъявлению Bearer токена!!!

### Атрибуты
1. name: название предмета
2. school_class_id: id класса
3. datetime: дата
4. user_id: id школьника

### get / - список предметов в расписании
Обязательный get параметр:
{
    school_class_id: id класса,
}
Возможные get параметры:
{
    datetime: 'Y-m-d H:i:s',
}
### post /create - добавление предмета в расписание
Обязательные данные (остальные по желанию):
{
    name,
    school_class_id,
}

### get /{id} - данные о предмете
### post /{id}/update - Обновление данных о предмете
Данные все из перечисленного выше списка атрибутов
### post /{id}/delete - Удаление предмета из расписания

## api/grade

### Только по предъявлению Bearer токена!!!

### Атрибуты
1. grade: оценка
2. class: номер класса (для сбора статистики)
3. school_id: id школы
4. user_id: id школьника
5. subject_id: id предмета

### get / - список оценок

### post /create - добавление оценки
Обязательные данные (остальные по желанию):
{
    grade,
    school_id,
    user_id,
    subject_id,
}

### get /stat - Статистика оценок по школе
Возможные get параметры:
{
    school_id,
    class: номер класса
}

### get /{id} - данные об оценке
### post /{id}/update - Обновление данных об оценке
Данные все из перечисленного выше списка атрибутов
### post /{id}/delete - Удаление оценки

# Концептуальная модель
Файл >> model.png
