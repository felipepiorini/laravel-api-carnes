
# API Carnês

API para criar um carnê de pagamento passando o valor total da compra, numero de parcelas, periodicidade e se foi feita entrada ou não. 


## Documentação da API

#### Cria um carnê

Iniciar a API pelo comando do laravel

```http
  php artisan serve
```
Em seu programa de requisições favoritos utilize os endpoints abaixo

```http
  POST /api/carne
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `valor_total` | `float` | **Obrigatório**. Valor total da compra |
| `qtd_parcelas` | `int` | **Obrigatório**. A quantidade de parcelas |
| `data_primeiro_vencimento` | `string` | **Obrigatório**. Data do primeiro vencimento |
| `valor_entrada` | `string` | Valor da entrada (opcional) |


#### Retorna um item

```http
  GET /api/carne/${id}
```

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `id`      | `int` | **Obrigatório**. O ID do carne |




## Demonstração

<img src="/assets/exemplo.png">


## Licença

[MIT](https://choosealicense.com/licenses/mit/)


## Autores

- [@code.felipe](https://www.instagram.com/code.felipe)

