# PHP & MySql Project

Welcome to my PHP & MySql project made for the Master in Back-End Development for Start2impact University.

## :desktop_computer: The project

The project is a REST API made for a startup born to help people to better undestand and get accessibility the statal bonuses and services. The API will help the creation of a dashboard to view all the information. (No front-end code)

## :gear: Instruction

- Copy the repository from my Github
- Open the file called `migrations.sql` and copy the code in your sql query to create the table and the column. (You should create a new database first)
- Start a web server (integrated with SQL and PHP) such as Laragon or similar. (Need a PHP, Apache, HTTP environment)
- Open the terminal (you should change the directory to the one copied) and digit `php -S localhost:8888`
- Now you can use POSTMAN or similar to test the API

## :page_facing_up: Documentation

### Project Structure

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

## :clipboard: REST API

Base Path: `http://localhost:8888/api`

### Data

`service-type`:

```
{
    id: 1,
    name: service,
    time_saved: 01:00
}
```

`service-provided`:

```
{
     id: 1,
     service-type-id: 1,
     quantity: 1,
     selling_date: 2023/01/01
}
```

### Read Data | GET Method:

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

---

`api/service-type/{id}`: Return the service with the ID indicated

JSON Response:

```
{
    "id": 1,
    "name": "service_name",
    "time_saved": "00:01:00"
}
```

---

`api/service-provided`: Return all the services provided.

JSON Response:

```
{
    "provided": [
        {
            "id": 1,
            "service_type_id": 1,
            "name": "service_name",
            "time_saved": "00:01:00",
            "selling_date": "2023-01-01",
            "quantity": 1
        }
    ]
},
```

---

`api/service-provided?name=service_name&from=from_date&to=to_date`: Return the services provided filtered by these params. (These params are optional and you can use all of them or just the one you need)

- `name`: filter the services provided by matching the service name indicated
- `from`: filter the services provided whose selling date is later the date indicated
- `to`: filter the services provided whose selling date is before the date indicated

JSON Response:

```
{
    "provided": [
        {
            "id": 1,
            "service_type_id": 1,
            "name": "service_name",
            "time_saved": "00:01:00",
            "selling_date": "2023-01-01",
            "quantity": 1
        }
    ]
},
```

---

`api/service-provided/{id}`: Return the service provided with the ID indicated.

JSON Response:

```
 {
    "id": 1,
    "service_type_id": 1,
    "name": "service_name",
    "time_saved": "00:01:00",
    "selling_date": "2023-01-01",
    "quantity": 1
 }
```

---

`api/total-time-saved`: Return both the total time saved for all the services in the database and the total time saved per service provided grouped by his name.

JSON Response:

```
{
    "Total Time Saved with our services": "01:00:00",
    "Time Saved per service": [
        {
            "time_saved": "00:30:00",
            "name": "service_name"
        },
    ]
}
```

### Create Data | POST Method:

`api/service-type`: Create a new service in the database. The body is required. Check the example below.

Body Example:

```
{
    name: new_service_name,
    time_saved: time_value
}
```

---

`api/service-provided`: Create a new service provided in the database based on an existing service type. The body is required. Check the example below

Body Example:

```
{
    service_type_id : service_id,
    quantity: number,
    selling_date: date
}
```

---

### Update Data | PATCH Method:

`api/service-type/{id}`: Modify an existing service. One of the property is required

Body Example:

```
{
    name: new_service_name,
    time_saved: time_value
}
```

---

`api/service-provided/{id}`: Modify an existing service provided. One of the property is required

Body Example:

```
{
    quantity: number,
    selling_date: date
}
```

---

### Delete Data | DELETE Method:

`api/service-type/{id}`: Delete an existing service

JSON Response:

```
{
    "Message": "Service deleted",
    "Service": "ID: 1"
}
```

`api/service-provided/{id}`: Delete an existing service provided

JSON Response:

```
{
    "Message": "Service provided deleted",
    "Service provided": "ID: 1"
}
```

## :incoming_envelope: Contact me

If you find some bugs to fix or simply you want to send me a message please write me at [brianmoretti2512@gmail.com](mailto:brianmoretti2512@gmail.com)
