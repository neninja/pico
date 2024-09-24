# Pico API

[![emojicom](https://img.shields.io/badge/emojicom-%F0%9F%90%9B%20%F0%9F%86%95%20%F0%9F%92%AF%20%F0%9F%91%AE%20%F0%9F%86%98%20%F0%9F%92%A4-%23fff)](http://neni.dev/emojicom)

Gerenciamento de coleções, aka *Pi Collection*

## Desenvolvimento

### Ambiente

1. Duplique `.env.example` para `.env` e **mude o usuário (`DB_USERNAME`) e senha (`DB_PASSWORD`)**

```sh
cp .env.example .env
```

2. Baixe o Sail juntamente com as dependências do composer
```sh
docker run -v $(pwd):/var/www/html -w /var/www/html laravelsail/php82-composer:latest sh -c "composer config --global && composer install --ignore-platform-reqs"
```

```sh
sudo chown 1000:1000 -R vendor
sudo chmod 775 -R vendor
```

3. Suba o ambiente
```sh
./vendor/bin/sail up -d
```

> Esse comando é <a href="#Execução">utilizado sempre que quiser subir o ambiente ja configurado</a> também

4. Crie a `APP_KEY`
```sh
./vendor/bin/sail art key:generate
```

5. Crie as tabelas com alguns registros do *seeder*
```sh
./vendor/bin/sail art migrate:fresh --seed
```

6. Baixe as dependências javascript
```sh
./vendor/bin/sail npm i
```

### Execução local

> Precisa de 2 terminais abertos

1. Inicie o backend se necessário
```sh
./vendor/bin/sail up -d
```

> Interrompa com `./vendor/bin/sail down`

2. Execute o ambiente de frontend
```sh
./vendor/bin/sail npm start
```

> Interrompa com <kbd>ctrl</kbd><kbd>c</kbd>

Outros comandos úteis durante o desenvolvimento:

- `./vendor/bin/sail bash`
- `./vendor/bin/sail psql`
- `./vendor/bin/sail tinker`
- `./vendor/bin/sail art queue:work`
- `./vendor/bin/sail art optimize:clear`
- `./vendor/bin/sail composer i`

### Backend
#### Linting

```sh
./vendor/bin/sail php ./vendor/bin/pint
./vendor/bin/sail composer format

./vendor/bin/sail php ./vendor/bin/pint --dirty
./vendor/bin/sail composer format:staged
```

#### Testes

##### Ambiente

```sh
./vendor/bin/sail mysql
create database testing;
```

##### Execução

```sh
./vendor/bin/sail test
./vendor/bin/sail test tests/Feature/BlablaTest.php
./vendor/bin/sail test --parallel --no-coverage
./vendor/bin/sail test --filter nomeDoTeste
```

#### Front end

- `./vendor/bin/sail npm start` inicia ambiente desenvolvimento (acesso em `localhost/app`)
- `./vendor/bin/sail npm build` criação do arquivo para produção, sem servidor de desenvolvimento
- `./vendor/bin/sail npm run format` para formatação e lint
- `./vendor/bin/sail composer api:doc` para gerar uma documentação básica da api, disponível no html na pasta do projeto em `/public/docs/index.html`
