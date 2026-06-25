# Sistema de Locadora de Veículos

Projeto final (2º Trabalho Prático / 4ª Avaliação) desenvolvido para a disciplina de **Desenvolvimento de Sistemas Web** do curso de Sistemas de Informação da Universidade Federal do Espírito Santo (UFES).

**Professor:** Giuliano Prado de Morais Giglio  
**Tema Sorteado:** Tema 02 - Locadora de Veículos  

---

##  Objetivo do Projeto
O objetivo deste sistema é aplicar na prática os conceitos de construção de páginas dinâmicas utilizando **PHP** e **Banco de Dados (MySQL)**. A aplicação simula o ambiente web de uma locadora de veículos, englobando a divulgação da empresa, reserva de carros e painéis administrativos com controle de acesso por perfil.

##  Funcionalidades Implementadas

O sistema foi dividido em três áreas principais de acesso, garantindo usabilidade, harmonia e navegação intuitiva (mapa de navegação em todas as páginas).

###  Área Pública (Visitantes)
- [x] Apresentação da empresa e logotipo customizado.
- [x] Sistema de Login (redirecionamento baseado no perfil: Cliente ou Admin).
- [] Busca e visualização do acervo de veículos disponíveis.
- [x] Página de "Fale Conosco".
- [x] Menu de navegação global acessível em todas as páginas.

###  Área do Cliente (Restrita)
- [x] **Gestão de Perfil:** Consulta, alteração e exclusão de dados cadastrais próprios.
- [] **Busca Avançada de Veículos:** Filtros por placa, nome, fabricante e motorização.
- [] **Sistema de Locação:** - Regra de Negócio: Um veículo só pode ser alugado para um único cliente em um determinado período de tempo.
  - Cálculo de Valor: `Valor Total = Valor Base do Veículo + Valor da Categoria`.
- [] **Histórico:** Visualização de locações em aberto e concluídas.

###  Área Administrativa (Restrita)
- [] **Controle de Acervo (CRUD):** Inclusão, exclusão, alteração e consulta de Veículos, Categorias e Exemplares.
- [] **Relatórios de Locação:** Consulta avançada de locações filtradas por intervalo de datas.

## 🛠️ Tecnologias Utilizadas
* **Backend:** PHP
* **Banco de Dados:** MySQL (Base `locadora.sql` normalizada e adaptada)
* **Frontend:** HTML5, CSS3 (Layout responsivo e focado em usabilidade)
