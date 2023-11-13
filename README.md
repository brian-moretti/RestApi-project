# PHP & MySql Project

Welcome to my PHP & MySql project made for the Master in Back-End Development for start2impact university.

## The project

The project is a REST API made for a startup that helps the people to make accessible the statal bonuses and services. The API will help the creation of a dashboard to view all the information. (No front-end code)

### Project Structure

The Database is create with MySql. The file `migrations.sql` containt the sql code to create the database you need to test or use the API

The structure of the project is the following:

_/api<br>
&nbsp;/config
&nbsp;&nbsp;/database.php
&nbsp;/controllers
&nbsp;&nbsp;/MethodGateway.php
&nbsp;/models
&nbsp;&nbsp;/ServiceType.php
&nbsp;&nbsp;/ServiceProvided.php
&nbsp;/service-type
&nbsp;&nbsp;/index.php
&nbsp;/service-provided
&nbsp;&nbsp;/index.php
&nbsp;/total-time-saved
&nbsp;&nbsp;/index.php _

### REST API

Base Path: `http://localhost:8888/api`

#### Read Data | GET Method:

`api/service-type`:  
`api/service-type/{id}`:

JSON Response:
`[{}]`

---

`api/service-provided`:
`api/service-provided/{id}`:

JSON Response:
`[{}]`

#### Create Data | POST Method:

`api/service-type`:
Body Example:
`{}`

---

`api/service-provided`:

Body Example:
`{}`

#### Update Data | PATCH Method:

`api/service-type/{id}`:
Body Example:

---

`api/service-provided/{id}`:
Body Example:

#### Delete Data | DELETE Method:

`api/service-type/{id}`:
`api/service-provided/{id}`:

_ /api/service-type _ : This endpoint will provide you all the services with GET Method and allow the creation of a new service with the POST Method (Body required)
_ /api/service-type/{id} _ : This endpoint will provide you the information about a specific service with the GET Method, will allow you to modify the service with the PATCH Method and to delete the service with the DELETE Method
_ /api/service-provided _ : This endpoint will provide you information about all the services provided with the GET Method, and allow you to provide a new service with the POST Method (Body required)
_ /api/service-provided/{id} _ : This endpoint will provide you the information about a specific service provided with the GET Method, will allow you to modify the service with the PATCH Method and to delete the service with the DELETE Method
_ /api/total-time-saved _ :
