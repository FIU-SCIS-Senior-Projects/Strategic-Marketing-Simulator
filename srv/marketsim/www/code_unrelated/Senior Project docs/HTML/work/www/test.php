<html ng-app>
    <head>
        <title>Cascading Dropdowns in AngularJs :devzone.co.in </title>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/angularjs/1.0.7/angular.min.js"></script>
        <script>
            function CountryCntrl($scope) {
                $scope.countries = {
                    'India': {
                        'Maharashtra': ['Pune', 'Mumbai', 'Nagpur', 'Akola'],
                        'Madhya Pradesh': ['Indore', 'Bhopal', 'Jabalpur'],
                        'Rajasthan': ['Jaipur', 'Ajmer', 'Jodhpur']
                    },
                    'USA': {
                        'Alabama': ['Montgomery', 'Birmingham'],
                        'California': ['Sacramento', 'Fremont'],
                        'Illinois': ['Springfield', 'Chicago']
                    },
                    'Australia': {
                        'New South Wales': ['Sydney'],
                        'Victoria': ['Melbourne']
                    }
                };
            }
        </script>
    </head>
    <body>
 
        <div ng-controller="CountryCntrl">
            <div>
                Country: 
                <select id="country" ng-model="states" ng-options="country for (country, states) in countries">
                    <option value=''>Select</option>
                </select>
            </div>
            <div>
                States: <select id="state" ng-disabled="!states" ng-model="cities" ng-options="state for (state,city) in states"><option value=''>Select</option></select>
            </div>
            <div>
                City: <select id="city" ng-disabled="!cities || !states" ng-model="city"><option value=''>Select</option> <option ng-repeat="city in cities" value='{{city}}'>{{city}}</option></select>        
            </div>
        </div>
 
    </body>
</html>