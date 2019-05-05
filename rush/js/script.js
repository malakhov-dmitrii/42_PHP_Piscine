const baseURL           = 'http://192.168.29.124:8100/rush00/api/';

const authForm          = document.querySelector("#auth-form");
const addCategoryForm   = document.querySelector("#add-category-form");
const addGoodForm       = document.querySelector('#add-good-form');
const submitAddGoodForm = document.querySelector('#submit-add-good');
const goodsList         = document.querySelector('#goods-list');
const productInfo       = document.querySelector('.product-info');

const addUserBtn        = document.querySelector('#addUser');
const usersList         = document.querySelector('.users-list');

const nav               = document.querySelector('nav');
const adminBody         = document.querySelector('#admin-page');
const logoutLink        = document.querySelector('.logout');

const addUserLogin      = document.querySelector('#add-user-login');
const addUserPassword   = document.querySelector('#add-user-password');
const addUserName       = document.querySelector('#add-user-name');
const addUserLastname   = document.querySelector('#add-user-lastname');
const addUserEmail      = document.querySelector('#add-user-email');

let cart;

if (authForm) {
    onLogin.addEventListener('click', () => login());
}
if (addCategoryForm) {
    renderCategories();
    addCategoryForm.addEventListener("submit", () => addCategory());
}
if (addGoodForm) {
    submitAddGoodForm.addEventListener('click', () => addGood(event));
    let select = document.querySelector('#categories-select');

    select.innerHTML = '';
    listCategoriesOptions()
        .then(res => {
            res.forEach(item => {
                select.innerHTML += item;
            })
        });

    renderGoods();

}
if (addUserBtn) {
    renderUsers();
    addUserBtn.addEventListener('click', () => addUser());
}
if (usersList) {
    getUsers();
}
if (goodsList) {
    renderGoods()
}
if (productInfo) {
    renderProductInfo();
}
if (logoutLink) logoutLink.addEventListener('click', () => logout());
if (adminBody && !isAdmin()) location.pathname = 'rush/index.html';

function isLoggedIn() {
    return !!localStorage.getItem('token');
}

function isAdmin() {
    return !!Number(localStorage.getItem('isAdmin'));
}

function login() {
    const login = document.querySelector("#login").value;
    const password = document.querySelector("#password").value;

    let data = new FormData()
    // data.append("login", 'admin');
    // data.append("passwd", 'admin');
    data.append("login", login);
    data.append("passwd", password);

    fetch(`${baseURL}loginUser.php`, {
        method: "POST",
        body: data
    })
        .then(res => res.json())
        .then(res => res.response)
        .then(res => {
            if (res.error) {
                // TODO Handle auth err
                alert("Error");
            } else if (res.token) {
                localStorage.setItem('token', res.token);
                localStorage.setItem('isAdmin', res.admin);
                window.location.pathname = 'rush/index.html'
            }
        });
    return false;
}

function logout() {
    localStorage.removeItem('token');
    localStorage.removeItem('isAdmin');
    cart.clear();
    location.pathname = 'rush/index.html'
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

function getCategories() {
    return fetch(`${baseURL}getCats.php`)
        .then(res => res.json())
        .then(res => res.response.products)
}

function renderCategories() {
    let list = document.querySelector('.categories-list');
    list.innerHTML = '';
    getCategories()
        .then(res => res.map(item => {
            return `
        <div class="list-item">
                <div class="title">
                    ${item.category_name}
                </div>
                <div class="description">
                    ${item.cat_description}
                </div>
                <div class="img"><img src="${item.cat_img}" alt=""></div>
                <i class="material-icons">delete</i>
            </div>
    `
        })).then(res => res.forEach(item => {
            list.innerHTML += item
    }))
}

function addGood(event) {
    event.preventDefault();

    let addGoodValues = {
        title: document.querySelector('#title').value,
        img: document.querySelector('#img').value,
        description: document.querySelector('#description').value,
        quantity: document.querySelector('#quantity').value,
        value: document.querySelector('#value').value,
        categories: location.search.slice(1).split('&').map(item => item.split('=')[1])
    };

    const token = localStorage.getItem('token');

    let data = new FormData();
    data.append('token', token);
    data.append('name', addGoodValues.title);
    data.append('description', addGoodValues.description);
    data.append('img', addGoodValues.img);
    data.append('cat', JSON.stringify(addGoodValues.categories));
    data.append('value', addGoodValues.value);
    data.append('quantity', addGoodValues.quantity);

    fetch(`${baseURL}addGood.php`, {
        method: "POST",
        body: data
    })
        .then(res => res.json())
        .then(res => renderGoods());
    return false;
}

function addUser() {
    let data = new FormData();
    data.append('name', addUserName.value);
    data.append('lastname', addUserLastname.value);
    data.append('login', addUserLogin.value);
    data.append('email', addUserEmail.value);
    data.append('address', '');
    data.append('passwd', addUserPassword.value);

    fetch(`${baseURL}addUser.php`, {
        method: "POST",
        body: data
    })
        .then(res => res.json())
        .then(res => res.response)
        .then(res => location.pathname.indexOf('register.html') >= 0
            ? location.pathname = 'rush/pages/auth.html'
            : renderUsers());
    return false;
}

function getUsers() {
    let data = new FormData();
    data.append('token', localStorage.getItem('token'));

    return fetch(`${baseURL}getUsers.php`, {
        method: "POST",
        body: data
    })
        .then(res => res.json())
        .then(res => res.response.products)
}

function renderNav() {
    console.log('nav')
    if (Number(localStorage.isAdmin)) {
        console.log('admin')
    } else {
        console.log('not admin')
    }

    let regularTemplate = `
<div class="left-side">
    ${isAdmin() ?
    `
    <div class="nav-item">
        <a onclick="location.pathname='rush/pages/admin.html'">
            Админка
        </a>
    </div>
    ` : ''}
    <div class="nav-item">
        <a onclick="location.pathname = 'rush/index.html'">
            Главная
        </a>
    </div>
    <div class="nav-item">
        <a  onclick="location.pathname = 'rush/pages/shop.html'">
            Товары
        </a>
    </div>
</div>
<div class="right-side">
    <div class="nav-item">
        <a class="cart" onclick="location.pathname = 'rush/pages/cart.html'">
            Корзина <p class="counter">${cart.getCount()}</p>
        </a>
    </div>
        ${isLoggedIn() ? `
    <div class="nav-item">
            <a onclick="logout()">
                Выйти
            </a>
        </div>
    ` :
    `
    <div class="nav-item">
        <a onclick="location.pathname = 'rush/pages/auth.html'">
            Авторизация
        </a>
    </div>
    `}
    `;

    let adminTemplate = `
    <div class="left-side">
        <div class="nav-item">
            <a href="../index.html">
                Главная
            </a>
        </div>
        <div class="nav-item">
            <a href="goods.html">
                Товары
            </a>
        </div>
        <div class="nav-item">
            <a href="categories.html">
                Категории
            </a>
        </div>
        <div class="nav-item">
            <a href="users.html">
                Пользователи
            </a>
        </div>
    </div>
    <div class="right-side">
    ${isLoggedIn() ? `
    <div class="nav-item">
            <a onclick="logout()">
                Выйти
            </a>
        </div>
    ` :
    `
    <div class="nav-item">
        <a href="../pages/auth.html">
            Авторизация
        </a>
    </div>
    `}
    </div>
`;

    let nav = document.querySelector('nav');
    location.pathname.indexOf('index.html')>= 0
    || location.pathname.indexOf('shop.html')>= 0
    || location.pathname.indexOf('product.html')>= 0
    || location.pathname.indexOf('cart.html') >= 0
        ? nav.innerHTML = regularTemplate
        : nav.innerHTML = adminTemplate;
}

function renderGoods() {
    getGoods()
        .then(res => res.map(item => {
            return `
        <div class="goods-item">
            <div class="title">
                ${item.prod_name}
            </div>
            <div class="image">
                <img src="${item.product_image}">
            </div>
            <div class="description">
                ${item.prod_description}
            </div>
            <hr>
            <div class="quantity">
                Количество: ${item.quantity}
            </div>
            <div class="value">
                Цена: ${item.prod_value}
            </div>
            <div class="action">
                <button class="action-button warn" ${location.pathname.indexOf('shop.html') >= 0
                ? `onclick="cart.addItem(${item.id})">Добавить в корзину</button>
                 <button class="action-button accent"
                 onclick="location.href='product.html?product=${item.id}'">Подробнее</button>` 
                : `onclick="delGood(${item.id})">Удалить</button>`}
            </div>
        </div>
    `
        }))
        .then(res => {
            let list = document.querySelector('.goods-list');
            list.innerHTML = '';
            res.forEach(item => list.innerHTML += item)
        });
}

function getGoods() {
    return fetch(`${baseURL}getGoods.php`)
        .then(res => res.json())
        .then(res => res.response.products)
}

function delGood(id) {
    let data = new FormData();
    const token = localStorage.getItem('token');
    data.append('token', token);
    data.append('id', String(id));

    fetch(`${baseURL}delGood.php`, {
        method: "POST",
        body: data
    })
        .then(res => res.json())
        .then(res => renderGoods());
    return false;
}

function delUser(id) {
    let data = new FormData();
    const token = localStorage.getItem('token');
    data.append('token', token);
    data.append('id', String(id));

    fetch(`${baseURL}delUser.php`, {
        method: "POST",
        body: data
    })
        .then(res => res.json())
        .then(res => renderUsers());
    return false;
}

function listCategoriesOptions() {
    return getCategories()
        .then(res => {
            return res.map(item => {
                return `
            <option value="${item.category_name}">${item.category_name}</option>
            `
            })
        })
}

function promoteUser(login, isAdmin = 0) {
    let data = new FormData();
    const token = localStorage.getItem('token');
    data.append('token', token);
    data.append('login', login);
    data.append('status', String(isAdmin));

    fetch(`${baseURL}setAdmin.php`, {
        method: "POST",
        body: data
    })
        .then(res => res.json())
        .then(res => renderUsers());
}

function renderUsers() {
    getUsers()
        .then(res => {
            console.log(res)
            let templates = res.map(data => {
                return `
                <div class="user-item">
                    <div class="user-login">
                        ${data.login}
                    </div>
                    <div class="user-login">
                        ${data.name}
                    </div>
                    <div class="user-login">
                        ${data.lastname}
                    </div>
                    <div class="user-login">
                        ${data.email}
                    </div>
                    <div class="delete-user">
                        <i class="material-icons promote-user" onclick="delUser(${data.id})">delete</i>
                    </div>
                    ${!!Number(data.admin) ?
                                `<div class="promote-user">
                        <i class="material-icons" onclick="promoteUser('${data.login}', 0)">arrow_downward
</i>
                    </div>` :
                                `<div class="promote-user">
                        <i class="material-icons" onclick="promoteUser('${data.login}', 1)">beenhere</i>
                    </div>`}
                </div>`
            });

            usersList.innerHTML = '';
            templates.forEach(item => {
                usersList.innerHTML += item;
            });
        });

    return ;
}

function getProduct(id) {
    return fetch(`${baseURL}getGood.php?id=${id}`)
        .then(res => res.json())
        .then(res => res.response.products)
}

function renderProductInfo() {
    getProduct(location.search.slice(1).split('=')[1])
        .then(item => {
            let placeholder = document.querySelector('.product-details');
            placeholder.innerHTML = '';
            placeholder.innerHTML = `
                <div class="goods-item">
                <div class="title">
                    ${item.prod_name}
                </div>

                <div class="info">
                    <div class="image">
                        <img src="${item.product_image}">
                    </div>
                    <div class="details">
                        <div class="description">
                            ${item.prod_description}
                        </div>
                        <hr>
                        <div class="quantity">
                            Осталось: ${item.quantity}
                        </div>
                        <div class="value">
                            Цена: ${item.prod_value}
                        </div>
                        <div class="action">
                            <button class="action-button accent">Добавить в корзину</button>
                        </div>
                    </div>
                </div>
            </div>
                `
        })
}

setTimeout(() => {
    cart = new Cart(13);
    renderNav();
}, 50);

class Cart {
    constructor(id) {
        this.ownerId = id
    }

    _cart = JSON.parse(localStorage.getItem('cart')) || [];

    addItem(item) {
        getGoods()
            .then(res => res.filter(goodsItem => goodsItem.id === String(item))[0])
            .then(res => {
                if (this._cart.some(cartItem => cartItem.id === res.id)) {
                    this._cart.filter(cartItem => cartItem.id === res.id)[0].count++;
                } else {
                    this._cart.push(res);
                    this._cart.filter(cartItem => cartItem.id === res.id)[0].count = 1;
                }
                localStorage.setItem('cart', JSON.stringify(this._cart));
                renderNav();
            })
    }

    getCount() {
        let sum = 0;
        this._cart.forEach(item => {
            sum += item.count;
        })
        return sum;
    }

    removeItem(id) {
        this._cart.filter(item => item.id !== id);
    }

    getItems() {
        return this._cart;
    }

    clear() {
        this._cart = [];
        localStorage.setItem('cart', JSON.stringify(this._cart));
    }

    renderCart() {

    }
}