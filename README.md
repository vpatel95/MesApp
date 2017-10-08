# MesApp

This is a basic web-application based messaging app with functionality of personal and group chats. It enables user to chat with registered users and also create groups. Application is developed using Laravel along with MySQL (Eloquent ORM).

## Running App on local machine

1.  Clone the repository

    ```bash
    git clone https://github.com/vpatel95/MesApp.git && cd MesApp
    ```
    
2.  Run command in terminal
    
    ```bash
    composer install
    ```
    
3. Duplicate the `.env.example` and rename it `.env` and fill in your database details

4.  Set the `BROADCAST_DRIVER` in your `.env` file to **pusher**:

    ```txt
    BROADCAST_DRIVER=pusher
    ```

5.  Then fill in your Pusher app credentials in your `.env` file:

    ```txt
    PUSHER_APP_ID=xxxxxx
    PUSHER_APP_KEY=xxxxxxxxxxxxxxxxxxxx
    PUSHER_APP_SECRET=xxxxxxxxxxxxxxxxxxxx
    PUSHER_APP_CLUSTER=
    ```
    
6.  Run command in terminal
    
    ```bash
    php artisan key:generate
    ```

7.  Create the database in MySQL and run the command in terminal

    ```bash
    php artisan migrate
    ```
    
8.  Finally run the command

    ```bash
    php artisan serve
    ```
    
9.  Access the application at [http://localhost:8000/](http://localhost:8000/)
    
