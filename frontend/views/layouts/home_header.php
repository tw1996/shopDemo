<!DOCTYPE html >
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>京西商城</title>
    <link rel="stylesheet" href="/style/base.css" type="text/css">
    <link rel="stylesheet" href="/style/global.css" type="text/css">
    <link rel="stylesheet" href="/style/header.css" type="text/css">
    <link rel="stylesheet" href="/style/index.css" type="text/css">
    <link rel="stylesheet" href="/style/bottomnav.css" type="text/css">
    <link rel="stylesheet" href="/style/footer.css" type="text/css">
    <link rel="stylesheet" href="style/list.css" type="text/css">
    <link rel="stylesheet" href="style/common.css" type="text/css">
    <link rel="stylesheet" href="style/home.css" type="text/css">
    <link rel="stylesheet" href="style/user.css" type="text/css">
    <link rel="stylesheet" href="style/order.css" type="text/css">

    <script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="js/home.js"></script>
    <script type="text/javascript" src="/js/header.js"></script>
    <script type="text/javascript" src="/js/index.js"></script>
    <script type="text/javascript" src="js/list.js"></script>
</head>
<body>
<!-- 顶部导航 start -->
<?php echo $this->render('nav'); ?>
<!-- 顶部导航 end -->

<div style="clear:both;"></div>

<?php
    use yii\helpers\Url;
    $query = new \yii\db\Query();
    /*一级分类信息*/
    $first = $query->select(['id', 'cat_name', 'pid'])->from('shop_category')->where(['pid' => '0'])->orderBy('id')->all();
    $firstIds = [];
    foreach($first as $k => $v)  $firstIds[] = $v['id'];
    /*二级分类信息*/
    $second = $query->select(['id', 'cat_name', 'pid'])->from('shop_category')->where(['pid' => $firstIds])->orderBy('id')->all();
    $secondIds = [];
    foreach($second as $k => $v)  $secondIds[] = $v['id'];
    /*三级分类信息*/
    $three = $query->select(['id', 'cat_name', 'pid'])->from('shop_category')->where(['pid' => $secondIds])->orderBy('id')->all();
    //当前路由
    $controller = Yii::$app->controller->id;
    $action = Yii::$app->controller->action->id;

?>


<!-- 头部 start -->
<div class="header w1210 bc mt15">
    <!-- 头部上半部分 start 包括 logo、搜索、用户中心和购物车结算 -->
    <div class="logo w1210">
        <h1 class="fl"><a href="/"><img src="/images/logo.png" alt="京西商城"></a></h1>
        <!-- 头部搜索 start -->
        <div class="search fl">
            <div class="search_form">
                <div class="form_left fl"></div>
                <form action="" name="serarch" method="get" class="fl">
                    <input type="text" class="txt" value="请输入商品关键字" /><input type="submit" class="btn" value="搜索" />
                </form>
                <div class="form_right fl"></div>
            </div>
            <div style="clear:both;"></div>
        </div>
        <!-- 头部搜索 end -->
        <!-- 用户中心 start-->
        <div class="user fl">
            <dl>
                <dt>
                    <em></em>
                    <a href="<?= Url::to(['user/index']) ?>">用户中心</a>
                    <b></b>
                </dt>
            </dl>
        </div>
        <!-- 用户中心 end-->
        <!-- 购物车 start -->
        <div class="cart fl">
            <dl>
                <dt>
                    <a href="<?= Url::to(['cart/mycart']) ?>">去购物车结算</a>
                    <b></b>
                </dt>
            </dl>
        </div>
        <!-- 购物车 end -->
    </div>
    <!-- 头部上半部分 end -->
    <div style="clear:both;"></div>
    <!-- 导航条部分 start -->
    <div class="nav w1210 bc mt10">
        <!--  商品分类部分 start-->
        <?php if($controller === 'index'): ?>
        <div class="category fl"> <!-- 非首页，需要添加cat1类 -->
            <div class="cat_hd">  <!-- 注意，首页在此div上只需要添加cat_hd类，非首页，默认收缩分类时添加上off类，鼠标滑过时展开菜单则将off类换成on类 -->
                <h2>全部商品分类</h2>
                <em></em>
            </div>
            <div class="cat_bd">
        <?php else: ?>
        <div class="category fl cat1"> <!-- 非首页，需要添加cat1类 -->
            <div class="cat_hd off">  <!-- 注意，首页在此div上只需要添加cat_hd类，非首页，默认收缩分类时添加上off类，鼠标滑过时展开菜单则将off类换成on类 -->
                <h2>全部商品分类</h2>
                <em></em>
            </div>
            <div class="cat_bd none">
        <?php endif; ?>
                <?php foreach( $first as $keyFirst => $valFirst):  ?>
                <div class="cat">
                    <h3><a href="<?= Url::toRoute(['goods/cat', 'id' => $valFirst['id']])  ?>" ><?= $valFirst['cat_name'] ?></a><b></b></h3>
                    <div class="cat_detail">
                    <?php foreach($second as $keySecond => $valSecond): ?>
                        <?php if($valSecond['pid'] == $valFirst['id']) :  ?>
                        <dl>
                            <dt><a href="<?= Url::toRoute(['goods/cat', 'id' => $valSecond['id']])  ?>"><?= $valSecond['cat_name'] ?></a></dt>
                            <dd>
                            <?php foreach($three as $keyThree => $valThree): ?>
                                <?php if($valThree['pid'] == $valSecond['id']) : ?>
                                <a href="<?= Url::toRoute(['goods/cat', 'id' => $valThree['id']])  ?>"><?= $valThree['cat_name']; ?></a>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            </dd>
                        </dl>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <!--  商品分类部分 end-->
        <div class="navitems fl">
            <ul class="fl">
                <?php if($controller === 'index') : $cur = "class = 'current'";  else: $cur = "";   endif; ?>
                <li <?= $cur ?>><a href="/">首页</a></li>
            </ul>
            <div class="right_corner fl"></div>
        </div>
    </div>
    <!-- 导航条部分 end -->
</div>
<!-- 头部 end-->
</body>
</html>