# demo-shortify
Demo Shortify is a URL shortly app based on laravel for learning purposes,
It was made to just a POC so always can be upgraded / optimize.

## Development - Getting started

In order to be more productive the project will be running with homestead / vagrant. Please follow the next steps in order to get running the environment.

*  for install homestead with laravel you can follow this simple steps:
[Laravel 5.8 homestead installation]( https://laravel.com/docs/5.8/homestead#installation-and-setup
)

In case you want to use/run docker instead of homestead, Pull request are always welcome, send a pull request to our repository:

- https://docs.docker.com/
- https://www.digitalocean.com/community/tutorials/how-to-set-up-laravel-nginx-and-mysql-with-docker-compose

### Development environment setup
1.  go to the local directory for this project

2. clone this repository

3. create your .env file or just copy and rename the .env.example

4. edit the .env with the right values.

5. generate an app key with:
```
$ php artisan key:generate
```

6. setup your hosts file and edit your .env with the rigth values
```
APP NAME
APP URL
Database info
```

7. perform a a migration to start the app
```
$ php artisan migrate
```

### Congratulations!
You have the project working, lets start shortify urls :)

### Hash / Code Generate
we have 2 types  of code on traits for generate  a `code` or `hash`, one just take the `Str:uuid` and the other its an str random shuffle, when a code or hash its already detected on the system it tried to generate a new one, we do try to make your url be the short as possible staring with 3 chars. 

we can  always improve our generare perform: 
[by adopting others algithms]( https://www.quora.com/What-are-the-http-bit-ly-and-t-co-shortening-algorithms )

### Endpoints
![list available endpoints](https://cdn1.imggmi.com/uploads/2019/5/19/f1e7050137aa7a3cce25d66545419cca-full.png)

```
POST: /api/urls : set an shortify url, it return an array with the shortify URL,  the url you are shortifying, a hashe and a code, the hash is the URL for your shortify ex. sBv and the code is an access token point to get more specific info about your shortify URL or even deleted from the system.

![shortify created succefully](https://imgur.com/0yfxCs1)

GET: /api/urls/{hash} : with this you can get the info for your shortify URL, you need to pass an aditional query string `code` in order to get this info, so nobody except you and us have access to this sencitive info.

DEL: /api/urls/{hash} : with this endpoint you can destroy from the system your shortify URL, you need to pass an aditional query string `code` to be deleted from our system; dont worry if you dont do it; We have have unlimited expiration time for now.

GET: /api/top : get the top 100 urls sort by access, this is an enpoint for us to track the most visited shortify url. The top result is paginate.  and btw dont worry on the top endpoint we dont show the your code access token, so its safe only for you.
```
##features / validations

We dont allow  porn on our website, for that we have an blacklist rule, so  you cant shortify urls that have certain words on it, of you think it is a mistake, send us the link at contact@shortify.com and we will sort it out for you adding it to our whitelist in case passes our internal validation.

![blacklist words](https://imgur.com/qI4GBNe)

## tests cases
we make a few case scenerario in order to keep the code up and running, in the future we can set a few CI with the test.
```
$ php phpunit
```
![tests cases](https://imgur.com/a/IXJQNdb)

## Licenses
shortify is a software licensed under the [MIT license](https://opensource.org/licenses/MIT).

The Laravel framework is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
