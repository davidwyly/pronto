# pronto

## Summary
This is a project for a code challenge.

## Project Structure
- Environment variables go into `/config/.env` and newly-required `.env` definitions are checked into `/config/bootstrap.php`
- Routes for all endpoints are declared in `/public/index.php`
- PSR4 namespacing is used in the `src` directory for all other project-related files
    - e.g., The `Davidwyly\Pronto\Http\Controller\TestController` class is located at `/src/Davidwyly/Pronto/Http/Controller/TestController.php`
- Tests are located in `/tests`
    - Test fixtures in `/tests/fixtures`
    - Mock objects are located in `/src/Davidwyly/Pronto/Mock`

## Installation
While this project does not have to be installed in order to be evaluated, I have set up docker so that you can more easily run and test the service yourself.

These installation instructions assume that the following is already installed on your dev environment:
- Git
- Composer
- Docker
- Docker Compose
- Postman

#### Git
1. Navigate to your home directory
    - `cd ~`
2. Clone down the project
    - `git clone git@github.com:davidwyly/pronto`

#### Bash Aliases
1. Ensure you're in the root directory
    - `cd ~/pronto`
2. Run `source .bash_aliases`
3. To view all alias commands for this project, run `cat .bash_aliases`

#### Composer
1. Ensure you're in the root directory
    - `cd ~/pronto`
2. Composer install
    - `composer install`

#### Docker
1. Open up a new terminal
2. Navigate to the root directory
    - `cd ~/pronto`
3. Build your containers
   - `docker-compose up --build`

#### Tests
1. Ensure you're in the root directory
    - `cd ~/pronto`
2. Run the PHPUnit tests
   - `run_tests`

#### Postman
1. Import collection from `~/pronto/storage/Pronto.postman_collection.json`
2. Set up a new postman environment
   1. Click the gear icon in top-right corner
   2. Click `Add`
   3. Create an environment name
   4. Add a `url` variable with `localhost:8080` as the initial value
   5. Click `Add`
   6. Select the environment from the drop-down in the top-right corner
3. Requests can be found within the `Pronto` collection
