

## About project

The goal for this project is to make Google calendar event from Laravel application.
User can save own Google event through Laravel form. 

First user needs to create a fake Google account.
For that fake account to be able to connect to the Google API, user need to go the Google console dashboard and create a new project.

After that user needs to download JSON credentials and save to the Laravel storage folder. Before that we need to run artisan command 
```
php artisan storage:link
```
The best practice is to put name of JSON credentials in ENV variable with the name i.e GOOGLE_CLIENT_SECRET_PATH
The name of the fake Google account also needs to be ENV variables i.e GOOGLE_FAKE_ACCOUNT. 

Redirect URI, entered in your settings from Google Console dashboard, needs to be the same as your ENV variable GOOGLE_REDIRECT_URI=http://127.0.0.1:8000/google/auth/callback

Later, if user wants to use another event calendar logic, just need to create different class, like Google calendar class, and implements the same interface `Calendar interface`.

If user want to use other methods than just `makeEvent`, just uncomment all interface methods which you need and write the logic in the newly created class service.

Don't forget to bind your newly created class in Laravel service container `AppServiceProvider` like this: 
```
$this->app->bind(CalendarInterface::class, YourNewlyCreatedEventService::class); (boot method)
```
