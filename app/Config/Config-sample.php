<?php

namespace Config;

class Config {
    const USER = 'nemex';
    const PASSWORD = 'io';

    const FILE_CREATION_MODE = 0777;
    const DATE_FORMAT = 'j. F Y';

    const PROJECTS_PATH = 'projects'.DIRECTORY_SEPARATOR;

    /**
     * Maximum width for Images. Beyond this, a scaled down version is
     * created
     */
    const IMAGE_BIG_PATH = 'big'.DIRECTORY_SEPARATOR;
    const IMAGE_MAX_WIDTH = 800;
    const IMAGE_JPEG_QUALITY = 95;
    const IMAGE_SHARPEN = true;

    /**
     * The TIMEZONE setting is only used if there's no explicit
     * timezone set in the php.ini
     */
    const TIMEZONE = 'UTC';

    /**
     * Custom markdown css styles
     * put a CSS file e.g example-markdown.css into app/webroot/assets/css/
     * set this option to 'example'
     * installed options are github | simonlc
     * to use none set it to ''
     */
    const MARKDOWN_CSS = 'github';
}
