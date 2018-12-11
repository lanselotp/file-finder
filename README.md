# Local laravel file finder

File finder is simple search package for finding .txt files by content in all directories or specific ones.


# Installation

- Publish Assets and Default files content

```
$ php artisan vendor:publish --tag=public --force
$ php artisan vendor:publish --tag=files --force

```

- FineFinderService provider is loaded automatically by laravel autodiscovery if version >= 5.5

- Testing demo after installation : http://example.com/file-finder-demo

- Ignored folders for searching files - **vendor, node_modules, bower_components**

# Demo image

![image](https://user-images.githubusercontent.com/19529749/49754622-43b9c000-fcbf-11e8-833b-41d212fb9c50.png)

# Results

```ruby
{
  "searchedString": "lore",
  "searchedFilesCount": 5,
  "foundFilesCount": 3,
  "files": [
{
    "name": "text_file.txt",
    "directory": "my_custom_folder",
    "pathName": "my_custom_folder",
    "extension": "txt",
    "size": 2019,
    "positionString": 8
  },
  {
    "name": "text_file2.txt",
    "directory": "my_custom_folder",
    "pathName": "my_custom_folder",
    "extension": "txt",
    "size": 2019,
    "positionString": 8
  },
  {
    "name": "text_file3.txt",
    "directory": "my_custom_folder",
    "pathName": "my_custom_folder",
    "extension": "txt",
    "size": 2019,
    "positionString": 8
  }
  ]
}
```
