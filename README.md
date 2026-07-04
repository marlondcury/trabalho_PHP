# Sistema de Locadora de Veículos

Projeto final (2º Trabalho Prático / 4ª Avaliação) desenvolvido para a disciplina de **Desenvolvimento de Sistemas Web** do curso de Sistemas de Informação da Universidade Federal do Espírito Santo (UFES).

**Professor:** Giuliano Prado de Morais Giglio
**Tema Sorteado:** Tema 02 - Locadora de Veículos

---

## 🎯 Objetivo do Projeto

O objetivo deste sistema é aplicar na prática os conceitos de construção de páginas dinâmicas utilizando **PHP** e **Banco de Dados (MySQL)**. A aplicação simula o ambiente web de uma locadora de veículos, englobando a divulgação da empresa, reserva de carros e painéis administrativos com controle de acesso por perfil.

## ✅ Funcionalidades Implementadas

O sistema foi dividido em três áreas principais de acesso, garantindo usabilidade, harmonia e navegação intuitiva (mapa de navegação em todas as páginas).

### Área Pública (Visitantes)
- [x] Apresentação da empresa e logotipo customizado.
- [x] Sistema de Login (redirecionamento baseado no perfil: Cliente ou Admin).
- [x] Busca e visualização do acervo de veículos disponíveis.
- [x] Página de "Fale Conosco".
- [x] Menu de navegação global acessível em todas as páginas.

### Área do Cliente (Restrita)
- [x] **Gestão de Perfil:** Consulta, alteração e exclusão de dados cadastrais próprios.
- [x] **Busca Avançada de Veículos:** Filtros por placa, nome, fabricante e motorização.
- [x] **Sistema de Locação:**
  - Regra de Negócio: um veículo só pode ser alugado por um único cliente em um determinado período de tempo, e um cliente não pode ter duas locações em aberto simultaneamente.
  - Cálculo de Valor: `Valor Total = (Valor Base do Veículo + Valor da Categoria) × quantidade de diárias`.
- [x] **Histórico:** Visualização de locações em aberto e concluídas ("Minhas Locações").

### Área Administrativa (Restrita)
- [x] **Controle de Acervo (CRUD):** Inclusão, exclusão, alteração e consulta de Veículos, Categorias e Exemplares.
- [x] **Gestão de Clientes:** Cadastro, edição e exclusão de clientes.
- [x] **Controle de Locações:** Consulta, edição, marcação de devolução e exclusão de locações.
- [x] **Relatórios de Locação:** Consulta de locações filtradas por intervalo de datas.

## 🛠️ Tecnologias Utilizadas

* **Backend:** PHP (padrão MVC simplificado: `views` / `controllers` / `dao` / `classes`)
* **Banco de Dados:** MySQL (base `locadora_veiculos.sql`, normalizada e adaptada a partir da sugestão do professor)
* **Frontend:** HTML5, CSS3 (layout responsivo, [Bootstrap 5](https://getbootstrap.com/) via CDN)
* **Acesso a dados:** PDO com prepared statements

## 📁 Estrutura do Projeto

```
trabalho_PHP/
├── classes/         # Entidades (Veiculo, Categoria, Cliente, Locacao, ...)
├── controllers/     # Regras de negócio e roteamento das ações (POST/GET)
├── dao/             # Acesso ao banco de dados (PDO) por entidade
├── views/           # Páginas HTML/PHP exibidas ao usuário
│   └── includes/    # Menu (visitante/admin/cliente) e rodapé, reaproveitados em todas as páginas
├── css/             # Folha de estilos
└── locadora_veiculos.sql   # Script de criação e carga inicial do banco
```

## 🚀 Como rodar localmente (XAMPP)

1. Clone o repositório **dentro da pasta `htdocs` do XAMPP, com o nome exato `trabalho_PHP`** (os links internos do site usam `/trabalho_PHP/...` como raiz, então o nome da pasta precisa ser esse):
   ```
   C:\xampp\htdocs\trabalho_PHP
   ```
2. Inicie o **Apache** e o **MySQL** pelo painel do XAMPP.
3. Crie o banco de dados importando o script `locadora_veiculos.sql` (via phpMyAdmin, por exemplo — `Importar` > selecionar o arquivo).
4. Confira as credenciais de conexão em `dao/conexao.inc.php` (por padrão: host `localhost`, banco `locadora_veiculos`, usuário `root`, sem senha — configuração padrão do XAMPP).
5. Acesse pelo navegador:
   ```
   http://localhost/trabalho_PHP/views/index.php
   ```

> ⚠️ Abrir os arquivos `.php` direto do disco (ex: dando duplo-clique ou usando `file:///C:/...`) **não funciona** — o navegador não interpreta PHP sozinho. É preciso acessar via `http://localhost/...`, com o Apache rodando.

## 👤 Usuários de teste

Já vêm cadastrados no script `locadora_veiculos.sql`:

| Perfil        | Login          | Senha    |
|---------------|----------------|----------|
| Administrador | `teste@email`  | `1234`   |
| Cliente       | `teste1@email` | `1234`   |
| Cliente       | `sdfd@email`   | `123456` |

## 👥 Integrantes

Suelen, Sabrina, Marlon e Sthefani 

## 📌 Observações

- O layout, a navegabilidade e o cálculo de valores seguem as regras definidas no enunciado do Tema 02.
- O banco de dados fornecido pelo professor foi adaptado (mantendo a estrutura sugerida) para atender às necessidades da implementação.
