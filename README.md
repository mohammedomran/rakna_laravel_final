<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[British Software Development](https://www.britishsoftware.co)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- [UserInsights](https://userinsights.com)
- [Fragrantica](https://www.fragrantica.com)
- [SOFTonSOFA](https://softonsofa.com/)
- [User10](https://user10.com)
- [Soumettre.fr](https://soumettre.fr/)
- [CodeBrisk](https://codebrisk.com)
- [1Forge](https://1forge.com)
- [TECPRESSO](https://tecpresso.co.jp/)
- [Runtime Converter](http://runtimeconverter.com/)
- [WebL'Agence](https://weblagence.com/)
- [Invoice Ninja](https://www.invoiceninja.com)
- [iMi digital](https://www.imi-digital.de/)
- [Earthlink](https://www.earthlink.ro/)
- [Steadfast Collective](https://steadfastcollective.com/)
- [We Are The Robots Inc.](https://watr.mx/)
- [Understand.io](https://www.understand.io/)
- [Abdel Elrafa](https://abdelelrafa.com)
- [Hyper Host](https://hyper.host)
- [Appoly](https://www.appoly.co.uk)
- [OP.GG](https://op.gg)

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).



--------------------------------------------------------------------------



# API Docs

## END POINTS
```bash
http://localhost:8000/api/users/
http://localhost:8000/api/categories/
http://localhost:8000/api/products/
http://localhost:8000/api/colors/
http://localhost:8000/api/orders/
http://localhost:8000/api/addresses/
http://localhost:8000/api/users-payment-methods/
http://localhost:8000/api/payment-methods/
http://localhost:8000/api/complaints/
```

## REQUEST AND RESPONSE STYLE

### users routes

1- sign up
```bash
ROUTE
http://localhost:8000/api/users/signup

REQUEST PARAMETERS
{
    "api_pass":"UKyu8yu9dfsHN98RM5f4g5e64bhJGFJKF5h6j41k65hj",
    "first_name":"mohammed",
    "last_name":"ali,
    "mobile":"01234657980,
    "email":"mo@g.com",
    "password":"123456",
}
RESPONSE
{
  "code":200,
}
```

2- login
```bash
ROUTE
http://localhost:8000/api/users/signup

REQUEST PARAMETERS
{
    "api_pass":"UKyu8yu9dfsHN98RM5f4g5e64bhJGFJKF5h6j41k65hj",
    "email":"m@g.com",
    "password":"123456",
}
RESPONSE
{
  "code":200,
}
```

3- logout
```bash
ROUTE
http://localhost:8000/api/users/signup

REQUEST PARAMETERS
{
    "api_pass":"UKyu8yu9dfsHN98RM5f4g5e64bhJGFJKF5h6j41k65hj",
    "token":"sdg56g4er657ygIHIODNJOI6u8o4i8yolui54654656",
}
RESPONSE
{
  "code":200,
}
```

4- orders
```bash
ROUTE
http://localhost:8000/api/users/signup

REQUEST PARAMETERS
{
    "api_pass":"UKyu8yu9dfsHN98RM5f4g5e64bhJGFJKF5h6j41k65hj",
    "token":this.token,
}
RESPONSE
{
  "code":200,
}
```

5- update
```bash
ROUTE
http://localhost:8000/api/users/signup

REQUEST PARAMETERS
{
  "api_pass":"UKyu8yu9dfsHN98RM5f4g5e64bhJGFJKF5h6j41k65hj",
  "token":this.token,
  "first_name":"Mohammed",
  "last_name":"ali",
  "mobile":"02315679894",
  "email":"m@g.com",
}
RESPONSE
{
  "code":200,
}
```

6- payment-methods
```bash
ROUTE
http://localhost:8000/api/users/signup

REQUEST PARAMETERS
{
    "api_pass":"UKyu8yu9dfsHN98RM5f4g5e64bhJGFJKF5h6j41k65hj",
    "token":this.token,
    "user_payment_method_id":id
}
RESPONSE
{
  "code":200,
}
```


### products routes

1- get all products
```bash
ROUTE
http://localhost:8000/api/products/show_products

REQUEST PARAMETERS
{
    "api_pass":"UKyu8yu9dfsHN98RM5f4g5e64bhJGFJKF5h6j41k65hj",
}
RESPONSE
{
  "code":200,
}
```
2- filter
```bash
ROUTE
http://localhost:8000/api/products/filter

REQUEST PARAMETERS
{
  "api_pass":"UKyu8yu9dfsHN98RM5f4g5e64bhJGFJKF5h6j41k65hj",
  "minPrice":parseInt(minPrice),
  "maxPrice":parseInt(maxPrice),
  "selected_categories":[0, 55, 15],
  "selected_colors":[0, 7, 11],
}
RESPONSE
{
  "code":200,
}
```
3- search for product
```bash
ROUTE
http://localhost:8000/api/products/search-for-product

REQUEST PARAMETERS
{
    "api_pass":"UKyu8yu9dfsHN98RM5f4g5e64bhJGFJKF5h6j41k65hj",
    "data":"كنبة زرقاء",
}
RESPONSE
{
  "code":200,
}
```

4- get all offers
```bash
ROUTE
http://localhost:8000/api/products/offers

REQUEST PARAMETERS
{
    "api_pass":"UKyu8yu9dfsHN98RM5f4g5e64bhJGFJKF5h6j41k65hj",
}
RESPONSE
{
  "code":200,
}
```


### categories routes

1- get all categories
```bash
ROUTE
http://localhost:8000/api/categories/index

REQUEST PARAMETERS
{
    "api_pass":"UKyu8yu9dfsHN98RM5f4g5e64bhJGFJKF5h6j41k65hj",
}
RESPONSE
{
  "code":200,
}
```

### colors routes

1- get all colors
```bash
ROUTE
http://localhost:8000/api/colors/index

REQUEST PARAMETERS
{
    "api_pass":"UKyu8yu9dfsHN98RM5f4g5e64bhJGFJKF5h6j41k65hj",
}
RESPONSE
{
  "code":200,
}
```

### addresses routes

1- get single address data
```bash
ROUTE
http://localhost:8000/api/addresses/show

REQUEST PARAMETERS
{
    "api_pass":"UKyu8yu9dfsHN98RM5f4g5e64bhJGFJKF5h6j41k65hj",
    "token":"gfghfdgshdf;sfd;lgthjry65j746ty5j46t5yj4t6y54d6ghty",
}
RESPONSE
{
  "code":200,
}
```

2- store new address
```bash
ROUTE
http://localhost:8000/api/addresses/store

REQUEST PARAMETERS
{
    "api_pass":"UKyu8yu9dfsHN98RM5f4g5e64bhJGFJKF5h6j41k65hj",
    "token":"gfghfdgshdf;sfd;lgthjry65j746ty5j46t5yj4t6y54d6ghty",
    "address":1, 'full address'
}
RESPONSE
{
  "code":200,
}
```
3- update address
```bash
ROUTE
http://localhost:8000/api/addresses/update

REQUEST PARAMETERS
{
    "api_pass":"UKyu8yu9dfsHN98RM5f4g5e64bhJGFJKF5h6j41k65hj",
    "token":"gfghfdgshdf;sfd;lgthjry65j746ty5j46t5yj4t6y54d6ghty",
    "address_id":1,
    "address":1, 'full address'
}
RESPONSE
{
  "code":200,
}
```
4-delete address
```bash
ROUTE
http://localhost:8000/api/addresses/delete

REQUEST PARAMETERS
{
    "api_pass":"UKyu8yu9dfsHN98RM5f4g5e64bhJGFJKF5h6j41k65hj",
    "token":"gfghfdgshdf;sfd;lgthjry65j746ty5j46t5yj4t6y54d6ghty",
    "address_id":1,
}
RESPONSE
{
  "code":200,
}
```



### users stored payment methods routes

1- store new payment method for a user
```bash
ROUTE
http://localhost:8000/api/users-payment-methods/store

REQUEST PARAMETERS
{
    "api_pass":"UKyu8yu9dfsHN98RM5f4g5e64bhJGFJKF5h6j41k65hj",
    "token":"gfghfdgshdf;sfd;lgthjry65j746ty5j46t5yj4t6y54d6ghty",
    "owner":"Mo Salah",
    "number":1645788256784213,
    "expire-year":2022,
    "expire-month":12,
    "cvv":456,
    "payment_method_id":2
}
RESPONSE
{
  "code":200,
}
```

2- delete user payment method
```bash
ROUTE
http://localhost:8000/api/users-payment-methods/delete

REQUEST PARAMETERS
{
    "api_pass":"UKyu8yu9dfsHN98RM5f4g5e64bhJGFJKF5h6j41k65hj",
    "token":"gfghfdgshdf;sfd;lgthjry65j746ty5j46t5yj4t6y54d6ghty",
    "user_payment_method_id":22
}
RESPONSE
{
  "code":200,
}
```


### payment methods routes

1- get all available payment methods
```bash
ROUTE
http://localhost:8000/api/payment-methods/index

REQUEST PARAMETERS
{
    "api_pass":"UKyu8yu9dfsHN98RM5f4g5e64bhJGFJKF5h6j41k65hj",
}
RESPONSE
{
  "code":200,
}
```

### complaints routes

1- store a new complaint
```bash
ROUTE
http://localhost:8000/api/complaints/store

REQUEST PARAMETERS
{
    "api_pass":"UKyu8yu9dfsHN98RM5f4g5e64bhJGFJKF5h6j41k65hj",
    "token":"gfghfdgshdf;sfd;lgthjry65j746ty5j46t5yj4t6y54d6ghty",
    "content":"هذه الشكوي مقدمة بخصوص طلبي المتأخر",
    "order_id":2
}
RESPONSE
{
  "code":200,
}
```

