<?php
/**  Josh Sheets
*    8-05-15
*    ThreatSTOP Coding Test
**/


class Config
{

    /**
     * Retrieves ini file and creates variables for names
     * @param $file Name of file to parse. Includes filepath.
     */
    public function __construct($file="config.txt")
    {
        if ($fp = fopen($file, 'r'))
        {
            while (!feof($fp)) {
                $line = fgets($fp);
                if (strlen($line) > 0)
                {
                    if (!self::isComment($line))
                    {
                        $equal_position = strpos($line, "=");

                        $key = trim(substr($line, 0, $equal_position));
                        $value = trim(substr($line, $equal_position + 1));
                        if (strlen($value) == 0 || $equal_position === FALSE)
                        {
                            throw new Exception("There is an error on line `$line`. File Processing halted", 500);
                        }
                        else
                        {
                            $value = self::convertBool($value);
                            $this->{$key} = $value;

                        }
                    }
                }
            }
            fclose($fp);
        }
        else
        {
            throw new Exception("Cannot open file `$file`. Instantiation halted", 500);
        }
    }

    /**
     * Converts true,yes,no to true and false,no,off to false.
     * @param $value to convert
     * @return $value
     */
    static function isComment($value)
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
    static function convertBool($value)
    {
        switch (strtolower($value)) {
            case '1':
            case 'true':
            case 'on':
            case 'yes':
                return true;
            case '0':
            case 'false':
            case 'off':
            case 'no':
                return false;
            default:
                return $value;
        }
    }

}