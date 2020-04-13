<p align="center">
  <img src="https://i.imgur.com/YCh9nXR.png" width="300">
</p>

## Sumary (Sumário)

* [Previews's](#)
* [Como Instalar e usar](#how-to-install-and-use-como-instalar-e-usar)
* [Fluxo da Aplicação](#)
* [Estrutura de Diretórios WebApp](#)
* [Como nomear arquivos na API](#how-to-name-your-file-in-api-como-nomear-arquivos-na-api)
* [Como nomear end-points REST](#how-to-name-end-point-rest-como-nomear-end-points-rest)
* [Como nomear métodos na API](#how-to-name-methods-in-api)
* [Como nomear FK em tabelas](#how-name-structure-table-foreign-key-como-nomear-fk-de-tabelas)
* [Modelagem do Banco de Dados](#)

<hr>


## How to install and use (Como Instalar e usar)

1. Copiar e colar `docker-compose.exemplo` para `docker-compose.yml`

2. Descomente as seguintes linhas:

   ```
   sh -c 'npm i && npm run serve'
   - UPDATE_COMPOSER_DEPENDENCIES=true
   ```

3. Comente a linha

   ```
   sh -c 'npm run serve'
   ```

4.  Execute o comando `docker-compose up`

5. Aguarde ate terminar de criar os container e configura-los **(Isso levara muito tempo)*

6. Logo apos de finalizar iremos derrubar os container com `Ctrl+c`

7. Comente as linhas:

   ```
   sh -c 'npm i && npm run serve'
   - UPDATE_COMPOSER_DEPENDENCIES=true
   ```

8. Descomente a linha

   ```
   sh -c 'npm run serve'
   ```

9. Pronto, basta executar o comando `docker-compose up` para subir todos os containers

10. Agora temos que terminar algumas configuracoes do JWT e da APP_KEY da API

11. Na pasta **webapp** iremos copiar o arquivo `.example_env` para `.env`

12. Na pasta **api** o arquivo `.env` esta com o campo `APP_KEY= ` vazio. Iremos entrar dentro do container para gerar uma chave para o projeto.

13. Execute os seguintes comandos

    ```
    docker exec -it app-api /bin/bash
    php artisan key:generate
    ```

14. Logo apos de finalizar iremos derrubar os container com `Ctrl+c` e subi-los novamente

15. `docker-compose up`

16. Pronto agora o projeto ja esta configurado e pronto para ser desenvolvido novas funcionalidades

---

## How to name your file in API (Como nomear arquivos na API)

**Name File Styles**

CamelCase

**Models**

❌ Objeto_Image (BAD)<br>
✅ ObjetoImage (GOOD)

**Services**

❌ Objeto_Image_Services (BAD)<br>
✅ ObjetoImageServices (GOOD)

**Controllers**

❌ Objeto_Image_Controller (BAD)<br>
✅ ObjetoImageController (GOOD)

Valid for (Models, Services, Controlllers)

---

## How to name end-point REST (Como nomear end-points REST)

**Resource Evento**

✅ **GET** `/evento`<br>
✅ **POST** `/evento`<br>
✅ **GET (SHOW)** `/evento/{id}`<br>
✅ **PATCH** `/evento/{id}`<br>
✅ **DELETE** `/evento/{id}`<br>

**Resource Evento by ID another Resource**

✅ **GET (SHOW)** `/evento/inistituicao/{id}`

Response: Events that belong to a specific institution
(Eventos que pertence a uma determinada instituição)

`$FIRST_RESOURCE/$ANOTHER_RESOURCE/{$ID_ANOTHER_RESOURCE}`


**Group Routes [REQUIRED]**

```php
$router->group(['namespace' => 'Evento'], function () use ($router) {
        $router->get('/evento', 'EventoController@get');
        $router->get('/evento/{id}', 'EventoController@show');
        $router->get('/evento/inistituicao/{id}', 'EventoController@getEventosByInsti');
        $router->post('/evento', 'EventoController@post');
        $router->patch('/evento/{id}', 'EventoController@patch');
        $router->delete('/evento/{id}', 'EventoController@delete');
    });
```

## How to name methods in API

**Controller**

public function `get`<br>
public function `post`<br>
public function `show`<br>
public function `patch`<br>
public function `delete`<br>

---

**Services**

public static function `get`<br>
public static function `post`<br>
public static function `show`<br>
public static function `patch`<br>
public static function `delete`<br>

---

**Model**

If necessary create basic methods CRUD

public static function `get`<br>
public static function `post`<br>
public static function `show`<br>
public static function `patch`<br>
public static function `delete`<br>

---

**With Another Resource**
CamelCase with **by**

public function `getEventosByInsti`

## How name structure table FOREIGN KEY (Como nomear FK de tabelas)

**FOREIGN KEY**

**usuario_id**

```php
$table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id')
                ->references('usuario_id')->on('app.usuario');
```






