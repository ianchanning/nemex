# Nemex
This is taken from the awesome <http://nemex.io>.

It's a simple way of creating notes on your own webserver.
Notes written in [markdown](http://daringfireball.net/projects/markdown/).
No database required.

Since I created this repo, nemex themselves have created their own [github repo](https://github.com/neonelephantstudio/nemex).

This fork is a merge of nemex with my own [Vanda PHP micro framework](https://github.com/ianchanning/vandaphp).

## Requirements

- PHP 5.3
- PECL [ZipArchive](http://php.net/manual/en/zip.installation.php) to download projects as zip files

## Installation

### No source control
1. Download the zip file
1. Unzip it and FTP the files to your webserver e.g httpdocs/nemex

### Git
1. Create a directory on your webserver e.g. nemex and change directory to it
1. `$ mkdir nemex`
1. `$ cd nemex`
1. `$ git clone https://github.com/ianchanning/nemex.git .`

## Configuration
1. `cd app/Config`
1. `cp Config-sample.php Config.php`
1. edit the `USER` and `PASSWORD` constants in `Config.php`
1. Create `PROJECTS_PATH` directory relative to `app/Models`
1. Go to <http://www.example.com/nemex>

## License
GPL v3