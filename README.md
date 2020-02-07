# 环境要求
php >= 7  
composer  
redis  
Predis

# Predis安装
composer require predis/predis  

# lexiang-cache安装
composer require lexiang/lexiang-cache  

# 设置hash缓存数组  
## setHash($key, array $hash);

$key  缓存键值  
$hash  缓存数组  

#获取hash缓存指定数据  
## getValueByHash($key, array $fields);
$key    缓存键值  
$fields 数组键值  


#获取所有hash缓存数据  
## getHashAll($key)
$key   缓存键值  

#删除hash缓存  
## removeHash($key, array $fields)
$key    缓存键值  
$fields 数组键值  







