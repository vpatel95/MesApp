# MesApp

This is a basic web-application based messaging app with functionality of personal and group chats. It enables user to chat with registered users and also create groups. Application is developed using Laravel along with MySQL (Eloquent ORM).

### Prerequisites

#### PHP 7.4 and Composer
```bash
sudo add-apt-repository ppa:ondrej/php
sudo apt update
sudo apt install php7.4 php7.4-curl php7.4-xml php7.4-mysql php7.4-json php7.4-cli

curl -sS https://getcomposer.org/installer | php7.4
sudo mv composer.phar /usr/local/bin/composer

sudo update-alternatives --set php /usr/bin/php7.4
```

#### Mysql
```bash
sudo apt install mysql-server
sudo systemctl start mysql
sudo systemctl enable mysql
sudo mysql_secure_installation
```

## Running App on local machine

1.  Clone the repository

    ```bash
    git clone https://github.com/vpatel95/MesApp.git && cd MesApp
    ```
2. Duplicate the `.env.example` and rename it `.env` and fill in your database details

3.  Set the `BROADCAST_DRIVER` in your `.env` file to **pusher**:

    ```txt
    BROADCAST_DRIVER=pusher
    ```

4.  Then fill in your Pusher app credentials in your `.env` file:

    ```txt
    PUSHER_APP_ID=xxxxxx
    PUSHER_APP_KEY=xxxxxxxxxxxxxxxxxxxx
    PUSHER_APP_SECRET=xxxxxxxxxxxxxxxxxxxx
    PUSHER_APP_CLUSTER=
    ```

5.  Run command in terminal

    ```bash
    composer install
    ```
6. Build the application CSS and JS

    ```bash
    npm install
    npm run dev
    ```

7.  Run command in terminal

    ```bash
    php artisan key:generate
    ```

8.  Create the database in MySQL and run the command in terminal

    ```bash
    php artisan migrate


9.  Finally run the command

    ```bash
    php artisan serve
    ```

10.  Access the application at [http://localhost:8000/](http://localhost:8000/)

