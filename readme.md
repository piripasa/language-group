# Language Group

A command-line application that will list all the countries which speaks the same language or checks if given two countries speak the same language by using open rest api: https://restcountries.eu/.

## Language & tools

- PHP7
- Composer (for installing dependencies)

## Installation

- Download or clone the repository.
- `cd project_directory/` into the project root directory.
- Run `composer install` to install dependencies

## How to Use
Run the following command from your terminal:

#### To get country code and other countries that speak the same languages

```bash
php index.php [Country name]
```

##### Parameters
| Parameter  | Required | Default | Example |
| :---        | :---: | :-------- | --- |
| Country name  | Yes  | None | Spain |

```bash
php index.php Spain
```

#### To check if two countries are speaking the same languages or not.

```bash
php index.php [First country name] [Second country name]
```

##### Parameters
| Parameter  | Required | Default | Example |
| :---        | :---: | :-------- | --- |
| First country name  | Yes  | None | Spain |
| Second country name  | Yes  | None | Bangladesh |

```bash
php index.php Spain Bangladesh
```

## Tests
```bash 
./vender/bin/phpunit
```