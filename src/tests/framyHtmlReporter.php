<?php
    class framyHtmlReporter extends HtmlReporter {
        /**
         *    Paints the end of the test with a summary of
         *    the passes and failures.
         *    @param string $test_name        Name class of test.
         *    @access public
         */
        function paintFooter($test_name) {
            $colour = ($this->getFailCount() + $this->getExceptionCount() > 0 ? "red" : "green");
            echo "<div style=\"";
            echo "padding: 8px; margin-top: 1em; background-color: $colour; color: white;";
            echo "\">";
            echo $this->getTestCaseProgress() . "/" . $this->getTestCaseCount();
            echo " test cases complete:\n";
            echo "<strong>" . $this->getPassCount() . "</strong> passes, ";
            echo "<strong>" . $this->getFailCount() . "</strong> fails and ";
            echo "<strong>" . $this->getExceptionCount() . "</strong> exceptions.";
            echo "</div>\n";
        }
    }
?>