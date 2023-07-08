```mysql
SELECT CONCAT(u.first_name, ' ', u.last_name) user_name,
       b.author,
       GROUP_CONCAT(b.name SEPARATOR ' ')
FROM users u
         JOIN user_books ub on u.id = ub.user_id
         JOIN books b on b.id = ub.book_id
WHERE TIMESTAMPDIFF(YEAR, u.birthday, NOW()) BETWEEN 7 AND 17
  AND DATEDIFF(ub.return_date, ub.get_date) <= 14
GROUP BY u.id, b.author
HAVING COUNT(b.author) = 2
```

### Запуск проекта
1. composer install 
2. cp .env.example .env
3. php artisan key:generate
4. docker-compose up -d

Сайт будет доступен на 8876 порту
http://localhost:8876/api/v1
