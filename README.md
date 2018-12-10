# Local laravel file finder

File finder is simple search package for finding .txt files by content in all directories or specific ones.


# Installation

- Publish Assets and Default Data Samples

```
$ php artisan vendor:publish --tag=public --force
$ php artisan vendor:publish --tag=files --force

```

- FineFinderService provider is loaded automatically by laravel autodiscovery if version >= 5.5
- Testing demo after installation : http://domain.example/file-finder-demo
