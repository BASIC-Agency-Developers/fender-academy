app.controller('triviaController', function($scope, $http) {
	$scope.submit = false;

	$scope.$watch('submit', function(){
		$scope.submitText = $scope.submit ? 'Enter Now' : 'Select to Enter'
	})

	$scope.submitTrivia = function(){
		$http.get('/assets/json/trivia.json').success(function(response){
			$scope.showForm = false;
			$scope.results = response.results;
		});
	}
});