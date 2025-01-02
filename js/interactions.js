// Função para validar o formulário de login
function validateLogin() {
    const email = document.forms["loginForm"]["email"].value;
    const senha = document.forms["loginForm"]["senha"].value;

    if (email === "" || senha === "") {
        alert("E-mail e senha são obrigatórios!");
        return false;
    }
}

// Função para validar o formulário de adição de livros
function validateAddBook() {
    const isbn = document.forms["addBookForm"]["isbn"].value;
    const titulo = document.forms["addBookForm"]["titulo"].value;
    const autor = document.forms["addBookForm"]["autor"].value;
    const categoria = document.forms["addBookForm"]["categoria"].value;
    const unidades = document.forms["addBookForm"]["unidades"].value;

    if (isbn === "" || titulo === "" || autor === "" || categoria === "" || unidades === "") {
        alert("Todos os campos são obrigatórios!");
        return false;
    }
}
