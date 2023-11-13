# PHP & MySql Project

Welcome to my PHP & MySql project made for the Master in Back-End Development for start2impact university.

## The project

The project is a REST API made for a startup that helps the people to make accessible the statal bonuses and services. The API will help the creation of a dashboard to view all the information. (No front-end code)

### Project Structure

The Database is create with MySql. The file `migrations.sql` containt the sql code to create the database you need to test or use the API

The structure of the project is the following:

```
└── /api/
    ├── /config/
    │   └── /database.php
    ├── /controllers/
    │   └── /MethodGateway.php
    ├── /models/
    │   ├── /ServiceType.php
    │   └── /ServiceProvided.php
    ├── /service-type/
    │   └── /index.php
    ├── /service-provided/
    │   └── /index.php
    └── /total-time-saved/
        └── /index.php
```

### REST API

Base Path: `http://localhost:8888/api`

#### Data

`service-type`: `{ id: 1, name: service, time_saved: 01:00 }`  
`service-provided`: `{ id: 1, service-type-id: 1, quantity: 1, selling_date: 2023/01/01 }`

#### Read Data | GET Method:

`api/service-type`: Return all the services in the database

JSON Response:

```
{
    "type": [
        {
            "id": 1,
            "name": "service_name",
            "time_saved": "00:01:00"
        },
    ]
}
```

`api/service-type/{id}`: Return the services with the ID indicated

`api/service-provided`: Return all the services provided.  
`api/service-provided?name=service_name&from=from_date&to=to_date`: Return the services provided filtered by these params. All are optional and you can use all of them or just the one you need.

- `name`: filter the services provided by matching the service name indicated
- `from`: filter the services provided whose selling date is later the date indicated
- `to`: filter the services provided whose selling date is before the date indicated

`api/service-provided/{id}`: Return the services provided with the ID indicated.  

JSON Response:
`[{}]`

#### Create Data | POST Method:

`api/service-type`: Create a new service in the database. The body is required. Check the example below.  
Body Example:
`{ name: new_service_name, time_saved: time_value }`

---

`api/service-provided`: Create a new service provided in the database based on an existing service type. The body is required. Check the example below

Body Example:
`{ service_type_id : service_id, quantity: number, selling_date: date }`

#### Update Data | PATCH Method:

`api/service-type/{id}`: Modify an existing service. One of the property is required
Body Example:
`{ name: new_service_name, time_saved: time_value }`

`api/service-provided/{id}`: Modify an existing service provided. One of the property is required
Body Example:
`{ service_type_id : service_id, quantity: number, selling_date: date }`

#### Delete Data | DELETE Method:

`api/service-type/{id}`: Delete an existing service
`api/service-provided/{id}`: Delete an existing service provided

_ /api/service-type _ : This endpoint will provide you all the services with GET Method and allow the creation of a new service with the POST Method (Body required)
_ /api/service-type/{id} _ : This endpoint will provide you the information about a specific service with the GET Method, will allow you to modify the service with the PATCH Method and to delete the service with the DELETE Method
_ /api/service-provided _ : This endpoint will provide you information about all the services provided with the GET Method, and allow you to provide a new service with the POST Method (Body required)
_ /api/service-provided/{id} _ : This endpoint will provide you the information about a specific service provided with the GET Method, will allow you to modify the service with the PATCH Method and to delete the service with the DELETE Method
_ /api/total-time-saved _ :
