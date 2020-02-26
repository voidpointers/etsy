### 店铺操作

> 以测试环境为例

#### 添加

1. 管理员通过后台输入shop_id或shop_name以及授权token等必要信息
<http://admin.createos.xyz/#/etsy/shop-list>
2. 请求Shop模块接口
> ...
3. Shop模块请求Etsy模块获取店铺基本信息（无需授权）
<http://etsy.ywysys.me/shop/FastestSloth>
或 <http://etsy.ywysys.me/shop/125136382>

> 返回文档参考 https://www.etsy.com/developers/documentation/reference/shop
4. Shop模块存储店铺信息

#### 修改
