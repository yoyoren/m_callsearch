<?php
/**
 * ����������
*/

/**
 * ����û�����ʵIP��ַ
 */
function real_ip()
{
    static $realip = NULL;

    if ($realip !== NULL)
    {
        return $realip;
    }

    if (isset($_SERVER))
    {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);

            /* ȡX-Forwarded-For�е�һ����unknown����ЧIP�ַ��� */
            foreach ($arr AS $ip)
            {
                $ip = trim($ip);

                if ($ip != 'unknown')
                {
                    $realip = $ip;

                    break;
                }
            }
        }
        elseif (isset($_SERVER['HTTP_CLIENT_IP']))
        {
            $realip = $_SERVER['HTTP_CLIENT_IP'];
        }
        else
        {
            if (isset($_SERVER['REMOTE_ADDR']))
            {
                $realip = $_SERVER['REMOTE_ADDR'];
            }
            else
            {
                $realip = '0.0.0.0';
            }
        }
    }
    else
    {
        if (getenv('HTTP_X_FORWARDED_FOR'))
        {
            $realip = getenv('HTTP_X_FORWARDED_FOR');
        }
        elseif (getenv('HTTP_CLIENT_IP'))
        {
            $realip = getenv('HTTP_CLIENT_IP');
        }
        else
        {
            $realip = getenv('REMOTE_ADDR');
        }
    }

    preg_match("/[\d\.]{7,15}/", $realip, $onlineip);
    $realip = !empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0';

    return $realip;
}

/**
 * ����û�����ϵͳ�Ļ��з�
 *
 * @access  public
 * @return  string
 */
function get_crlf()
{
/* LF (Line Feed, 0x0A, \N) �� CR(Carriage Return, 0x0D, \R) */
    if (stristr($_SERVER['HTTP_USER_AGENT'], 'Win'))
    {
        $the_crlf = '\r\n';
    }
    elseif (stristr($_SERVER['HTTP_USER_AGENT'], 'Mac'))
    {
        $the_crlf = '\r'; // for old MAC OS
    }
    else
    {
        $the_crlf = '\n';
    }

    return $the_crlf;
}

if (!function_exists('file_get_contents'))
{
    /**
     * ���ϵͳ������file_get_contents�����������ú���
     *
     * @access  public
     * @param   string  $file
     * @return  mix
     */
    function file_get_contents($file)
    {
        if (($fp = @fopen($file, 'rb')) === false)
        {
            return false;
        }
        else
        {
            $fsize = @filesize($file);
            if ($fsize)
            {
                $contents = fread($fp, $fsize);
            }
            else
            {
                $contents = '';
            }
            fclose($fp);

            return $contents;
        }
    }
}

if (!function_exists('file_put_contents'))
{
    define('FILE_APPEND', 'FILE_APPEND');

    /**
     * ���ϵͳ������file_put_contents�����������ú���
     *
     * @access  public
     * @param   string  $file
     * @param   mix     $data
     * @return  int
     */
    function file_put_contents($file, $data, $flags = '')
    {
        $contents = (is_array($data)) ? implode('', $data) : $data;

        if ($flags == 'FILE_APPEND')
        {
            $mode = 'ab+';
        }
        else
        {
            $mode = 'wb';
        }

        if (($fp = @fopen($file, $mode)) === false)
        {
            return false;
        }
        else
        {
            $bytes = fwrite($fp, $contents);
            fclose($fp);

            return $bytes;
        }
    }
}

if (!function_exists('floatval'))
{
    /**
     * ���ϵͳ������ floatval �����������ú���
     *
     * @access  public
     * @param   mix     $n
     * @return  float
     */
    function floatval($n)
    {
        return (float) $n;
    }
}

/**
 * �ļ���Ŀ¼Ȩ�޼�麯��
 *
 * @access          public
 * @param           string  $file_path   �ļ�·��
 * @param           bool    $rename_prv  �Ƿ��ڼ���޸�Ȩ��ʱ���ִ��rename()������Ȩ��
 *
 * @return          int     ����ֵ��ȡֵ��ΧΪ{0 <= x <= 15}��ÿ��ֵ��ʾ�ĺ��������λ������������Ƴ���
 *                          ����ֵ�ڶ����Ƽ������У���λ�ɸߵ��ͷֱ����
 *                          ��ִ��rename()����Ȩ�ޡ��ɶ��ļ�׷������Ȩ�ޡ���д���ļ�Ȩ�ޡ��ɶ�ȡ�ļ�Ȩ�ޡ�
 */
function file_mode_info($file_path)
{
    /* ��������ڣ��򲻿ɶ�������д�����ɸ� */
    if (!file_exists($file_path))
    {
        return false;
    }

    $mark = 0;

    if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN')
    {
        /* �����ļ� */
        $test_file = $file_path . '/cf_test.txt';

        /* �����Ŀ¼ */
        if (is_dir($file_path))
        {
            /* ���Ŀ¼�Ƿ�ɶ� */
            $dir = @opendir($file_path);
            if ($dir === false)
            {
                return $mark; //���Ŀ¼��ʧ�ܣ�ֱ�ӷ���Ŀ¼�����޸ġ�����д�����ɶ�
            }
            if (@readdir($dir) !== false)
            {
                $mark ^= 1; //Ŀ¼�ɶ� 001��Ŀ¼���ɶ� 000
            }
            @closedir($dir);

            /* ���Ŀ¼�Ƿ��д */
            $fp = @fopen($test_file, 'wb');
            if ($fp === false)
            {
                return $mark; //���Ŀ¼�е��ļ�����ʧ�ܣ����ز���д��
            }
            if (@fwrite($fp, 'directory access testing.') !== false)
            {
                $mark ^= 2; //Ŀ¼��д�ɶ�011��Ŀ¼��д���ɶ� 010
            }
            @fclose($fp);

            @unlink($test_file);

            /* ���Ŀ¼�Ƿ���޸� */
            $fp = @fopen($test_file, 'ab+');
            if ($fp === false)
            {
                return $mark;
            }
            if (@fwrite($fp, "modify test.\r\n") !== false)
            {
                $mark ^= 4;
            }
            @fclose($fp);

            /* ���Ŀ¼���Ƿ���ִ��rename()������Ȩ�� */
            if (@rename($test_file, $test_file) !== false)
            {
                $mark ^= 8;
            }
            @unlink($test_file);
        }
        /* ������ļ� */
        elseif (is_file($file_path))
        {
            /* �Զ���ʽ�� */
            $fp = @fopen($file_path, 'rb');
            if ($fp)
            {
                $mark ^= 1; //�ɶ� 001
            }
            @fclose($fp);

            /* �����޸��ļ� */
            $fp = @fopen($file_path, 'ab+');
            if ($fp && @fwrite($fp, '') !== false)
            {
                $mark ^= 6; //���޸Ŀ�д�ɶ� 111�������޸Ŀ�д�ɶ�011...
            }
            @fclose($fp);

            /* ���Ŀ¼���Ƿ���ִ��rename()������Ȩ�� */
            if (@rename($test_file, $test_file) !== false)
            {
                $mark ^= 8;
            }
        }
    }
    else
    {
        if (@is_readable($file_path))
        {
            $mark ^= 1;
        }

        if (@is_writable($file_path))
        {
            $mark ^= 14;
        }
    }

    return $mark;
}

/**
 * ���Ŀ���ļ����Ƿ���ڣ�������������Զ�������Ŀ¼
 *
 * @access      public
 * @param       string      folder     Ŀ¼·��������ʹ���������վ��Ŀ¼��URL
 *
 * @return      bool
 */
function make_dir($folder)
{
    $reval = false;

    if (!file_exists($folder))
    {
        /* ���Ŀ¼���������Դ�����Ŀ¼ */
        @umask(0);

        /* ��Ŀ¼·����ֳ����� */
        preg_match_all('/([^\/]*)\/?/i', $folder, $atmp);

        /* �����һ���ַ�Ϊ/��������·������ */
        $base = ($atmp[0][0] == '/') ? '/' : '';

        /* ��������·����Ϣ������ */
        foreach ($atmp[1] AS $val)
        {
            if ('' != $val)
            {
                $base .= $val;

                if ('..' == $val || '.' == $val)
                {
                    /* ���Ŀ¼Ϊ.����..��ֱ�Ӳ�/������һ��ѭ�� */
                    $base .= '/';

                    continue;
                }
            }
            else
            {
                continue;
            }

            $base .= '/';

            if (!file_exists($base))
            {
                /* ���Դ���Ŀ¼���������ʧ�������ѭ�� */
                if (@mkdir(rtrim($base, '/'), 0777))
                {
                    @chmod($base, 0777);
                    $reval = true;
                }
            }
        }
    }
    else
    {
        /* ·���Ѿ����ڡ����ظ�·���ǲ���һ��Ŀ¼ */
        $reval = is_dir($folder);
    }

    clearstatcache();

    return $reval;
}


/**
 * �ݹ鷽ʽ�ĶԱ����е������ַ�����ת��
 *
 * @access  public
 * @param   mix     $value
 *
 * @return  mix
 */
function addslashes_deep($value)
{
    if (empty($value))
    {
        return $value;
    }
    else
    {
        return is_array($value) ? array_map('addslashes_deep', $value) : addslashes($value);
    }
}

/**
 * �������Ա������������������ַ�����ת��
 *
 * @access   public
 * @param    mix        $obj      �����������
 * @author   Xuan Yan
 *
 * @return   mix                  �����������
 */
function addslashes_deep_obj($obj)
{
    if (is_object($obj) == true)
    {
        foreach ($obj AS $key => $val)
        {
            $obj->$key = addslashes_deep($val);
        }
    }
    else
    {
        $obj = addslashes_deep($obj);
    }

    return $obj;
}

/**
 * �ݹ鷽ʽ�ĶԱ����е������ַ�ȥ��ת��
 *
 * @access  public
 * @param   mix     $value
 *
 * @return  mix
 */
function stripslashes_deep($value)
{
    if (empty($value))
    {
        return $value;
    }
    else
    {
        return is_array($value) ? array_map('stripslashes_deep', $value) : stripslashes($value);
    }
}


/**
 * ����ļ�����
 *
 * @access      public
 * @param       string      filename            �ļ���
 * @param       string      realname            ��ʵ�ļ���
 * @param       string      limit_ext_types     ������ļ�����
 * @return      string
 */
function check_file_type($filename, $realname = '', $limit_ext_types = '')
{
    if ($realname)
    {
        $extname = strtolower(substr($realname, strrpos($realname, '.') + 1));
    }
    else
    {
        $extname = strtolower(substr($filename, strrpos($filename, '.') + 1));
    }

    if ($limit_ext_types && stristr($limit_ext_types, '|' . $extname . '|') === false)
    {
        return '';
    }

    $str = $format = '';

    $file = @fopen($filename, 'rb');
    if ($file)
    {
        $str = @fread($file, 0x400); // ��ȡǰ 1024 ���ֽ�
        @fclose($file);
    }
    else
    {
        if (stristr($filename, ROOT_PATH) === false)
        {
            if ($extname == 'jpg' || $extname == 'jpeg' || $extname == 'gif' || $extname == 'png' || $extname == 'doc' ||
                $extname == 'xls' || $extname == 'txt'  || $extname == 'zip' || $extname == 'rar' || $extname == 'ppt' ||
                $extname == 'pdf' || $extname == 'rm'   || $extname == 'mid' || $extname == 'wav' || $extname == 'bmp' ||
                $extname == 'swf' || $extname == 'chm'  || $extname == 'sql' || $extname == 'cert')
            {
                $format = $extname;
            }
        }
        else
        {
            return '';
        }
    }

    if ($format == '' && strlen($str) >= 2 )
    {
        if (substr($str, 0, 4) == 'MThd' && $extname != 'txt')
        {
            $format = 'mid';
        }
        elseif (substr($str, 0, 4) == 'RIFF' && $extname == 'wav')
        {
            $format = 'wav';
        }
        elseif (substr($str ,0, 3) == "\xFF\xD8\xFF")
        {
            $format = 'jpg';
        }
        elseif (substr($str ,0, 4) == 'GIF8' && $extname != 'txt')
        {
            $format = 'gif';
        }
        elseif (substr($str ,0, 8) == "\x89\x50\x4E\x47\x0D\x0A\x1A\x0A")
        {
            $format = 'png';
        }
        elseif (substr($str ,0, 2) == 'BM' && $extname != 'txt')
        {
            $format = 'bmp';
        }
        elseif ((substr($str ,0, 3) == 'CWS' || substr($str ,0, 3) == 'FWS') && $extname != 'txt')
        {
            $format = 'swf';
        }
        elseif (substr($str ,0, 4) == "\xD0\xCF\x11\xE0")
        {   // D0CF11E == DOCFILE == Microsoft Office Document
            if (substr($str,0x200,4) == "\xEC\xA5\xC1\x00" || $extname == 'doc')
            {
                $format = 'doc';
            }
            elseif (substr($str,0x200,2) == "\x09\x08" || $extname == 'xls')
            {
                $format = 'xls';
            } elseif (substr($str,0x200,4) == "\xFD\xFF\xFF\xFF" || $extname == 'ppt')
            {
                $format = 'ppt';
            }
        } elseif (substr($str ,0, 4) == "PK\x03\x04")
        {
            $format = 'zip';
        } elseif (substr($str ,0, 4) == 'Rar!' && $extname != 'txt')
        {
            $format = 'rar';
        } elseif (substr($str ,0, 4) == "\x25PDF")
        {
            $format = 'pdf';
        } elseif (substr($str ,0, 3) == "\x30\x82\x0A")
        {
            $format = 'cert';
        } elseif (substr($str ,0, 4) == 'ITSF' && $extname != 'txt')
        {
            $format = 'chm';
        } elseif (substr($str ,0, 4) == "\x2ERMF")
        {
            $format = 'rm';
        } elseif ($extname == 'sql')
        {
            $format = 'sql';
        } elseif ($extname == 'txt')
        {
            $format = 'txt';
        }
    }

    if ($limit_ext_types && stristr($limit_ext_types, '|' . $format . '|') === false)
    {
        $format = '';
    }

    return $format;
}

/**
 * �� MYSQL LIKE �����ݽ���ת��
 *
 * @access      public
 * @param       string      string  ����
 * @return      string
 */
function mysql_like_quote($str)
{
    return strtr($str, array("\\\\" => "\\\\\\\\", '_' => '\_', '%' => '\%', "\'" => "\\\\\'"));
}

/**
 * ��ȡ��������ip
 *
 * @access      public
 *
 * @return string
 **/
function real_server_ip()
{
    static $serverip = NULL;

    if ($serverip !== NULL)
    {
        return $serverip;
    }

    if (isset($_SERVER))
    {
        if (isset($_SERVER['SERVER_ADDR']))
        {
            $serverip = $_SERVER['SERVER_ADDR'];
        }
        else
        {
            $serverip = '0.0.0.0';
        }
    }
    else
    {
        $serverip = getenv('SERVER_ADDR');
    }

    return $serverip;
}

/**
 * �Զ��� header ���������ڹ��˿��ܳ��ֵİ�ȫ����
 *
 * @param   string  string  ����
 *
 * @return  void
 **/
function los_header($string, $replace = true, $http_response_code = 0)
{
    $string = str_replace(array("\r", "\n"), array('', ''), $string);

    if (preg_match('/^\s*location:/is', $string))
    {
        @header($string . "\n", $replace);

        exit();
    }

    if (empty($http_response_code) || PHP_VERSION < '4.3')
    {
        @header($string, $replace);
    }
    else
    {
        @header($string, $replace, $http_response_code);
    }
}

/**
 * ȥ���ַ����Ҳ���ܳ��ֵ�����
 *
 * @param   string      $str        �ַ���
 *
 * @return  string
 */
function trim_right($str)
{
    $len = strlen($str);
    /* Ϊ�ջ򵥸��ַ�ֱ�ӷ��� */
    if ($len == 0 || ord($str{$len-1}) < 127)
    {
        return $str;
    }
    /* ��ǰ���ַ���ֱ�Ӱ�ǰ���ַ�ȥ�� */
    if (ord($str{$len-1}) >= 192)
    {
       return substr($str, 0, $len-1);
    }
    /* �зǶ������ַ����ȰѷǶ����ַ�ȥ��������֤�Ƕ������ַ��ǲ���һ���������֣�������ԭ��ǰ���ַ�Ҳ��ȡ�� */
    $r_len = strlen(rtrim($str, "\x80..\xBF"));
    if ($r_len == 0 || ord($str{$r_len-1}) < 127)
    {
        return sub_str($str, 0, $r_len);
    }

    $as_num = ord(~$str{$r_len -1});
    if ($as_num > (1<<(6 + $r_len - $len)))
    {
        return $str;
    }
    else
    {
        return substr($str, 0, $r_len-1);
    }
}

/**
 * ���ϴ��ļ�ת�Ƶ�ָ��λ��
 *
 * @param string $file_name
 * @param string $target_name
 * @return blog
 */
function move_upload_file($file_name, $target_name = '')
{
    if (function_exists("move_uploaded_file"))
    {
        if (move_uploaded_file($file_name, $target_name))
        {
            @chmod($target_name,0755);
            return true;
        }
        else if (copy($file_name, $target_name))
        {
            @chmod($target_name,0755);
            return true;
        }
    }
    elseif (copy($file_name, $target_name))
    {
        @chmod($target_name,0755);
        return true;
    }
    return false;
}

/**
 * ��ȡ�ļ���׺��,���ж��Ƿ�Ϸ�
 *
 * @param string $file_name
 * @param array $allow_type
 * @return blob
 */
function get_file_suffix($file_name, $allow_type = array())
{
    $file_suffix = strtolower(array_pop(explode('.', $file_name)));
    if (empty($allow_type))
    {
        return $file_suffix;
    }
    else
    {
        if (in_array($file_suffix, $allow_type))
        {
            return true;
        }
        else
        {
            return false;

        }
    }
}

/**
 * ����������ļ�
 *
 * @params  string  $cache_name
 *
 * @return  array   $data
 */
function read_static_cache($cache_name)
{
    if ((DEBUG_MODE & 2) == 2)
    {
        return false;
    }
    static $result = array();
    if (!empty($result[$cache_name]))
    {
        return $result[$cache_name];
    }
    $cache_file_path = ROOT_PATH . '/temp/static_caches/' . $cache_name . '.php';
    if (file_exists($cache_file_path))
    {
        include_once($cache_file_path);
        $result[$cache_name] = $data;
        return $result[$cache_name];
    }
    else
    {
        return false;
    }
}

/**
 * д��������ļ�
 *
 * @params  string  $cache_name
 * @params  string  $caches
 *
 * @return
 */
function write_static_cache($cache_name, $caches)
{
    if ((DEBUG_MODE & 2) == 2)
    {
        return false;
    }
    $cache_file_path = ROOT_PATH . '/temp/static_caches/' . $cache_name . '.php';
    $content = "<?php\r\n";
    $content .= "\$data = " . var_export($caches, true) . ";\r\n";
    $content .= "?>";
    file_put_contents($cache_file_path, $content, LOCK_EX);
}
/**
 * ����Ƿ�Ϊһ���Ϸ���ʱ���ʽ
 *
 * @access  public
 * @param   string  $time
 * @return  void
 */
function is_time($time)
{
    $pattern = '/[\d]{4}-[\d]{1,2}-[\d]{1,2}\s[\d]{1,2}:[\d]{1,2}:[\d]{1,2}/';

    return preg_match($pattern, $time);
}

/**
 * ��ò�ѯʱ��ʹ���������ֵ��smarty
 *
 * @access  public
 * @return  void
 */
function assign_query_info()
{
    if ($GLOBALS['db']->queryTime == '')
    {
        $query_time = 0;
    }
    else
    {
        if (PHP_VERSION >= '5.0.0')
        {
            $query_time = number_format(microtime(true) - $GLOBALS['db']->queryTime, 6);
        }
        else
        {
            list($now_usec, $now_sec)     = explode(' ', microtime());
            list($start_usec, $start_sec) = explode(' ', $GLOBALS['db']->queryTime);
            $query_time = number_format(($now_sec - $start_sec) + ($now_usec - $start_usec), 6);
        }
    }
    $GLOBALS['smarty']->assign('query_info', sprintf('��ִ�� %d ����ѯ����ʱ %s ��', $GLOBALS['db']->queryCount, $query_time));

    /* �ڴ�ռ����� */
    if (function_exists('memory_get_usage'))
    {
        $GLOBALS['smarty']->assign('memory_info', sprintf('���ڴ�ռ�� %0.3f MB', memory_get_usage() / 1048576));
    }

}
?>