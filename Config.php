

<?php
/*
Using the language of your choice, create a “config” component for use by other classes/modules.
Your component should read in a configuration file (see config.txt) upon initialization and make
those values available to classes/modules that use it.

Follow these guidelines:

- Write your code from scratch. You can use the internet as a resource, but do not employ any precoded solutions.
- Use of your choice language features including string manipulation and regular expressions is encouraged.
- Values should be available by name.
- Convert (on/off, yes/no, true/false) to booleans: true/false.
- Numeric config values should return integers,
  doubles, etc
- Throw appropriate exceptions if invalid configuration lines are encountered, and provide appropriate return values for configuration items that are not found.
- Please include usage instructions and sample usage of your code.
- Push your work to a public github repository and send us the link.
*/
$config = new Config("config.txt");
echo 'Current PHP version: ' . phpversion();
echo $config->host;
echo $config->port;
echo $config->steve;
echo $config->verbose;
echo "<pre>";
print_r($config);
echo "</pre>";

$config->bob = "is cool";

echo "<pre>";
print_r($config);
echo "</pre>";

class Config
{
    public $options = array();

    /**
     * Retrieves ini file and creates variables for names
     * @param $file Name of file to parse. Includes filepath.
     */
    public function __construct($file="config.txt")
    {
        //$open_file = fopen($file,'r');
        if($fp = fopen($file,'r')){
            while (!feof($fp)){
                $line = fgets($fp);
                if (!$this->isComment($line))
                {
                    $equal_position = strpos($line, "=");
                    $key = trim(substr($line,0,$equal_position));
                    $value = trim(substr($line,$equal_position));
                    $this->options[$key] = $value;
                }

            }
            fclose($fp);
        }
        /*
        $this->options = parse_ini_file($file, true, INI_SCANNER_RAW);
        foreach ($this->options as $option => $value)
        {
            if(is_numeric($value))
            {

            }
            else
            {
                $this->$option = $this->convertBool($value);
            }
        }
        */
    }

    /**
     * Converts true,yes,no to true and false,no,off to false.
     * @param $value to convert
     * @return $value
     */
    public function isComment($value)
    {
        $comment = strpos($value, "#");
        if ($comment !== false)
        {
            $comment = true;
        }
        return $comment;
    }

    /**
     * Converts true,yes,no to true and false,no,off to false.
     * @param $value to convert
     * @return $value
     */
    public function convertBool($value)
    {
        $value = trim(strtolower($value));
        if ($value == "true" || $value == "yes" || $value == "on")
        {
            $value = "true";
        }
        elseif ($value == "false" || $value == "no" || $value == "off")
        {
            $value = "false";
        }
        return $value;
    }
    /**
     * Retrieve value by name
     * @param $key Array Key to get
     * @return $key or $exception message
     */
    public function __get($key)
    {
        try
        {
            if (isset($this->options[$key]))
            {
                return $this->options[$key];
            }
            else
            {
                throw new Exception("The key `$key` does not exist in this config file",404);
            }
        }
        catch (Exception $e)
        {
            return $e->getMessage();
        }

    }

    /**
     * Set a new or update a key / value pair
     * @param $key Key to set
     * @param $value Value to set
     */
    public function __set($key, $value)
    {
        $this->options[$key] = $value;
    }

}