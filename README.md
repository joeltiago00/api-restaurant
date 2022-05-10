# Construindo container 🐋 && Configurando aplicação

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

<br>
Após isso verifique se você está dentro do container e execute:

```
composer install
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
Container OK, configuração OK. 👌
<br>

#
Se precisar entrar no container como root use:

```
docker-compose exec -uroot app bash
```
<br>

# Testando API

<br>
Para ter certeza que a API está online acesse url:

```
localhost:9050/api/
```
