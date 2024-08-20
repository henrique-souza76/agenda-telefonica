## Agenda Telefônica

Aplicação criada com Laravel, VueJs e banco de dados MySQL com o objetivo de criar um CRUD na forma de uma agenda telefônica.


## Explicação do projeto

[![Video Title](https://img.youtube.com/vi/XJTInLUmV3k/0.jpg)](https://www.youtube.com/watch?v=XJTInLUmV3k)


## Instalação

* Para essa instalação, é necessário ter o <a href="https://getcomposer.org/download/" target="_blank">Composer</a>, o <a href="https://docs.npmjs.com/downloading-and-installing-node-js-and-npm" target="_blank">npm</a> e o banco de dados <a href="https://www.mysql.com/downloads/" target="_blank">MySQL</a> instalado na sua máquina. Recomendo também a instalação do <a href="https://www.phpmyadmin.net/downloads/" target="_blank">phpMyAdmin</a> para a visualização do banco de dados.

* O primeiro passo para instalação é clonar este repositório do github.

* Após clonado, deve-se renomear o arquivo .env.example para .env e preencher as variáveis de ambiente com os dados adequados, principalmente as variáveis que configuram a conexão com o banco de dados. É necessário subir o serviço do banco de dados na sua máquina local. A variável APP_KEY será preenchida automaticamente nos passos seguintes.

* No terminal, na raíz do projeto, insira o comando para instalar as dependências do projeto: <br>
```composer install```

* Seguimos com a instalação das dependências do frontend: <br>
```npm install vue @vitejs/plugin-vue```

* Com as dependências instaladas, insira o seguinte comando para compilar o frontend: <br>
```npm run dev```

* É necessário gerar uma chave para preencher a variável APP_KEY. Para isso, em outra janela de terminal, na mesma pasta, use o comando: <br>
```php artisan key:generate```

* Agora iremos subir o servidor embutido do Laravel: <br>
```php artisan serve```

* Por fim, basta executar as migrations e seeds numa outra janela de terminal, na mesma pasta: <br>
```php artisan migrate --seed``` <br>
*Ps.: Caso o banco de dados definido no seu arquivo .env não exista na sua conexão MySQL, ele irá perguntar se você deseja criar. Basta teclar enter.*

Se tudo ocorreu bem, sua aplicação deve estar disponível acessando localhost:8000 no seu navegador!
