## Dive API

A *DiveAPI* surgiu como projeto de estudos, onde busco desenvolver e aprimorar meus conhecimentos como programador. Basicamente vou automatizar os cálculos das Tabela de Mergulho fornecidas no manual de mergulho da **[(US Navy Rev 7)](https://www.navsea.navy.mil/Portals/103/Documents/SUPSALV/Diving/US%20DIVING%20MANUAL_REV7.pdf?ver=2017-01-11-102354-393)**, que são estritamente seguidas e respeitadas pela categoria de Mergulho Comercial no mundo. Em desenvolvimento através de algoritmos e funcionalidades das tecnologias atuais, como por exemplo, Framework **Laravel** para a construção do Backend API, MySQL como Banco de Dados para armazenar e nos permitir acessar os dados dinâmicamente, Docker onde virtualizo a aplicação em um "Container" onde estão todas as dependências necessárias para executar a aplicação.

## O que são tabelas de Mergulho? Para que servem?

A principal função das tabelas de descompressão e dos computadores para mergulho é permitir aos mergulhadores saberem os limites de tempo que podem estar a cada profundidade de forma a poderem regressar à superfície em segurança no que diz respeito à ocorrência de uma doença descompressiva, patologia relacionada com a respiração de misturas contendo gases inertes (os mais comuns no mergulho são o azoto e o hélio) que, por ação de um fenómeno explicado pela “Lei de Henry”, se dissolvem nos tecidos mediante a pressão parcial a que são respirados.

As tabelas de descompressão são, fundamentalmente, tabelas de dupla entrada em que se cruzam os valores da profundidade máxima atingida durante um mergulho com o tempo de permanência no fundo, resultando desse cruzamento o nível de saturação dos tecidos no gás inerte que está a ser respirado e, no caso de tabelas para mergulhos que requeiram descompressão (mergulho técnico, militar e comercial) as obrigações descompressivas do mergulhador, nomeadamente as paragens ou patamares de descompressão.

## **[(App Mergulho)](https://appmergulho.vercel.app)** É um projeto em HTML, CSS e JavaScript onde você pode checar as Tabelas de Mergulho em seu formato Original, aproveite e confira as Ferramentas de navegação.

## Documentação (Em construção)

#### Retorna todos os registros da Tabela de Mergulho Não Descompressivo (JSON)

```http
  GET /api/dive-table
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `api_key` | `string` | **Opcional**. |

#### Retorna o registro de profundidade específica da Tabela de Mergulho Não Descompressivo, com base no Paramêtro passado na QueryString. (JSON)

```http
  GET /api/dive-table?depth=(int)
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `depth=(int)` | `integer` | **Obrigatório**. Paramêtro deve ser do tipo inteiro e a unidade de medidada está em Pés(fsw)|

#### Retorna o registro de profundidade específico da Tabela de Mergulho Não Descompressivo, com base nos Paramêtros passados na QueryString.

```http
  GET /api/dive-table-letter/?depth=(int)&depthTime=(int)
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `depth=(int)&depthTime=(int)`      | `integer` | **Obrigatório**. Informe a profundidade e tempo de fundo para obter o Grupo Repetitivo referente ao Nitrogênio Residual acumulado nos tecidos |

#### Retorna o Grupo Repetitivo inicial para calcular um mergulho sucessivo dentro de um range de tempo.

```http
  GET /api/surface-interval/?lastLetter=(string)&intervalTime=(int)
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `lastLetter=(string)&intervalTime=(int)`      | `integer` | **Obrigatório**. Informando o Grupo Repetitivo Final, e o intervalo de superfície, retorna o Grupo Repetitivo relativo ao Tempo de Nitrogênio residual acumulado nos tecidos, para então programar um mergulho sucessivo ou não.

#### Retorna o tempo de nitrogênio residual acumulado nos tecidos, obtido para subtrair do limite não descompressivo da profundidade alvo do mergulho sucessivo

```http
  GET /api/successive-dive/?endGroup=(string)&successiveDepth=(int)
```
| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `endGroup=(string)&successiveDepth=(int)`      | `integer/string` | **Obrigatório**. Após cumprir o intervalo de superfície e obtido o Grupo Repetitivo final, informe a profundidade em pés(fsw) para o mergulho sucessivo e obtenha o valor de nitrogênio residual nos tecidos para então subtrair do tempo total não descompressivo da profundidade alvo de retorno, obtendo o tempo total permitido para o mergulho sucessivo em planejamento.
