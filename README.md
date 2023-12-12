<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="200" alt="Laravel Logo"></a></p>


## Hotel Booking Reservation

Questo è il sito di un hotel con prenotazione e checkout online, costruito utilizzando Laravel.
Ci sono un template frontend e un template backend con la possibilità di scegliere tra tema "chiaro" e tema "scuro".

- Routes [Simple, fast routing engine](https://laravel.com/docs/routing).
- Factory Design Pattern [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- [Laravel](https://laravel.com/docs/10.x/).
- [Blade](https://laravel.com/docs/10.x/blade).
- Eloquent [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).
- [Bootstrap](https://getbootstrap.com/).
- [Jquery](https://jquery.com/).
- [Stripe](https://stripe.com/it).
- [Spatie](https://spatie.be/docs/laravel-permission/v6/introduction).
- [Laravel Excel](https://docs.laravel-excel.com/3.1/imports/).
- Smtp.
- [Mailtrap](https://mailtrap.io/?gad_source=1).
- [TinyCloud](https://www.tiny.cloud/).
- [Toastr](https://github.com/CodeSeven/toastr).
- [Simplebar](https://www.cssscript.com/performant-custom-scrollbar-javascript-library-simplebar/).
- [Chart](https://www.chartjs.org/).
-[Intervention Image](https://image.intervention.io/v2/introduction/installation).


## Frontend

Nella parte frontend è stato implementato un sistema di autenticazione necessario per procedere al checkout. Il cliente, una volta registrato, ha a disposizione una dashboard nella quale impostare le informazioni di base del contatto.
L'utente riceve notifiche mail quando dimentica la password e la vuole reimpostare, quando cambia lo stato del booking o del pagamento.
Per i pagamenti il cliente può decidere se pagare Cash on delivery oppure tramite carta di credito(Stripe).
Il sito presenta vari sezioni oltre al booking:
- room e relativi servizi
- team
- testimonial
- gallery
- blog
- contatti

Tutti i contenuti sono inseriti in modo dinamico nel sito. Per ogni sezione sono state create le relative tabelle nel database e le informazioni sono inserite grazie al template Blade di Laravel.

## Backend

Nel sito è implementata oltre la parte dell'autenticazione anche una parte relativa alle autorizzazioni, ai ruoli e ai permessi.
Se l'user che fa login è registrato come admin avrà accesso alla dashboard di controllo delle funzionalità del sito. I vari menu' e le varie funzionalità sono visibili all'admin in base al ruoli ed ai permessi attribuiti al ruolo stesso.
Con i relativi permessi è possibile impostare direttamente dall'admin panel le impostazioni smtp, attribuire ruoli e relativi permessi, variare lo stato dei pagamenti e del booking, assegnare il numero di camera, verificare i messaggi di contatto, impostare la gallery, le room, il team, i testimonial e il blog.


## Contributing

Laravel framework! [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

Copyright (c) 2023 Laura Servettini MIT LICENSE

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

