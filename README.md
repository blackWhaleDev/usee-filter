# blackWhaleDev-filter

The `blackWhaleDev/filter` package provides easy to writing global queries for filtering.

Here's a demo of how you can use it:

```php
pipe(New User(),
    [
        NameFilter::class,
    ])->paginate(10);
```

You can create your own filter class using artisan command :
```bash
php artisan make:filter ClassName ColumnName 
``` 

This Command have some option:
```bash
--type --second --relation=
```

## Support us

You can support me by using this package and help me to improve it

## Documentation


For EXP: you have search page and you want set some filters for that page, 
and this filters should be apply on User class.

first with `artisan` call we create 2 class (Name and LastNameLike):

name:
```bash
php artisan make:filter Name FirstName
```
this command will generate "Name.php" file in "App\QueryFilters" Folder

*Note*: the column that we want make filter on it is "first_name" but we should write it in CamelCase and also
in the HTML form input name should be the same of column name "first_name"

now second class :
```bash
php artisan make:filter LastName LastName --type=like
```
this command will generate "likeLastName.php" file in "App\QueryFilters" Folder

now call `pipe()` helper into your function

```php
pipe(New User::class, [
    Name::class,
    likeLastName::class, // --type = like
])->paginate(10);
```
just it ;) !!!

when request come into the helper its go to the Name Class and check if request has "name"
it will be check and if request do not has "name" it will be go to next request (next class) without check


Find yourself stuck using the package? Found a bug? Do you have general questions or suggestions for improving the filter system? Feel free to [create an issue on GitHub](https://github.com/usee1993/usee-filter/issues), I'll try to address it as soon as possible.

If you've found a security issue please mail [alizade488@gmail.com](mailto:alizade488@gmail.com) instead of using the issue tracker.

## Type of Artisan Call
*Single*: 

```bash
php artisan make:filter Name FirstName
```

its default type

*like*: 

```bash
php artisan make:filter Name FirstName --type=like
```

its "Like" Query

*between*: 

```bash
php artisan make:filter Name StartDate --type=between --second=EndDate
```

in this type you should pass "--second" option and it will check data between two time
or anything else...

*--relation*: 

```bash
php artisan make:filter Name StartDate --type=relation --relation=RelationName
```

in this type you should pass "--relation" option  and it will check data whereHas that relation

## Installation

You can install the package via composer:

``` bash
composer require youness_usee/filter
```

The package will automatically register itself.

*Note*: Please Keep CamelCase Style


## Security

If you discover any security related issues, please email alizade488@gmail.com instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
