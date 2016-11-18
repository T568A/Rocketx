# Rocketx

Rocketx is a simple and quick configuration NGINX.

WARNING: use at your own risk 💀

## Install
```shell
$ git clone https://github.com/T568A/Rocketx.git
$ cd Rocketx
$ chmod +x rocketx.php
```

## Examples

```shell
$ sudo ./rocketx.php -d example.com -t example.tmp
```
or
```shell
$ sudo ./rocketx.php
Enter Domain (example.com):
Enter Template (example.tmp):
```

## Show templates

```shell
$ ./rocketx.php -l
yii2.tmp
example.tmp
```

## Show Logs

```shell
$ journalctl -b -p err
...
Nov 18 15:27:08 webserver php[7664]: Rocketx: Template not found!(getNginxConfig)
```
or

```shell
$ tail -f /var/log/rocketx.log
...
2016-11-18 15:27:08: Template not found!(getNginxConfig)
```

## Help

```shell
$ ./rocketx.php -h

-t --template   Set Name template NGINX
-d --domain     Set Domain Name Site
-l --list       Get template files
-h --help       Get help
```

## License

[MIT](LICENSE)
