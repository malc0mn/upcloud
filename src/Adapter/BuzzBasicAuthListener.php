<?php

namespace UpCloud\Adapter;

use Buzz\Listener\ListenerInterface;
use Buzz\Message\MessageInterface;
use Buzz\Message\RequestInterface;

class BuzzBasicAuthListener implements ListenerInterface
{
    /**
     * @var string
     */
    protected $token;

    /**
     * @param string $user
     * @param string $password
     */
    public function __construct($user, $password)
    {
        $this->token = "$user:$password";
    }

    /**
     * {@inheritdoc}
     */
    public function preSend(RequestInterface $request)
    {
        $request->addHeader(sprintf('Authorization: Basic %s', base64_encode($this->token)));
    }

    /**
     * {@inheritdoc}
     */
    public function postSend(RequestInterface $request, MessageInterface $response)
    {
        //
    }
}
