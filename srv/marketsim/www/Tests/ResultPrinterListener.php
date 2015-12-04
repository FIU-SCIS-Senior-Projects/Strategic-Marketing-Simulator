<?php

class ResultPrinterListener implements PHPUnit_Framework_TestListener {

    protected $suites = array();

    public function addError(PHPUnit_Framework_Test $test, Exception $e, $time) {}
    public function addFailure(PHPUnit_Framework_Test $test, PHPUnit_Framework_AssertionFailedError $e, $time) {}
    public function addIncompleteTest(PHPUnit_Framework_Test $test, Exception $e, $time) {}
    public function addSkippedTest(PHPUnit_Framework_Test $test, Exception $e, $time) {}
    public function startTest(PHPUnit_Framework_Test $test) {}
    public function endTest(PHPUnit_Framework_Test $test, $time) {}
    public function startTestSuite(PHPUnit_Framework_TestSuite $suite) {}
	public function addriskyTest(PHPUnit_Framework_Test $test, Exception $e, $time){}

    public function endTestSuite(PHPUnit_Framework_TestSuite $suite) {
        $this->suites[] = $suite;
    }

    public function __destruct() {
        $tests = array();
        foreach($this->suites as $suite) {
            foreach($suite->tests() as $test) {
                if(!$test instanceOf PHPUnit_Framework_TestCase) {
                    continue;
                }

                $testClass = get_class($test);
                $classUnderTest = substr($testClass, 0, -4);  // just cutting the "Test" for now
                /**
                 * Create an array structue
                 *   array[ClassUnderTests][methodUnderTest][arrayOfTestMethodsThatTestThatMethod]
                 * Every method for a class you have at least one test for will show up here for now
                 */
                if(!isset($tests[$classUnderTest])) {
                    if(!class_exists($classUnderTest)) {
                        echo "\nCan't find matching class '$classUnderTest' for test class $testClass!\n";
                    }
                    $class = new ReflectionClass($classUnderTest);
                    foreach($class->getMethods() as $method) {
                        $tests[$classUnderTest][$method->getName()] = array();
                    }
                }
                $annotations = $test->getAnnotations();
                if(!isset($annotations["method"]["covers"])) {
                    continue;
                }

                foreach($annotations["method"]["covers"] as $functionUnderTest) {

                    $statusLine = "";
                    $status = $test->getStatus();
                    if($status == PHPUnit_Runner_BaseTestRunner::STATUS_FAILURE) {
                        $statusLine .= "fail - ";
                    } else if($status == PHPUnit_Runner_BaseTestRunner::STATUS_SKIPPED) {
                        $statusLine .= "skip - ";
                    } else if($status == PHPUnit_Runner_BaseTestRunner::STATUS_INCOMPLETE) {
                        $statusLine .= "inc  - ";
                    } else {
                        $statusLine .= "ok   - ";
                    }
                    $statusLine .= $testClass."::".$test->getName();
                    $tests[$classUnderTest][$functionUnderTest][] = $statusLine;
               }
            }
        }
        foreach($tests as $classUnderTest => $methods) {
            echo "\n\n --- $classUnderTest --- \n\n";
            foreach($methods as $method => $testCaseStrings) {
               // echo "-- $classUnderTest::$method -- \n";
                if($testCaseStrings == array()) {
                    //echo "  !! Method untested !!\n";
                    continue;
                }
                foreach($testCaseStrings as $testCaseString) {
                    echo "  $testCaseString\n";
                }
                echo "\n";
            }

        }
    }

}
?>