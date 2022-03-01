<?php

namespace CarroPublic\LaravelTwilio;

use InvalidArgumentException;

class LaravelTwilioManager implements Factory
{
    /**
     * The array of resolved senders.
     *
     * @var array
     */
    protected $senders = [];
    
    protected $config;
    
    protected static $runningInSandboxValidator;
    
    public function __construct($app) {
        $this->config = $app['config'];
    }

    /**
     * Get a sender instance by name.
     *
     * @param  string|null  $name
     * @return LaravelTwilioSender
     */
    public function sender($name = null)
    {
        $name = $name ?: $this->getDefaultSender();

        return $this->senders[$name] = $this->get($name);
    }

    /**
     * Get the default sender config
     *
     * @return string
     */
    public function getDefaultSender()
    {
        return $this->config->get('laraveltwilio.default');
    }

    /**
     * Attempt to get the mailer from the local cache.
     *
     * @param  string  $name
     * @return LaravelTwilioSender
     */
    protected function get($name)
    {
        return $this->mailers[$name] ?? $this->resolve($name);
    }

    /**
     * Resolve the given mailer.
     *
     * @param  string  $name
     * @return LaravelTwilioSender
     *
     * @throws \InvalidArgumentException
     */
    protected function resolve($name)
    {
        $config = $this->getConfig($name);

        if (is_null($config)) {
            throw new InvalidArgumentException("Sender [{$name}] is not defined.");
        }

        return new LaravelTwilioSender($config, $this->isTesting());
    }

    /**
     * Get the mail connection configuration.
     *
     * @param string $name
     * @return array
     */
    protected function getConfig($name)
    {
        return $this->config->get("laraveltwilio.senders.{$name}");
    }

    /**
     * Determine if running in sandbox mode
     * @return bool
     */
    protected function isTesting() {
        if (self::$runningInSandboxValidator) {
            return call_user_func(self::$runningInSandboxValidator);
        }
        
        return $this->config->get('laraveltwilio.sandbox');
    }

    /**
     * Register sandbox Mode Validator
     * @param \Closure $closure
     * @return void
     */
    public static function registerSandboxValidator(\Closure $closure) {
        self::$runningInSandboxValidator = $closure;
    }
}