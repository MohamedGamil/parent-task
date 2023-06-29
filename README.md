# Parent ApS: Full Stack Assessment

## Getting Started
In order to test this app, first make sure that **docker** and **NodeJS** are installed on your local machine, then follow these steps:

+ Clone this repository by running the following command somewhere on your local machine:
```shell
git clone git@github.com:MohamedGamil/parent-task.git parent-aps-task
```

+ Run the following command to quickly spin up backend and frontend servers:
```shell
cd ./parent-aps-task
npm run serve
```

That's it. You can now test the application on your local machine 🥳

> Application services are served using the following ports by default:
> + **Frontend**: `http://localhost:4200`
> + **Backend**: `http://localhost:8000`

- - -

## Testing
To run backend tests, make sure you already have the app services up and running, then run the following command:

```shell
cd ./parent-aps-task
npm run test
```

- - -

## Overview

![Transactions Explorer](./screenshot.png)

The application's user interface (UI) has been designed to meet the task's requirements, featuring a straightforward and intuitive design. However, the backend functionality of the application is considerably more complex in comparison.

The backend code has been meticulously structured to adhere to SOLID principles, ensuring efficient implementation. Despite being somewhat complex, the backend code structure maintains an inherent flexibility, allowing for seamless extension and efficient development workflows.

- - -


## The Challenge
We have two providers collect data from them in json files we need to read and make some filter operations on them to get the result

DataProviderX data is stored in [DataProviderX.json]
DataProviderY data is stored in [DataProviderY.json]

`DataProviderX` schema is:

```json
{
    "parentAmount": 200,
    "Currency": "USD",
    "parentEmail": "parent2@parent.eu",
    "statusCode": 1,
    "registerationDate": "2018-11-30",
    "parentIdentification": "d3d29d70-1d25-11e3-8591-034165a3a610"
}
```

`DataProviderY` schema is:

```json
{
    "balance": 300,
    "currency": "AED",
    "email": "parent2@parent.eu",
    "status": 100,
    "created_at": "22/12/2018",
    "id": "sfc2-a8d1"
}
```

`DataProviderX` and `DataProviderY` have three status codes which corrosponds to a status state as follows:

+ `authorised`: **1** for `DataProviderX`, **100** for `DataProviderY`
+ `decline`: **2** for `DataProviderX`, **200** for `DataProviderY`
+ `refunded`: **3** for `DataProviderX`, **300** for `DataProviderY`


- - -

## Acceptance Criteria

Using PHP Laravel, implement this API endpoint `/api/v1/users` based on the following:

+ [✅] it should list all users which combine transactaions from all the available provider `DataProviderX` and `DataProviderY`
+ [✅] it should be able to filter resullt by payment providers for example `/api/v1/users?provider=DataProviderX` it should return users from `DataProviderX`
+ [✅] it should be able to filter result three `statusCode` (`authorised`, `decline`, `refunded`) for example `/api/v1/users?statusCode=authorised` it should return all users from all providers that have status code authorised
+ [✅] it should be able to filer by amount range for example `/api/v1/users?balanceMin=10&balanceMax=100` it should return result between **10** and **100** including **10** and **100**
+ [✅] it should be able to filer by `currency`
+ [✅] it should be able to combine all this filter together
