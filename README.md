# Work in Progress

##

# Construindo container 🐋 && Configurando aplicação

Para construir o container acesse o terminal de sua aplicação e execute:

```
docker-compose up -d --build
```

Depois que o procedimento acabar certifique-se de que o container da api está on e execute:

```
docker-compose exec app bash
```

Após isso verifique se você está dentro do container e execute:

```
composer install
```

Crie as tabelas no banco de dados:

```
php artisan migrate
```

E finalmente popule o banco de dados utilizando:

```
php artisan db:seed
```

Container OK, configuração OK. 👌

Se precisar entrar no container como root use:

```
docker-compose exec -uroot app bash
```

# Testando API

Para ter certeza que a API está online acesse url:

```
localhost:9050/api/
```
