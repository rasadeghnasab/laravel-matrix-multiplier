About YOU technical test:

# Prerequisites

You have to have `docker` and `docker-composer` installed on your system in order to run this project.

---
# Up and Running
1. clone the repository
    - `git clone git@gitlab.com:rasadeghnasab/about_you_test`

2. cd to the repository directory
    - `cd about_you_test`
    
3. up and run the whole project
    - `make project`

---
# Useful make commands

Here we listed some useful commands that you can use to develop the application:

### Docker commands
- Run all the necessary containers to make project work and accessible through a URI and PORT
    - `make up`
    
- Stop all the containers and free resources and ports
    - `make down`

### Back-end commands

- Install laravel composer packages and create `.env` file from the `.env.example`
    - `make laravel-dep`

- Run all the tests
    - `make test`
    
- You can run a specific test by passing the `filter` argument to the command
    - `make test filter=TEST_FILE_OR_FUNCTION`

### Front-end commands

- Install npm dependencies
    - `make node-dep`
    
- Build front-end files for production
    - `make front-production`
    
- Start developing the front-end system and watching for changes
    - `make front-dev`
