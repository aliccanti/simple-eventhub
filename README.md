# Simple EventHub

Aplicação para gestão de eventos e compra de ingressos.

## 🔧 1. Instalação

Para executar essa aplicação em seu ambiente local é necessário apenas o Docker.

### 1.1 Baixar o projeto do Git

```sh
git clone git@github.com:aliccanti/simple-eventhub.git
```

### 1.2 Definir variáveis de ambiente

Crie um arquivo `.env` a partir do arquivo `.env.example` com as suas credenciais.

```sh
cp .env.example .env
```
### 1.3 Subir o projeto no Docker
```
docker compose up -d
```

### 1.4 Criação da base de dados e tabelas

```
php artisan migrate
```

## ⚙️ 2. Executando os testes

A aplicação é coberta com testes unitários para assegurar confiabilidade.

Para executar os testes:

```
composer test:unit
```

## ⌨️ 3. Testes de estilo de codificação

Foi adicionado ferramentas de análise estática para garantir estilo de codificação. Teste rodando os seguintes comandos:

```
composer run lint:style
```

```
composer run lint:static
```


## 4. Erros retornados

| Tipo do Erro             | Descrição                                                                                       |
|--------------------------|-------------------------------------------------------------------------------------------------|
| `CapacityExceededException` | Ocorre ao tentar realizar a compra de ingressos onde a quantidade ultrapassa o quantitativo de ingressos disponíveis do evento.                                              |
| `EventSoldOutException` | Ocorre ao tentar realizar uma compra de evento sem ingressos disponíveis. |
| `ParticipantUserCannotCreateEventException` | Ocorre ao tentar criar um evento a partir de um usuário que não é organizador.                           |
| `PaymentNotAuthorizedException`      | Ocorre quando a compra é negada pelo autorizador externo.      |
| `UserLimitExceededException`     | Ocorre quando o usuário atingiu o limite de ingressos permitidos por evento.                                              |
| `ConnectionException`         | Ocorre quando a comunicação com autorizador externo falha.                                                           |                                                 |


