#vote_system_php

这是一个用PHP作为后台，HTML+JS+jQuery作为前端的投票系统。

主要的技术点在于使用MVC的设计思想，解开了数据库操作和请求处理的耦合。

dao层有两个文件，dao.php是使用字符串拼接SQL的，可能会被SQL注入，safe_dao.php中登录功能使用了pdo中的预编译语句。

service层中使用了switch-case语句调用处理请求的函数，有良好的可扩展性，也更容易找到处理相应请求的函数。

view层中使用了ajax处理请求发送和响应。

并且view层中部分表格是通过jQuery代码生成的，能够动态显示，这也是我第一次尝试。

存在的问题：

1.功能还不完善，应该添加编辑候选人，投票人的功能。

2.请求后台的地址存在硬编码的问题，我希望能够使用Java重写后台，修改完成后，需要去每个HTML文件中修改后台url，非常麻烦，我会把所有url封装成一个js对象，存在一个文件中，供所有页面引用，使用属性获取url，这样就像配置文件一样，方便修改。

3.ajax重复使用的次数过多，可以考虑封装。

4.前端页面简陋，可以进行美化。
