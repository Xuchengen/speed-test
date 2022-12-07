# 暂停服务
php artisan down

# 删除入口目录
rm -rf ~/public_html2

# 强制拉代码
git fetch --all
git reset --hard origin/master
git pull

# 创建代码缓存
php artisan optimize:clear
php artisan optimize
php artisan view:cache

# 创建软连接
ln -s ~/repositories/speed-test ~/public_html2

# 开启服务
php artisan up
