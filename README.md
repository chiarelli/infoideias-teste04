### Introdução

Esse é um projeto da segunda fase de seleção promivido pela infoidéias.

#### Sobre as questões

Estão referenciadas por tags, ex: `question-1`.

#### Banco de dados

As alterações do banco da dados para a questão 2 estão no arquivo `question2.sql`.

É necessário alterar as configurações de acesso ao banco de dados em `www/app/config/config.php` se quiser acessar o banco de dados remoto, pois fiz todo o projeto localmente em um stack de containers docker.

#### Docker

O projeto pode ser rodado localmente em Docker. Para isso é necesário o `docker` instalado e o `docker-composer`.

Após iniciar o stack do projeto digite `docker exec -t -i phalcon_start_phalcon_apache_1  /bin/bash` para acessar o terminal do container docker e ter acesso ao CLI do `phalcon dev-tools`.

Através do seu gerenciador preferido, acesse o mysql do container através dos dados de acesso:
```
Host: localhost
Port: 3316
Username: wordpress
Senha: wordpress
```

Com o stack iniciado, acesse `https://localhost:8443`
