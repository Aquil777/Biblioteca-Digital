# Biblioteca Digital
Este sistema foi desenvolvido em PHP para gerenciar o registro de empréstimos de livros e usuários em uma biblioteca. Utiliza PHP, HTML, CSS e um banco de dados MySQL para armazenar e gerenciar as informações dos empréstimos. O sistema permite que os usuários façam empréstimos com data de entrega e, caso não devolvam no prazo, sejam bloqueados de acessar a página.

# Principais Funcionalidades
> Consultas e Empréstimos Online: Usuários podem consultar o catálogo da biblioteca e realizar empréstimos, reservas e renovações de livros diretamente pela plataforma, sem necessidade de presença física na biblioteca.
> Gestão de Acervo e Usuários: Bibliotecários podem registrar e monitorar o status dos livros (disponíveis, emprestados, reservados), bem como gerenciar os registros de empréstimos e devoluções.
> Bloqueio por Atraso: Se um usuário não devolver o livro na data estipulada, ele será automaticamente bloqueado de acessar a plataforma até a devolução do item.
> Relatórios de Uso: O sistema gera relatórios detalhados sobre o uso da biblioteca, incluindo dados sobre empréstimos, livros mais populares e sugestões de melhorias no acervo.

# Instruções de Configuração

### Requisitos:
- **XAMPP**: Certifique-se de ter o [XAMPP](https://www.apachefriends.org/pt_br/index.html) baixado e instalado. Ele fornece o servidor Apache e o banco de dados MySQL necessários para o funcionamento do projeto.

### Passos para configurar o ambiente:

1. **Iniciar o XAMPP**:
   - Abra o XAMPP e inicie os serviços **Apache** e **MySQL**.

2. **Colocar o projeto no diretório correto**:
   - Mova a pasta do projeto para o diretório `C:\xampp\htdocs`.

3. **Criar a base de dados**:
   - Abra o seu navegador e vá para [http://localhost/phpmyadmin](http://localhost/phpmyadmin).
   - No **phpMyAdmin**, crie uma base de dados com o nome **"biblioteca"**.
     - Caso prefira, você pode alterar o nome da base de dados diretamente no arquivo `bd.sql`.

4. **Importar o script de banco de dados**:
   - Dentro do **phpMyAdmin**, selecione a base de dados **biblioteca** (ou o nome que você escolheu).
   - Importe o arquivo `bd.sql` que está presente no projeto.

5. **Acessar o projeto localmente**:
   - Agora, você pode acessar o projeto no navegador através do endereço: [http://localhost/biblioteca](http://localhost/biblioteca).

---

### Observações Importantes:
- Eu deixei as **senhas não criptografadas** no código para que você possa facilmente visualizar e testar diferentes casos. **Recomendo fortemente** que, ao utilizar este código em produção, você **implemente a criptografia das senhas** para maior segurança.
