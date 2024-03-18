<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About

This is a simple laravel application that lets users register with their email, name and password. In addition, once registered, the user can decide to add fingerprint authentication. 

Fingerprint auth is added courtesy of a couple of libraries: 

- [Laragear/WebAuthn](https://github.com/Laragear/WebAuthn) which handles webauthn authentication on the server side.
- [Webpass](https://www.npmjs.com/package/@laragear/webpass) on the client side (interacting with the browser).

The libraries implement [Webauthn](https://www.w3.org/TR/webauthn-2/), a w3c standard that prescribes communication between an authenticator hardware device and the laravel application, over the web, enabling authentication of users using passkeys: fingerprints, patterns and biometric data.

## How to Set Up the Application for Development

- Clone this project on a new directory in your work environment.
- Run **composer install** and **npm install** to set up required dependencies.
- Run **php artisan key:generate** to generate your applicaion key.
- Run **php artisan migrate** to set up the schema for the user and webauthn databases.
- User **php artisan serve** to run the application in localhost

## User Authentication and Registration Flows

Thanks to the webauthn standard, our laravel application does not need to store any fingerprint data, only a public key generated by the authenticator device.  

### Registration

![registration flow](https://github.com/ckodalo/cautious-octo-enigma/assets/48943229/b99eab2d-b43d-4b42-8cff-b7950b717338)

### Login

![login flow](https://github.com/ckodalo/cautious-octo-enigma/assets/48943229/e465bc05-e8a0-423e-a67f-1ff28cca8d8e)


## Compatibility Issues

The major assumption for this project is that the user will be leveraging their smartphone device for fingerprint authentication. However webauthn does not have full support for smartphones across all browsers and operating systems. You can refer [here](https://webauthn.me/browser) for more info.


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
