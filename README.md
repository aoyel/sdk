#aoyel 邮件sdk
aoyel 邮件接口是一个小型的简易邮件邮件服务器，支持邮件服务配置和模板发送，使用队列实现，响应速度极高，支持邮件状态查询和失败重试等！

#使用方式
####申请APPID
[进入](http://console.aoyel.com/)注册一个账号，填写简易的信息即可完成

####配置邮件服务器
首次进入点击邮件会自动进入邮件配置服务器，按照相关要求填写即可
填写完成之后点击添加模板按要求填写对应信息

#SDK使用
```
<?php
$appid = "You AppId"; #填写你的APPID
$mail = new Mail($appid);

#设置模板ID
$templateid  = "You template id";
$mail->setTemplateId($templateid);

#添加模板变量
$mail->addParam("foo","this is value");

#添加收件人地址
$mail->addAddress("foo@aoyel.com");


#其他可函数
$mail->setFromAddress("sender@aoyel.com"); //设置发送地址
$mail->setFromName("You name"); //设置发件人信息
$mail->setServerHost("mail host")； //设置发送的服务器地址，默认不填使用配置的服务器地址
$mail->setServerUser("mail user"); //设置发送的账号信息，默认不填使用配置的账号信息
$mail->setServerPassword("password"); //设置发送的账号密码，默认不填使用配置的账号密码



#发送邮件,点击发送并不会马上发送邮件，而是添加到服务器发送队列里面，发送成功返回true，失败返回false
$state = $mail->send();



```
