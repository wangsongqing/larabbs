## 前置工作
- 修改配置文件 backend/scripts/prod-local/app-backend
- 配置host 127.0.0.1  shop.test

## 镜像打包
- 项目打包 docker build -t  app-backend:latest . (需要进入backend目录)
- Nginx打包 docker build -t  app-nginx:latest . （需要进入scripts/nginx目录）

## 项目启动
- docker-compose up -d --renew-anon-volumes （需要进入script/prod-local目录）

## 数据库迁移
- php artisan migrate

## 数据填充
- php artisan migrate:refresh --seed

## 访问
- shop.test

## 默认用户和登录密码
- 用户：xmwme@qq.com
- 密码：password

## 参考资料
- https://www.cnblogs.com/pheye/p/12873465.html
