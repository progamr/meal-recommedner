Meal Recommender
-----------
**How To Run it**
- clone the Repo.
- ``composer install``
- ``geenrate the app key (if not generated) php artisan key:generate``
- ``Create a .env file and copy .env.example in it``
- ``Add your DB connection configuration``
- ``Migrate the DB: php artisan migrate``
- ``Seed the DB: php artisan db:seed``
- ``Run the app: php artisan serve``


**Testing Data**
- ``use one of "[ 'Fried Chicken', 'Kofta', 'Koshary', 'Burger', 'Fish', 'Shawerma' ]" to test the happy path that the restaurants are returned based on the "Rank" of each restaurant and that rank is calculated based on the 4 mentioned criterias"``
- ``use "Foo" text to test that the app handles the (No meal with this name) Scenario``
- ``And finally Use empty string to test the validation on user input``

**Hint**
- the user lat and long are fixed values in the search form for simplicity.

**Architecture and Design**
- This app is built using the MVC Arch because it is a simple app. i used some of Laravel features like ``Requests`` and ``Scopes`` along with ``SOLID`` design principles
, the ``Repository`` pattern and ``Traits`` from the PHP language.

**Unit Tests**
- No tests written currently i didn't have much time to add them for sorry but if possible i can add them later.
