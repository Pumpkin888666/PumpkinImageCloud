## 介绍
**南瓜图床系统，一个简单的图片管理系统。但是没有后台管理界面，任何人都可以查看、下载、删除。可以删除deleteFile.php文件来防止别人删除。**

## 功能
1.文件上传 -- 因为设计目标是图床系统，所以没有写分片上传。根据php.ini文件的默认设置来限制文件大小。  
2.文件查看 -- 内置图片、视频、压缩包、其他文件的查看器，可以二次开发。~~才不是因为我原本想写网盘但是不会分片上传~~  
3.文件删除 -- 任何人都可以，最好不要泄露你的图床地址。或者删除deleteFile.php文件。

## 安装  
建议使用PHP7.4和Mysql5.6版本。
上传根目录后访问 你的网址/install 即可安装。  

## 开源
本系统开源，可以进行二次开发。但是要写明来源，禁止用来任何商业行为!

## 注意
如果保存文件或者读取config文件错误，请给权限