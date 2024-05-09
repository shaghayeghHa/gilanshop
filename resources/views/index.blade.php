<!doctype html>
<html lang="en" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>گیلان شاپ</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body style="background-color: #ececec">
<nav class="navbar bg-body-tertiary">
    <div id="nav-container" class="container-fluid w-75">
        <a class="navbar-brand" href="#">
            <img src="{{asset('assets/logo.png')}}" alt="گیلان شاپ" width="64" class="d-inline-block align-middle">
            <h1 class="d-inline me-2 ms-2 fs-5 fw-bold text-secondary">گیلان شاپ</h1>
            <h4 id="nav-description" class="d-inline fs-6 text-muted">فروشگاه محصولات متنوع گیلان</h4>
        </a>
        <div class="d-flex align-items-center">
            <div id="search_form" class="d-flex ms-5">
                <button id="search_button" class="ms-1 btn btn-outline-success" type="button">جستجو</button>
                <input id="search_input" class="form-control me-1" type="search" placeholder="جستجو" value="{{$query ?? ''}}">
            </div>
            <form>
                <button id="cart" class="btn btn-sm btn-outline-secondary me-5" type="button">سبد خرید</button>
            </form>
        </div>
    </div>
</nav>
<div class="pt-1 pb-1 bg-white container-fluid justify-content-center d-flex" style="margin-top: 2px">
    <ul class="nav p-0 w-75">
        @foreach($menu as $menuItem)
            <li class="nav-item">
                <a class="nav-link {{$menuItem['active'] ? 'text-primary' : 'text-muted'}}" href="{{$menuItem['url']}}">{{$menuItem['title']}}</a>
            </li>
        @endforeach
    </ul>
</div>
<div class="mt-4 container-fluid d-flex justify-content-center">
    <div class="rounded-3 g-product-container">
        @foreach($products as $p)
            <div class="card d-flex g-card">
                <img src="{{asset('assets/products/' . $p->pic_url)}}" class="card-img-top" alt="{{$p->title}}">
                <div class="card-body">
                    <h6 class="card-title fw-bold text-truncate">{{$p->title}}</h6>
                    <p class="card-text text-truncate" style="font-size: .8em">{{$p->description}} (<span style="font-size: .8em; font-family: Vazir-fa">{{$p->amount}} کیلوگرم</span>)</p>
                    <div class="d-flex">
                        <div id="add-to-cart" pid="{{$p->id}}" class="btn btn-primary">+</div>
                        <span class="me-auto mt-auto mb-auto" style="font-family: Vazir-fa"><span class="fw-bold">{{number_format($p->price)}}</span> تومان</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
<div id="toast" class="position-fixed me-5 mb-5 end-0 bottom-0 toast align-items-center text-bg-primary border-0"  style="width: 15em" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
        <div class="toast-body">
            به سبد خرید اضافه شد.
        </div>
    </div>
</div>
<div id="toast-empty" class="position-fixed me-5 mb-5 end-0 bottom-0 toast align-items-center text-bg-secondary border-0"  style="width: 15em" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
        <div class="toast-body">
            سبد خرید خالی است.
        </div>
    </div>
</div>
<div id="cart-modal" class="modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">سبد خرید</h5>
            </div>
            <div id="cart-items" class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">انصراف</button>
                <button type="button" class="btn btn-primary">نهایی کردن خرید</button>
            </div>
        </div>
    </div>
</div>
<footer class="bg-white  mt-4 border-top d-flex justify-content-center">
    <div id="footer-area" class="w-75 d-flex flex-wrap justify-content-between align-items-center py-3">
        <div class="col-md-4 d-flex align-items-center">
            <a href="/" class="mb-3 me-2 mb-md-0 text-body-secondary text-decoration-none lh-1">
                <img src="{{asset('assets/logo.png')}}" alt="گیلان شاپ" width="48" class="d-inline-block align-middle">
            </a>
            <span class="me-2 mb-3 mb-md-0 text-body-secondary" style="font-family: Vazir-fa; font-size: .8em">تمامی حقوق محفوظ می باشه ©1403 </span>
        </div>

        <div class="nav justify-content-end d-flex fs-5">
            <a class="text-body-secondary ms-3" href="#"><i class="bi bi-instagram"></i></a>
            <a class="text-body-secondary ms-3" href="#"><i class="bi bi-telegram"></i></a>
            <a class="text-body-secondary ms-3" href="#"><i class="bi bi-twitter"></i></a>
        </div>
    </div>
</footer>
</body>
<script>
    //search
    document.querySelector('#search_button').addEventListener('click', (e) => {
        search()
    });
    document.querySelector('#search_input').addEventListener('keyup', (e) => {
        if (e.keyCode !== 13) {
            return
        }
        search()
    });
    function search() {
        let input = document.getElementById("search_input").value;
        window.location.href = window.location.pathname+"?q="+input
    }

    let products = @json($products);
    let cartProducts = []
    for(let i in products) {
        let p = products[i]
        cartProducts[p['id']] = p
    }
    let cart = []
    //cart
    document.querySelectorAll('#add-to-cart').forEach(function(el) {
        el.addEventListener('click', (e) => {
            cart.push(e.target.getAttribute('pid'))
            const toast = document.getElementById('toast')
            new Toast(toast).show()
        });
    });

    document.querySelectorAll('#cart').forEach(function(el) {
        el.addEventListener('click', (e) => {
            if (cart.length === 0) {
                const toast = document.getElementById('toast-empty')
                new Toast(toast).show()
                return
            }
            let total = 0
            let items = document.getElementById("cart-items")
            items.innerHTML = ""
            cart.forEach(function (c) {
                let element = document.createElement("p")
                element.textContent = cartProducts[c]['title'] + ", " + cartProducts[c]['amount'] + " کیلوگرم , " + (cartProducts[c]['amount']*cartProducts[c]['price']).toLocaleString() + " تومان"
                element.className = "cart-items"
                items.appendChild(element)
                total += (cartProducts[c]['amount']*cartProducts[c]['price'])
            });

            let totalElement = document.createElement("p")
            totalElement.textContent = "مجموع: " + total.toLocaleString() + " تومان"
            totalElement.className = "cart-items"
            items.appendChild(totalElement)

            const modal = new Modal(document.getElementById('cart-modal'))
            modal.show()
        });
    });
</script>
</html>
