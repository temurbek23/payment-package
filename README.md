# Laravel Payment Package

![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg)

Bu Laravel paketi, Payme to'lov tizimini integratsiyalash uchun yaratilgan. Ushbu README faylida ushbu paketni o'rnatish, sozlash va ishlatish bo'yicha ko'rsatmalar mavjud.

## O'rnatish

Ushbu paketni Composer orqali o'rnatishingiz mumkin. Terminalni oching va quyidagi buyruqni ishga tushiring:

```bash
composer require your-package-name

## Sozlash

Loyhangizdagi .env fayliga quydagi o'zgaruvchilarni qo'shing va Payme API dan URL va HOST ni va Payme taqdim etadigan ID va KEY ni olib quydagi o'zgaruvchilarga ta'minlang:

```dotenv
PAYME_URL=your_url
PAYME_HOST=your_host
PAYME_ID=your_id
PAYME_KEY=your_key

## To'lov Amalga Oshirish

Paketni o'rnatgandan so'ng, uning `Payment` klassidan foydalanib to'lovni amalga oshirishingiz mumkin. Quyidagi kod qismida ushbu amalni ko'rish mumkin:

```php
use ProgrammeruzPayme\PaymentPackage\Payment;

$payme = new Payment();

$amount = 10000; // To'lov miqdori
$token = 'your_payment_token'; // To'lov uchun token

$payme->pay($amount, $token);
