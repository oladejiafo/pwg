<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
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

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).



E-portal play same as a E-commerce site here the the user can apply the destination which the user wish to proceed. Through this th payments also be done.

## Prerequisites

PHP 7.3 or later
Laravel 8.x

## Project Structure

app/
├── Http/
│   ├── Controllers/
│   │   ├── HomeController.php
│   │   ├── ApplicationController.php
|   |   ├── ApiController.php
|   |   ├── NetworkController.php
|   |   ├── ResetPasswordController.php
|   |   └── Affiliate/
|   |           └── AffiliatePartnerController.php
|   |   
│   ├── Middleware/
│   │   ├── Authenticate.php
│   │   └── AffiliateCheck.php
│   └── ...
├── Providers/
│   ├── AppServiceProvider.php
│   ├── AuthServiceProvider.php
|   ├── EventServiceProvider.php
|   ├── FortifyServiceProvider.php
|   └── JetstreamServiceProvider.php
└── ...

## Database Schema
Here's the database schema for the project:

- **clients**
- id
- family_member_id 
- name 
- sur_name
- middle_name
- email
- phone_number 
- new_email  
- new_phone_number 
- sex	
- date_of_birth
- place_of_birth
- country_of_birth
- civil_status
- other_civil_status
- citizenship
- country_of_residence
- passport_number 
- passport_issue_date 
- passport_expiry
- passport_issued_by
- address_line_1
- address_line_2
- city
- state
- postal_code
- country
- is_schengen_visa_issued_last_five_year
- is_finger_print_collected_for_Schengen_visa
- residence_mobile_number	
- visa_validity	
- residence_id
- current_job_profession
- work_state
- work_city	
- work_postal_code
- work_address

When registering in eportal the datas will be saved in clients table.

- **applications**

After providing signature and and either by go forward with card payment or bank transfer when the slip upload the application detaisl will be enterded in this table.









