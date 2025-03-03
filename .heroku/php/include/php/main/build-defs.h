/*
   +----------------------------------------------------------------------+
   | Copyright (c) The PHP Group                                          |
   +----------------------------------------------------------------------+
   | This source file is subject to version 3.01 of the PHP license,      |
   | that is bundled with this package in the file LICENSE, and is        |
   | available through the world-wide-web at the following url:           |
   | https://www.php.net/license/3_01.txt                                 |
   | If you did not receive a copy of the PHP license and are unable to   |
   | obtain it through the world-wide-web, please send a note to          |
   | license@php.net so we can mail you a copy immediately.               |
   +----------------------------------------------------------------------+
   | Author: Stig Sæther Bakken <ssb@php.net>                             |
   +----------------------------------------------------------------------+
*/

#define CONFIGURE_COMMAND " './configure'  '--prefix=/app/.heroku/php' '--with-config-file-path=/app/.heroku/php/etc/php' '--with-config-file-scan-dir=/app/.heroku/php/etc/php/conf.d' '--disable-phpdbg' '--enable-fpm' '--with-bz2' '--with-curl' '--with-pdo-mysql' '--with-mysqli' '--with-openssl' '--with-kerberos' '--with-password-argon2' '--with-pgsql' '--with-pdo-pgsql' '--with-readline' '--enable-sockets' '--with-zlib' '--enable-bcmath=shared' '--enable-calendar=shared' '--enable-exif=shared' '--enable-ftp=shared' '--with-gettext=shared' '--with-gmp=shared' '--with-imap=shared' '--with-imap-ssl' '--enable-intl=shared' '--with-ldap=shared' '--with-ldap-sasl' '--enable-mbstring=shared' '--enable-pcntl=shared' '--enable-shmop=shared' '--enable-soap=shared' '--with-sodium=shared' '--with-xsl=shared' '--with-zip' '--with-sqlite3=shared' '--with-pdo-sqlite=shared' '--enable-gd=shared' '--with-freetype' '--with-jpeg' '--with-webp'"
#define PHP_ODBC_CFLAGS	""
#define PHP_ODBC_LFLAGS		""
#define PHP_ODBC_LIBS		""
#define PHP_ODBC_TYPE		""
#define PHP_OCI8_DIR			""
#define PHP_OCI8_ORACLE_VERSION		""
#define PHP_PROG_SENDMAIL	"/usr/sbin/sendmail"
#define PEAR_INSTALLDIR         ""
#define PHP_INCLUDE_PATH	".:"
#define PHP_EXTENSION_DIR       "/app/.heroku/php/lib/php/extensions/no-debug-non-zts-20210902"
#define PHP_PREFIX              "/app/.heroku/php"
#define PHP_BINDIR              "/app/.heroku/php/bin"
#define PHP_SBINDIR             "/app/.heroku/php/sbin"
#define PHP_MANDIR              "/app/.heroku/php/php/man"
#define PHP_LIBDIR              "/app/.heroku/php/lib/php"
#define PHP_DATADIR             "/app/.heroku/php/share/php"
#define PHP_SYSCONFDIR          "/app/.heroku/php/etc"
#define PHP_LOCALSTATEDIR       "/app/.heroku/php/var"
#define PHP_CONFIG_FILE_PATH    "/app/.heroku/php/etc/php"
#define PHP_CONFIG_FILE_SCAN_DIR    "/app/.heroku/php/etc/php/conf.d"
#define PHP_SHLIB_SUFFIX        "so"
#define PHP_SHLIB_EXT_PREFIX    ""
