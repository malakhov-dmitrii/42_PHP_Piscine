const authForm = document.querySelector("#auth-form");
const addCategoryForm = document.querySelector("#add-category-form");
const baseURL = 'http://192.168.29.124:8100/rush00/api/';
const testUser = document.querySelector('#testUser');

if (authForm) {
    authForm.addEventListener("submit", () => login());
    authForm.addEventListener('click', () => login());
}
if (addCategoryForm) addCategoryForm.addEventListener("submit", () => addCategory());
if (testUser) testUser.addEventListener('click', () => addUser());
function login() {
    const login = document.querySelector("#login");
    const password = document.querySelector("#password");

    let data = new FormData();
    data.append("login", 'fuckyeaher');
    data.append("passwd", 'fuckme@mail.com');

    fetch(`${baseURL}loginUser.php`, {
        method: "POST",
        body: data
    })
        .then(res => res.json())
        .then(res => res.response)
        .then(res => {
            if (res.error) {
                // TODO Handle auth err
                console.log("Error");
            } else if (res.token) {
                console.log(res)
                localStorage.setItem('token', res.token);
                window.location.href = '../index.html'
            }
        });
    return false;
}

function addCategory() {
    const URL = 'https://images.unsplash.com/photo-1556909212-d5b604d0c90d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=800&q=60';
    const title = 'Lorem ipsum';
    const description = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt recusandae, soluta? Animi atque doloremque eius esse, ex expedita hic laudantium saepe tempora vel? A ad aliquid at atque distinctio dolor dolorem, nam nesciunt nostrum porro quas quod ratione sed, similique tempore veritatis?';
    const token = localStorage.getItem('token');

    let data = new FormData();
    data.append('token', token);
    data.append('name', title);
    data.append('description', description);
    data.append('img', URL);

    fetch(`${baseURL}addCat.php`, {
        method: "POST",
        body: data
    })
        .then(res => res.json())
        .then(res => res.response)
        .then(res => {
            console.log(res);
            getCategories(0);
            getCategories(1);
            getCategories(2);
        });
    return false;
}

function getCategories(page = 0) {
    fetch(`${baseURL}getCat.php?page=${page}`)
        .then(res => res.json())
        .then(res => console.log(res))
}

function addUser() {
    let data = new FormData();
    data.append('name', 'Pipka');
    data.append('lastname', 'Big');
    data.append('login', 'fuckyeaher');
    data.append('email', 'fuckme@mail.com');
    data.append('address', 'fuckme@mail.com');
    data.append('passwd', 'fuckme@mail.com');

    fetch(`${baseURL}addUser.php`, {
        method: "POST",
        body: data
    })
        .then(res => res.json())
        .then(res => res.response)
        .then(res => {
            console.log(res);
        });
    return false;
}

function getUsers() {
    
}