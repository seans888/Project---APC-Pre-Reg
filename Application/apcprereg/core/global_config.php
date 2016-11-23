<?php
define('GLOBAL_PROJECT_NAME', 'APC Online Pre-registration');
define('GLOBAL_SESSION_NAME', 'C80b25962');

//Default database settings
define('DEFAULT_DB_HOST','localhost');
define('DEFAULT_DB_USER','root');
define('DEFAULT_DB_PASS','');
define('DEFAULT_DB_USE' ,'preregistration');

//Paths and directory names
define('BASE_DIRECTORY', 'apcprereg');
define('FULLPATH_CORE', dirname(__FILE__) . "/");
define('GRAPH_CREATOR_FONTDIR', FULLPATH_CORE . 'fonts/');
define('LOGIN_PAGE', '/' . BASE_DIRECTORY . '/login.php');
define('HOME_PAGE', '/' . BASE_DIRECTORY . '/main.php');
define('INDEX_TARGET', '/' . BASE_DIRECTORY . '/start.php');
define('TMP_DIRECTORY', 'C:\xampp\htdocs' . '/' . BASE_DIRECTORY . '/tmp');
define('TMP_PDF_STORE', 'rpt_pdf_tmp');
define('TMP_CSV_STORE', 'rpt_csv_tmp');
define('THIRD_PARTY_DIR', '/' . BASE_DIRECTORY . '/core/thirdparty/');

//Security-related options
define('DEBUG_MODE', TRUE);
define('IP_CHANGE_DETECTION', TRUE);

//Documentation options
define('DEFAULT_DOC_LANGUAGE', 'en');

//Misc
define('MULTI_BYTE_ENCODING', 'utf-8');
define('TIMEZONE_SETTING', 'Asia/Manila');
define('LOG_SELECT_QUERIES', FALSE);
define('LOG_MODULE_ACCESS', FALSE);
define('MAX_PASSWORD_LENGTH', 200);
define('MAX_FORM_KEYS',10);
define('LISTVIEW_RESULTS_PER_PAGE',50);
define('FOOTER_RESOURCE_USAGE', FALSE);
define('ENABLE_SIDEBAR', TRUE);
define('CONTROL_CENTER_COLUMNS',6);