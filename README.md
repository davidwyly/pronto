# pronto

## Summary
This is a project for a code challenge: Write a program in whatever language you prefer that takes an array of integers and decides whether those integers conform to Benford's Law.

This project was written in PHP 7.4. It exists within a bare-bones RESTful API mini-framework that I previously wrote for testing sample code through Postman HTTP requests.

The `margin of error` is calculated for each distribution of a leading digit (1-9). If the `actual distribution percentage` is within the `expected distribution percentage` plus or minus the `margin of error`, the assumption is made that the distribution of that leading digit conforms to Benford's law.

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

#### Fibonacci Endpoint Results (1000 iterations)

```json
{
    "zScore": 0.4621525165147706,
    "standardDeviation": 2.460911840575985,
    "1": {
        "expected": "30.103%",
        "actual": "30.1%",
        "variance": "-0.003%",
        "margin-of-error": "0.6704%",
        "conforms-to-benford's-law": true
    },
    "2": {
        "expected": "17.6091%",
        "actual": "17.7%",
        "variance": "0.0909%",
        "margin-of-error": "0.5578%",
        "conforms-to-benford's-law": true
    },
    "3": {
        "expected": "12.4939%",
        "actual": "12.5%",
        "variance": "0.0061%",
        "margin-of-error": "0.4833%",
        "conforms-to-benford's-law": true
    },
    "4": {
        "expected": "9.691%",
        "actual": "9.6%",
        "variance": "-0.091%",
        "margin-of-error": "0.4305%",
        "conforms-to-benford's-law": true
    },
    "5": {
        "expected": "7.9181%",
        "actual": "8%",
        "variance": "0.0819%",
        "margin-of-error": "0.3965%",
        "conforms-to-benford's-law": true
    },
    "6": {
        "expected": "6.6947%",
        "actual": "6.7%",
        "variance": "0.0053%",
        "margin-of-error": "0.3654%",
        "conforms-to-benford's-law": true
    },
    "7": {
        "expected": "5.7992%",
        "actual": "5.6%",
        "variance": "-0.1992%",
        "margin-of-error": "0.336%",
        "conforms-to-benford's-law": true
    },
    "8": {
        "expected": "5.1153%",
        "actual": "5.3%",
        "variance": "0.1847%",
        "margin-of-error": "0.3274%",
        "conforms-to-benford's-law": true
    },
    "9": {
        "expected": "4.5757%",
        "actual": "4.5%",
        "variance": "-0.0757%",
        "margin-of-error": "0.303%",
        "conforms-to-benford's-law": true
    }
}
```

#### Custom Array Endpoint Results

```json
{
    "zScore": 1.6379464099227126,
    "standardDeviation": 2.1521345609224443,
    "1": {
        "expected": "30.103%",
        "actual": "14.2574%",
        "variance": "-15.8456%",
        "margin-of-error": "2.5484%",
        "conforms-to-benford's-law": false
    },
    "2": {
        "expected": "17.6091%",
        "actual": "23.7624%",
        "variance": "6.1533%",
        "margin-of-error": "3.1023%",
        "conforms-to-benford's-law": false
    },
    "3": {
        "expected": "12.4939%",
        "actual": "19.2079%",
        "variance": "6.714%",
        "margin-of-error": "2.8713%",
        "conforms-to-benford's-law": false
    },
    "4": {
        "expected": "9.691%",
        "actual": "0%",
        "variance": "-9.691%",
        "margin-of-error": "0%",
        "conforms-to-benford's-law": false
    },
    "5": {
        "expected": "7.9181%",
        "actual": "14.2574%",
        "variance": "6.3393%",
        "margin-of-error": "2.5484%",
        "conforms-to-benford's-law": false
    },
    "6": {
        "expected": "6.6947%",
        "actual": "9.505%",
        "variance": "2.8103%",
        "margin-of-error": "2.1377%",
        "conforms-to-benford's-law": false
    },
    "7": {
        "expected": "5.7992%",
        "actual": "19.0099%",
        "variance": "13.2107%",
        "margin-of-error": "2.86%",
        "conforms-to-benford's-law": false
    },
    "8": {
        "expected": "5.1153%",
        "actual": "0%",
        "variance": "-5.1153%",
        "margin-of-error": "0%",
        "conforms-to-benford's-law": false
    },
    "9": {
        "expected": "4.5757%",
        "actual": "0%",
        "variance": "-4.5757%",
        "margin-of-error": "0%",
        "conforms-to-benford's-law": false
    }
}
```
