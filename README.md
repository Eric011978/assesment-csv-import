# assessment execution

Installeren composer packages

```bash
composer install
```

Maak een nieuwe .env file aan in de root op basis van .env.example

Database instellingen goed zetten in de .env

```bash
DATABASE_URL="mysql://root:root@127.0.0.1:3306/assesment?serverVersion=8.0.37"
```

Met Doctrine db aanmaken

```bash
php bin/console doctrine:database:create
```

Met Doctrine data migreren

```bash
php bin/console doctrine:migrations:migrate
```

Nieuwe import draaien na aanmaken db / tabellen

```bash
php bin/console app:import-cats 
```

Starten php webserver vanuit public folder. 
(Dit kan ook een eigen local webserver zijn uiteraard)

```bash
php -S localhost:8000 
```

Ga tenslotte naar de url http://localhost:8000/cats (of localhost van de eigen webserver)