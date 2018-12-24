# pear-api
pear让你更畅快地编程。pear-api是以yii2为基础，去除次要服务，重构为只支持api访问服务的框架。

### 前提准备

必要服务支持：Mysql、Nginx、php-fpm、Redis、Kafka、RabbitMQ

可选服务支持：Elasticsearch、Kibana、Jenkins

### 使用说明

```
cd /yourProjectParentPath

composer create-project peachpear/pear-api yourProjectName

cd /path/yourProjectName/backend/config

ln -sf dev.php main.php
```

nginx 配置
```
server {
    charset utf-8;
    client_max_body_size 128M;

    listen 80; ## listen for ipv4
    #listen [::]:80 default_server ipv6only=on; ## listen for ipv6

    server_name yourServerName;
    root        /path/yourProjectName/public;
    index       index.php;

    location / {
        # Redirect everything that isn't a real file to index.php
        try_files $uri $uri/ /index.php?$args;
    }

    location ~ \.php$ {
        include fastcgi.conf;
        fastcgi_pass   127.0.0.1:9000;
        #fastcgi_pass unix:/var/run/php5-fpm.sock;
        try_files $uri =404;
    }

    #error_page 404 /404.html;

    location ~ /\.(ht|svn|git) {
        deny all;
    }
}
```

#### 目录结构
```
├── backend
|   ├── components
|   ├── config
|   ├── controllers
|   └── lib
├── common
│   ├── components
│   ├── config
│   ├── dao
│   ├── exception
│   ├── lib
│   ├── misc
│   ├── models
│   └── service
└── console
    ├── components
    ├── config
    └── controllers    
```

#### 编码规范
```
1.PHP所有 关键字 必须 全部小写（常量 true 、false 和 null 也 必须 全部小写）
2.命名model对应的class 必须 以Model结尾
3.命名service对应的class 必须 以Service结尾
4.命名dao对应的class 必须 以Dao结尾
5.数据库查询返回接口 应该 使用model对象/对象列表
6.数据库的key必须是dbname+DB形式，e.g:dbname为test,则key为testDB
7.dao目录存放sql语句或者orm
8.model目录存放对应的数据实例对象
9.service目录存放业务逻辑处理
```