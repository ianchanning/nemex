# Nemex
This is taken from the awesome <http://nemex.io>.

Its a simple way of creating notes on your own webserver. 
Notes written in [markdown](http://daringfireball.net/projects/markdown/).
No database required.

As of the initial release all files are the same as the downloadable v0.98.

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
1. Copy config-sample.php to config.php and edit the `usr` and `pwd` properties
1. Go to <http://www.mydomain.com/nemex>

## License
GPL v3