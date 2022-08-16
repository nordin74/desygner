# Desyner Test

## Get Started
- First, you will need to install git, docker, docker-compose, curl on your computer.
- Clone the repo `git clone <this repository url>`
- The test is enclosed in 2 directories: backend, frontend
- Execute the command in the root folder to run the containers, setup dependencies:
  `docker-compose up` and wait till you see the message: "DESYGNER APP READY :)"

### Backend

- Inside the directory backend execute the commands to populate some data(Administrator task):  
  - `curl -F 'type=file' -F 'resource=' -F 'img=@assets/crane.jpeg' -F 'tags[]=crane' -F 'tags[]=origami' -F 'providerName=Will' http://localhost:8888/files`  
  - `curl -X POST -d 'type=url' -d 'resource=https://upload.wikimedia.org/wikipedia/commons/3/3b/Symfony.jpg' -d 'tags[]=php' -d 'tags[]=symfony' -d 'providerName=Daniel' http://localhost:8888/files`  
  - `curl -X POST -d 'type=url' -d 'resource=https://afrentesistemas.com.br/wp-content/uploads/2022/05/Php.png' -d 'tags[]=php' -d 'tags[]=elephant' -d 'providerName=Nordin' http://localhost:8888/files`  
  
  Later you can search in the UI(frontend) by the tag: crane, php, elephant, symfony, origami  

- To run the static analyzer execute in the backend dir:  
  `docker-compose exec backend vendor/bin/phpstan analyse -l 5 --xdebug src`
- The API is running on http://localhost:8888   

### Frontend

- You go to the frontend via: http://localhost:3000
- You can search images by tags(after writing 3 letters)
- You can add images to the library
- I've created a folder `frontend/src` that contains all the logic for the requested task.
  Later a transpiled/minified file is created from that directory in `frontend/build/dist/main.js`   
  The remaining folder/files contains the resources to make the resources to make desygner page works, ignore them
- To execute the tests go frontend folder and run:
  `yarn jest`


## Final Thoughts
- My intention here is to show up my PHP skills using symfony and their related packages.
- I used Serve, Nginx & PHP-FPM for this application to achieve great performance.
- There are missing points I would have liked to achieve, but due to time I couldn't. I'm going to mention them anyway:
  - Cache the result
  - Setup preloading & jit to reach higher performance.
    I have a project which focus on performance & microservices: https://github.com/nordin74/sample-code-sf.
  - Setup tests in the frontend.
  - Setup Nginx for the frontend instead Serve package.   
  - If this was not a test, but a real project I would setup to upload directly to some storage-node,
    something similar to aws, previous token authorizations  
  - The project lack of test in the backend for that I decided to use phpstan to detect errors. I have a project
    focus on testing, maybe you could find it interesting: https://github.com/nordin74/associative-json-assertions.

### Thanks!
