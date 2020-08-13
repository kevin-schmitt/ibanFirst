# Iban First wallet visualisation

This project use iban first public api for wallet visualisation and these financial movements . Contain complete stack front  back and docker for installation

## Stack
- php
- symfony 5 (jwt, cors, json api)
- docker
- mysql
- vuejs (grid, npm)

## Installation
This project require docker and docker-compose, you need npm too run front side no include in container.
In root of project (check you have permission)

```bash
docker-compose up -d
make init
cd front
npm install
npm run serve
```

## Usage

For authentification in login form
``` json
login:johndoe
password:test
```

## Technical description
File structure back
```
back/
    src/
        Controller
            WalletController # 2 routes for get wallet and financial movements, all endpoints are protect with jwt
        Api
            IbanFirstApi # get data from ibanFirst api with connexion x-wsse
        DataFixtures
            AppFixture #fixture for create demo user
        Exception
            IbanFirstApiException # custom exception for problem with public api
        Utils
            FiltreArrayTrait # Permit to select data in array with FiltreArrayTrait
     

```
File structure front
```
front/
    src/
        components
            FinancialMovements # search financial movements by wallet code
            Login # form for authentification
            Wallet # for display all wallet
    axios # for http request and token authentifcation with jwt
```


## Endpoints

POST /api/login_check - get jwt token with username and password
``` json
{
  {"username":"johndoe","password":"test"}
}
```
response
``` json
{
  "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.
            eyJpYXQiOjE1OTcyMzA1NzEsImV4cCI6MTU5NzIzNDE3MSwicm9sZX
            MiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoiam9obmRvZSJ9.IsznvRlpPVMZ
            pYh3ypyMLM4DJYzx3ntOFzOGgfaJrMMgBj7KPFd1pTWzZZ6QhDhCqhgDbCDnm4wuFyUAKImp4l1Z
            sBotnAF4b72vwEkSr1pvhh1fNaG6z_4cnX8XBhXi4zx5NzcJBG1u7mwDj6NMVuw8G4OAwSfu3Y6G1KWxyCC2ZW-Q-Hq
            hTsDo0epkxqJD919xN-1DDsfsrcTZQ7hFG6i0qqjvnydSEFzY_AiyAk-87Wg-TmpqIeT8EG8E791Wxe8CnsXRWcLAav2u4lAiYdNo
            XEXIOiIWZeKCDqr6RAs26bEGZzOtM8NBUMfF-kFfKjZZGlg4COZdbdizLkePfOwNM_5KnCRMx6r-DH5DIcub3qos9i3VNOr8coucMmKqOH
            MRXP_WIiWxuKtqPw1Pn9svkVYrrWHfTRDtoed18Abx2366Kpv8oApsNl5Mab8T2NE6Pv9qKK6hcHHlUtAeH5HVFu8tOnvIYvVLjU3Lm5ey
            DFm4AXP-gmxZiyShh-aBucWWc99hHubxLpFiN_-CKtl0ff2hI692LWP-_4ipTm015tUwDDgFgDcdkPUHUrKyjjmt9cfuzsNMaQfrw_fCC3H
            sWwmzWNR23DeID1PZLemwRCJlbnQPJ05V2ziTIQr21tYZpxfZRQXEl5ySIbjyrqUWoGO6nRXD5iFNC33GGc8"
}
```

GET /api/wallets - get all wallets
response
``` json
{
  "wallets": [
    {
      "id": "NDgyODM",
      "tag": "86f7e437faa5a7f",
      "currency": "EUR",
      "bookingAmount": {
        "value": "57.85",
        "currency": "EUR"
      },
      "valueAmount": {
        "value": "57.85",
        "currency": "EUR"
      },
      "dateLastFinancialMovement": "2020-04-02 15:25:51"
    },
    {
      "id": "NDgyODY",
      "tag": "86f7e437faa5a7f",
      "currency": "USD",
      "bookingAmount": {
        "value": "50002.75",
        "currency": "USD"
      },
      "valueAmount": {
        "value": "50002.75",
        "currency": "USD"
      },
      "dateLastFinancialMovement": "2020-04-09 08:57:56"
    }
  ]
}
```

GET /api/wallets/{idWallets}/financial_movements - get all financial movements for one wallet
response
``` json
 [
    {
      "id": "MTEyOTU1Mg",
      "bookingDate": "2019-08-19",
      "valueDate": "2019-08-19",
      "walletId": "NDgyODM",
      "amount": {
        "value": "-5027.48",
        "currency": "EUR"
      },
      "description": "a085677f370c890 - Buy/sell currencies"
    },
    {
      "id": "MTEyOTU1NA",
      "bookingDate": "2019-08-19",
      "valueDate": "2019-08-19",
      "walletId": "NDgyODM",
      "amount": {
        "value": "-980.27",
        "currency": "EUR"
      },
      "description": "a085677f370c890 - Buy/sell currencies"
    }
]
```

## Todo
- Add functional test with behat and selenium
- Add functional test for json (with mock api)
- Use interface for IbanFirstApi
- Use symfony normalizer and no trait for filter financial movements
- Add crud for add and update wallet
- add docker fro front side
- add swagger with nelmio