# sso-tests

## branch classic-required

2 different and independent tests:
 * **frontend**:  a single application page which redirect to login page when begin
 * **backend**:  a php application which redirect to login page when begin



## branch classic-check

2 different and independent tests:
 * **frontend**: a single page application which only test if user is logged
 * **backend**: a php application which only test if user is logged


## branch classic-window

2 different and independent tests:
 * **frontend**: a single page application  which open a window to log in
 * **backend**: a php application which open a window to login

## branch together

The vuejs app is the frontend of the php application
The backend manage the login and logout.

## branch service

The vuejs app is an independent application, and the php application is only a service for it.
The 2 applications must be registered to the sso service.



