# API

### pets

* [`GET /pets/{petId}`](#getpetstype2) Info for a specific pet
* [`GET /pets`](#getpets) List all pets
* [`POST /pets`](#postpets) Create a pet



## Operations

### `GetPets`



_Endpoint_: `/pets`

_Namespace_: `Swaggest\RestClient\Tests\Petstore\Pets\Operation`

#### Request
Type: `Swaggest\RestClient\Tests\Petstore\Pets\Request\GetPetsRequest`

|Name   |Type |In     |Description                                   |
|-------|-----|-------|----------------------------------------------|
|`limit`|`int`|`query`|How many items to return at one time (max 100)|





#### Response


|Status|Type                                                           |Description           |
|------|---------------------------------------------------------------|----------------------|
|200 OK|[`Pets`](#swaggestrestclienttestspetstorepetsdefinitionspets)  |An paged array of pets|
|      |[`Error`](#swaggestrestclienttestspetstorepetsdefinitionserror)|unexpected error      |

### `PostPets`



_Endpoint_: `/pets`

_Namespace_: `Swaggest\RestClient\Tests\Petstore\Pets\Operation`

#### Request
Type: `Swaggest\RestClient\Tests\Petstore\Pets\Request\PostPetsRequest`




#### Response


|Status     |Type                                                           |Description     |
|-----------|---------------------------------------------------------------|----------------|
|201 Created|                                                               |Null response   |
|           |[`Error`](#swaggestrestclienttestspetstorepetsdefinitionserror)|unexpected error|

### `GetPetsType2`



_Endpoint_: `/pets/{petId}`

_Namespace_: `Swaggest\RestClient\Tests\Petstore\Pets\Operation`

#### Request
Type: `Swaggest\RestClient\Tests\Petstore\Pets\Request\GetPetsType2Request`

|Name   |Type    |In    |Description                  |
|-------|--------|------|-----------------------------|
|`petId`|`string`|`path`|The id of the pet to retrieve|





#### Response


|Status|Type                                                           |Description                         |
|------|---------------------------------------------------------------|------------------------------------|
|200 OK|[`Pets`](#swaggestrestclienttestspetstorepetsdefinitionspets)  |Expected response to a valid request|
|      |[`Error`](#swaggestrestclienttestspetstorepetsdefinitionserror)|unexpected error                    |



## Structures

#### Swaggest\RestClient\Tests\Petstore\Pets\Definitions\Error
|Name     |Type    |
|---------|--------|
|`code`   |`int`   |
|`message`|`string`|

#### Swaggest\RestClient\Tests\Petstore\Pets\Definitions\Pet
|Name  |Type    |
|------|--------|
|`id`  |`int`   |
|`name`|`string`|
|`tag` |`string`|

#### Swaggest\RestClient\Tests\Petstore\Pets\Definitions\Pets
[`Pet`](#swaggestrestclienttestspetstorepetsdefinitionspet)[]&#124;`array`

