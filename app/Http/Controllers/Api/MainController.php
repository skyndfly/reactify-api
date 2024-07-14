<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="REACTIFY API",
 *     version="1.0"
 * ),
 * @OA\PathItem(
 *      path="/api/v1/cars"
 * )
 */
class MainController extends Controller
{
//1. **Authentication (Аутентификация):**
//- `POST /api/register`: Регистрация нового пользователя
//- `POST /api/login`: Вход пользователя
//- `POST /api/logout`: Выход пользователя
//- `POST /api/refresh`: Обновление токена
//
//2. **Пользовательские операции:**
//- `GET /api/user`: Получение данных авторизованного пользователя
//- `PUT /api/user`: Обновление данных пользователя
//
//3. **Автомобили (Cars):**
//- `GET /api/cars`: Получение списка доступных автомобилей
//- `GET /api/cars/{id}`: Получение информации об автомобиле
//- `POST /api/cars`: Добавление нового автомобиля (требуется админ-доступ)
//- `PUT /api/cars/{id}`: Обновление информации об автомобиле (требуется админ-доступ)
//- `DELETE /api/cars/{id}`: Удаление автомобиля (требуется админ-доступ)
//
//4. **Аренда автомобилей (Car Rentals):**
//- `POST /api/rentals`: Создание заказа на аренду автомобиля
//- `GET /api/rentals`: Получение списка аренд пользователя
//- `GET /api/rentals/{id}`: Получение информации о конкретной аренде
//- `PUT /api/rentals/{id}`: Обновление аренды (например, продление срока аренды)
//- `DELETE /api/rentals/{id}`: Отмена аренды
}
