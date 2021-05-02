var app = angular.module('myApp', ['ngRoute']);

app.config(function ($httpProvider, $httpParamSerializerJQLikeProvider){
    $httpProvider.defaults.transformRequest.unshift($httpParamSerializerJQLikeProvider.$get());
    $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded; charset=utf-8';
});

app.config(function($routeProvider) {

	$routeProvider
	.when('/', {
	templateUrl : './components/landing/home.php',
	controller : 'HomeController'
	})
	.when('/login', {
	templateUrl : './components/login/login.php',
	controller : 'LoginController'
	})
	.when('/register', {
	templateUrl : './components/register/register.php',
	controller : 'RegisterController'
	})
	.when('/ratings', {
	templateUrl : './components/ratings/ratings.php',
	controller : 'ReviewsController'
	})
	.when('/suggestions', {
	templateUrl : './components/suggestions/suggestions.html'
	})
	.when('/service_a', {
	templateUrl : './components/service_a/service_a.html',
	controller : 'CarController'
	})
	.when('/service_b', {
	templateUrl : './components/service_b/service_b.html',
	controller : 'BController'
	})
	.when('/service_c', {
	templateUrl : './components/service_c/service_c.html',
	controller : 'CController'
	})
	.when('/shop1', {
	templateUrl : './components/coffee_shop/coffee_shop.html',
	controller : 'CoffeeController'
	})
	.when('/shop2', {
	templateUrl : './components/flower_shop/flower_shop.html',
	controller : 'FlowerController'
	})
	.when('/checkout', {
	templateUrl : './components/checkout/checkout.html',
	controller : 'CheckoutController'
	})
	.when('/c_shop1', {
	templateUrl : './components/service_c/green_coffee_shop.html',
	controller : 'Green_CoffeeController'
	})
	.when('/c_shop2', {
	templateUrl : './components/service_c/green_flower_shop.html',
	controller : 'Green_FlowerController'
	})
	.when('/c_ride', {
	templateUrl : './components/service_c/car_ride.html',
	controller : 'Green_CarController'
	})
	.when('/compare', {
	templateUrl : './components/service_c/compare.html',
	controller : 'Compare_Controller'
	})
    .when('/maintain/insert', {
	templateUrl : './components/maintain_insert/maintain_insert.html'
	})
    .when('/maintain/delete', {
	templateUrl : './components/maintain_delete/maintain_delete.html'
	})
    .when('/maintain/select', {
	templateUrl : './components/maintain_select/maintain_select.html'
	})
    .when('/maintain/update', {
	templateUrl : './components/maintain_update/maintain_update.html'
	})
	.otherwise({redirectTo: '/'});
});

app.run(function($rootScope) {
	$rootScope.$on("$locationChangeStart", function(event, next, current) { 
		if (next.endsWith('#!/') || next.endsWith('/#about') || next.endsWith('/#contact') || next.endsWith('/#top')) {
			$('#order_query').addClass("d-flex")
			$('#order_query').show();
		} else {
			$('#order_query').removeClass("d-flex")
			$('#order_query').hide();
		}
		
	});
	$rootScope.$on("$locationChangeSuccess", function(event, newUrl, oldUrl) {
		console.log("went from " + oldUrl + " to " + newUrl);
		if (oldUrl.endsWith('login') && newUrl.endsWith('app/')) {
			$rootScope.reloadHeader = true;
			console.log("making reloadHeader true");
			window.location.reload();
		}
	}); 
});

app.controller('HomeController', function($scope, $http) {$scope.message = 'Hello from home';});

app.controller('LoginController', function($scope, $http) {
	$scope.myBackgroundUrl = "../assets/img/login_register/birds.jpeg"

	$scope.submit = function(e) {
        $http.post('../server/login_verification.php', 
            {
              username: document.getElementById('username').value,
              password: document.getElementById('password').value,
              remember: document.getElementById('remember-me').checked
            }).then (
            function(response) {
              if (response.data !== "success") {
                document.getElementById('error').innerHTML ="Incorrect Username or Password. Please try again"
              }
              else {
              	window.location = "#"
              }
            }
        );
    };
});

app.controller('RegisterController', function($scope, $http) {
	$scope.myBackgroundUrl = "../assets/img/login_register/birds.jpeg"
	
	$scope.submit = function() {
		obj = {
				username: document.getElementById('username').value,
				password: document.getElementById('password').value,
				email: document.getElementById('email').value,
				phone: document.getElementById('phone').value,
				name: document.getElementById('name').value
			}
		$http.post('../server/register_user.php', obj)
			.then (function(response) {
				if (response.data !== "success") {
					console.log(response);
				}
				else {
					window.location = "#!login"
				}
			});
		};
});

app.controller('ReviewsController', function($scope, $http) {	$scope.message = 'Hello from reviews';});

app.controller('BController', function($scope, $http) {
	$scope.message = 'Hello from B';
	$http.get('../server/get_shops.php')
		.then( function (response) {$scope.shops = response.data.records;})
});

app.controller('CController', function($scope, $http) {
	$scope.message = 'Hello from C';
	$http.get('../server/get_shops.php')
		.then( function (response) {$scope.shops = response.data.records;})
});

app.controller('FlowerController', function($scope, $http, $timeout, cartService, checkoutInfoService) {
	a = new Date();
	document.getElementById('date').valueAsDate = a;
	document.getElementById('time').value = a.toLocaleTimeString('fr-FR', {hour: '2-digit', minute:'2-digit'});
	//get shop info
	var obj = {};
	obj["id"] = 2;
	$http.post('../server/get_shop_info.php', obj).then( function (response) {
		$scope.shopinfo = response.data;
	});
	//get products
	var obj = {};
	obj["category"] = "flowershop";
	$http.post('../server/get_products.php', obj).then( function (response) {
		$scope.products = response.data.records;
	});
	//make draggable?
	$timeout(function() {
   		setDraggable();
	}, 1000); // 1 seconds
	//TODO: on submit the products in the cart should be sent to the cartService. Info included should be source, dest, time, data, price, name, image
	$scope.submitCart = function() {
		$scope.checkoutInfo = {
			'start_address' : document.getElementById('start_address').value,
			'end_address' : document.getElementById('end_address').value,
			'date' : document.getElementById('date').value,
			'time' : document.getElementById('time').value,
			}
		$scope.productInfo = {
		  'product_info' : document.getElementById("cart").childNodes[3].children[1].children[0].innerHTML,
		  'product_price' : document.getElementById("cart").childNodes[3].children[1].children[1].innerHTML,
		  'product_img' : document.getElementById("cart").childNodes[3].children[0].src,
		  'product_id' : document.getElementById("cart").childNodes[3].id,
		  'category' : "Flower"
			}

		if (validateCheckout($scope.checkoutInfo)) {
			cartService.clearProducts();
			checkoutInfoService.clearInfo();
			cartService.addProduct($scope.productInfo);
			checkoutInfoService.addcheckoutInfo($scope.checkoutInfo);
			window.location.href = "#!checkout"
		}
	};
});

app.controller('CoffeeController', function($scope, $http, $timeout, cartService, checkoutInfoService) {
	$scope.message = 'Hello from shop';
	a = new Date();
	document.getElementById('date').valueAsDate = a;
	document.getElementById('time').value = a.toLocaleTimeString('fr-FR', {hour: '2-digit', minute:'2-digit'});
	// default post header
	$http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
	//get shop info
	var obj = {};
	obj["id"] = 1;
	$http.post('../server/get_shop_info.php', obj)
	.then( function (response) {$scope.shopinfo = response.data;})
	//get products
	var obj = {};
	obj["category"] = "coffeeshop";
	$http.post('../server/get_products.php', obj)
	.then( function (response) {$scope.products = response.data.records;})
	//make draggable?
	$timeout(function() {
			setDraggable();
	}, 1000); // 1 seconds
	//TODO: on submit the products in the cart should be sent to the cartService. Info included should be source, dest, time, data, price, name, image
	$scope.submitCart = function() {
		$scope.checkoutInfo = {
			'start_address' : document.getElementById('start_address').value,
			'end_address' : document.getElementById('end_address').value,
			'date' : document.getElementById('date').value,
			'time' : document.getElementById('time').value,
			}
		$scope.productInfo = {
		  'product_info' : document.getElementById("cart").childNodes[3].children[1].children[0].innerHTML,
		  'product_price' : document.getElementById("cart").childNodes[3].children[1].children[1].innerHTML,
		  'product_img' : document.getElementById("cart").childNodes[3].children[0].src,
		  'product_id' : document.getElementById("cart").childNodes[3].id,
		  'category' : "Coffee"
			}

		if (validateCheckout($scope.checkoutInfo)) {
			cartService.clearProducts();
			checkoutInfoService.clearInfo();
			cartService.addProduct($scope.productInfo);
			checkoutInfoService.addcheckoutInfo($scope.checkoutInfo);
			window.location.href = "#!checkout"
		}
	};
});

app.controller('CarController', function($scope, $http, $timeout, cartService, checkoutInfoService) {
	a = new Date();
	document.getElementById('date').valueAsDate = a;
	document.getElementById('time').value = a.toLocaleTimeString('fr-FR', {hour: '2-digit', minute:'2-digit'});
	$scope.message = 'Hello from cars';
	// default post header
	$http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
	//get cars
	$http.post('../server/get_cars.php')
	.then( function (response) {$scope.cars = response.data.records;})

	$timeout(function() {
		setDraggable();
	}, 1000); // 1 seconds
	$scope.submitCart = function() {
		$scope.checkoutInfo = {
			'start_address' : document.getElementById('start_address').value,
			'end_address' : document.getElementById('end_address').value,
			'date' : document.getElementById('date').value,
			'time' : document.getElementById('time').value,
			}
		$scope.productInfo = {
			'product_info' : document.getElementById("cart").childNodes[3].children[1].children[0].innerHTML,
			'product_price' : document.getElementById("cart").childNodes[3].children[1].children[1].innerHTML,
			'product_img' : document.getElementById("cart").childNodes[3].children[0].src,
			'product_id' : document.getElementById("cart").childNodes[3].id,
			'category' : "Car"
		}

		if (validateCheckout($scope.checkoutInfo)) {
			cartService.clearProducts();
			checkoutInfoService.clearInfo();
			cartService.addProduct($scope.productInfo);
			checkoutInfoService.addcheckoutInfo($scope.checkoutInfo);
			window.location.href = "#!checkout"
		}
	};
});

app.controller('CheckoutController', function($scope, $http, cartService, checkoutInfoService) {
    $scope.products = cartService.getProducts();
    $scope.checkoutInfo = checkoutInfoService.getcheckoutInfo();
});

app.controller('OrderFormController', function($scope, $http, cartService, checkoutInfoService) {
	$scope.products = cartService.getProducts();
    $scope.checkoutInfo = checkoutInfoService.getcheckoutInfo();
	$scope.submit = function() {
    	//validate all fields

    	//submit to db
		var obj = {};;
		var trip = {};
		var pay = {};
		var price = parseFloat($scope.products[0].product_price.substring(1))

		trip['city'] = 'Toronto';
		trip['source'] = $scope.checkoutInfo[0].start_address;
		trip['dest'] = $scope.checkoutInfo[0].end_address;
		trip['dist'] = $('#dist').val();
		if ($scope.products.category == "Car"){
			trip['car'] = $scope.products[0].product_info;
		}else{
			trip['car'] = ''
		}
		trip['price'] = price;
		  
		pay['first'] = $('#first_name').val();
		pay['last'] = $('#last_name').val();
		pay['card'] = $('#card_number').val();
		pay['exp'] = $('#card_expiry').val();
		pay['cvv'] = $('#card_cvv').val();
		 
		obj["iss"] = dateToDatetime();
		obj["price"] = price;
		obj["pay_code"] = 'PROCESSING';
		if ($scope.products[0].category == "Car"){
			obj['car'] = $scope.products[0].product_id;
			obj["flower"] = '';
			obj["coffee"] = '';
		}else if ($scope.products[0].category == "Flower"){
			obj['car'] = '';
			obj["flower"] = $scope.products[0].product_id;
			obj["coffee"] = '';
		} else if ($scope.products[0].category == "Coffee"){
			obj['car'] = '';
			obj["flower"] = '';
			obj["coffee"] = $scope.products[0].product_id;
		}
		obj["desc"] = $scope.products[0].product_info;
		  
		obj['trip'] = trip;
		obj['pay'] = pay;
      
		$http.post('../server/order_confirmed.php', obj).then (
		    function(response) {
		    if (response.data !== "order insertion success") {
		    	console.log(response.data);
		    	afterOrderFailure();
		    } else {
		        afterOrderSuccess();
		        console.log("success");
		        setTimeout(function() {
			    	window.location.href = "#!";
			    }, 3000);
		    }    
	    });
	    
	};
});

app.controller('Green_FlowerController', function($scope, $http, $timeout, cartService, checkoutInfoService) {
	a = new Date();
	document.getElementById('date_1').valueAsDate = a;
	document.getElementById('time_1').value = a.toLocaleTimeString('fr-FR', {hour: '2-digit', minute:'2-digit'});
	document.getElementById('date_2').valueAsDate = a;
	document.getElementById('time_2').value = a.toLocaleTimeString('fr-FR', {hour: '2-digit', minute:'2-digit'});
	//get shop info
	var obj = {};
	obj["id"] = 2;
	$http.post('../server/get_shop_info.php', obj).then( function (response) {
		$scope.shopinfo = response.data;
	});
	//get products
	var obj = {};
	obj["category"] = "flowershop";
	$http.post('../server/get_products.php', obj).then( function (response) {
		$scope.products = response.data.records;
	});
	//make draggable?
	$timeout(function() {
   		setDraggable();
	}, 1000); // 1 seconds
	$scope.submitCart = function() {
		$scope.checkoutInfo = {
			'start_address' : document.getElementById('start_address_1').value,
			'end_address' : document.getElementById('end_address_1').value,
			'date' : document.getElementById('date_1').value,
			'time' : document.getElementById('time_1').value,
			}
		$scope.productInfo = {
		  'product_info' : document.getElementById("cart").childNodes[3].children[1].children[0].innerHTML,
		  'product_price' : document.getElementById("cart").childNodes[3].children[1].children[1].innerHTML,
		  'product_img' : document.getElementById("cart").childNodes[3].children[0].src,
		  'product_id' : document.getElementById("cart").childNodes[3].id,
		  'category' : "Flower"
			}
		
		if (validateCheckout($scope.checkoutInfo)) {
			cartService.clearProducts();
			checkoutInfoService.clearInfo();
			cartService.addProduct($scope.productInfo);
			checkoutInfoService.addcheckoutInfo($scope.checkoutInfo);

			$scope.checkoutInfo = {
				'start_address' : document.getElementById('start_address_2').value,
				'end_address' : document.getElementById('end_address_2').value,
				'date' : document.getElementById('date_2').value,
				'time' : document.getElementById('time_2').value,
				}
			$scope.productInfo = {
				'product_info' : document.getElementById("cart").childNodes[4].children[1].children[0].innerHTML,
				'product_price' : document.getElementById("cart").childNodes[4].children[1].children[1].innerHTML,
				'product_img' : document.getElementById("cart").childNodes[4].children[0].src,
				'product_id' : document.getElementById("cart").childNodes[4].id,
				'category' : "Flower"
				}

			if (validateCheckout($scope.checkoutInfo)) {
				cartService.addProduct($scope.productInfo);
				checkoutInfoService.addcheckoutInfo($scope.checkoutInfo);
				window.location.href = "#!compare"
			}
		}
	};
});

app.controller('Green_CoffeeController', function($scope, $http, $timeout, cartService, checkoutInfoService) {
	a = new Date();
	document.getElementById('date_1').valueAsDate = a;
	document.getElementById('time_1').value = a.toLocaleTimeString('fr-FR', {hour: '2-digit', minute:'2-digit'});
	document.getElementById('date_2').valueAsDate = a;
	document.getElementById('time_2').value = a.toLocaleTimeString('fr-FR', {hour: '2-digit', minute:'2-digit'});
	//get shop info
	var obj = {};
	obj["id"] = 1;
	$http.post('../server/get_shop_info.php', obj)
	.then( function (response) {$scope.shopinfo = response.data;})
	//get products
	var obj = {};
	obj["category"] = "coffeeshop";
	$http.post('../server/get_products.php', obj)
	.then( function (response) {$scope.products = response.data.records;})
	//make draggable?
	$timeout(function() {
			setDraggable();
	}, 1000); // 1 seconds
	$scope.submitCart = function() {
		$scope.checkoutInfo = {
			'start_address' : document.getElementById('start_address_1').value,
			'end_address' : document.getElementById('end_address_1').value,
			'date' : document.getElementById('date_1').value,
			'time' : document.getElementById('time_1').value,
			}
		$scope.productInfo = {
		  'product_info' : document.getElementById("cart").childNodes[3].children[1].children[0].innerHTML,
		  'product_price' : document.getElementById("cart").childNodes[3].children[1].children[1].innerHTML,
		  'product_img' : document.getElementById("cart").childNodes[3].children[0].src,
		  'product_id' : document.getElementById("cart").childNodes[3].id,
		  'category' : "Coffee"
			}

		if (validateCheckout($scope.checkoutInfo)) {

			cartService.clearProducts();
			checkoutInfoService.clearInfo();
			cartService.addProduct($scope.productInfo);
			checkoutInfoService.addcheckoutInfo($scope.checkoutInfo);
			$scope.checkoutInfo = {
				'start_address' : document.getElementById('start_address_2').value,
				'end_address' : document.getElementById('end_address_2').value,
				'date' : document.getElementById('date_2').value,
				'time' : document.getElementById('time_2').value,
				}
			$scope.productInfo = {
				'product_info' : document.getElementById("cart").childNodes[4].children[1].children[0].innerHTML,
				'product_price' : document.getElementById("cart").childNodes[4].children[1].children[1].innerHTML,
				'product_img' : document.getElementById("cart").childNodes[4].children[0].src,
				'product_id' : document.getElementById("cart").childNodes[4].id,
				'category' : "Coffee"
				}

			if (validateCheckout($scope.checkoutInfo)) {
				cartService.addProduct($scope.productInfo);
				checkoutInfoService.addcheckoutInfo($scope.checkoutInfo);
				window.location.href = "#!compare"
			}
		}
	};
});

app.controller('Green_CarController', function($scope, $http, $timeout, cartService, checkoutInfoService) {
	a = new Date();
	document.getElementById('date_1').valueAsDate = a;
	document.getElementById('time_1').value = a.toLocaleTimeString('fr-FR', {hour: '2-digit', minute:'2-digit'});
	document.getElementById('date_2').valueAsDate = a;
	document.getElementById('time_2').value = a.toLocaleTimeString('fr-FR', {hour: '2-digit', minute:'2-digit'});
	//get cars
	$http.post('../server/get_cars.php')
	.then( function (response) {$scope.cars = response.data.records;})

	$timeout(function() {
		setDraggable();
	}, 1000); // 1 seconds
	$scope.submitCart = function() {
		$scope.checkoutInfo = {
			'start_address' : document.getElementById('start_address_1').value,
			'end_address' : document.getElementById('end_address_1').value,
			'date' : document.getElementById('date_1').value,
			'time' : document.getElementById('time_1').value,
			}
		$scope.productInfo = {
		  'product_info' : document.getElementById("cart").childNodes[3].children[1].children[0].innerHTML,
		  'product_price' : document.getElementById("cart").childNodes[3].children[1].children[1].innerHTML,
		  'product_img' : document.getElementById("cart").childNodes[3].children[0].src,
		  'product_id' : document.getElementById("cart").childNodes[3].id,
		  'category' : "Car"
			}

		if (validateCheckout($scope.checkoutInfo)) {
			cartService.clearProducts();
			checkoutInfoService.clearInfo();
			cartService.addProduct($scope.productInfo);
			checkoutInfoService.addcheckoutInfo($scope.checkoutInfo);
			$scope.checkoutInfo = {
				'start_address' : document.getElementById('start_address_2').value,
				'end_address' : document.getElementById('end_address_2').value,
				'date' : document.getElementById('date_2').value,
				'time' : document.getElementById('time_2').value,
				}
			$scope.productInfo = {
				'product_info' : document.getElementById("cart").childNodes[4].children[1].children[0].innerHTML,
				'product_price' : document.getElementById("cart").childNodes[4].children[1].children[1].innerHTML,
				'product_img' : document.getElementById("cart").childNodes[4].children[0].src,
				'product_id' : document.getElementById("cart").childNodes[4].id,
				'category' : "Car"
				}

			if (validateCheckout($scope.checkoutInfo)) {
				cartService.addProduct($scope.productInfo);
				checkoutInfoService.addcheckoutInfo($scope.checkoutInfo);
				window.location.href = "#!compare"
			}
		}		
	};
});

app.controller('Compare_Controller', function($scope, $http, cartService, checkoutInfoService) {
    $scope.products = cartService.getProducts();
    $scope.checkoutInfo = checkoutInfoService.getcheckoutInfo();

		$http.post('../server/get_rating.php', {desc: $scope.products[0]['product_info']})
		.then( function (response) {$scope.rating_item1 = response.data.average;})

		$http.post('../server/get_rating.php', {desc: $scope.products[1]['product_info']})
		.then( function (response) {$scope.rating_item2 = response.data.average;})

    $scope.submitChoice1 = function() {
    	cartService.clearSecond();
    	checkoutInfoService.clearSecond();
		window.location.href = "#!checkout";
	};

	$scope.submitChoice2 = function() {
		cartService.clearFirst();
    	checkoutInfoService.clearFirst();
		window.location.href = "#!checkout";
	};
});

app.factory('cartService', function() {
  var productList = [];

  var addProduct = function(newObj) {
      productList.push(newObj);
  };

  var getProducts = function(){
      return productList;
  };

  var getNumOfProducts = function(){
      return productList.length;
  };

  var clearProducts = function() {
  	  productList = [];
  }
    var clearFirst = function() {
  	  productList.shift();
  }
  var clearSecond = function() {
  	  productList.pop();
  }

  return {
    addProduct: addProduct,
    clearProducts: clearProducts,
    getNumOfProducts: getNumOfProducts,
    clearFirst: clearFirst,
    clearSecond: clearSecond,
    getProducts: getProducts
  };
});

app.factory('checkoutInfoService', function() {
  var checkoutInfo = [];

  var addcheckoutInfo = function(newObj) {
      checkoutInfo.push(newObj);
  };

  var getcheckoutInfo = function(){
      return checkoutInfo;
  };
  var getNumOfCheckoutInfo = function(){
      return checkoutInfo.length;
  };
  var clearInfo = function() {
  	  checkoutInfo = [];
  }
  var clearFirst = function() {
  	  checkoutInfo.shift();
  }
  var clearSecond = function() {
  	  checkoutInfo.pop();
  }
  //need a way to also remove info once it has been passed to the checkout page
  return {
    addcheckoutInfo: addcheckoutInfo,
    getNumOfCheckoutInfo: getNumOfCheckoutInfo,
    clearInfo: clearInfo,
    clearFirst: clearFirst,
    clearSecond: clearSecond,
    getcheckoutInfo: getcheckoutInfo
  };
});

function validateCheckout(params) {
	var start_address = params['start_address'];
  var end_address = params['end_address'];
  var date = params['date'];
  var time = params['time'];

	if (time == undefined || date == '' || start_address == '' || end_address == '') {
    alert('Entries must be filled in order to proceed.');
		return false;
	} else {
		return true;
	}
}