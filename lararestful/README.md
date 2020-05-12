Ao clonar o projeto laravel deverá realizar algumas configurações.
      1 - Aconselhavelmente, em '.env' e '.env.example', localizados na raiz do projeto, 
            altere as linhas referentes ao banco de dados local, ficando da seguinte forma:
                  DB_CONNECTION=mysql
                  DB_HOST=127.0.0.1
                  DB_PORT=3306
                  DB_DATABASE=laravel
                  DB_USERNAME=root
                  DB_PASSWORD=
            Observando que 'DB_HOST', 'DB_PORT' 'DB_USERNAME' e 'DB_PASSWORD' devem ser inseridas conforme seu banco de dados mysql local.
      
      2 - No seu banco de dados local executar o script sql 'create.sql', ele irá criar a base de dados chamada 'laravel' e a tabela denominada 'tasks'.

      3 - Após o banco criado, deverá executar o comando: 
            'php artisan serve'
      (sem as aspas) que executará o projeto localmente, permitindo a conexão e consumo de dados entre Front e Banco de Dados.
      Após estes passos, o projeto estará sendo exxecutado, normalmente, no caminho 'http://127.0.0.1:8000'