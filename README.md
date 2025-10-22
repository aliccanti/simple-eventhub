# Simple EventHub

Aplicação para gestão de eventos e compra de ingressos.

### 🔧 Instalação

Para realizar a instalação dê esses comandos:

```
docker compose up 
```

Ele realizará a instalação completa da aplicação. Após isso:

```
php artisan migrate
```

Para criar as tabelas necessárias no banco de dados. Para popular o banco, para fins de teste: 

```
php artisan db:seed
```

## ⚙️ Executando os testes

A aplicação é coberta com testes unitários para assegurar confiabilidade.

Para executar os testes:

```
composer test:unit
```

### ⌨️ E testes de estilo de codificação

Foi adicionado ferramentas de análise estática para garantir estilo de codificação. Teste rodando os seguintes comandos:

```
composer run lint:style
```

```
composer run lint:static
```


## 🛠️ Construído com

## Rotas da API

### `POST /buy-ticket`

Permite a compra de ingressos.

#### 🔸 Requisição

```json
{
  "quantity": 3,
  "event_id": 4,
  "user_id": 2
}
```


