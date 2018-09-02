## 模块、控制器、视图模型，双向数据绑定模型 ##

	<body>
	    <div ng-app="hd" ng-controller="ctrl">
	        <h2 ng-bind="name"></h2>
	        <input type="text" ng-model="name"> <!-- 双向数据绑定  -->
	       
	    </div>
	</body>
	<script>
	    var m=angular.module('hd',[]);
	    m.controller('ctrl',['$scope',function ($scope) {
	       // viewmodel
	        $scope.name='后盾网';//model server
	    }]);
	</script>
模块  

	ng-app="hd"

控制器 

	ng-controller="ctrl"

双向绑定  

model Server 从服务端拿到数据，然后把数据交给$scope（ViewModel）  
$scope 是由controller管理，$scope把数据分配给视图view  
如果视图view发生变化，同样影响到viewmodel，即MVVM双向绑定 

## 声明模块与控制器规范与依赖注入 ##
html

	<body ng-app="hd">
		<div ng-controller="ctrl">
			{{name}}
		</div>
	</body>

js 

	<script>
		var m=angular.module('hd',[]);
		m.controller('ctrl',['$scope',function($scope){
			$scope.name="模块";
		}]);
	</script>

为什么要向上面这样写呢？其实下面这种写法也是可以的，但是当使用js打包工具时，形参$scope会被压缩成a等单字母，而Angular容器依赖$scope注入，变成单字母后angular就不认识了。  
因此上使用依赖注入的形式，先[],然后在里面写上依赖$scope

	m.controller('ctrl',function($scope){
		$scope.name="模块";
	});


## $scope的基本用法 ##
html 


	<body ng-app="hd">
		<div ng-cotroller="ctrl">
			商品名称 {{goods.data.title}}
			价格 {{goods.data.price}}
			购买数量 {{goods.data.num}}
			总计 {{goods.data.price*goods.data.num}}
			<button ng-click="goods.add">增加</button>
			<button ng-click="goods.reduce">减少</button>
			<button ng-click="fun()">触发函数</btuuon>
		</div>
	</body>

js

	<script>
	var m=angular.module('hd',[]);
	m.controller('ctrl',['$scope',function($scope){
		$scope.goods={
			data:{'title':'apple','price':300,'num':0},
			add:function(){
				$scope.goods.data.num=Math.min(++$scope.goods.data.num,6);
			},
			reduce:function(){
				$scope.goods.data.num=Math.max(--	$scope.goods.data.num,0);
			},
		}
		$scope.fun=function(){
			alert(2);
		}
	}]);
	<script>


ng-click 绑定单击事件  


## 表达式与ng-bind以及ng-cloak解决闪屏问题 ##
html 

	<body ng-app="hd" ng-cloak style="display: none;">
	    <div ng-controller="ctrl">
	        {{name+'houdongern.cojm houdongwangl.com bbs.houdun.com'}}
	        <hr>
	        {{user.username+'=>'+user.url}}
	        <hr>
	        {{num*8}}
	        <hr>
	        <h3 ng-bind="name"></h3>
	    </div>
	</body>

js  


	<script>
	    var m=angular.module('hd',[]);
	    m.controller('ctrl',['$scope',function ($scope) {
	        $scope.name='后盾网';
	        $scope.num=2;
	        $scope.user={'username':'后盾人','url':'www.houdunren.com'};
	    }]);
	</script>

- 可以看到，{{name}}和ng-bind="name"都能显示$scope下的name,那么什么时候用表达式，什么时候用指令呢 ？  
- 表达式后面可以随意添加字符串，指令里面添加字符串比较繁琐一些，  
- 当网络延迟或者js文件按需加载时，表达式可能会出现没来得及加载的情况，花括号会闪烁一下，这时用指令好一些  
- 也可以使用ng-cloak解决表达式中花括号闪烁的问题  
- 如果js按需加载，当执行到body时，由于css的关系，body隐藏，然后引入angular文件  
- angular会解析ng-cloak指令，解析之后，再显示


## ng-model在表单中的双向绑定 ##
html  

	<body ng-app="hd">
	    <div ng-controller="ctrl">
	        <form action="">
	            <input type="text" name="title" ng-model="name">
	            {{name}}
	            <input type="submit">
	        </form>
	    </div>
	</body>

js

	<script>
	    var m=angular.module('hd',[]);
	    m.controller('ctrl',['$scope',function ($scope) {
	        $scope.name='后盾网';
	    }]);
	</script>


通过ng-model指令双向绑定

![](./images/ng-model.gif)

## ng-value的使用 ##

html 

	<body ng-app="hd">
	    <div ng-controller="ctrl">
	        商品： <input type="text" ng-model="goods.title"><br>
	        价格：<input type="text" ng-model="goods.price" readonly><br>
	        数量：<input type="text" ng-model="goods.num"><br>
	        总价：<input type="text" ng-value="goods.price*goods.num" readonly>
	    </br>
	    </div>
	</body>

js  

	<script>
	    var m=angular.module('hd',[]);
	    m.controller('ctrl',['$scope',function ($scope) {
	        $scope.goods={title:'后盾网视频',price:89,num:2};
	    }]);
	</script>

ng-value可以直接读取到scope中的值 

![](./images/ng-value.gif)

## angular控制单选框 ##


html  

	<body ng-app="hd">
	    <div ng-controller="ctrl">
	        网站开启
	        <input type="radio" ng-model="status" ng-value="1">开启
	        <input type="radio" ng-model="status" ng-value="0">关闭
	        {{status}}
	        <div ng-show="status==0">
	            <h2>关闭原因</h2>
	            <textarea name="" id="" cols="30" rows="10">正在维护中</textarea>
	        </div>
	    </div>
	</body>

js 

	<script>
	    var m=angular.module('hd',[]);
	    m.controller('ctrl',['$scope',function ($scope) {
	        $scope.status=1;
	    }]);
	</script>

打开页面时，默认状态为1，即开启  

当选择关闭时，因为双向绑定，$scope.status=0  

ng-show即显示 

![](./images/angular-radio.gif)
## angular控制复选框 ##

html

	<body ng-app="hd">
	    <div ng-controller="ctrl">
	        游戏：<input type="checkbox" ng-model="data.game" ng-true-value="1" ng-false-value="0">
	        电影：<input type="checkbox" ng-model="data.video" ng-true-value="1" ng-false-value="0">
	
	        <div ng-show="data.game==1">
	            <h1>游戏</h1>
	            <textarea name="" id="" cols="30" rows="10"></textarea>
	        </div>
	        <div ng-show="data.video==1">
	            <textarea name="" cols="30" rows="10"></textarea>
	        </div>
	        {{data}}
	    </div>
	</body>


js  

	<script>
	    var m=angular.module('hd',[]);
	    m.controller('ctrl',['$scope',function ($scope) {
	        $scope.data={game:0,video:0};
	    }]);
	</script>


ng-model指令双向绑定   
ng-true-value=1 勾选时值为1 
ng-false-vlue=0  取消勾选时值为0

![](./images/angular-checkbox.gif)


## angular操作下拉列表框 ##

html 

	<body ng-app="hd">
	    <div ng-controller="ctrl">
	        <select name="" ng-options="v.value as v.name for v in data" ng-model="city" id="">
	            <option value="">请选择城市</option>
	        </select>
	        {{city}}
	    </div>
	</body>

js  

	<script>
	    var m=angular.module('hd',[]);
	    m.controller('ctrl',['$scope',function ($scope) {
	        $scope.city='beijing';
	        $scope.data=[
	            {name:'北京',value:'beijing'},
	            {name:'南京',value:'nanjing'},
	            {name:'长沙',value:'changsha'}
	        ];
	    }]);
	</script>

![](./images/angular-select.gif)


## 函数使用方法之大小写和对象深拷贝 ##

	<body ng-app="hd" ng-controller="ctrl">
	
	</body>
	<script>
	    var m=angular.module('hd',[]);
	    m.controller('ctrl',['$scope',function ($scope) {
	        console.log(angular.version);//查看angular版本
	        console.log(angular.uppercase('houdunWANG'));//转换为大写 HOUDUNWANG
	        var obj={name:'后盾人'};
	        var obj2={};
	        angular.copy(obj,obj2);//深拷贝
	        obj2.name='后盾网';
	        console.log(obj2);//"后盾网"
	    }]);
	</script>


## 函数使用对象扩充与数据遍历 ##

	<body ng-app="hd" ng-controller="ctrl">
	{{data}}
	{{data1}}
	</body>
	<script>
	    var m=angular.module('hd',[]);
	    m.controller('ctrl',['$scope',function ($scope) {
	        var obj={name:'后盾网'};
	        angular.extend(obj,{url:'houdunwang',web:'后盾人'});
	        console.log(obj);
	//        name :"后盾网"
	//        url: "houdunwang"
	//        web: "后盾人"
	        $scope.data=[
	            {name:'后盾网',url:'houdunwang'},
	            {name:'后盾人',url:'houdunren'},
	            {name:'百度',url:'baidu.com'},
	        ];
	        angular.forEach($scope.data,function (v,k) {
	            v.url='www'+v.url;
	            console.log(v);
	            //输出
	            //{name: "后盾网", url: "wwwhoudunwang"}
	            //{name: "后盾人", url: "wwwhoudunren"}
	            //{name: "百度", url: "wwwbaidu.com"}
	        });
	       data1= {name:'后盾网',url:'houdunwang'};
	        angular.forEach(data1,function (v,k) {
	           console.log(v);
	           //后盾网
	            // houdunwang
	        })
	    }]);
	</script>

## json数据转换与本地存储及$scope数据序列化提交后台 ##

	<body ng-app="hd" ng-controller="ctrl">
	
	</body>
	<script>
	    var m=angular.module('hd',[]);
	    m.controller('ctrl',['$scope',function ($scope) {
	        $scope.data={name:'houdunren'};
	        //localStorage.setItem('data',$scope.data);//由于是json格式，存储不了
	        localStorage.setItem('data',angular.toJson($scope.data));//现在可以
			 console.log(localStorage.getItem('data'));//读取存储的数据
	        $scope.data1=angular.fromJson(localStorage.getItem('data'));//json对象变成字符串
		    }]);
	</script>


数据提交后台 

html 

	<body ng-app="hd" ng-controller="ctrl">
	<form action="" method="post">
	    标题：<input type="text" ng-model="field.title">
	    点击量：<input type="text" ng-model="field.click">
	    内容: <input type="text" ng-model="field.content">
	    <textarea name="data" id="" cols="30" rows="10"></textarea>
	    <input type="submit" value="提交">
	</form>
	</body>

js

	<script>
	    var m=angular.module('hd',[]);
	    m.controller('ctrl',['$scope',function ($scope) {
	       $scope.field={title:'后盾人',click:100,content:'后盾网'};
	       $('form').submit(function () {
	           $("[name='data']").val(angular.toJson($scope.field));
	           return false;
	       });
	    }]);
	</script>

## 数据类型判断函数与数据比较方法的使用 ##

	<body ng-app="hd" ng-controller="ctrl">
	
	</body>
	<script>
	    var m=angular.module('hd',[]);
	    m.controller('ctrl',['$scope',function ($scope) {
	        var a;
	        console.log(angular.isDefined(a));//false
	        console.log(angular.isUndefined(a));//true
	        var b=99;
	        console.log(angular.isNumber(b));//true
	        console.log(angular.isString(b));//false
	        var d={};
	        console.log(angular.isObject(d));//true
	        e=document.getElementsByTagName('body').item(0);
	        console.log(angular.isElement(e));//true
	        f={name:9};
	        g={name:9};
	        console.log(angular.equals(f,g));//true
	    }]);
	</script>

## ng-init与ng-trim ##

html 

	<body ng-app="hd">
	<div ng-controller="ctrl" ng-init="name='后盾人'">
	    <form action="">
	        标题：<input type="text" name="title" ng-trim ng-model="title"><br>
	        <input type="text" name="data"><br>
	        <input type="submit">
	    </form>
	    {{title}}
	</div>
	</body>

js  

	<script>
	    var m=angular.module('hd',[]);
	    m.controller('ctrl',['$scope',function ($scope) {
	        $scope.title='';
	        $('form').submit(function () {
	            $("[name='data']").val($scope.title);
	        });
	    }]);
	</script>

- ng-init 是某个的初始值
- 当使用ng-model双向绑定时，$scope.title会因为ng-model定执行了ng-trim而去掉多余空格
- 所以name=data的这个输入框中是没有空格的 
- 而name=title的这个输入框里面还是有空格的
- 但是，如果input框的类型是password，则自动保留空格
- 其他输入框想继续保留空格，可以设置ng-trim=false



## ng-if,ng-show,ng-disabled ##

html 

	<body ng-app="hd">
	    <div ng-controller="ctrl">
	        <input type="checkbox" ng-model="name">显示
	        <input type="checkbox" ng-model="status">接受协议
	        <button ng-init="copyright=false" ng-click="copyright=!copyright">查看协议</button>
	        <br>
	        <textarea name="" ng-show="copyright" id="" cols="30" rows="10"></textarea>
	        <br>
	        <button ng-disabled="!status">登录</button>
	        <div ng-show="name">hhhhh</div>
	        {{name}}
	        <div ng-if="name">hhhhh</div>
	    </div>
	
	</body>

js 

	<script>
	    var m=angular.module('hd',[]);
	    m.controller('ctrl',['$scope',function ($scope) {
	        
	    }]);
	</script>

![](./images/ng-if.gif)

ng-if和ng-show的区别
- 虽然两个指令都是控制元素显示，但是ng-if直接remove了这个元素，而ng-show只是设置了它display="none "
- ng-show还有ng-hide为不显示 


## ng-repeat ##

html 

	<div ng-app="hd" ng-controller="ctrl">
	        <!--$first为第一个 $last为最后一个 $middle为中间的 $even为偶数行 $odd 为奇数行-->
	        <li ng-repeat="(k,v) in data" style="{{$odd ? 'color:red;' : 'color:blue'}}">
	            名称：{{v.name}}  网址：{{v.url}}
	        </li>
	        <li ng-repeat="(k,v) in data">
	            <span ng-if="$first" style="color:red;">
	                名称：{{v.name}}  网址：{{v.url}}
	            </span>
	            <span ng-if="$middle" style="color:green;">
	                名称：{{v.name}}  网址：{{v.url}}
	            </span>
	            <span ng-if="$last" style="color:yellow;">
	                名称：{{v.name}}  网址：{{v.url}}
	            </span>
	        </li>
	        <li ng-repeat="v in data1 track by $index">
	            {{v}}
	        </li>
	    </div>

js 

	<script>
	    var m=angular.module('hd',[]);
	    m.controller('ctrl',['$scope',function ($scope) {
	        $scope.a=99;
	        $scope.data=[
	            {name:'百度',url:'www.baidu.com'},
	            {name:'腾讯',url:'www.tencent.com'},
	            {name:'谷歌',url:'www.google.com'},
	            {name:'雅虎',url:'www.yahoo.com'},
	            {name:'新浪',url:'www.sina.com'},
	        ];
	        $scope.data1=['百度','腾讯','谷歌','雅虎','新浪'];
	    }]);
	</script>

在ng-repeat中

- $first为第一个 
- $last为最后一个 
- $middle为中间的 
- $even为偶数行 
- $odd 为奇数行

![](./images/ng-repeat.gif)


## ng-selected,ng-disabled,ng-readonly ##

html

	<body ng-app="hd">
	    <div ng-controller="ctrl">
	        <form action="">
	            性别：<select name="" id="" ng-model="user.sex">
	                <option value="">性别选择</option>
	                <option value="" ng-value="1" ng-selected="user.sex==1">男</option>
	                <option value="" ng-value="2" ng-selected="user.sex==2">女</option>
	            </select>
	            <input type="radio" ng-model="user.sex" ng-value="1">男
	            <input type="radio" ng-model="user.sex" ng-value="2">女
	            <input type="text" ng-readonly="user.sex==1">
	            <input type="text" ng-disabled="user.sex==2">
	        </form>
	
	    </div>
	</body>

js 

	<script>
	    var m=angular.module('hd',[]);
	    m.controller('ctrl',['$scope',function ($scope) {
	
	    }]);
	</script>

![](./images/ng-readonly.gif)


## 表单的全选与反选 ##

html 

	<body ng-app="hd">
	    <div ng-controller="ctrl">
	        <table border="1" width="500">
	            <tr>
	                <td>
	                    <input type="checkbox" ng-model="all">
	                    <span ng-bind="all? '取消' :'全选'"></span>
	                </td>
	                <td>标题</td>
	                <td>网址</td>
	            </tr>
	            <tr ng-repeat="v in data">
	                <td>
	                    <input type="checkbox" ng-checked="all">
	                </td>
	                <td>{{v.name}}</td>
	                <td>{{v.url}}</td>
	            </tr>
	        </table>
	    </div>
	</body>

js 

	<script>
	    var m=angular.module('hd',[]);
	    m.controller('ctrl',['$scope',function ($scope) {
	        $scope.data=[
	            {name:'百度',url:'www.biaud.com'},
	            {name:'谷歌',url:'www.google.com'}
	        ];
	    }]);
	</script>

![](./images/checkbox-checkall.gif)

## 设置数据同步时机 ##
代码 

	<body ng-app="hd" ng-controller="ctrl">
	<input type="text" ng-model="title" ng-model-options="{updateOn:'default blur',debounce:{default:2000,blur:0}}">
	<!--当失去焦点之后立即执行，或者仍获得焦点，等待2000ms后执行-->
	{{title}}
	</body>
	<script>
	    var m=angular.module('hd',[]);
	    m.controller('ctrl',['$scope',function ($scope) {
	        
	    }]);
	</script>

![](./images/data-update.gif)


## ng-class动态改变样式 ##

html

	<body ng-app="hd" ng-controller="ctrl">
	    <table border="1" width="600">
	        <tr>
	            <th>编号</th>
	            <th>姓名</th>
	            <th>年龄</th>
	        </tr>
	        <tr ng-repeat="v in data" ng-class="{lock:v.status==0}">
	            <td>{{v.id}}</td>
	            <td ng-class="{red:v.age>25}">{{v.username}}</td>
	            <td>{{v.age}}</td>
	        </tr>
	    </table>
	
	    <hr>
	    <table border="1" width="600">
	        <tr>
	            <th>编号</th>
	            <th>姓名</th>
	            <th>年龄</th>
	        </tr>
	        <tr ng-repeat="v in data" ng-class-odd="{red:true}" ng-class-even="{green:true}">
	            <td>{{v.id}}</td>
	            <td>{{v.username}}</td>
	            <td>{{v.age}}</td>
	        </tr>
	    </table>
	    <hr>
	</body>


js  

	<script>
	    var m=angular.module('hd',[]);
	    m.controller('ctrl',['$scope',function ($scope) {
	        $scope.data=[
	            {id:1,username:'百度',age:18,status:1},
	            {id:2,username:'谷歌',age:10,status:0},
	            {id:3,username:'新浪',age:28,status:1},
	            {id:4,username:'腾讯',age:38,status:0},
	        ];
	    }]);
	</script>


css  

	<style>
        .lock{
            color:#eee;
        }
        .red{
            color: red;
        }
        .green{
            color: green;
        }
    </style>

![](./images/ng-class.gif)

## ng-style动态改变样式 ##

html

	<body ng-app="hd">
	    <div ng-controller="ctrl">
	        颜色：<input type="color" ng-model="color">
	        大小：<input type="number" ng-model="size">
	        <span ng-style="{color:color,fontSize:size+'px'}">百度</span>
	       <div>{{color}}</div>
	    </div>
	
	</body>

js 


	<script>
	    var m=angular.module('hd',[]);
	    m.controller('ctrl',['$scope',function ($scope) {
	        $scope.color='red';
	    }]);
	</script>

![](./images/ng-style.gif)


## 事件处理指令 ##

html

	<body ng-app="hd">
	    <div ng-controller="ctrl">
	        <!--<input type="text" ng-click="fun()">-->
	        <!--<input type="text" ng-dblclick="fun()">-->
	        <!--<input type="text" ng-change="fun()" ng-model="title">-->
	        <!--<input type="text" ng-focus="fun()" ng-model="title">-->
	        <input type="text" ng-keydown="fun()" ng-model="title">
	        <div>{{data}}</div>
	    </div>
	</body>

js 

	<script>
	    var m=angular.module('hd',[]);
	    m.controller('ctrl',['$scope',function ($scope) {
	        $scope.fun=function () {
	            $scope.data ='百度';
	        }
	    }]);
	</script>

- ng-click 单击
- ng-dblclick  双击
- ng-change  改变
- ng-focus  获得焦点
- ng-keydown 键盘按下事件


## 变量调节器与货币变量调节器 ##

	<body ng-app="hd" ng-controller="ctrl">
	{{price|currency:'￥':1}}
	<br>
	{{price|number:2}}
	<br>
	{{name|uppercase|lowercase}}
	<br>
	{{title|limitTo:2:1}} <!-- 从第（1+1）个字开始  截取2个-->
	</body>
	<script>
	    var m=angular.module('hd',[]);
	    m.controller('ctrl',['$scope',function ($scope) {
	        $scope.name='aaaaaaa';
	        $scope.price='12323.456';
	        $scope.title='今天是个好日子，开心的事儿都很多';
	    }]);
	</script>

界面显示 

	￥12,323.5 
	12,323.46 
	aaaaaaa 
	天是


## date过滤器处理时间 ##

	<body ng-app="hd" ng-controller="ctrl">
	{{time|date:'yyyy年MM月dd日 HH:mm:ss'}}
	</body>
	<script>
	    var m=angular.module('hd',[]);
	    m.controller('ctrl',['$scope',function ($scope) {
	        $scope.time=new Date().getTime();
	    }]);
	</script>

界面显示 

	2018年09月01日 13:52:24


## orderBy和filter ##

html

	<body ng-app="hd" ng-controller="ctrl">
	{{data|orderBy:'id':true}}<!--第二个参数true  会按照降序排列-->
	<hr>
	{{data|filter:'百度':true}}<!--第二个参数true  是完全匹配 title为新浪百度的或被过滤掉-->
	</body>

js

	<script>
	    var m=angular.module('hd',[]);
	    m.controller('ctrl',['$scope',function ($scope) {
	        $scope.data=[
	            {id:1,click:100,title:'百度'},
	            {id:2,click:200,title:'谷歌'},
	            {id:3,click:300,title:'新浪百度'}
	        ];
	    }]);
	</script>

![](./images/orderby.gif)

## 控制器中使用过滤器服务 ##

html

	<body ng-app="hd" ng-controller="ctrl">
	{{data}}
	<hr>
	<button ng-click="orderby()">排序</button>
	</body>

js

	<script>
	    var m=angular.module('hd',[]);
	    m.controller('ctrl',['$scope','$filter',function ($scope,$filter) {
	        $scope.data=[
	            {id:1,click:100,title:'百度'},
	            {id:2,click:200,title:'谷歌'},
	            {id:3,click:300,title:'新浪百度'}
	        ];
	        $scope.orderby=function () {
	            $scope.data=$filter('orderBy')($scope.data,'id',true);
	        }
	    }]);
	</script>

![](./images/controller-orderby.gif)



callee与过滤器结合制作表格升降排序

html 

	<body ng-app="hd" ng-controller="ctrl">
	    <table border="1" width="600">
	        <tr>
	            <th ng-click="orderby('id')">编号</th>
	            <th ng-click="orderby('click')">点击数</th>
	            <th ng-click="orderby('title')">标题</th>
	        </tr>
	        <tr ng-repeat="v in data">
	            <td>{{v.id}}</td>
	            <td>{{v.click}}</td>
	            <td>{{v.title}}</td>
	        </tr>
	    </table>
	</body>

js

	<script>
	    var m=angular.module('hd',[]);
	    m.controller('ctrl',['$scope','$filter',function ($scope,$filter) {
	        $scope.data=[
	            {id:1,click:100,title:'百度'},
	            {id:2,click:200,title:'谷歌'},
	            {id:3,click:300,title:'新浪百度'}
	        ];
	        $scope.orderby=function (field) {
	            if(arguments.callee[field]==undefined){
	                arguments.callee[field]=false;
	            }
	            arguments.callee[field]=!arguments.callee[field];
	            $scope.data=$filter('orderBy')($scope.data,field,arguments.callee[field]);
	        }
	    }]);
	</script>

![](./images/callee.gif)

## $scope与过滤器结合制作表格升降排序 ##

html

	<body ng-app="hd" ng-controller="ctrl">
	    <table border="1" width="600">
	        <tr>
	            <th ng-click="orderby('id')">编号
	                <span ng-if="status.id">升序</span>
	                <span ng-if="!status.id">升序</span>
	            </th>
	            <th ng-click="orderby('click')">点击数
	                <span ng-if="status.click">升序</span>
	                <span ng-if="!status.click">升序</span>
	            </th>
	            <th ng-click="orderby('title')">标题
	                <span ng-if="status.title">升序</span>
	                <span ng-if="!status.title">升序</span>
	            </th>
	        </tr>
	        <tr ng-repeat="v in data">
	            <td>{{v.id}}</td>
	            <td>{{v.click}}</td>
	            <td>{{v.title}}</td>
	        </tr>
	    </table>
	{{status.id}}
	</body>

js
	
	<script>
	    var m=angular.module('hd',[]);
	    m.controller('ctrl',['$scope','$filter',function ($scope,$filter) {
	        $scope.data=[
	            {id:1,click:100,title:'百度'},
	            {id:2,click:200,title:'谷歌'},
	            {id:3,click:300,title:'新浪百度'}
	        ];
	        $scope.status={id:false,click:false,title:false};
	        $scope.orderby=function (field) {
	            $scope.status[field]=!$scope.status[field];
	            $scope.data=$filter('orderBy')($scope.data,field,$scope.status[field]);
	        }
	    }]);
	</script>



## $watch监听数据变化 ##

	<body ng-app="hd" ng-controller="ctrl">
	    标题：<input type="text" ng-model="news.title">{{error}}
	</body>
	<script>
	    var m=angular.module('hd',[]);
	    m.controller('ctrl',['$scope',function ($scope) {
	        $scope.news={title:''};
	        $scope.$watch('news',function (n,o) {
	            //console.log(n);
	            $scope.error=n.title.length>3 ?'标题长度不能大于3个': '';
	        },true);
	    }]);
	</script>


![](./images/swatch.gif)

## $watch和$filter过滤器数据筛选示例 ##

html

	<body ng-app="hd" ng-controller="ctrl">
	    搜索 <input type="text" ng-model="search">
	    <table border="1" width="600">
	        <tr>
	            <th>编号</th>
	            <th>点击数</th>
	            <th>标题</th>
	        </tr>
	        <tr ng-repeat="v in lists">
	            <td>{{v.id}}</td>
	            <td>{{v.click}}</td>
	            <td>{{v.title}}</td>
	        </tr>
	    </table>
	</body>

js

	<script>
	    var m=angular.module('hd',[]);
	    m.controller('ctrl',['$scope','$filter',function ($scope,$filter) {
	        $scope.data=[
	            {id:1,click:100,title:'百度'},
	            {id:2,click:200,title:'新浪'},
	            {id:3,click:300,title:'百度人'}
	        ];
	        //用于临时数据
	        $scope.lists=$scope.data;
	        $scope.$watch('search',function (newVal) {
	            $scope.lists=$filter('filter')($scope.data,newVal);
	        });
	    }]);
	</script>

![](./images/search.gif)


## 自定义过滤器之手机加* ##

html

	<body ng-app="hd" ng-controller="ctrl">
	    <table border="1" width="600">
	        <tr>
	            <th>编号</th>
	            <th>名称</th>
	            <th>手机</th>
	        </tr>
	        <tr ng-repeat="v in data">
	            <td>{{v.id}}</td>
	            <td>{{v.name}}</td>
	            <td>{{v.mobile|truncate:4}}</td>
	        </tr>
	    </table>
	</body>

js

	<script>
	    var m=angular.module('hd',[]);
	    m.filter('truncate',function () {
	        return function (mobile,len) {
	            len= len ? len :3;
	            return mobile.substr(0,11-len)+new String("*").repeat(len);
	        }
	    });
	    m.controller('ctrl',['$scope','$filter',function ($scope,$filter) {
	        $scope.data=[
	            {id:1,name:'张三',mobile:'13893404506'},
	            {id:2,name:'李四',mobile:'17092559941'},
	            {id:3,name:'王五',mobile:'15043234567'}
	        ];
	    }]);
	</script>

![](./images/mobile.gif)

## 自定义指令之directive的restricet属性 ##

html

	body ng-app="hd" ng-controller="ctrl">
	    <div gm-cms></div>
	    <hr>
	    <gm-cms></gm-cms>
	</body>

js

	<script>
	    var m=angular.module('hd',[]);
	    //驼峰命名规则  gmCms 在html中 gm-cms
	    m.directive('gmCms',[function () {
	        return{
	            restrict:'AE',//a -attr  e-element
	            template:'这是自定义指令'
	        }
	    }]);
	    m.controller('ctrl',['$scope','$filter',function ($scope,$filter) {
	
	    }]);
	</script>

![](./images/restrict.gif)


## 自定义指令之directive的template属性 ##

html

	<body ng-app="hd" ng-controller="ctrl">
	    <div gm-cms color="green">你好</div>
	</body>
	
js 
	
	<script>
	    var m=angular.module('hd',[]);
	    //驼峰命名规则  gmCms 在html中 gm-cms
	    m.directive('gmCms',[function () {
	        return{
	            restrict:'AEC',//a -attr  e-element
	            template:function (elem,attr) {
	                return "<span style='color: "+attr['color']+"'>"+$(elem).html()+"</span>";
	            }
	        }
	    }]);
	    m.controller('ctrl',['$scope','$filter',function ($scope,$filter) {
	
	    }]);
	</script>

![](./images/template.gif)


## 自定义指令之replace属性 ##

html

	<body ng-app="hd" ng-controller="ctrl">
	    <gm-cms></gm-cms>
	</body>

js


	<script>
	    var m=angular.module('hd',[]);
	    //驼峰命名规则  gmCms 在html中 gm-cms
	    m.directive('gmCms',[function () {
	        return{
	            restrict:'E',//a -attr  e-element
	            template:'<h1>国民</h1>',
	            replace:false
	        }
	       
	    }]);
	    m.controller('ctrl',['$scope','$filter',function ($scope,$filter) {
	
	    }]);
	</script>


- 当replace属性为false时

		<gm-cms><h1>国民</h1></gm-cms>

- 当replace属性为true时

		<h1>国民</h1>

![](./images/replace.gif)

## 自定义指令之trancclude,templateUrl属性 ##

html 

	<body ng-app="hd" ng-controller="ctrl">
	    <div gm-cms></div>
	</body>

js

	<script>
	    var m=angular.module('hd',[]);
	    //驼峰命名规则  gmCms 在html中 gm-cms
	    m.directive('gmCms',[function () {
	        return{
	            restrict:'EA',//a -attr  e-element
	            replace:true,
	            templateUrl:'./view/1.html'
	        }
	       
	    }]);
	    m.controller('ctrl',['$scope','$filter',function ($scope,$filter) {
	
	    }]);
	</script>

1.html

	<div>
	    aaaa;
	</div>

当使用replace时，模板文件一定要有一级块标签

![](./images/templateUrl.gif)

## scope作用域分析 ##

html 

	<body ng-app="hd" ng-controller="ctrl">
	    {{name}} <input type="text" ng-model="name">
	    <hr>
	    <gm-cms></gm-cms>
	    <hr>
	    <gm-cms></gm-cms>
	</body>

js

	<script>
	    var m=angular.module('hd',[]);
	    //驼峰命名规则  gmCms 在html中 gm-cms
	    m.directive('gmCms',[function () {
	        return{
	            restrict:'EA',//a -attr  e-element
	            template:' {{name}} <input type="text" ng-model="name">',
	            scope:{},
	        }
	        
	    }]);
	    m.controller('ctrl',['$scope','$filter',function ($scope,$filter) {
	        $scope.name='国民';
	    }]);
	</script>


- 当scope为false时，指令 ng-model互相影响，共享数据

- 当scope为true时,scope分离，ng-model会影响到gm-cms 但是gm-cms不会影响ng-model

- 当scope为{}时相互独立


## scope作用域分析之单向文本绑定 ##

html 


	<body ng-app="hd" ng-controller="ctrl">
	    <input type="color" ng-model="color">
	    <h1 gm-cms color="{{color}}"></h1>
	    <hr>
	</body>

js

	<script>
	    var m=angular.module('hd',[]);
	    //驼峰命名规则  gmCms 在html中 gm-cms
	    m.directive('gmCms',[function () {
	        return{
	            restrict:'EA',//a -attr  e-element
	            template:'<span style="color: {{color}};">百度网</span>',
	            scope:{color:'@'},
	        }
	    }]);
	    m.controller('ctrl',['$scope','$filter',function ($scope,$filter) {
	        $scope.name='国民';
	        $scope.color='red';
	    }]);
	</script>

![](./images/single-text-bind.gif)

