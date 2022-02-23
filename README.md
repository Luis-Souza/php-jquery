# php-jquery
api with slim framework and front with jquery,html and css. Database MONGODB.


###  Para rodar a api entre na pasta api-php e execute os seguintes comandos:
  - primeiro``` composer install``` 
  - depois ```composer dev```

### O front basta abrir o arquivo .html em um navegador!


### A api possui os seguintes endpoints:

  - Create
    ``` /create ```
  - Delete
    ``` /delete/{id} ```
  - Find By Name
    ``` /search/{name} ```
  - Update
    ``` /update ```
  - List All
    ``` /users ```

### Dependencias da api.
  arquivo composer.json.
  
    "require": {
        "php": "^7.4",
        "slim/slim": "4.*",
        "slim/psr7": "^1.5",
        "php-di/php-di": "^6.3",
        "php-di/slim-bridge": "^3.2",
        "mongodb/mongodb": "^1.5",
        "respect/validation": "^2.2"
    }
  
