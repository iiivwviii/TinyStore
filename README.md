<p align="center"><img src="public/docs/icons/logo.png" width="300" alt="Laravel Logo"></p><a id='links'></a>

# <p align="center">TinyStore</p>

### <p align="center">Минималистичный REST API интернет-магазин</p>

## <img src="public/docs/icons/link.png" width="35" align="absmiddle"> Ссылки
### [Технологии](#technologies) | [Описание](#description) | [Маршруты](#routes) | [Инициализация](#init) | [Взаимодействие](#interaction)

## <img src="public/docs/icons/tools.png" width="35" align="absmiddle"> Используемые технологии <a id='technologies'></a>[<img src="public/docs/icons/up.png" width="20" align="absmiddle">](#links)

[PHP 8.2](https://www.php.net/) - Язык программироваия.

[Laravel 12](https://laravel.com/docs) - Фреймворк.

[Mysql 8.0](https://www.mysql.com/) - База данных.

[Docker](https://www.docker.com/) - Контейнеризация.

[Laravel Sail](https://laravel.su/docs/12.x/sail) - Docker-интерфейс.

[Laravel Sanctum](https://laravel.su/docs/12.x/sanctum) - Cистема аутентификации.

## <img src="public/docs/icons/book2.png" width="35" align="absmiddle"> Описание <a id='description'></a>[<img src="public/docs/icons/up.png" width="20" align="absmiddle">](#links)

Проект представляет собой RESTful API интернет-магазин с тремя типами пользователей: гости, покупатели и администраторы.

### Основные сущности

- **Категории товаров** 
- **Товары**
- **Пользователи**
- **Заказы**

### Связи между сущностями

- Один пользователь → много заказов
- Один заказ → много товаров (через позиции заказа)

### Технические особенности
- **Логирование** всех действий с заказами (`storage/logs/orders.log`)
- **Пагинация** для всех списков
- **Фильтрация** и **сортировка** для продуктов
- **type hints**
- **Ответы через Resources**
- **Валидация через Requests**
- **Логирование через Observers**
- **Бизнес логика представлена в Services**

## <img src="public/docs/icons/route.png" width="35" align="absmiddle"> Маршруты <a id='routes'></a> [<img src="public/docs/icons/up.png" width="20" align="absmiddle">](#links)

<div class="ds-markdown ds-markdown--block" style="--ds-md-zoom: 1.143;">
  <h3>Публичные маршруты (без аутентификации)</h3>
  <div class="markdown-table-wrapper">
    <table>
      <thead>
        <tr>
          <th>Метод</th>
          <th>Эндпоинт</th>
          <th>Описание</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>GET</td>
          <td><code>/api/categories</code></td>
          <td>Получить список категорий</td>
        </tr>
        <tr>
          <td>GET</td>
          <td><code>/api/products</code></td>
          <td>Получить список товаров</td>
        </tr>
        <tr>
          <td>GET</td>
          <td><code>/api/products/{product}</code></td>
          <td>Получить данные конкретного товара</td>
        </tr>
      </tbody>
    </table>
  </div>
  <h3>Маршруты для покупателей</h3>
  <h4>Аутентификация</h4>
  <div class="markdown-table-wrapper">
    <table>
      <thead>
        <tr>
          <th>Метод</th>
          <th>Эндпоинт</th>
          <th>Описание</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>POST</td>
          <td><code>/api/customer/register</code></td>
          <td>Регистрация</td>
        </tr>
        <tr>
          <td>POST</td>
          <td><code>/api/customer/login</code></td>
          <td>Вход</td>
        </tr>
        <tr>
          <td>POST</td>
          <td><code>/api/customer/logout</code></td>
          <td>Выход</td>
        </tr>
      </tbody>
    </table>
  </div>
  <h4>Защищенные маршруты (требуется аутентификация покупателя)</h4>
  <div class="markdown-table-wrapper">
    <table>
      <thead>
        <tr>
          <th>Метод</th>
          <th>Эндпоинт</th>
          <th>Описание</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>GET</td>
          <td><code>/api/customer/profile</code></td>
          <td>Получить свой профиль</td>
        </tr>
        <tr>
          <td>GET</td>
          <td><code>/api/customer/orders</code></td>
          <td>Получить свои заказы</td>
        </tr>
        <tr>
          <td>POST</td>
          <td><code>/api/customer/orders</code></td>
          <td>Создать новый заказ</td>
        </tr>
      </tbody>
    </table>
  </div>
  <h3>Маршруты для администраторов</h3>
  <h4>Аутентификация</h4>
  <div class="markdown-table-wrapper">
    <table>
      <thead>
        <tr>
          <th>Метод</th>
          <th>Эндпоинт</th>
          <th>Описание</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>POST</td>
          <td><code>/api/admin/login</code></td>
          <td>Вход администратора</td>
        </tr>
        <tr>
          <td>POST</td>
          <td><code>/api/admin/logout</code></td>
          <td>Выход администратора</td>
        </tr>
      </tbody>
    </table>
  </div>
  <h4>Защищенные маршруты (требуется аутентификация администратора)</h4>
  <h5>Управление пользователями</h5>
  <div class="markdown-table-wrapper">
    <table>
      <thead>
        <tr>
          <th>Метод</th>
          <th>Эндпоинт</th>
          <th>Описание</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>GET</td>
          <td><code>/api/admin/users</code></td>
          <td>Получить список покупателей</td>
        </tr>
      </tbody>
    </table>
  </div>
  <h5>Управление заказами</h5>
  <div class="markdown-table-wrapper">
    <table>
      <thead>
        <tr>
          <th>Метод</th>
          <th>Эндпоинт</th>
          <th>Описание</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>GET</td>
          <td><code>/api/admin/orders</code></td>
          <td>Получить все заказы</td>
        </tr>
        <tr>
          <td>PUT</td>
          <td><code>/api/admin/orders/{order}</code></td>
          <td>Изменить статус заказа</td>
        </tr>
        <tr>
          <td>DELETE</td>
          <td><code>/api/admin/orders/destroy</code></td>
          <td>Удалить заказ (админ)</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

## <img src="public/docs/icons/rocket.png" width="30" align="absmiddle"> Инициализация <a id='init'></a>[<img src="public/docs/icons/up.png" width="20" align="absmiddle">](#links)
> [!NOTE]
> Рекомендуется использовать DNS 8.8.8.8 для избежания проблем с контейнерами.
### Предварительные требования

```bash
sudo apt update && sudo apt upgrade -y
```
### Установка зависимостей:
```bash
composer install
```
### Настройка окружения
```bash
cp .env.example .env
```
### Запуск Docker
> [!NOTE]
> По умолчанию в docker-compose.yml находится development версия.
```bash
cp docker/production/docker-compose.prod.yml docker-compose.yml
docker compose up -d --build
```
### Генерация ключа
```bash
docker compose exec app php artisan key:generate
```
### Инициализация БД
```bash
docker compose exec app php artisan migrate --seed
```
### Все команды
```bash
sudo apt update && sudo apt upgrade -y
```
```bash
composer install
cp .env.example .env
cp docker/production/docker-compose.prod.yml docker-compose.yml
docker compose up -d --build
docker compose exec app php artisan key:generate
sleep 5
docker compose exec app php artisan migrate --seed
```
### После успешного запуска система будет доступна по адресу:
### `http://localhost`

## <img src="public/docs/icons/fire.png" width="35" align="absmiddle"> Взаимодействие с системой  <a id='interaction'></a>[<img src="public/docs/icons/up.png" width="20" align="absmiddle">](#links)
> [!NOTE]
> После успешного выполнения миграций и заполнения данных, у всех пользователей (покупателей и администраторов) будет один и тот-же пароль = `password`.
### Данные для входа администратора:
```json
{ 
    "email": "admin@example.com", 
    "password": "password"
}
```
### Данные для входа покупателя:
```json
{ 
    "email": "Почта_автора", 
    "password": "password"
}
```
### Данные для создания заказа:
```json
{
    "items": [
        {
            "product_id": "2",
            "quantity": "1"
        }
    ]
}
```
### Данные для обновления статуса заказа(администратор):
```json
{
    "status": "confirmed or cancelled"
}
```
### Фильтрация и сортировка продуктов:
```
/api/products?category_id=1&name=test&sort=name
```
