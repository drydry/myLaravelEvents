# myLaravelEvents (Laravel & AngularJS)

myLaravelEvents is a web-app allowing users to manage and book events.

The back-end is based on RESTFUL api calls, MySQL database and the front-end on AngularJS:
  - Authentication process (register, login, logout)
  - List of events/hosted events only
  - Event management (creation, update, delete, booking).

Concerning the APIs:
  - they are protected from the 'public', you need to be logged-in to use them
  - they are prefixed by 'api/' 
  - they have url parameters in order to customize responses data and avoid useless processing time

There is a validation system, based on the server-side:
  - different 'Request' classes define validation rules and authorize an API call, so the model stays clean and correct
  - errors are showed in forms and in some cases with a simple javascript alert (when the error response comes from Angular controller). 

Validation rules on booking:
  - event must exist
  - event time must be in the future
  - a creator cannot book his event
  - a user cannot book an event where the maximum capacity is reached
  - a user cannot book the same event twice
  - a user cannot book an event where timeslots are in conflicts (two events in the same time).

Validation rules on event (not implemented yet):
  - an event cannot be created at the same time as another event for the same host
  - an event must be programmed for at least 15min
  - an event cannot be created in the past and must be created at least 2 hours after now.

No client-side validation to keep the web-app clean of endless javascript.