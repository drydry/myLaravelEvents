# myLaravelEvents (Laravel & AngularJS)

myLaravelEvents is a web-app allowing users to manage and book events.

## Screenshots
The design is not beautiful but functional, I will arrange it soon.


### Events list

There are 3 main 'tabs' (for now it's only buttons) :
  - Upcoming events: events you can book, which means not full and events you don't have already booked. 
  - Booked events: events you have booked
  - Hosted events: events you host, possibility to view bookings and kick users.

Only future events are displayed and bookable.

![alt tag](https://raw.githubusercontent.com/drydry/myLaravelEvents/master/storage/app/screenshots/events-list-upcoming.png)
![alt tag](https://raw.githubusercontent.com/drydry/myLaravelEvents/master/storage/app/screenshots/events-list-booked.png)
![alt tag](https://raw.githubusercontent.com/drydry/myLaravelEvents/master/storage/app/screenshots/events-list-hosted.png)

### Bookings list

![alt tag](https://raw.githubusercontent.com/drydry/myLaravelEvents/master/storage/app/screenshots/bookings-list.png)

### Event create form

This form asks for a title, description, capacity start/end dates and times.
Set the capacity to 0 to allow unlimited books.  

![alt tag](https://raw.githubusercontent.com/drydry/myLaravelEvents/master/storage/app/screenshots/event-create.png)

### Event types

This section of the app allows you to create templates for events.
Each template is defined by a title, description and a capacity.
Click on "Create event" to open a new event create form with data already filled.

![alt tag](https://raw.githubusercontent.com/drydry/myLaravelEvents/master/storage/app/screenshots/event-types-list.png)


## General description
The back-end is based on RESTFUL api calls, MySQL database and the front-end on AngularJS:
  - Authentication process (register, login, logout)
  - List of events, categorized by type
  - Event management (creation, update, delete, booking)
  - Validation process on server-side, with notifications on errors and on actions (book, unbook, delete).

Concerning the APIs:
  - they are protected from the 'public', you need to be logged-in to use them
  - they have url parameters in order to customize responses data and avoid useless processing time, bandwidth.

There is a validation system, based on the server-side:
  - different 'Request' classes define validation rules and authorize an API call, so the model stays clean and correct
  - errors are showed in forms, handled either by Laravel (errors written in a div) or by Angular(errors displayed as a notification). 

## Validation rules

### Creating an event:
  - an event cannot be created at the same time as another event for the same host
  - an event must be programmed for at least 10 minutes and less than 12 hours
  - an event cannot be created in the past and must be created at least 2 hours after now.

### Booking an event:
  - event must exist
  - event time must be in the future
  - a creator cannot book his event
  - a user cannot book an event where the maximum capacity is reached
  - a user cannot book the same event twice
  - a user cannot book an event where timeslots are in conflicts (two events in the same time)
  - a user cannot book an event if he was kicked from it.

### Common validation rules:
  - you can't edit/update/delete an entity (Event, EventType, Booking) that doesn't belong to you. For example, the user #1 can't edit an event created by the user #2, and so on.

The validation is handled by the server and no specific javascript was added to perform front-validation.