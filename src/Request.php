<?php
class Request
{
    /**
     * @property String
     */
    protected $action = '';

    /**
     * @property String
     */
    protected $controller = '';

    /**
     * @property Array
     */
    protected $cookie = array();

    /**
     * @property Array
     */
    protected $files = array();

    /**
     * @property Array
     */
    protected $get = array();

    /**
     * @property Array
     */
    protected $parameters = array();

    /**
     * @property Array
     */
    protected $post = array();

    /**
     * @property Array
     */
    protected $session = array();

    /**
     * @property String
     */
    protected $referer = '';

    /**
     * @property Option
     * @options http, https
     */
    protected $protocol = 'get';

    /**
     * @property Option
     * @options get, post
     */
    protected $requestMethod = 'get';

    /**
     * @property Integer
     */
    protected $requestTime = 0;

    /**
     * The request URI
     *
     * example: /Project/View/Some.jpg?add_some_var=1&some_other=2
     * @property String
     */
    protected $uri = '';

    /**
     * The request URL
     *
     * If uri is /Project/View/Some.jpg?add_some_var=1&some_other=2
     * Then the url is /Project/View/Some.jpg
     * @property String
     */
    protected $url = '';

    /**
     * Full url including http://
     *
     * example: http://www.marijnkoesen.nl/
     * @property String
     */
    protected $fullUrl= '';

    /**
     * The useragent of the request
     *
     * @property String
     */
    protected $userAgent = '';

    /**
     * Ip of the request
     *
     * @property String
     */
    protected $ip = '';

    public function __construct($data)
    {
        foreach($data as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * Adds a cookie to the cookie array.
     **/
    public function addCookieItem($cookie)
    {
        return $this->cookie[] = $cookie;
    }

    /**
     * Get a single cookie by index from the cookie array.
     * @param mixed $key.
     **/
    public function getCookieItem($key)
    {
        return isset($this->cookie[$key]) ? $this->cookie[$key] : null;
    }

    /**
     * Get the number of cookie.
     * @return integer total cookie.
     **/
    public function getCookieCount()
    {
        return count($this->cookie);
    }

    /**
     * Get the cookie.
     * @return array $cookie.
     **/
    public function getCookie()
    {
        return $this->cookie;
    }

    /**
     * Get if cookie is not empty.
     * @return boolean $hasCookie.
     **/
    public function hasCookie()
    {
        return !empty($this->cookie);
    }

    /**
     * Remove a single cookie by index from the cookie array.
     * @param mixed $key.
     * @return boolean $succes.
     **/
    public function removeCookieItem($key)
    {
        if (isset($this->cookie[$key])) {
            unset($this->cookie[$key]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Set a single cookie to the cookie array at index $key.
     * @param mixed $key.
     * @param mixed $cookie.
     **/
    public function setCookieItem($key, $cookie)
    {
        return $this->cookie[$key] = $cookie;
    }

    /**
     * Set the cookie.
     * @param array $cookie.
     **/
    public function setCookie($cookie)
    {
        if (is_array($cookie)) {
            $this->cookie = $cookie;
        } else {
            trigger_error('Supplied argument is not a valid array.', E_USER_ERROR);
        }
    }

    /**
     * Adds a file to the files array.
     **/
    public function addFile($file)
    {
        return $this->files[] = $file;
    }

    /**
     * Get a single file by index from the files array.
     * @param mixed $key.
     **/
    public function getFile($key)
    {
        return isset($this->files[$key]) ? $this->files[$key] : null;
    }

    /**
     * Get the number of files.
     * @return integer total files.
     **/
    public function getFileCount()
    {
        return count($this->files);
    }

    /**
     * Get if files is not empty.
     * @return boolean $hasFiles.
     **/
    public function hasFiles()
    {
        return !empty($this->files);
    }

    /**
     * Remove a single file by index from the files array.
     * @param mixed $key.
     * @return boolean $succes.
     **/
    public function removeFile($key)
    {
        if (isset($this->files[$key])) {
            unset($this->files[$key]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Set a single file to the files array at index $key.
     * @param mixed $key.
     * @param mixed $file.
     **/
    public function setFile($key, $file)
    {
        return $this->files[$key] = $file;
    }

    /**
     * Adds a get to the get array.
     **/
    public function addGetItem($get)
    {
        return $this->get[] = $get;
    }

    /**
     * Get a single get by index from the get array.
     * @param mixed $key.
     **/
    public function getGetItem($key)
    {
        return isset($this->get[$key]) ? $this->get[$key] : null;
    }

    /**
     * Get the number of get.
     * @return integer total get.
     **/
    public function getGetCount()
    {
        return count($this->get);
    }

    /**
     * Get the get.
     * @return array $get.
     **/
    public function getGet()
    {
        return $this->get;
    }

    /**
     * Get if get is not empty.
     * @return boolean $hasGet.
     **/
    public function hasGet()
    {
        return !empty($this->get);
    }

    /**
     * Remove a single get by index from the get array.
     * @param mixed $key.
     * @return boolean $succes.
     **/
    public function removeGetItem($key)
    {
        if (isset($this->get[$key])) {
            unset($this->get[$key]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Set a single get to the get array at index $key.
     * @param mixed $key.
     * @param mixed $get.
     **/
    public function setGetItem($key, $get)
    {
        return $this->get[$key] = $get;
    }

    /**
     * Set the get.
     * @param array $get.
     **/
    public function setGet($get)
    {
        if (is_array($get)) {
            $this->get = $get;
        } else {
            trigger_error('Supplied argument is not a valid array.', E_USER_ERROR);
        }
    }

    /**
     * Adds a parameter to the parameters array.
     **/
    public function addParameter($parameter)
    {
        return $this->parameters[] = $parameter;
    }

    /**
     * Get a single parameter by index from the parameters array.
     * @param mixed $key.
     **/
    public function getParameter($key)
    {
        return isset($this->parameters[$key]) ? $this->parameters[$key] : null;
    }

    /**
     * Get the number of parameters.
     * @return integer total parameters.
     **/
    public function getParameterCount()
    {
        return count($this->parameters);
    }

    /**
     * Get the parameters.
     * @return array $parameters.
     **/
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Get if parameters is not empty.
     * @return boolean $hasParameters.
     **/
    public function hasParameters()
    {
        return !empty($this->parameters);
    }

    /**
     * Remove a single parameter by index from the parameters array.
     * @param mixed $key.
     * @return boolean $succes.
     **/
    public function removeParameter($key)
    {
        if (isset($this->parameters[$key])) {
            unset($this->parameters[$key]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Set a single parameter to the parameters array at index $key.
     * @param mixed $key.
     * @param mixed $parameter.
     **/
    public function setParameter($key, $parameter)
    {
        return $this->parameters[$key] = $parameter;
    }

    /**
     * Set the parameters.
     * @param array $parameters.
     **/
    public function setParameters($parameters)
    {
        if (is_array($parameters)) {
            $this->parameters = $parameters;
        } else {
            trigger_error('Supplied argument is not a valid array.', E_USER_ERROR);
        }
    }

    /**
     * Adds a post to the post array.
     **/
    public function addPostItem($post)
    {
        return $this->post[] = $post;
    }

    /**
     * Get a single post by index from the post array.
     * @param mixed $key.
     **/
    public function getPostItem($key)
    {
        return isset($this->post[$key]) ? $this->post[$key] : null;
    }

    /**
     * Get the number of post.
     * @return integer total post.
     **/
    public function getPostCount()
    {
        return count($this->post);
    }

    /**
     * Get the post.
     * @return array $post.
     **/
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Get if post is not empty.
     * @return boolean $hasPost.
     **/
    public function hasPost()
    {
        return !empty($this->post);
    }

    /**
     * Remove a single post by index from the post array.
     * @param mixed $key.
     * @return boolean $am mixed $key.
     * @param mixed $post.
     **/
    public function setPostItem($key, $post)
    {
        return $this->post[$key] = $post;
    }

    /**
     * Set the post.
     * @param array $post.
     **/
    public function setPost($post)
    {
        if (is_array($post)) {
            $this->post = $post;
        } else {
            trigger_error('Supplied argument is not a valid array.', E_USER_ERROR);
        }
    }

    /**
     * Adds a session to the session array.
     **/
    public function addSessionItem($session)
    {
        return $this->session[] = $session;
    }

    /**
     * Get a single session by index from the session array.
     * @param mixed $key.
     **/
    public function getSessionItem($key)
    {
        return isset($this->session[$key]) ? $this->session[$key] : null;
    }

    /**
     * Get the number of session.
     * @return integer total session.
     **/
    public function getSessionCount()
    {
        return count($this->session);
    }

    /**
     * Get the session.
     * @return array $session.
     **/
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Get if session is not empty.
     * @return boolean $hasSession.
     **/
    public function hasSession()
    {
        return !empty($this->session);
    }

    /**
     * Remove a single session by index from the session array.
     * @param mixed $key.
     * @return boolean $succes.
     **/
    public function removeSessionItem($key)
    {
        if (isset($this->session[$key])) {
            unset($this->session[$key]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Set a single session to the session array at index $key.
     * @param mixed $key.
     * @param mixed $session.
     **/
    public function setSessionItem($key, $session)
    {
        return $this->session[$key] = $session;
    }

    /**
     * Set the session.
     * @param array $session.
     **/
    public function setSession($session)
    {
        if (is_array($session)) {
            $this->session = $session;
        } else {
            trigger_error('Supplied argument is not a valid array.', E_USER_ERROR);
        }
    }

    public static function getCurrentRequest()
    {
        // If we open an url '/?r=123545' for example, we want to load the Controller Index
        // But not the controller 'r', so don't include the '?a=b&c=d' part in the parameters
        // So use the REDIRECT_URL instead of the REQUEST_URI for the controller
        $parameters = explode("/", (isset($_SERVER['REDIRECT_URL'])) ? $_SERVER['REDIRECT_URL'] : '');

        foreach($parameters as $key => $value) {
            $parameters[$key] = urldecode($value);

            if (empty($parameters[$key])) {
                unset($parameters[$key]);
            }
        }

        $controller = (count($parameters) > 0) ? array_shift($parameters) : null;
        $action = (count($parameters) > 0) ? array_shift($parameters) : null;

        $protocol = (isset($_SERVER['HTTPS'])) ? 'https' : 'http';
        $fullUrl = $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        $request = new Request(array(
            'requestMethod' => strtolower($_SERVER['REQUEST_METHOD']),
            'requestTime' => time(),
            'uri' => $_SERVER['REQUEST_URI'],
            'url' => (isset($_SERVER['REDIRECT_URL']) ? $_SERVER['REDIRECT_URL'] : '/'),
            'fullUrl' => $fullUrl,
            'userAgent' => $_SERVER['HTTP_USER_AGENT'],
            'ip' => $_SERVER['REMOTE_ADDR'],
            'protocol' => $protocol,
            'referer' => (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '',
            'controller' => $controller,
            'action' => $action,
            'parameters' => $parameters,
            'get' => $_GET,
            'post' => $_POST,
            'cookie' => $_COOKIE,
            'session' => isset($_SESSION) ? $_SESSION : array(),
            'files' => isset($_FILES) ? $_FILES : array()
        ));

        return $request;
    }
}
