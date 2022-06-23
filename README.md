# Construindo container 🐋

<br>
Para construir o container acesse o terminal de sua aplicação e execute:

```
docker-compose up -d --build
```

<br>
Depois que o procedimento acabar certifique-se de que o container da api está on e execute:

```
docker-compose exec app bash
```

# Configurando aplicação 🤖

<br>
Após isso verifique se você está dentro do container e execute:

```
composer install
```

<br>
<p>---------------------------------------------------------------------------------------------------------------</p>
<strong>Observação: Este projeto foi desenvolvido utilizando banco de dados MySQl.</strong>
<p>---------------------------------------------------------------------------------------------------------------</p>
<br>

Configure sua conexão com o banco de dados ou se preferir usar conexão do local utilize no seu .env:

```
DB_CONNECTION=mysql
DB_HOST=mysqlsrv
DB_PORT=3306
DB_DATABASE=api_restaurant_multiplier_dev
DB_USERNAME=root
DB_PASSWORD=root
```

<br>
Crie as tabelas no banco de dados:

```
php artisan migrate
```

<br>
E finalmente popule o banco de dados utilizando:

```
php artisan db:seed
```

<br>
Container OK, Configuração OK. 👌
<br>

#
Se precisar entrar no container como root use:

```
docker-compose exec -uroot app bash
```

# Testando API

<br>
Para ter certeza que a API está online acesse url:

```
localhost:9050/api/
```

# Rotas API

<br>
Importe as collections para testar as rotas via Postman ou Insomnia a partir do arquivo.

```
api-restaurant.postman-collection.json
```

