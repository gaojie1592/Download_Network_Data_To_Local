# Download Network Data To Local
[![Latest Stable Version](https://poser.pugx.org/gaojie1592/download_network_data_to_local/v)](//packagist.org/packages/gaojie1592/download_network_data_to_local) [![Total Downloads](https://poser.pugx.org/gaojie1592/download_network_data_to_local/downloads)](//packagist.org/packages/gaojie1592/download_network_data_to_local) [![Coverage Status](https://coveralls.io/repos/github/gaojie1592/Download_Network_Data_To_Local/badge.svg?branch=main)](https://coveralls.io/github/gaojie1592/Download_Network_Data_To_Local?branch=main) [![Latest Unstable Version](https://poser.pugx.org/gaojie1592/download_network_data_to_local/v/unstable)](//packagist.org/packages/gaojie1592/download_network_data_to_local) [![License](https://poser.pugx.org/gaojie1592/download_network_data_to_local/license)](//packagist.org/packages/gaojie1592/download_network_data_to_local)

# 功能说明:

将网络数据下载并自动识别文件后缀,保存到本地并返回本地地址.

Download network data and automatically recognize the file suffix, save it locally and return to the local address.

# 安装方法:

```
composer require gaojie1592/download_network_data_to_local
```

# 使用方法:

- 例子一:

```php
require_once __DIR__ . '/vendor/autoload.php';

use gaojie1592\Download_Network_Data_To_Local;

$img = new Download_Network_Data_To_Local(
    // 必要参数:需要下载的网络地址,必须是完整的
    // Necessary parameters: the network address to be downloaded must be complete
    'http://www.github.com/gif_download',
    // 必要参数:保存到本地的地址,不包含文件名称,以'/'或'\'结尾
    // Necessary parameters: save to the local address, do not include the file name, end with'/' or'\'
    '/home/www.github.com/img/',
    // 可选参数:可以指定保存的文件名称,如果不指定则用随机字符
    // Optional parameter: you can specify the saved file name, if not specified, use random characters
    'filename'
);
$local = $img->start();

var_dump($local);

// 返回结果
string() "/home/www.github.com/img/filename.gif"
```

- 例子二:

```php
require_once __DIR__ . '/vendor/autoload.php';

use gaojie1592\Download_Network_Data_To_Local;

$img = new Download_Network_Data_To_Local();

             // 必要参数:需要下载的网络地址,必须是完整的
             // Necessary parameters: the network address to be downloaded must be complete
$local = $img->set_http_url('http://www.github.com/jpg_download')
             // 必要参数:保存到本地的地址,不包含文件名称,以'/'或'\'结尾
             // Necessary parameters: save to the local address, do not include the file name, end with'/' or'\'
             ->set_local_path('/home/www.github.com/img/')
             // 可选参数:可以指定保存的文件名称,如果不指定则用随机字符
             // Optional parameter: you can specify the saved file name, if not specified, use random characters
             ->set_filename('filename')
             ->start();

var_dump($local);

// 返回结果
string() "/home/www.github.com/img/filename.jpg"

```

- 例子三:

```php
require_once __DIR__ . '/vendor/autoload.php';

use gaojie1592\Download_Network_Data_To_Local;

$img = new Download_Network_Data_To_Local();

            // 必要参数:需要下载的网络地址,必须是完整的
            // Necessary parameters: the network address to be downloaded must be complete
$local = $img->set_http_url('http://www.github.com/jpg_download')
            // 必要参数:保存到本地的地址,不包含文件名称,以'/'或'\'结尾
            // Necessary parameters: save to the local address, do not include the file name, end with'/' or'\'
             ->set_local_path('/home/www.github.com/img/')
            // 可选参数:可以指定保存的文件名称,如果不指定则用随机字符
            // Optional parameter: you can specify the saved file name, if not specified, use random characters
             ->set_filename('filename')
            //  可选参数:下载持续的最大时间,需要下载的文件体积越大,则设置越大
            // Optional parameter: the maximum time for downloading, the larger the file size to be downloaded, the larger the setting
             ->set_http_timeout(50)
            //  可选参数:连接服务器的最大等待时间,如果网络不好,则设置大点
            // Optional parameter: the maximum waiting time to connect to the server, if the network is not good, set a larger one
             ->set_http_sertimeout(50)
            //  可选参数:使用代理下载
            // Optional parameter: download using proxy
             ->set_http_proxy('192.168.0.1:1080')
            //  可选参数:使用代理的账号与密码
            // Optional parameters: use proxy account and password
             ->set_http_proxyusrpwd('usrname:password')
             ->start();

var_dump($local);

// 返回结果
string() "/home/www.github.com/img/filename.jpg"

```

# 支持文件后缀:

- js
- psd
- htm_or_html
- xml
- bmp
- gif
- exe
- midi
- zip
- rar
- bt
- png
- bat
- xls_or_doc_or_ppt
- txt_or_aspx_or_asp_or_sql
- jpg
- rdp

# 许可证:

当前软件使用的许可证是 MIT,请查看[完整的许可证](https://github.com/gaojie1592/Download_Network_Data_To_Local/blob/main/LICENSE).

This bundle is under the MIT license. See the complete [license in the bundle](https://github.com/gaojie1592/Download_Network_Data_To_Local/blob/main/LICENSE).
