# myLaravelEvents (Laravel & AngularJS)

myLaravelEvents is a web-app allowing users to manager and book events.

The back-end is based on RESTFUL api calls, MySQL database and the front-end on AngularJS:
  - Authentication process (register, login, logout)
  - List of events/hosted events only
  - Event management (creation, update, delete, booking).

Concerning the APIs:
  - they are protected from the 'public', you need to be logged in to use them
  - they are prefixed by 'api/'
  - they have url parameters in order to customize responses data and avoid useless processing time

There is a validation system, based on the server-side, with Laravel:
  - different 'Request' classes define validation rules and authorize an API call, so the model stays clean and correct
  - errors are showed in forms and in some cases with a simple javascript alert (when the error response comes from Angular controller)
  - validation rules are simple right now but some are missing yet. 

No client-side validation to keep the web-app clean of endless javascript.