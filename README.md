# Simple Todo App

The app features a basic register/login system. Logged users can add a todo, update and delete todos. Todos will be marked *due today* if their due date is today or *overdue* accordingly.
Frontend uses Bootstrap 5 with a tiny bit of custom javascript for the input date field. PHP uses PDO extension with prepared statements.


## Usage

1. Create a new database - `todo`
2. Create a table for storing users
```sql
CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```
3. Create a table for storing tasks(todos)
```sql
CREATE TABLE `tasks` (
  `task_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

## Screenshots

Home page for non-logged users
![homepage](https://user-images.githubusercontent.com/6689087/107503541-c0e46680-6ba2-11eb-8134-7874ded72185.png)

Home page for logged users
![homepage-logged](https://user-images.githubusercontent.com/6689087/107503542-c17cfd00-6ba2-11eb-96af-aeada350e9ef.png)

Add a taks
![add](https://user-images.githubusercontent.com/6689087/107503544-c2159380-6ba2-11eb-9a61-b165ab831ea4.png)

Taks added
![task-added](https://user-images.githubusercontent.com/6689087/107503555-c772de00-6ba2-11eb-961a-7f77971eb001.png)

View all todos
![current-tasks](https://user-images.githubusercontent.com/6689087/107503559-c80b7480-6ba2-11eb-8da7-5748f13b98b7.png)

Update a todo
![update-tasks](https://user-images.githubusercontent.com/6689087/107503561-c80b7480-6ba2-11eb-9650-92d34c0f865d.png)
