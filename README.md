
## About Project

This projects gets live locations of vehicles and displays it on a map. It uses Laravel for backend and VueJs for frontend. 
It uses SSE to keep calling the external endpoint to get vehicle locations and updates the map with the new locations.

## Installation

1. Clone the repository
2. Run `composer install`
3. Run `npm install`
4. Run `npm run dev`
5. Create a `.env` file by copying the `.env.example` file and file the USER_ID, API_KEY and GROUP_ID with the correct values
6. Run `php artisan migrate` to create the database tables
7. Run `php artisan db:seed --class=SeedVechicleSeeder` to seed the database with the vehicles ensure env file has the correct database credentials and values
8. Run `php artisan serve` to start the server
9. Visit `http://localhost:8000` to view the application