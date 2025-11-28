# TwoG - GCC263

Projeto desenvolvido para a disciplina de Introdução a Sistemas de Banco de Dados.
O Intuíto de Demonstrar habilidades em técnicas de programação para bancos de dados.

Um sistema web completo desenvolvido em **PHP** e **MySQL** para o gerenciamento de Usuários (com especialização em Clientes e Desenvolvedores) e Estúdios de Desenvolvimento. 
O Projeto conta com CSS para tornar a interface mais elegante. (BONUS)

## 🖼️ Screenshots do Projeto

<img width="1868" height="947" alt="image" src="https://github.com/user-attachments/assets/65130b85-34b9-4689-9497-c186b7b1850c" />
<img width="1869" height="947" alt="image" src="https://github.com/user-attachments/assets/ddaaf17d-0278-47aa-a1c4-69fe9758c7e6" />
<img width="1845" height="947" alt="image" src="https://github.com/user-attachments/assets/37339746-6e7f-494f-acda-f3e145ce3630" />
<img width="1869" height="949" alt="image" src="https://github.com/user-attachments/assets/1dd1f44f-bfd6-4244-a1b1-c39bf5b63b1b" />


## ✨ Funcionalidades

### 👥 Gerenciamento de Usuários
- **CRUD Completo:** Criar, Ler, Atualizar e Deletar usuários.
- **Especialização (Herança):**
  - Nesse contexto, tanto clientes quanto Desenvolvedores possuem todos os atributos de um Usuário, porém possuem alguns atributos específicos. 
  - **Clientes:** Possuem campo específico para "País de Origem".
  - **Desenvolvedores:** Possuem "Área", "Cargo" e vínculo com um Estúdio.
- **Formulário Dinâmico:** Os campos mudam automaticamente dependendo do tipo de usuário selecionado.

### 🏢 Gerenciamento de Estúdios
- Cadastro e administração de empresas parceiras.
- Vinculação automática com desenvolvedores.

### 🎨 Interface
- Design responsivo e moderno.
- Tema **Dark Mode**.
- Inputs e Selects estilizados.

---

## 🛠️ Tecnologias Utilizadas

- **Back-end:** PHP 8+
- **Banco de Dados:** MySQL (MariaDB)
- **Front-end:** HTML5, CSS3 (Flexbox/Grid)
- **Servidor Local:** XAMPP (Apache)

---

## 📂 Estrutura do Banco de Dados

O sistema utiliza um conceito de **Herança de Tabelas** para os usuários:

1.  **Usuario:** Tabela pai (ID, Nome, Email, Senha).
2.  **Cliente:** Tabela filha (ID_Usuario, País).
3.  **Desenvolvedor:** Tabela filha (ID_Usuario, Área, Cargo, ID_Estudio).
4.  **Estudio:** Tabela independente para cadastro das empresas.

---

## 🚀 Como Executar o Projeto

### Pré-requisitos
Ter o **XAMPP** instalado (ou outro ambiente com PHP e MySQL).

### Passo a Passo

1.  **Clone ou Baixe** este repositório para a pasta do servidor:
    - No XAMPP: `C:\xampp\htdocs\sistema_usuarios`

2.  **Configurar o Banco de Dados:**
    - Abra o **PHPMyAdmin** (geralmente em `http://localhost/phpmyadmin`).
    - Crie um banco de dados ou execute o script SQL fornecido no arquivo `banco_completo.sql`.

3.  **Configurar a Conexão:**
    - Verifique o arquivo `config.php`.
    - Certifique-se de que o usuário e senha do banco correspondem ao seu ambiente local:
    ```php
    $host = "127.0.0.1";
    $user = "root";
    $pass = ""; // Coloque sua senha se houver
    $bd   = "sistema_usuarios";
    ```

4.  **Acessar:**
    - Abra o navegador e digite: `http://localhost/sistema_usuarios`

---

## 📝 Estrutura de Arquivos

- `index.php`: Página principal (Lista de Usuários).
- `form_usuario.php`: Formulário de cadastro/edição de usuários.
- `lista_estudios.php`: Página de gerenciamento de estúdios.
- `style.css`: Estilização global (Dark Mode).
- `config.php`: Conexão com o banco de dados.

---

## 🤝 Contribuição

Sinta-se à vontade para clonar, testar e enviar pull requests.

---

Desenvolvido com 💜 por Giovane Godoi durante meus estudos de PHP.
